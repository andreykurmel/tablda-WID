<?php
class r3d_write {

	function units($handle, $data) {
		$a = 0; $b = 0; $c = 0; $d = 0; $e = 0; $f = 0; $g = 0; $h = 0; $i = 0; $j = 0; $k = 0; $l = 0; $m = 0; $n = 0;
		$units = "\r\n".'[UNITS] <1>'."\r\n".$a.' '.$b.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h.' '.$i.' '.$j.' '.$k.' '.$l.' '.$m.' '.$n.';'."\r\n".'[END_UNITS]'."\r\n";
		fwrite($handle, $units);  	
	}

    function formAnalysisFile($geometry_PK, $lc_id, $ansys, $db, $dbshared) {
        $uploaddir = __DIR__.'/documents/analysis/'.$geometry_PK.'/';

        $filename = 'Analysis.json';

        $ANSYS_input_file = 'input.txt';

        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        //main row for geometry
        $data = array();

        $data_geometry = array();

        $query = "SELECT * FROM db_geometry WHERE id = {$geometry_PK}";

        if ($result = $db->query($query)) {
            $data_geometry = $result->fetch_assoc();
        }

        $data['geometry'] = $data_geometry;

        //analysis

        $muploaddir = __DIR__.'/documents/'.$data_geometry["Model_G"].'/';

        if (!file_exists($muploaddir)) {
            mkdir($muploaddir, 0777, true);
        }

        $data_analysis = array();

        $query = "SELECT * FROM analysis WHERE id = {$lc_id}";

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data_analysis[] = $row;
            }

            $result->close();
        }

        $data['analysis'] = $data_analysis;


        //analysis LC\DC\Eqpt

        $data_analysis_lc = array();
        $data_analysis_lc_parent = array();
        $data_analysis_dc = array();
        $data_analysis_eqpt = array();

        foreach ($data_analysis as $value) {

            $query = "SELECT * FROM analysis_lc_parent WHERE id = {$value['lc_id']}";

            if ($result = $db->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $data_analysis_lc_parent[] = $row;
                }

                $result->close();
            }

            $query = "SELECT * FROM analysis_lc WHERE lc_parent_id = {$data_analysis_lc_parent[0]["id"]}";

            if ($result = $db->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $data_analysis_lc[] = $row;
                }

                $result->close();
            }

            $query = "SELECT * FROM analysis_dc WHERE id = {$value['dc_id']}";

            if ($result = $db->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $data_analysis_dc[] = $row;
                }

                $result->close();
            }

            $query = "SELECT * FROM analysis_eqpt WHERE analysis_PK = {$value['id']}";

            if ($result = $db->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $data_analysis_eqpt[] = $row;
                }

                $result->close();
            }
        }

        foreach($data_analysis_eqpt as &$deq) {

            $query = "SELECT * FROM db_pro_asctn WHERE db_pro_PK = {$deq['db_pro_PK']}";

            if ($response = $db->query($query)) {
                $result = $response->fetch_assoc();

                $deq = array_merge($deq, $result);
            }

        }



        //global offset & rotation calculation

        $gdx = 0;
        $gdy = 0;
        $gdz = 0;

        $grotx = 0;
        $groty = 0;
        $grotz = 0;

        foreach ($data_analysis_dc as $dc) {
            $gdx = $gdx + $dc['dx'];
            $gdy = $gdy + $dc['dy'];
            $gdz = $gdz + $dc['dz'];

            $grotx = $grotx + $dc['rotx'];
            $groty = $groty + $dc['roty'];
            $grotz = $grotz + $dc['rotz'];
        }

        //

        //nodes

        $data_nodes = array();

        $query = "SELECT * FROM db_geo_node WHERE db_geo_PK = {$data_geometry['id']} ORDER BY no ASC";

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data_nodes[] = $row;
            }

            $result->close();
        }


        // to apply global translations / rotations set in Analsyis/Design Configuration table.
        foreach($data_nodes as &$n) {

            if($grotx != 0) {

                $oldY = $n['y'];
                $oldZ = $n['z'];
                $rx = $grotx * (M_PI/180);

                $n['y'] = $oldY * cos($rx) - $oldZ * sin($rx);
                $n['z'] = $oldY * sin($rx) + $oldZ * cos($rx);

            }

            if($groty != 0) {

                $oldX = $n['x'];
                $oldZ = $n['z'];
                $ry = $groty * (M_PI/180);

                $n['x'] = $oldX * cos($ry) - $oldZ * sin($ry);
                $n['z'] = $oldX * sin($ry) + $oldZ * cos($ry);

            }

            if($grotz != 0) {

                $oldX = $n['x'];
                $oldY = $n['y'];
                $rz = $grotz * (M_PI/180);

                $n['x'] = $oldX * cos($rz) - $oldY * sin($rz);
                $n['y'] = $oldX * sin($rz) + $oldY * cos($rz);

            }

            $n['x'] = $n['x'] + $gdx;
            $n['y'] = $n['y'] + $gdy;
            $n['z'] = $n['z'] + $gdz;
        }

        $data['nodes'] = $data_nodes;

        //materials

        $data_materials = array();

        $query = "SELECT * FROM db_geo_mat WHERE db_geo_PK = {$data_geometry['id']}";

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data_materials[] = $row;
            }

            $result->close();
        }

        foreach($data_materials as &$mat) {

            $query = "SELECT * FROM db_material WHERE `name` = '{$mat['name']}' ORDER BY no ASC";



            if ($response = $dbshared->query($query)) {
                $result = $response->fetch_assoc();

                if(!empty($result)) {
                    $mat = array_merge($mat, $result);
                }

            }

        }

        $data['materials'] = $data_materials;


        //sections

        $data_sections = array();

        $query = "SELECT * FROM db_geo_sec WHERE db_geo_PK = {$data_geometry['id']} ORDER BY no ASC";

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data_sections[] = $row;
            }

            $result->close();
        }

        $dataSec = array();

        $where = '';

        foreach ($data_sections as $s) {

            $where = $where."(Type = '{$s['shape']}' AND `AISC_Size1` = '{$s['size1']}' AND `AISC_Size2` = '{$s['size2']}') OR ";

        }

        $where = rtrim($where, ' OR ');

        $querySec = "SELECT * FROM db_aisc_v141 WHERE {$where} ORDER BY id_no ASC";


        if ($result = $dbshared->query($querySec)) {
            while ($row = $result->fetch_assoc()) {
                $dataSec[] = $row;
            }
        }

        foreach ($data_sections as &$section) {

            foreach($dataSec as $ds) {

                if($ds['Type'] === $section['shape'] && $ds['AISC_Size1'] === $section['size1'] && $ds['AISC_Size2'] === $section['size2']) {

                    $section['properties'] = $ds;

                }

            }

        }

        $data['sections'] = $data_sections;


        //members

        $data_members = array();

        $query = "SELECT * FROM db_geo_mbr WHERE db_geo_PK = {$data_geometry['id']} ORDER BY no ASC";

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data_members[] = $row;
            }

            $result->close();
        }

        foreach ($data_members as &$member) {

            if(!empty($member['NodeS']) && !empty($member['NodeE'])) {

                $nodeSX = 0;
                $nodeSY = 0;
                $nodeSZ = 0;
                $nodeEX = 0;
                $nodeEY = 0;
                $nodeEZ = 0;

                $NYX = 0;
                $NYY = 0;
                $NYZ = 0;

                foreach ($data_nodes as $node) {

                    if($node['no'] == $member['NodeS']) {
                        $nodeSX = $node['x'];
                        $nodeSY = $node['y'];
                        $nodeSZ = $node['z'];
                    }

                    if($node['no'] == $member['NodeE']) {
                        $nodeEX = $node['x'];
                        $nodeEY = $node['y'];
                        $nodeEZ = $node['z'];
                    }

                }

                //Y orientation
                $YX = $nodeEX - $nodeSX;
                $YY = $nodeEY - $nodeSY;
                $YZ = $nodeEZ - $nodeSZ;

                //length
                $L = sqrt($YZ*$YZ + $YY*$YY + $YX*$YX);

                //normalized
                if($L != 0) {
                    $NYX = $YX/$L;
                    $NYY = $YY/$L;
                    $NYZ = $YZ/$L;
                }

                $member['orientation'] = array(
                    'Y' => array(
                        'x' => $NYX,
                        'y' => $NYY,
                        'z' => $NYZ
                    ),
                    'X' => array(
                        'x' => $NYY,
                        'y' => -$NYX,
                        'z' => $NYZ
                    ),
                    'Z' => array(
                        'x' => $NYX,
                        'y' => -$NYZ,
                        'z' => $NYY
                    )
                );

            }

        }

        $data['members'] = $data_members;

        // vertices

        foreach ($data_analysis_lc as &$lc) {

            $member_center = array();
            $eqpt_center = array();
            $nodeE = false;
            $nodeS = false;
            $mbr_orientation = array();

            foreach ($data_members as $mbr) {
                if ($mbr['Mbr_Name'] === $lc['mbr_name']) {

                    foreach ($data_nodes as $node) {

                        if ($mbr['NodeS'] == $node['no']) {
                            $nodeS = $node;
                            if ($nodeE) {
                                break;
                            }
                        }

                        if ($mbr['NodeE'] == $node['no']) {
                            $nodeE = $node;
                            if ($nodeS) {
                                break;
                            }
                        }
                    }

                    if ($nodeS && $nodeE) {
                        $member_center['x'] = $nodeS['x'] + $nodeE['x'] / 2;
                        $member_center['y'] = $nodeS['y'] + $nodeE['y'] / 2;
                        $member_center['z'] = $nodeS['z'] + $nodeE['z'] / 2;
                    }

                    $mbr_orientation = $mbr['orientation'];

                    break;
                }
            }

            $eqpt_center['x'] = $member_center['x'] + $lc['dx'];
            $eqpt_center['y'] = $member_center['y'] + $lc['dy'];
            $eqpt_center['z'] = $member_center['z'] + $lc['dz'];

            foreach ($data_analysis_eqpt as &$eqpt) {
                if ($eqpt['name'] === $lc['eqpt_name'] && $eqpt['geometryShapeType'] == 'Cuboid') {

                    $vertices = array(
                        'vert1' => [],
                        'vert2' => [],
                        'vert3' => [],
                        'vert4' => [],
                        'vert5' => [],
                        'vert6' => [],
                        'vert7' => [],
                        'vert8' => []
                    );

                    $areas = array(
                        'area1' => [],
                        'area2' => [],
                        'area3' => [],
                        'area4' => [],
                        'area5' => [],
                        'area6' => [],
                    );

                    $vertices["vert1"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
                    $vertices["vert1"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
                    $vertices["vert1"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;

                    $vertices["vert2"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
                    $vertices["vert2"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
                    $vertices["vert2"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;

                    $vertices["vert3"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
                    $vertices["vert3"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
                    $vertices["vert3"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;

                    $vertices["vert4"]["x"] = $eqpt_center["x"] - ($eqpt["d3"] / 2) / 12;
                    $vertices["vert4"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
                    $vertices["vert4"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;

                    $vertices["vert5"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
                    $vertices["vert5"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
                    $vertices["vert5"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;

                    $vertices["vert6"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
                    $vertices["vert6"]["y"] = $eqpt_center["y"] - ($eqpt["d1"] / 2) / 12;
                    $vertices["vert6"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;

                    $vertices["vert7"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
                    $vertices["vert7"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
                    $vertices["vert7"]["z"] = $eqpt_center["z"] + ($eqpt["d2"] / 2) / 12;

                    $vertices["vert8"]["x"] = $eqpt_center["x"] + ($eqpt["d3"] / 2) / 12;
                    $vertices["vert8"]["y"] = $eqpt_center["y"] + ($eqpt["d1"] / 2) / 12;
                    $vertices["vert8"]["z"] = $eqpt_center["z"] - ($eqpt["d2"] / 2) / 12;

                    foreach ($vertices as &$vert) {

                        if ($grotx != 0) {
                            $oldY = $vert['y'];
                            $oldZ = $vert['z'];
                            $rx = $grotx * (M_PI / 180);

                            $vert['y'] = $oldY * cos($rx) - $oldZ * sin($rx);
                            $vert['z'] = $oldY * sin($rx) + $oldZ * cos($rx);
                        }

                        if ($groty != 0) {
                            $oldX = $vert['x'];
                            $oldZ = $vert['z'];
                            $ry = $groty * (M_PI / 180);

                            $vert['x'] = $oldX * cos($ry) - $oldZ * sin($ry);
                            $vert['z'] = $oldX * sin($ry) + $oldZ * cos($ry);
                        }

                        if ($grotz != 0) {
                            $oldX = $vert['x'];
                            $oldY = $vert['y'];
                            $rz = $grotz * (M_PI / 180);

                            $vert['x'] = $oldX * cos($rz) - $oldY * sin($rz);
                            $vert['y'] = $oldX * sin($rz) + $oldY * cos($rz);
                        }

                        $vert['x'] = $vert['x'] + $gdx;
                        $vert['y'] = $vert['y'] + $gdy;
                        $vert['z'] = $vert['z'] + $gdz;
                    }

                    // vertices of areas
                    $areas['area1']['vertices'] = [$vertices["vert1"], $vertices["vert2"], $vertices["vert3"], $vertices["vert4"]];
                    $areas['area2']['vertices'] = [$vertices["vert1"], $vertices["vert5"], $vertices["vert3"], $vertices["vert7"]];
                    $areas['area3']['vertices'] = [$vertices["vert5"], $vertices["vert6"], $vertices["vert7"], $vertices["vert8"]];
                    $areas['area4']['vertices'] = [$vertices["vert2"], $vertices["vert6"], $vertices["vert4"], $vertices["vert8"]];
                    $areas['area5']['vertices'] = [$vertices["vert3"], $vertices["vert7"], $vertices["vert4"], $vertices["vert8"]];
                    $areas['area6']['vertices'] = [$vertices["vert1"], $vertices["vert5"], $vertices["vert2"], $vertices["vert6"]];

                    // normal vector
                    foreach ($areas as &$area) {
                        $AB = [
                            $area['vertices'][0]['x'] - $area['vertices'][1]['x'],
                            $area['vertices'][0]['y'] - $area['vertices'][1]['y'],
                            $area['vertices'][0]['z'] - $area['vertices'][1]['z']
                        ];
                        $AC = [
                            $area['vertices'][2]['x'] - $area['vertices'][1]['x'],
                            $area['vertices'][2]['y'] - $area['vertices'][1]['y'],
                            $area['vertices'][2]['z'] - $area['vertices'][1]['z']
                        ];

                        $normalVector = [($AB[1] * $AC[2]) - ($AB[2] * $AC[1]), ($AB[2] * $AC[0]) - ($AB[0] * $AC[2]), ($AB[0] * $AC[1]) - ($AB[1] * $AC[0])];
                        $area['area_normal_direction'] = $normalVector;
                    }


                    $lc['eqpt_vertices'] = $vertices;
                    $lc['eqpt_areas'] = $areas;
                }

                $eqpt_orientation = $mbr_orientation;

                foreach ($eqpt_orientation as &$vector) {
                    if ($lc['rotx'] != 0) {
                        $oldY = $vector['y'];
                        $oldZ = $vector['z'];
                        $rx = $lc['rotx'] * (M_PI / 180);

                        $vector['y'] = $oldY * cos($rx) - $oldZ * sin($rx);
                        $vector['z'] = $oldY * sin($rx) + $oldZ * cos($rx);
                    }

                    if ($lc['roty'] != 0) {
                        $oldX = $vector['x'];
                        $oldZ = $vector['z'];
                        $ry = $lc['roty'] * (M_PI / 180);

                        $vector['x'] = $oldX * cos($ry) - $oldZ * sin($ry);
                        $vector['z'] = $oldX * sin($ry) + $oldZ * cos($ry);
                    }

                    if ($lc['rotz'] != 0) {
                        $oldX = $vector['x'];
                        $oldY = $vector['y'];
                        $rz = $lc['rotz'] * (M_PI / 180);

                        $vector['x'] = $oldX * cos($rz) - $oldY * sin($rz);
                        $vector['y'] = $oldX * sin($rz) + $oldY * cos($rz);
                    }
                }

                $lc['eqpt_orientation'] = $eqpt_orientation;
            }
        }

        $data['analysis_lc'] = $data_analysis_lc;
        $data['analysis_lc_parent'] = $data_analysis_lc_parent;
        $data['analysis_dc'] = $data_analysis_dc;
        $data['analysis_eqpt'] = $data_analysis_eqpt;

        //file writing

        // $ansys->write_input($data, $uploaddir, $ANSYS_input_file);

        file_put_contents( $uploaddir.$filename, json_encode($data, JSON_PRETTY_PRINT));

        // var_dump($data);

//        $my_file = 'mount.r3d';
        $mdata = array();

        $name = "".$data_geometry["Model_G"]."_".$data_analysis_lc_parent[0]["lc_name"]."_".$data_analysis_dc[0]["dc_name"].".r3d";

        $mfile =  $mfile = $muploaddir.$name;

        file_put_contents( $mfile, json_encode($mdata, JSON_PRETTY_PRINT));

        $this->writeRISA3Dinput($data, $mfile);

        // print_r($data);

        //        file_put_contents( $uploaddir.$ANSYS_input_file, json_encode($data));

        // call SHARED\ansys\ansys.php with $data as input and write input.inp.

        if (file_exists($uploaddir.$filename)) {
            $success = true;
        } else {
            $success = false;
        }

        return $success;
    }

    function writeRISA3Dinput($data, $file){


        $my_file = 'mount.r3d';


        $handle = fopen($file, 'w') or die('Cannot open file:  '.$file);

        $data = '[RISA-3D_INPUT_DATA]'."\r\n";
        fwrite($handle, $data);

        $risa3d_v = '15.04';
        $data ="\r\n".'[VERSION_NO] <1>'."\r\n".$risa3d_v."\r\n".'[END_VERSION_NO]'."\r\n";
        fwrite($handle, $data);

        $program_info = '64';
        $data ="\r\n".'[PROGRAM_INFO] <1>'."\r\n".$program_info."\r\n".'[END_PROGRAM_INFO]'."\r\n";
        fwrite($handle, $data);

        $data_integrity_key = '64';
        $data ="\r\n".'[DATA_INTEGRITY_KEY] <1>'."\r\n".$data_integrity_key."\r\n".'[END_DATA_INTEGRITY_KEY]'."\r\n";
        fwrite($handle, $data);

        $cloudid = '';
        $data ="\r\n".'[CLOUDID] <1>'."\r\n".$cloudid."\r\n".'[END_CLOUDID]'."\r\n";
        fwrite($handle, $data);

        $os_version = '';
        $data ="\r\n".'[OS_VERSION] <1>'."\r\n".$os_version."\r\n".'[END_OS_VERSION]'."\r\n";
        fwrite($handle, $data);


        $this->units($handle, '');


        $gloabl_prtrs = array();
        $gloabl_prtrs['proj_dsrpn'] = array('model_title'=>'072-082', 'compay_name'=>'MasTec', 'designer_name'=>'Bruce', 'job_number'=>'xxx-yyy');
        $gloabl_prtrs['sol_prtrs']     = array();
        $gloabl_prtrs['design_codes']  = array();

        $wind_prtrs = array();
        $wind_prtrs['is_wind_prtrs']   = array();
        $wind_prtrs['mexi_wind_prtrs'] = array();
        $wind_prtrs['nbc_wind_prtrs']  = array();
        $gloabl_prtrs['wind_prtrs']    = $wind_prtrs;

        $seismic_prtrs = array();
        $seismic_prtrs['is_seismic_prtrs']   = array();
        $seismic_prtrs['mexi_seismic_prtrs'] = array();
        $seismic_prtrs['nbc_seismic_prtrs']  = array();

        $gloabl_prtrs['seismic_prtrs']    = $seismic_prtrs;
        $gloabl_prtrs['ntnl_load_prtrs']     = array();
        $gloabl_prtrs['conc_prtrs'] = array();
        $gloabl_prtrs['ftn_prtrs']  = array();
        $gloabl_prtrs['lc_grtr_rll_optns']  = array();
        $this->gloabl_parameters($handle, $gloabl_prtrs);

        $material_prtrs = array();
        $material_prtrs['gen_mat']   = array();
        $material_prtrs['hr_steel']  = array();
        $material_prtrs['cf_steel']  = array();
        $material_prtrs['aluminum']  = array();
        $material_prtrs['concrete']  = array();
        $material_prtrs['wood']      = array();
        $material_prtrs['masonry']   = array();
        $this->material_parameters($handle, $material_prtrs);

        $sec_sets = array();
        $sec_sets['hr_steel']  = array();
        $sec_sets['cf_steel']  = array();
        $sec_sets['wood']      = array();
        $sec_sets['general']   = array();
        $sec_sets['concrete']  = array();
        $sec_sets['aluminum']  = array();
        $sec_sets['masonry']   = array();
        $this->section_sets($handle, $sec_sets);

        $wood_skedus = array();
        $wood_skedus['one']  = array();
        $wood_skedus['two']  = array();
        $this->wood_schedules($handle, $wood_skedus);

        $wood_skedu_data = array();
        $this->wood_schedule_data($handle, $wood_skedu_data);

        $wood_hodn_series = array();
        $wood_hodn_series['one']  = array();
        $wood_hodn_series['two']  = array();
        $this->wood_holddown_series($handle, $wood_hodn_series);

        $design_rules = array();
        $design_rules['size_uc']     = array();
        $design_rules['deflection']  = array();
        $design_rules['rebar']       = array();
        $design_rules['masonry_wallpanel']   = array();
        $design_rules['wood_wallpanel']      = array();
        // &&   $this->write->design_rules($handle, $design_rules);


        $mbr_design_rules = array();
        $mbr_design_rules['size_uc']     = array();
        $mbr_design_rules['deflection']  = array();
        $mbr_design_rules['rebar']       = array();
        // &&   $this->write->member_design_rules($handle, $mbr_design_rules);

        $wall_design_rules = array();
        $wall_design_rules['masonry_wallpanel']  = array();
        $wall_design_rules['wood_wallpanel']     = array();
        $wall_design_rules['conc_wallpanel']     = array();
        $wall_design_rules['uc_wallpanel']       = array();
        // &&   $this->write->wall_design_rules($handle, $wall_design_rules);

        $seismic_design_rules = array();
        // &&   $this->write->seismic_design_rules($handle, $seismic_design_rules);


        $conn_rules = array();
        // &&   $this->write->connection_rules($handle, $conn_rules);

        /*
                // all materials
            for ($imat = 0; $imat < sizeof($data['materials']); $imat++) {

            }
        */
        // all nodes
        // for ($inode = 0; $inode < sizeof($data['nodes']); $inode++) {

        // }

        // for ($inode = 0; $inode < sizeof($data->nodes); $inode++) {

        // }

        /*
                // all sections
            for ($isec = 0; $isec < sizeof($data['sections']); $isec++) {

            }

                // all structural members
            for ($imbr = 0; $imbr < sizeof($data['members']); $imbr++) {

            }

                // all discrete appurtenances
            for ($ida = 0; $ida < sizeof($data['analysis_lc']); $ida++) {

            }
        */

    }

	function _project_description($handle, $proj_dsrpn){

		fwrite($handle, "\r\n".'[.PROJECT_DESCRIPTION] <1>'."\r\n");		

		$model_title = "\r\n".'[..MODEL_TITLE] <1>'."\r\n".$proj_dsrpn['model_title']."\r\n".'[..END_MODEL_TITLE]'."\r\n";
		fwrite($handle, $model_title); 	

		$compay_name = "\r\n".'[..COMPANY_NAME] <1>'."\r\n".$proj_dsrpn['compay_name']."\r\n".'[..END_COMPANY_NAME]'."\r\n";
		fwrite($handle, $compay_name);

		$designer_name = "\r\n".'[..DESIGNER_NAME] <1>'."\r\n".$proj_dsrpn['designer_name']."\r\n".'[..END_DESIGNER_NAME]'."\r\n";
		fwrite($handle, $designer_name);

		$job_number = "\r\n".'[..JOB_NUMBER] <1>'."\r\n".$proj_dsrpn['job_number']."\r\n".'[..END_JOB_NUMBER]'."\r\n";
		fwrite($handle, $designer_name); 		 

		fwrite($handle, "\r\n".'[.END_PROJECT_DESCRIPTION]'."\r\n");			

	}

	function _solution_parameters($handle, $sol_prtrs){

		$a_aa= 0.005000; // "a.aa" is the number used to set the P-Delta Convergence Tolerance, in % (default is 0.5)
		$b_bb = 144; // "b.bb" is the number used to set the Area Load Mesh Size (default is 144 in^2)
		$c = 6; // "c" is the integer used to set the number of internal sections
		$d = 5; // "d" is the integer used to se the Number of Sections for displayed reports
		$e = 1; // "e" is the integer used to designate if Shear Deformation shall be included in the analysis.  
		$f = 1; // "f"  is the integer used to designate if Torsional Warping effects shall be included in the analysis.  
		$g = 2; // "g" is the integer used to designate what axis will be used as the vertical_axis
		$h_hh = 0.12; // "h.hh" is the number used to designate the Merge tolerance (default is 0.12 inches)
		$i = 0; // "i" is the integer used to designate the member_orient_default
		$j_jj = 32.2; // "j.jj" is the number used to define the acceleration of gravity (32.2 ft / second^2 is the default)
		$k = 1; // "k" is the integer that defines which type of static solver is used
		$l_ll = 24; // "l.ll" is the integer used for wall panel mesh size (default is 12 inches)
		$m = 0; // "m" is the integer used for the transfer of load between intersecting wood walls
		$n = 1;  
		$o = 1; 
		$p = 1; 
		$q = 3; 
		$r = 1;

		$sol_prtrs = "\r\n".'[.SOLUTION_PARAMETERS] <1>'."\r\n".$a_aa.' '.$b_bb.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h_hh.' '.$i.' '.$j_jj.' '.$k.' '.$l_ll.' '.$m.' '.$n.' '.$o.' '.$p.' '.$q.' '.$r.';'."\r\n".'[.END_SOLUTION_PARAMETERS]'."\r\n";
		fwrite($handle, $sol_prtrs); 		

	}

	function _design_codes($handle, $design_codes){

		$a = 303;
		$b = 30;
		$c = 5;
		$d = 0;
		$e = 17;
		$f = 0;
		$g = 12;
		$h = 1;
		$i = 7;
		$j = 0;
		$k = 0;
		$l = 303;
		$m = 1;
		$n = 0;
		$o = 0;

		$p = 1;
		$q = 1;
		$r = 1;						

		$design_codes = "\r\n".'[.DESIGN_CODES] <1>'."\r\n".$a.' '.$b.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h.' '.$i.' '.$j.' '.$k.' '.$l.' '.$m.' '.$n.' '.$o.' '.$p.' '.$q.' '.$r.';'."\r\n".'[.END_DESIGN_CODES]'."\r\n";
		fwrite($handle, $design_codes); 
	}

	function __is_wind_prtrs($handle, $is_wind_prtrs){
		$is_wind_prtrs = "\r\n".'[..IS_WIND_PARAMETERS] <1>'."\r\n"."\r\n".'[..END_IS_WIND_PARAMETERS]'."\r\n";
		fwrite($handle, $is_wind_prtrs); 
	}

	function __mexi_wind_prtrs($handle, $mexi_wind_prtrs){
		$mexi_wind_prtrs = "\r\n".'[..MEXI_WIND_PARAMETERS] <1>'."\r\n"."\r\n".'[..END_MEXI_WIND_PARAMETERS]'."\r\n";
		fwrite($handle, $mexi_wind_prtrs); 
	}

	function __nbc_wind_prtrs($handle, $nbc_wind_prtrs){
		$nbc_wind_prtrs = "\r\n".'[..NBC_WIND_PARAMETERS] <1>'."\r\n"."\r\n".'[..END_NBC_WIND_PARAMETERS]'."\r\n";
		fwrite($handle, $nbc_wind_prtrs); 
	}


	function _wind_parameters($handle, $wind_prtrs){
		fwrite($handle, "\r\n".'[.WIND_PARAMETERS] <1>'."\r\n");

		$a = 8;
		$b_bb = 115;
		$c = 2;
		$d = 1;
		$e_ee = 0;
		$f_ff = 0;
		$g_gg = 0;
		$h_hh = 0.85;
		$i = 14;
		$j_jj = -999999;
		$k = 1;

		$_wind_prtrs = $a.' '.$b_bb.' '.$c.' '.$d.' '.$e_ee.' '.$f_ff.' '.$g_gg.' '.$h_hh.' '.$i.' '.$j_jj.' '.$k.';'."\r\n";
		fwrite($handle, $_wind_prtrs);

		$is_wind_prtrs = $wind_prtrs['is_wind_prtrs'];
		$this->__is_wind_prtrs($handle, $is_wind_prtrs);

		$mexi_wind_prtrs = $wind_prtrs['mexi_wind_prtrs'];
		$this->__mexi_wind_prtrs($handle, $mexi_wind_prtrs);

		$nbc_wind_prtrs = $wind_prtrs['nbc_wind_prtrs'];
		$this->__nbc_wind_prtrs($handle, $nbc_wind_prtrs);				

		fwrite($handle, "\r\n".'[.END_WIND_PARAMETERS]'."\r\n");
	}


	function __is_seismic_prtrs($handle, $is_seismic_prtrs){
		$is_seismic_prtrs = "\r\n".'[..IS_SEISMIC_PARAMETERS] <1>'."\r\n"."\r\n".'[..END_IS_SEISMIC_PARAMETERS]'."\r\n";
		fwrite($handle, $is_seismic_prtrs); 
	}

	function __mexi_seismic_prtrs($handle, $mexi_seismic_prtrs){
		$mexi_seismic_prtrs = "\r\n".'[..MEXI_SEISMIC_PARAMETERS] <1>'."\r\n"."\r\n".'[..END_MEXI_SEISMIC_PARAMETERS]'."\r\n";
		fwrite($handle, $mexi_seismic_prtrs); 
	}

	function __nbc_seismic_prtrs($handle, $nbc_seismic_prtrs){
		$nbc_seismic_prtrs = "\r\n".'[..NBC_SEISMIC_PARAMETERS] <1>'."\r\n"."\r\n".'[..END_NBC_SEISMIC_PARAMETERS]'."\r\n";
		fwrite($handle, $nbc_seismic_prtrs); 
	}	


	function _seismic_parameters($handle, $seismic_prtrs){
		fwrite($handle, "\r\n".'[.SEISMIC_PARAMETERS] <1>'."\r\n");

		$a=9;	$b_bb=0.02;	$c_cc=0.02;	$d_dd=-1;	$e_ee=-1;	$f_ff=3;	$g_gg=3;	$h=3;	$i=3;	$j_jj=1;	$k=0;	$l_ll=0.54;	$m_mm=0.36;	$n_nn=1;	$o_oo=1;	$p_pp=1;	$q=-1;	$r=20;	$s_ss=-999999;	$t=1;	$u_uu=5;	$v_vv=0.75;	$w_ww=0.75;	$x_xx=0.54;	$y_yy=0.36;	$z_zz=1;	$a1_a1a1=1;	$b1_b1b1=1;	$c1_c1c1=1;	$d1=3;	$e1_e1e1=4;	$f1_f1f1=4;

		$_seismic_prtrs = $a.' '.$b_bb.' '.$c_cc.' '.$d_dd.' '.$e_ee.' '.$f_ff.' '.$g_gg.' '.$h.' '.$i.' '.$j_jj.' '.$k.' '.$l_ll.' '.$m_mm.' '.$n_nn.' '.$o_oo.' '.$p_pp.' '.$q.' '.$r.' '.$s_ss.' '.$t.' '.$u_uu.' '.$v_vv.' '.$w_ww.' '.$x_xx.' '.$y_yy.' '.$z_zz.' '.$a1_a1a1.' '.$b1_b1b1.' '.$c1_c1c1.' '.$d1.' '.$e1_e1e1.' '.$f1_f1f1.';';
		fwrite($handle, $_seismic_prtrs);

		$is_seismic_prtrs = $seismic_prtrs['is_seismic_prtrs'];
		$this->__is_seismic_prtrs($handle, $is_seismic_prtrs);

		$mexi_seismic_prtrs = $seismic_prtrs['mexi_seismic_prtrs'];
		$this->__mexi_seismic_prtrs($handle, $mexi_seismic_prtrs);

		$nbc_seismic_prtrs = $seismic_prtrs['nbc_seismic_prtrs'];
		$this->__nbc_seismic_prtrs($handle, $nbc_seismic_prtrs);				

		fwrite($handle, "\r\n".'[.END_SEISMIC_PARAMETERS]'."\r\n");
	}


	function _notional_load_parameters($handle, $ntnl_load_prtrs){
		fwrite($handle, "\r\n".'[.NOTIONALLoad_PARAMETERS] <1>'."\r\n");

		$a_aa = 0.010000;
		$b_bb = 0.010000;
		$c = -1;
		$d = 12;
		$e = -1;
		$f = -1;
		$g = -1;
		$h_hh = 0; 
		$i = 0;
		$j = 1;

		$ntnl_load_prtrs = $a_aa.' '.$b_bb.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h_hh.' '.$i.' '.$j.';';
		fwrite($handle, $ntnl_load_prtrs);			

		fwrite($handle, "\r\n".'[.NOTIONALLoad_PARAMETERS]'."\r\n");
	}


	function _concrete_parameters($handle, $conc_prtrs){
		fwrite($handle, "\r\n".'[.CONCRETE_PARAMETERS] <1>'."\r\n");

		$a=0; // "a" is the integer used to designate if "Framing Warnings" should be shown.
		$b=1; // "b" is the integer used to designate if Cracked Sections should be considered
		$c_cc=4; // "c.cc" is the number used to designate the shear steel increment.  The minimum is 1.0 inches, and the default is 4.0 inches.
		$d_dd=2; // "d.dd" is the number used to designate the space between the face of support and the first stirrup.  This field is not currently used.
		$e=4; // "e" is the integer used to designate the number of shear regions in the beams.  This may be set to 2 or 4.  The default is 4.
		$f=1; // "f" is the integer used to designate the whether the concrete force warnings should be displayed or not. 
		$g=1; // "g" is the integer used to designate which concrete stress block should be used.  
		$h=2; // "h" is the integer used to designate which method should be used for the Bi-Axial column solutions. 
		$i_ii=0.65;	// "i.ii" is the number used to designate the Parme Beta Factor.  This will vary from 0.5 to 1.0 with a default of 0.65.  
		$j=0; // "j" is the integer used to designate rebar set being used.  
		$k_kk=8; // "k.kk" is the number used to designate the maximum percentage of steel allowed in a column.  This may be any value from 0 to 100, with a default of 8.0.  
		$l=0; // "l" is the integer used to designate if you are requiring only 1 bar diameter clear spacing.
		$m_mm=1; // "m.mm" is the number used to designate the Minimum percentage of steel allowed in a column.

		$o=0;	
		$p=0;	
		$q=1;

		$conc_prtrs = $a.' '.$b.' '.$c_cc.' '.$d_dd.' '.$e.' '.$f.' '.$g.' '.$h.' '.$i_ii.' '.$j.' '.$k_kk.' '.$l.' '.$m_mm.' '.$o.' '.$p.' '.$q.';';
		fwrite($handle, $conc_prtrs);			

		fwrite($handle, "\r\n".'[.CONCRETE_PARAMETERS]'."\r\n");
	}	


	function _footing_parameters($handle, $ftn_prtrs){
		fwrite($handle, "\r\n".'[.FOOTING_PARAMETERS] <1>'."\r\n");

		$a_aa=0.145152;	
		$b_bb=4;	
		$c_cc=3644;	
		$d_dd=60;	
		$e_ee=0.0018;	
		$f_ff=0.0075;	
		$g_gg=1;	
		$h_hh=1.5;	
		$i_ii=3;	
		$j_jj=1.5;	
		$k=3;	
		$l=3;	
		$m=3;	
		$n=1;	
		$o=0;	
		$p=1;	
		$q=1;

		$ftn_prtrs = $a_aa.' '.$b_bb.' '.$c_cc.' '.$d_dd.' '.$e_ee.' '.$f_ff.' '.$g_gg.' '.$h_hh.' '.$i_ii.' '.$j_jj.' '.$k.' '.$l.' '.$m.' '.$n.' '.$o.' '.$p.' '.$q.';';
		fwrite($handle, $ftn_prtrs);			

		fwrite($handle, "\r\n".'[.FOOTING_PARAMETERS]'."\r\n");
	}	


	function _lc_generator_rll_options($handle, $lc_grtr_rll_optns){
		fwrite($handle, "\r\n".'[.LC_GENERATOR_RLL_OPTIONS] <1>'."\r\n");

		$a = 1;
		$b = 0;
		$c = 0;

		$lc_grtr_rll_optns = $a.' '.$b.' '.$c.';';
		fwrite($handle, $lc_grtr_rll_optns);			

		fwrite($handle, "\r\n".'[.LC_GENERATOR_RLL_OPTIONS]'."\r\n");
	}		


	function gloabl_parameters($handle, $gloabl_prtrs){

		fwrite($handle, "\r\n".'[GLOBAL_PARAMETERS] <1>'."\r\n");

		$proj_dsrpn = $gloabl_prtrs['proj_dsrpn'];
		$this->_project_description($handle, $proj_dsrpn);

		$sol_prtrs  = $gloabl_prtrs['sol_prtrs'];
		$this->_solution_parameters($handle, $sol_prtrs);

		$design_codes  = $gloabl_prtrs['design_codes'];
		$this->_design_codes($handle, $design_codes);	

		$wind_prtrs  = $gloabl_prtrs['wind_prtrs'];
		$this->_wind_parameters($handle, $wind_prtrs);

		$seismic_prtrs  = $gloabl_prtrs['seismic_prtrs'];
		$this->_seismic_parameters($handle, $seismic_prtrs);

		$ntnl_load_prtrs  = $gloabl_prtrs['ntnl_load_prtrs']; // NOTIONALLoad_PARAMETERS
		$this->_notional_load_parameters($handle, $ntnl_load_prtrs);

		$conc_prtrs  = $gloabl_prtrs['conc_prtrs']; // CONCRETE_PARAMETERS
		$this->_concrete_parameters($handle, $conc_prtrs);

		$ftn_prtrs  = $gloabl_prtrs['ftn_prtrs']; // FOOTING_PARAMETERS
		$this->_footing_parameters($handle, $ftn_prtrs);

		$lc_grtr_rll_optns  = $gloabl_prtrs['lc_grtr_rll_optns']; // LC_GENERATOR_RLL_OPTIONS
		$this->_lc_generator_rll_options($handle, $lc_grtr_rll_optns);	

		fwrite($handle, "\r\n".'[END_GLOBAL_PARAMETERS]'."\r\n");			
	}

	function label_length($handle, $label_length){
		fwrite($handle, "\r\n".'[.LABEL_LENGTHS] <1>'."\r\n");

		$a=32;	$b=32;	$c=32;	$d=32;	$e=32;	$f=32;	$g=32;	$h=32;	$i=32;	$j=32;	$k=32;	$l=32;	$m=32;	$n=79;	$o=200;	$p=200;	$q=32;	$r=32;	$s=36;	$t=32;	$u=10;	$v=32;	$w=32;

		$lable_lth = $a.' '.$b.' '.$c.' '.$d.' '.$e.' '.$f.' '.$g.' '.$h.' '.$i.' '.$j.' '.$k.' '.$l.' '.$m.' '.$n.' '.$o.' '.$p.' '.$q.' '.$r.' '.$s.' '.$t.' '.$u.' '.$v.' '.$w.';';
		fwrite($handle, $lable_lth);			

		fwrite($handle, "\r\n".'[.LABEL_LENGTHS]'."\r\n");
	}	



	function _general_material($handle, $gen_mat){
		fwrite($handle, "\r\n".'[.GENERAL_MATERIAL] <1>'."\r\n");

		$a_aa = 1000000; // "a.aa" is the number used to designate the elastic modulus (Default = 29000)
		$b_bb = 0;       // "b.bb" is the number used to designate the shear modulus (The default is calculated based on the Elastic Modulus and the Poisson's ratio).
		$c_cc = 0.3;     // "c.cc" is the number used to designate the Poisson's Ratio. (Default = 0.3)
		$d_dd = 0;       // "d.dd" is the number used to designate the thermal expansion coefficient (Default = 0.65E-5)
		$e_ee = 0;       // "e.ee" is the number used to designate the density of the material (Default = 0.49 k / ft3)
		$f    = -1;      // "f” is the integer used to designate the BIM material Id.

		$gen_mat = '"RIGID"'.' '.$a_aa.' '.$b_bb.' '.$c_cc.' '.$d_dd.' '.$e_ee.' '.$f.';';
		fwrite($handle, $gen_mat);

		fwrite($handle, "\r\n".'[.END_GENERAL_MATERIAL]'."\r\n");
	}


	function _hr_steel($handle, $hr_steel){


		$hr_steel = array(
			"A992"          =>array(29000.000000,11154.000000,0.300000,0.650000,0.490000,50.000000,-1,1.100000,65.000000,1.100000),
			"A36 Gr.36"     =>array(29000.000000,11154.000000,0.300000,0.650000,0.490000,36.000000,-1,1.500000,58.000000,1.200000),
			"A572 Gr.50"    =>array(29000.000000,11154.000000,0.300000,0.650000,0.490000,50.000000,-1,1.100000,65.000000,1.100000),
			"A500 Gr.B RND" =>array(29000.000000,11154.000000,0.300000,0.650000,0.527000,42.000000,-1,1.400000,58.000000,1.300000),
			"A500 Gr.B Rect"=>array(29000.000000,11154.000000,0.300000,0.650000,0.527000,46.000000,-1,1.400000,58.000000,1.300000),
			"A53 Gr.B"      =>array(29000.000000,11154.000000,0.300000,0.650000,0.490000,35.000000,-1,1.600000,60.000000,1.200000)
			);
		$keys = array_keys($hr_steel);

		fwrite($handle, "\r\n".'[.HR_STEEL_MATERIAL] <'.count($keys).'>'."\r\n");		

		for($x = 0; $x < count($keys); $x++) {

			$mat = $hr_steel[$keys[$x]];
			$a_aa=$mat[0]; // "a.aa" is the number used to designate the elastic modulus (Default i= 29000)
			$b_bb=$mat[1]; // "b.bb" is the number used to designate the shear modulus (default is calculated based on the Elastic Modulus and the Poisson's ratio).
			$c_cc=$mat[2];	 // "c.cc" is the number used to designate the Poisson's Ratio. (Default = 0.3)
			$d_dd=$mat[3];	 // "d.dd" is the number used to designate the thermal expansion coefficient (Default = 0.65E-5)
			$e_ee=$mat[4];	 // "e.ee" is the number used to designate the density of the material (Default = 0.49 k / ft3)
			$f_ff=$mat[5];	 // "f.ff" is the number used to designate the yield strength of hot rolled (Default = 36 ksi)
			$g=$mat[6];	 // “g” is the integer used to designate the BIM material Id.
			$h_hh=$mat[7];	// “h.hh” is the number used to designate Ry. (the ratio of expected yield stress to the specified minimum yield stress)
			$i_ii=$mat[8];	// “i.ii” is the number used to designate the specified minimum tensile strength.
			$j_jj=$mat[9]; // “j.jj” is the number used to designate Rt. (for future use to determine expected tensile strength for seismic detailing)

			$mat = '"'.$keys[$x].'"'.' '.$a_aa.' '.$b_bb.' '.$c_cc.' '.$d_dd.' '.$e_ee.' '.$f_ff.' '.$g.' '.$h_hh.' '.$i_ii.' '.$j_jj.';';
			fwrite($handle, $mat);
			if($x != count($keys) - 1){
				fwrite($handle, "\r\n");
			}
		}

		fwrite($handle, "\r\n".'[.END_HR_STEEL_MATERIAL]'."\r\n");
	}		


	function _cf_steel($handle, $cf_steel){

		fwrite($handle, "\r\n".'[.CF_STEEL_MATERIAL] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_CF_STEEL_MATERIAL]'."\r\n");
	}

	function _aluminum($handle, $aluminum){

		fwrite($handle, "\r\n".'[.ALUMINUM_MATERIAL] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_ALUMINUM_MATERIAL]'."\r\n");
	}	

	function _wood($handle, $wood){

		fwrite($handle, "\r\n".'[.WOOD_MATERIAL] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_WOOD_MATERIAL]'."\r\n");
	}

	function _concrete($handle, $concrete){

		fwrite($handle, "\r\n".'[.CONCRETE_MATERIAL] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_CONCRETE_MATERIAL]'."\r\n");
	}

	function _masonry($handle, $masonry){

		fwrite($handle, "\r\n".'[.MASONRY_MATERIAL] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_MASONRY_MATERIAL]'."\r\n");
	}									


	function material_parameters($handle, $mat_prtrs){

		fwrite($handle, "\r\n".'[MATERIAL_PROPERTIES] <1>'."\r\n");

		$gen_mat = $mat_prtrs['gen_mat'];
		$this->_general_material($handle, $gen_mat);

		$hr_steel = $mat_prtrs['hr_steel'];
		$this->_hr_steel($handle, $hr_steel);	

		$cf_steel = $mat_prtrs['cf_steel'];
		$this->_cf_steel($handle, $cf_steel);

		$aluminum = $mat_prtrs['aluminum'];
		$this->_aluminum($handle, $aluminum);	

		$wood = $mat_prtrs['wood'];
		$this->_wood($handle, $wood);

		$concrete = $mat_prtrs['concrete'];
		$this->_concrete($handle, $concrete);

		$masonry = $mat_prtrs['masonry'];
		$this->_masonry($handle, $masonry);						

		fwrite($handle, "\r\n".'[END_MATERIAL_PROPERTIES]'."\r\n");			
	}


	function _hr_steel_sec($handle, $hr_steel){

		fwrite($handle, "\r\n".'[.HR_STEEL_SECTION_SETS] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_HR_STEEL_SECTION_SETS]'."\r\n");
	}


	function _cf_steel_sec($handle, $hr_steel){

		$hr_steel = array(
			"Face Horizontal"  =>array("Pipe","HSS3.500x0.313",1,1,3,0,0,2.930000,3.810000,3.810000,7.610000,-1),
			"Mount Pipe"       =>array("Pipe","PIPE_2.0",      1,1,5,0,0,1.020000,0.627000,0.627000,1.250000,-1),
			"Sidearm"          =>array("Tube","HSS4x4x4",      1,1,4,0,0,3.370000,7.800000,7.800000,12.800000,-1),
			"Support Vertical" =>array("Pipe","PIPE_4.0",      1,1,5,0,0,2.960000,6.820000,6.820000,13.600000,-1),
			"Platform_PL"      =>array("RECT","PL6x0.125",     1,1,1,0,0,0.750000,0.000977,2.250000,0.003855,-1),
			"DM_PL"            =>array("RECT","2.375*0.5",     1,1,1,0,0,0.750000,0.016000,0.141000,0.049000,-1),
			"Grating_Pipe"     =>array("Pipe","PIPE_2.5",      1,1,5,0,0,1.610000,1.450000,1.450000,2.890000,-1)
			);
		$keys = array_keys($hr_steel);

		fwrite($handle, "\r\n".'[.CF_STEEL_SECTION_SETS] <0>'."\r\n");			

		for($x = 0; $x < count($keys); $x++) {

			$mat = $hr_steel[$keys[$x]];

			$SECTION_LABEL = $keys[$x]; // The Section Label is a designator set by the user may be up to 20 characters long.
			$DESIGN_LIST = $mat[0]; // The Design List references the redesign file designated by the user and may be up to 32 characters long.
			$SHAPE_LABEL = $mat[1]; // The Shape Label is a designator set by the user may be up to 20 characters long.
			$a = $mat[2]; // "a" is the integer used to define the Member Type.
			$b = $mat[3]; // "b" is the integer used to define the Material Type.
			$c = $mat[4]; // "c" is the integer used to define the Material Offset.
			$d = $mat[5]; // "d" is the integer used to define the Shape Lock code.
			$e = $mat[6]; // "e" is the integer used to define the Redesign Rules associated with this section set.  
			$f_ff = $mat[7]; // "f.ff" is the number used to define the area of the member.
			$g_gg = $mat[8]; // "g.gg" is the number used to define the Iyy of the member..
			$h_hh = $mat[9]; // "h.hh" is the number used to define the Izz of the member..
			$i_ii = $mat[10]; // "i.ii" is the number used to define the J of the member..

			$sec_sec = '"'.$SECTION_LABEL.'"'.' '.'"'.$DESIGN_LIST.'"'.' '.'"'.$SHAPE_LABEL.'"'.' '.$a.' '.$b.' '.$c.' '.$d.' '.$e.' '.$f_ff.' '.$g_gg.' '.$h_hh.' '.$i_ii.';';
			fwrite($handle, $sec_sec);
			if($x != count($keys) - 1){
				fwrite($handle, "\r\n");
			}
		}			

		fwrite($handle, "\r\n".'[.END_CF_STEEL_SECTION_SETS]'."\r\n");
	}


	function _wood_sec($handle, $wood){

		fwrite($handle, "\r\n".'[.WOOD_SECTION_SETS] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_WOOD_SECTION_SETS]'."\r\n");
	}	


	function _general_sec($handle, $general){

		fwrite($handle, "\r\n".'[.GENERAL_SECTION_SETS] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_GENERAL_SECTION_SETS]'."\r\n");
	}

	function _concrete_sec($handle, $concrete){

		fwrite($handle, "\r\n".'[.CONCRETE_SECTION_SETS] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_CONCRETE_SECTION_SETS]'."\r\n");
	}


	function _aluminum_sec($handle, $aluminum){

		fwrite($handle, "\r\n".'[.ALUMINUM_SECTION_SETS] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[.END_ALUMINUM_SECTION_SETS]'."\r\n");
	}			


	function section_sets($handle, $sec_sets){

		fwrite($handle, "\r\n".'[SECTION_SETS] <1>'."\r\n");

		$hr_steel = $sec_sets['hr_steel'];
		$this->_hr_steel_sec($handle, $hr_steel);	

		$cf_steel = $sec_sets['cf_steel'];
		$this->_cf_steel_sec($handle, $cf_steel);

		$wood = $sec_sets['wood'];
		$this->_wood_sec($handle, $wood);		

		$general = $sec_sets['general'];
		$this->_general_sec($handle, $general);		

		$concrete = $sec_sets['concrete'];
		$this->_concrete_sec($handle, $concrete);

		$aluminum = $sec_sets['aluminum'];
		$this->_aluminum_sec($handle, $aluminum);								

		fwrite($handle, "\r\n".'[END_SECTION_SETS]'."\r\n");			
	}	

	function _wood_skedus($handle, $wood_skedus_1){

		fwrite($handle, "\r\n".'[WOOD_SCHEDULE : 1] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[END_WOOD_SCHEDULE : 1]'."\r\n");
	}


	function wood_schedules($handle, $wood_skedus){

		fwrite($handle, "\r\n".'WOOD_SCHEDULES] <1>'."\r\n");

		$wood_skedus_1 = $wood_skedus['one'];
		$this->_wood_skedus($handle, $wood_skedus_1);					

		fwrite($handle, "\r\n".'[END_WOOD_SCHEDULES]'."\r\n");			
	}


	function wood_schedule_data($handle, $wood_skedu_data){

		fwrite($handle, "\r\n".'[WOOD_SCHEDULES_DATA] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[END_WOOD_SCHEDULES_DATA]'."\r\n");
	}	


	function _wood_hodn($handle, $wood_hodn_1){

		fwrite($handle, "\r\n".'[WOOD_HOLDDOWN_SERIES : 1] <0>'."\r\n");		

		fwrite($handle, "\r\n".'[END_WOOD_HOLDDOWN_SERIES : 1]'."\r\n");
	}


	function wood_holddown_series($handle, $wood_hodn_series){

		fwrite($handle, "\r\n".'WOOD_HOLDDOWN_SERIES] <1>'."\r\n");

		$wood_hodn_1 = $wood_hodn_series['one'];
		$this->_wood_hodn($handle, $wood_hodn_1);					

		fwrite($handle, "\r\n".'[END_WOOD_HOLDDOWN_SERIES]'."\r\n");			
	}	



}

?>