<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('./../../../../../../../../../config.php');
//require_once('./../../../../../../WID/engeneering.php');
include('calculations/wl_d_change.php');

require_once "wl_da_engeneering.php";

$g_calc = new g_calc();
$da_eng = new da_eng();

//$wid = new wid();

class Generic {
    private $db;

    private $config;

    private $usersID;
    
    function __construct($database = "calc") {
        global $g_calc;
        global $da_eng;

        $this->calc = $g_calc;
        $this->da_eng = $da_eng;
        
        $this->config = array(
            'data' => array(),
            'database' => array(
                'wid' => array(
                    'host' => DB_HOSTNAME,
                    'username' => DB_USERNAME,
                    'password' => DB_PASSWORD,
                    'db' => DB_WID_NAME
                ),
                'calc' => array(
                    'host' => DB_HOSTNAME,
                    'username' => DB_USERNAME,
                    'password' => DB_PASSWORD,
                    'db' => DB_CALC_NAME
                )
            )
        );

        $this->db    = $this->database();
        $this->dbwid = $this->database_wid();

        $this->usersID = '155,140,175';


    }

    function database() {
        $conn = new mysqli(
            $this->config['database']['calc']['host'],
            $this->config['database']['calc']['username'],
            $this->config['database']['calc']['password'],
            $this->config['database']['calc']['db']
        );

        if ($conn->connect_errno) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }

    function database_wid() {
        $conn = new mysqli(
            $this->config['database']['wid']['host'],
            $this->config['database']['wid']['username'],
            $this->config['database']['wid']['password'],
            $this->config['database']['wid']['db']
        );

        if ($conn->connect_errno) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }

    function getProductsList($users, $privateId) {
        $data = array();

        //LINKS

        $query_links = "SELECT id, linkID FROM db_product WHERE mode = 'link' AND linkID IS NOT NULL AND userID = {$privateId}";

        if ($result = $this->dbwid->query($query_links)) {
            while ($row = $result->fetch_row()) {
                $links[] = $row[1];
            }

            $result->close();
        }

        $linkids = '';

        if(!empty($links)) {
            $linkids = ''.implode(',',$links);
        } else {
            $linkids = '-1';
        }

        $whereNew = 'userID IN '.$users.' OR id IN('.$linkids.')';

        //

        $query = "SELECT * FROM db_product WHERE ".$whereNew;

        if ($result = $this->dbwid->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;
    }

    function getVPcalcsList($calcId) {

        $data = array();
        $dataVp = array();

        $query = "SELECT * FROM userscalc WHERE `RcdNo` = {$calcId}";

        if ($result = $this->db->query($query)) {
            $data = $result->fetch_assoc();

            $result->close();

            if(!empty($data['projectID'])) {
                $project = $data['projectID'];
                $parent = $data['parentID'];

                $queryVp = "SELECT * FROM userscalc WHERE `parentID` = {$parent} AND `projectID` = {$project} AND `calcAppName` = 'TIA-222-G-VP'";

                if ($resultVp = $this->db->query($queryVp)) {
                    while ($row = $resultVp->fetch_assoc()) {
                        $dataVp[] = $row;
                    }

                    $resultVp->close();
                }

                return array(
                    'query' => $queryVp,
                    'data' => $dataVp
                );

            } else {
                return array(
                    'error' => 'Error with calc info',
                    'data' => $data,
                    'query' => $query
                );
            }


        }



    }
    
    function getEquipment($users, $privateId) {
        
        $ddls = array();
        $table = 'db_product';
        $columns = array(
            'type' => "Type",
            'sub_type' => "Sub Type",
            'shape' => "Shape",
            'mftr' => "Manufacturer",
            'model' => "Model"
        );

        $links = array();


        $whereU = 'userID IN '.$users;

        //LINKS

        $query_links = "SELECT id, linkID FROM {$table} WHERE mode = 'link' AND linkID IS NOT NULL AND userID = {$privateId}";

        if ($result = $this->dbwid->query($query_links)) {
            while ($row = $result->fetch_row()) {
                $links[] = $row[1];
            }

            $result->close();
        }


        $linkids = '';

        if(!empty($links)) {
            $linkids = ''.implode(',',$links);
        } else {
            $linkids = '-1';
        }

        $whereNew = 'AND ( '.$whereU.' OR id IN('.$linkids.') )';

        //



        foreach ($columns as $column => $value) {
            $data = array();

            $query = "SELECT id, {$column} FROM {$table} WHERE {$column} IS NOT NULL {$whereNew} GROUP BY {$column}";

            if ($result = $this->dbwid->query($query)) {
                while ($row = $result->fetch_row()) {
                    $data[] = array(
                        'id' => $row[0],
                        'value' => $row[1]
                    );
                }

                $result->close();
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'sql' => $query,
                'data' => $data
            );
        }

        return $ddls;
    }

    function sortEq ($data, $users, $privateId) {
        $data = json_decode(json_encode($data));

        if(empty($data)) $data = array();
        $ddls = array();
        $last = array();
        $selected = array();
        $columns = array(
            'type' => "Type",
            'sub_type' => "Sub Type",
            'shape' => "Shape",
            'mftr' => "Manufacturer",
            'model' => "Model"
        );
        $size = array(
            100,
            100,
            100,
            100,
            250
        );

        $links = array();

        $whereU = 'userID IN '.$users;


        //LINKS

        $query_links = "SELECT id, linkID FROM db_product WHERE mode = 'link' AND linkID IS NOT NULL AND userID = {$privateId}";

        if ($result = $this->dbwid->query($query_links)) {
            while ($row = $result->fetch_row()) {
                $links[] = $row[1];
            }

            $result->close();
        }


        $linkids = '';

        if(!empty($links)) {
            $linkids = ''.implode(',',$links);
        } else {
            $linkids = '-1';
        }

        $whereNew = 'AND ( '.$whereU.' OR id IN('.$linkids.') )';

        //

        foreach ($data as $item) {
            $last[] = $item->last;
            $selected[] = $item->key;
        }

        foreach ($columns as $column => $value) {
            $where = '';
            $array = array();
            $num = array_search($column, $selected);

            if ($num !== false) {
                if ($num != 0) {
                    $where = ' AND ';
                    if ($last[$num] != "true") {
                        for ($i = 0; $i <= $num - 1 ; $i++) {
                            $where .= $data[$i]->key.' = "'.$data[$i]->value.'" ';
                            if ($i != $num-1) {
                                $where .= ' AND ';
                            }
                        }
                    } else {
                        for ($i = 0; $i < $num; $i++) {
                            $where .= $data[$i]->key.' = "'.$data[$i]->value.'" ';
                            if ($i != ($num - 1)) {
                                $where .= ' AND ';
                            }
                        }
                    }
                }
            } else {
                $count = count($data);
                if($count){
                    $where = ' AND ';

                    for ($i = 0; $i < $count; $i++) {
                        $where .= ' '.$data[$i]->key.' = "'.$data[$i]->value.'" ';
                        if ($i != ($count - 1)) {
                            $where .= ' AND ';
                        }
                    }
                }
            }

            $query = "SELECT id, {$column} FROM db_product WHERE {$column} IS NOT NULL {$where} {$whereNew} GROUP BY {$column}";

            if ($result = $this->dbwid->query($query)) {
                while ($row = $result->fetch_row()) {
                    $array[] = array(
                        'id' => $row[0],
                        'value' => $row[1],
                        'query' => $query
                    );
                }
                
            }

            $ddls[] = array(
                'key' => $column,
                'name' => $value,
                'data' => $array,
                'query' => $query,
                'num' => $num,
                '$last[$num]' => $last[$num]
            );
        }

        foreach ($ddls as $i => &$ddl) {
            $ddl['size'] = $size[$i];
        }

        return $ddls;
    }
    
    function items( $data, $users, $privateId) {
        $data = json_decode(json_encode($data));

        $links = array();

        if(empty($data)) $data = array();
        $table = 'db_product';

        $query = "SELECT * FROM {$table} WHERE ";

        foreach ($data as $column) {
            $query .= $column->key.' = "'.$column->value.'" AND ';
        }

        $whereU = ' userID IN '.$users;


        //LINKS

        $query_links = "SELECT id, linkID FROM {$table} WHERE mode = 'link' AND linkID IS NOT NULL AND userID = {$privateId}";

        if ($result = $this->dbwid->query($query_links)) {
            while ($row = $result->fetch_row()) {
                $links[] = $row[1];
            }

            $result->close();
        }


        $linkids = '';

        if(!empty($links)) {
            $linkids = ''.implode(',',$links);
        } else {
            $linkids = '-1';
        }

        $whereNew = '( '.$whereU.' OR id IN('.$linkids.') )';

        //

        $query = $query.$whereNew;

        $array = array();

        if ($result = $this->dbwid->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $array['data'][] = $row;
            }
        }


        return $array;
    }

    function updatewlda($calcId, $vp_calc, $ice_thk, $wind_dir) {
        $query = "UPDATE tia_222_g_wl_da SET `vp_calc`='{$vp_calc}', `ice_thk`='{$ice_thk}' , `wind_dir`='{$wind_dir}' WHERE `userscalcPK` = '{$calcId}'";

        $status = $this->db->query($query);

        if(!$status){
            return [
                'error' => 'cant update wlda',
                'query' => $query
            ];
        } else {
            return [
                'status' => true,
                'query' => $query
            ];
        }
    }

    function addEquipment($data) {
        $data = json_decode(json_encode($data));

        // $product_data = $this->getProductAddInfo($data->db_pro_PK);

        // if($product_data[0]) {
        //     if ($product_data[0]['geometryType'] == 'single_object') {
        //         $product_data[0] = $this->da_eng->calc('single_object', $product_data[0]['geometryShapeType'], $product_data);
        //     } else {
        //         // get the face data from db_pro_PK.sql
        //         $product_data[0]['resultData'] = array();
        //         $product_data[0]['resultData']['faces'] = $this->getProductWa($data->db_pro_PK);
        //     }
        // }

        $notes = !empty($data->notes) ? $data->notes : '';
        $name  = !empty($data->name) ? $data->name : '';

        $query0 = "SELECT * FROM `tia_222_g_wl_da` WHERE `userscalcPK` =  {$data->calcPK}";

        if ($result0 = $this->db->query($query0)) {
            while ($row = $result0->fetch_assoc()) {
                $base_wl_data = $row;
            }
        }

        if(!empty($base_wl_data)) {

            $equip_id_da = $base_wl_data['id'];

        } else {
            $query1 = "INSERT INTO `tia_222_g_wl_da` (`userscalcPK`) VALUES ('$data->calcPK')";

            $status1 = $this->db->query($query1);

            $equip_id_da = $this->db->insert_id;
        }

        $query_lib = "INSERT INTO `tia_222_g_wl_da_lib` (`tia_222_g_wl_da_PK`, `db_pro_PK`, `name`, `notes`) VALUES ('{$equip_id_da}', '$data->db_pro_PK', '$name', '$notes')";

        $status2 = $this->db->query($query_lib);

        return array(
            '$query1' => $query1,
            '$status1' => $status1,
            '$query_lib' => $query_lib,
            '$status2' => $status2
            // 'error' => $product_data[0] ? false : 'Cant find product data'
        );
    }

    function updateEquipment($equipment){
        $equipment = json_decode(json_encode($equipment));

        $id = '';
        $set = '';

        foreach ($equipment as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change') {
                continue;
            }

            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE tia_222_g_wl_da_lib SET {$set} WHERE `id` = '{$id}'";

        $status = $this->db->query($query);

        if(!$status){
            return [
                'error' => 'cant update equipment',
                'query' => $query
            ];
        } else {
            return [
                'status' => true,
                'query' => $query
            ];
        }

    }

    function getListForEquipment($data){
        $data = json_decode(json_encode($data));

        $product_data = $this->getProductAddInfo($data->db_pro_PK);

        $units  = $data->units;

        // var_dump($data); exit;

        // $writedir = 'debug/';  
        // $filename = 'data.json';
        // file_put_contents( $writedir.$filename, json_encode($data, JSON_PRETTY_PRINT));        
        $product_data[0]['units'] = $units; 

        $product_data[0]['frt_azm']  = array('value'=>$data->frt_azm, 'unit'=>$units->frt_azm);
        $product_data[0]['z'] = array('value'=>$data->ctr_elev, 'unit'=>$units->ctr_elev);
        $product_data[0]['t_iz']  = array('value'=>$data->ice_thk, 'unit'=>$units->ice_thk);

        $product_data[0]['q_z']  = array('value'=>$data->q_z, 'unit'=>$units->q_z);

        $product_data[0]['g_h']    = $data->g_h;
        $product_data[0]['k_a']    = $data->k_a;

        $product_data[0]['epa_a']  = array('value'=>$data->epa_a, 'unit'=>$units->epa_a);
        $product_data[0]['dwf']    = array('value'=>$data->dwf, 'unit'=>$units->dwf);        

        $product_data[0]['quantity'] = $data->quantity;
        $product_data[0]['vp_calc_id']  = $data->vp->calc_id;

        if(isset($data->vp->calc_id)){

            // if $data->vp_calc_id is not empty, has a valid value from the selection
            // retrieve the values of the saved calc identified by vp_calc_id and assign the values to $vp_data
            // include the units for variables.

            $vp_data = array();

            $vp_query = "SELECT * FROM tia_222_g_vp WHERE userscalcPK = {$data->vp->calc_id}";

            if ($result = $this->db->query($vp_query)) {
                $temp = $result->fetch_assoc();

                $units4vp = $data->vp->units;

                // $writedir = 'debug/';
                // $filename = 'vp_units.json';
                // file_put_contents( $writedir.$filename, json_encode($units4vp , JSON_PRETTY_PRINT));  

                $vp_data['exp_cat'] =  $temp['expCAT'];

                $vp_data['topCAT'] =  $temp['topCAT'];
                $vp_data['H_crest'] = array('value'=> $temp['H_crest'], 'unit'=>$units4vp->H_crest);

                // $vp_data['z_g'] = array('value'=> $temp['z_g'], 'unit'=>$units4vp->z_g);
                // $vp_data['z'] = array('value'=> $temp['z'], 'unit'=>$units4vp->z);
                // $vp_data['q_z'] = array('value'=> $temp['q_z'], 'unit'=>$units4vp->->q_z);

                $vp_data['str_type'] =  $temp['str_type'];
                $vp_data['str_cros_sec'] =  $temp['str_cros_sec'];

                $vp_data['str_class'] =  $temp['str_class'];
                $vp_data['purpose_of_calculation'] =  $temp['purpose_of_calculation'];
                $vp_data['V'] = array('value'=>$temp['V'], 'unit'=>$units4vp->V);

                $vp_data['h_str'] =  array('value'=> $temp['h_str'], 'unit'=>$units4vp->h_str);

                $vp_data['str_sptd_on_other_str'] =  $temp['str_sptd_on_other_str'];
            }

            $product_data[0]['vp'] = $vp_data;

        }

        $product_data[0]['t_i']  = array('value'=>$data->design_ice_thk, 'unit'=>$units->ice_thk);
        $product_data[0]['wind_dir']  = array('value'=>$data->wind_dir, 'unit'=>$units->wind_dir);

//        var_dump($product_data, $data->db_pro_PK); exit;

        // $writedir = 'debug/';
        // $filename = 'product_data_0_bf_g_calc.json';
        // file_put_contents( $writedir.$filename, json_encode($product_data[0] , JSON_PRETTY_PRINT));         

        if($product_data[0]) {

            if ($product_data[0]['geometryType'] == 'single_object') {
                $product_data[0] = $this->da_eng->calc($product_data);

                // $product_data[0] = $this->da_eng->calc('single_object', $product_data[0]['geometryShapeType'], $product_data);
            } else {
                $product_data[0]['resultData'] = array();
                $product_data[0]['resultData']['faces'] = $this->getProductWa($data->db_pro_PK);
            }

        } else {
            return ['error' => 'Cant find product data'];
        }
        $res = isset($product_data[0]['resultData']) ? $product_data[0]['resultData'] : array();
        // var_dump($res); exit;
        
        // $filename = 'resultData.json';
        // file_put_contents( $filename, json_encode($res , JSON_PRETTY_PRINT));

        return $res;
    }

    function recalcListRow($list) {
        $list = json_decode(json_encode($list));

        $product_data = $this->getProductAddInfo($list->db_pro_PK);

        if($product_data[0]) {
            $product_data[0]['frt_azm'] = $list->frt_azm;
            $product_data[0]['ctr_elev'] = $list->ctr_elev;
            $product_data[0]['t_iz'] = $list->ice_thk;
            $product_data[0]['q_z'] = $list->q_z;
            $product_data[0]['g_h'] = $list->g_h;
            $product_data[0]['k_a'] = $list->k_a;
            $product_data[0]['epa_a'] = $list->epa_a;
            $product_data[0]['dwf'] = $list->dwf;
            $product_data[0]['quantity'] = $list->quantity;

            // $product_data[0]['vp_calc_id']  = $list->vp_calc_id;
            $product_data[0]['vp_calc_id']  = $data->vp->calc_id;

            $product_data[0]['t_i'] = $list->design_ice_thk;
            $product_data[0]['wind_direction']  = $list->wind_direction;

            if ($product_data[0]['geometryType'] == 'single_object'){
                $product_data[0] = $this->da_eng->calc($product_data);
            }
        } else {
            return ['error' => 'Cant find product data'];
        }

        $res = isset($product_data[0]['resultData']) ? $product_data[0]['resultData'] : array();

        return $res;
    }

    function getProductAddInfo($db_pro_PK) {
        $query_assoc = "SELECT * FROM db_pro_asctn WHERE db_pro_PK = {$db_pro_PK}";

        $product_data = array();

        if ($result = $this->dbwid->query($query_assoc)) {
            while ($row = $result->fetch_assoc()) {
                $product_data[] = $row;
                // $product_data['value'] = $row;    <--            
            }
        }

        $query_assoc = "SELECT * FROM units WHERE dbtable = 'db_product'";

        if ($result = $this->dbwid->query($query_assoc)) {
            while ($row = $result->fetch_assoc()) {
                $product_data[0]['units'][$row['var']] = $row;
            }
        }

        $product_data[0]['d1'] = array('value'=>$product_data[0]['d1'], 'unit'=>$product_data[0]['units']['d']['unit']);
        $product_data[0]['d2'] = array('value'=>$product_data[0]['d2'], 'unit'=>$product_data[0]['units']['d']['unit']);
        $product_data[0]['d3'] = array('value'=>$product_data[0]['d3'], 'unit'=>$product_data[0]['units']['d']['unit']);
        $product_data[0]['weight'] = array('value'=>$product_data[0]['weight_wo_mkit'], 'unit'=>$product_data[0]['units']['weight']['unit']);

        return $product_data;
    }

    function getProductsAssoc($productPks) {

        $data = array();

        $query = "SELECT * FROM db_pro_asctn WHERE db_pro_PK IN ".$productPks;

        if ($result = $this->dbwid->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->close();
        }

        return $data;

    }

    function getProductWa($db_pro_PK) {

        $wa_data = array();

        $query_wa = "SELECT * FROM db_pro_wa WHERE db_pro_PK = {$db_pro_PK}";

        if ($result = $this->dbwid->query($query_wa)) {
            while ($row = $result->fetch_assoc()) {
                $wa_data[] = $row;
            }
        }

        return $wa_data;
    }

    function removeEquipment($id) {
        $query = "DELETE FROM tia_222_g_wl_da_lib WHERE `id` = {$id}";

        $status = $this->db->query($query);
        
        if(!$status) return [
          'error' => 'cant remove lib'  
        ];

        $queryList = "DELETE FROM tia_222_g_wl_ida WHERE `tia_222_g_wl_da_PK` = {$id}";

        $status1 = $this->db->query($queryList);
        
        if(!$status1) return [
            'error' => 'cant remove list'
        ];

        $query_face = "DELETE FROM tia_222_g_wl_ida_faces WHERE `tia_222_g_wl_ida_PK` = {$id}";

        $status2 = $this->db->query($query_face);

        if(!$status2) return [
            'error' => 'cant remove faces'
        ];

        return array(
            'query' => $query,
            '$query_list' => $queryList,
            '$query_face' => $query_face,
            'success' => $status,
            'success1' => $status1,
            'success2' => $status2
        );
    }

    function getAddDaEquipment($data) {

        $query_prod = "SELECT * FROM db_product WHERE `id` = {$data}";

        if ($result = $this->dbwid->query($query_prod)) {
            while ($row = $result->fetch_assoc()) {
                $prod_data = $row;
            }
        }
        $query_asctn = "SELECT * FROM db_pro_asctn WHERE db_pro_PK = {$data}";

        if ($result = $this->dbwid->query($query_asctn)) {
            while ($row = $result->fetch_assoc()) {
                $asctn_data = $row;
            }
        }
        $query_wa = "SELECT * FROM db_pro_wa WHERE db_pro_PK = {$data}";

        if ($result = $this->dbwid->query($query_wa)) {
            while ($row = $result->fetch_assoc()) {
                $wa_data = $row;
            }
        }

        $da = array(
            'db_product' => $prod_data,
            'db_pro_asctn' => $asctn_data,
            'db_pro_wa' => $wa_data
        );

//        $da = $g_calc->DA_areas($da);
        //$da = $g_calc->A_A_P_A($da, $front_azimuth, $ice_thk);

        return $da;
    }

//    function getDaEquipment($data_lib) {
//        global $da;
//        global $g_calc;
//
//        foreach ( $data_lib as $v_pro ) {
//            $res_pro = "SELECT * FROM db_product WHERE `id` = {$v_pro['db_pro_PK']}";
//
//            $result_pro = $this->dbwid->query($res_pro);
//            while ($row_pro = $result_pro->fetch_assoc()) {
//                $data_pro[] = $row_pro;
//            }
//            }
//        foreach ( $data_pro as $v_pro_id ) {
//            $res_asctn = "SELECT * FROM db_pro_asctn WHERE db_pro_PK = {$v_pro_id['id']}";
//
//            $result_asctn = $this->dbwid->query($res_asctn);
//            while ($row_asctn = $result_asctn->fetch_assoc()) {
//                $data_asctn[] = $row_asctn;
//            }
//        }
//        foreach ( $data_pro as $v_pro_id ) {
//            $res_wa = "SELECT * FROM db_pro_wa WHERE db_pro_PK = {$v_pro_id['id']}";
//
//            $result_wa = $this->dbwid->query($res_wa);
//            while ($row_wa = $result_wa->fetch_assoc()) {
//                $data_wa[] = $row_wa;
//            }
//        }
//
//        $da = array(
//            'db_product' => $data_pro,
//            'db_pro_asctn' => $data_asctn,
//            'db_pro_wa' => $data_wa,
//        );
//
//        $da = $g_calc->DA_areas($da);
//
//        return $da;
//    }
    
    function getCalcEquipment($calcPK) {

        $data = array();
        $data_ida = array();
        $data_lib = array();

        $query = "SELECT * FROM tia_222_g_wl_da WHERE userscalcPK = {$calcPK}";

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            foreach ( $data as $v_da ) {
                $res_id_da = "SELECT * FROM tia_222_g_wl_ida WHERE tia_222_g_wl_da_PK = {$v_da['id']}";

                $result_ida = $this->db->query($res_id_da);
                while ($row_ida = $result_ida->fetch_assoc()) {
                     $data_ida[] = $row_ida;
                }
            }

            foreach ( $data as $v_lib ) {
                $res_id_lib = "SELECT * FROM tia_222_g_wl_da_lib WHERE tia_222_g_wl_da_PK = {$v_lib['id']}";

                $result_lib = $this->db->query($res_id_lib);
                while ($row_lib = $result_lib->fetch_assoc()) {
                    $data_lib[] = $row_lib;
                }
            }
        }
        $res = array(
            'tia_222_g_wl_ida' => $data_ida,
            'tia_222_g_wl_da' => $data,
            'tia_222_g_wl_da_lib' => $data_lib
        );

        return $res;
    }

    function getLoading($calcPK) {

        $data = array();

        $query_da = "SELECT * FROM tia_222_g_wl_da WHERE userscalcPK = {$calcPK}";

        $result_da = $this->db->query($query_da);
            while ($row_da = $result_da->fetch_assoc()) {
                $data_da[] = $row_da;
            }
        foreach ( $data_da as $v_da ) {
            $res_ida = "SELECT * FROM tia_222_g_wl_ida WHERE tia_222_g_wl_da_PK = {$v_da['id']}";

            $result_ida = $this->db->query($res_ida);
            while ($row_ida = $result_ida->fetch_assoc()) {
                $data_ida[] = $row_ida;
            }
        }
        foreach ( $data_ida as $v_ida ) {
            $query = "SELECT * FROM tia_222_g_wl_ida_faces WHERE tia_222_g_wl_ida_PK = {$v_ida['id']}";

            $result = $this->db->query($query);
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    function updateList($data){
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if ($key == '$$hashKey' || $key == 'change' || $key == 'db_pro_PK') {
                continue;
            }

            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE tia_222_g_wl_ida SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);

        $query2 = "DELETE FROM tia_222_g_wl_ida_faces WHERE `tia_222_g_wl_ida_PK` = {$id}";

        $status2 = $this->db->query($query2);

        foreach ($data->faces as $key => $value) {

            $inclusion = 1;
            $face_name = $value->face_name;
            $face_shape = isset($value->face_shape) ? $value->face_shape : '';
            $display  = 1;
            $face_azm = isset($value->face_azm) ? $value->face_azm : 0;
            $angle_btw = isset($value->angle_btw) ? $value->angle_btw : '';
            $exposed  = isset($value->exposed) ? $value->exposed : 1;
            $p_a      = isset($value->p_a) ? $value->p_a : 0;
            $aspect_ratio = isset($value->aspect_ratio) ? $value->aspect_ratio : '';
            $c_a      = isset($value->c_a) ? $value->c_a : 0;
            $epa_a    = isset($value->epa_a) ? $value->epa_a : 0;
            $notes    = 0;
            //global $g_calc;

            $query_faces = "INSERT INTO `tia_222_g_wl_ida_faces` 
            (`name`,          `tia_222_g_wl_ida_PK`, `inclusion`, `face_name`,   `face_shape`,  `display`,  `face_azm`,  `angle_btw`, `exposed`,  `p_a`,  `aspect_ratio`,  `c_a`,  `epa_a`,  `notes`) 
            VALUES 
            ('{$data->name}', '{$id}',     '$inclusion', '$face_name', '$face_shape', '$display', '$face_azm', '$angle_btw', '$exposed', '$p_a', '$aspect_ratio', '$c_a', '$epa_a', '$notes')";

            $statusFaces = $this->db->query($query_faces);

            if(!$statusFaces) return [
                'error' => 'cant save face',
                'query' => $query_faces
            ];
        }


        return array(
            'query' => $query,
            'success' => $status
        );
    }

    function updateLoadingFace($data) {
        $data = json_decode(json_encode($data));

        $id = '';
        $set = '';

        foreach ($data as $key => $value) {
            if($key == 'faces') continue;
            if ($key == '$$hashKey' || $key == 'change') {
                continue;
            }

            if ($key == "id") {
                $id = $value;
            } else {
                $set .= $key.' = "'.(!empty($value) ? $value : '').'", ';
            }
        }

        $set = trim($set, ', ');

        $query = "UPDATE tia_222_g_wl_ida_faces SET {$set} WHERE `id` = '{$id}'";
        $status = $this->db->query($query);

        return array(
            'query' => $query,
            'success' => $status
        );
    }

    function insertList($data){

        $intQ_z = !empty($data->q_z) ? "'$data->q_z'" : "NULL";

//        if($res){
        $query_ida = "INSERT INTO `tia_222_g_wl_ida` (`tia_222_g_wl_da_PK`,          `name`,           `tia_222_g_wl_da_lib_PK`,          `status`,          `frt_azm`,                    `ctr_elev`,          `ice_thk`,          `q_z`,           `g_h`,          `k_a`,          `epa_a`,         `dwf`,         `quantity`) 
                                              VALUES ('{$data->tia_222_g_wl_da_PK}', '{$data->name}',  '{$data->tia_222_g_wl_da_lib_PK}', '{$data->status}', '{$data->frt_azm}',  '{$data->ctr_elev}', '{$data->ice_thk}', {$intQ_z},  '{$data->g_h}', '{$data->k_a}', '{$data->epa_a}','{$data->dwf}', '{$data->quantity}')";
        $statusLib = $this->db->query($query_ida);

        if(!$statusLib) return [
            'error' => 'cant save lib',
            'query' => $query_ida
        ];

        $equip_id_ida = $this->db->insert_id;

        foreach ($data->faces as $key => $value) {

            $inclusion = 1;
            $face_name = $value->face_name;
            $face_shape = isset($value->face_shape) ? $value->face_shape : '';
            $display  = 1;
            $face_azm = isset($value->face_azm) ? $value->face_azm : 0;
            $angle_btw = isset($value->angle_btw) ? $value->angle_btw : '';

            $exposed  = isset($value->exposed) ? $value->exposed : 1;
            $p_a      = isset($value->p_a) ? $value->p_a : 0;
            $aspect_ratio = isset($value->aspect_ratio) ? $value->aspect_ratio : '';
            $c_a      = isset($value->c_a) ? $value->c_a : 0;
            $epa_a    = isset($value->epa_a) ? $value->epa_a : 0;
            $notes    = 0;
            //global $g_calc;

            $query_faces = "INSERT INTO `tia_222_g_wl_ida_faces` 
            (`name`,          `tia_222_g_wl_ida_PK`, `inclusion`, `face_name`,   `face_shape`,  `display`,   `face_azm`, `angle_btw`, `exposed`,  `p_a`,  `aspect_ratio`,  `c_a`,  `epa_a`,  `notes`) 
            VALUES 
            ('{$data->name}', '{$equip_id_ida}',     '$inclusion', '$face_name', '$face_shape', '$display', '$face_azm', '$angle_btw', '$exposed', '$p_a', '$aspect_ratio', '$c_a', '$epa_a', '$notes')";

            $statusFaces = $this->db->query($query_faces);

            if(!$statusFaces) return [
                'error' => 'cant save face',
                'query' => $query_faces
            ];
        }

        return [
            'status' => true,
            'id' => $equip_id_ida
        ];
//        } else {
//            $query_ida = "INSERT INTO `tia_222_g_wl_ida` (`tia_222_g_wl_da_PK`, `tia_222_g_wl_da_lib_PK`, `name`) VALUES ('{$equip_id_da}', '{$equip_id_lib}', '$name')";
//        }
//        $query_lib = "INSERT INTO `tia_222_g_wl_da_lib` (`tia_222_g_wl_da_PK`, `db_pro_PK`, `name`, `notes`) VALUES ('{$equip_id_da}', '$data->db_pro_PK', '$name', '$notes')";

    }

    function removeList($listId){
        $query = "DELETE FROM tia_222_g_wl_ida WHERE `id` = {$listId}";

        $status = $this->db->query($query);

        if(!$status) return [
            'error' => 'cant remove list'
        ];

        $query2 = "DELETE FROM tia_222_g_wl_ida_faces WHERE `tia_222_g_wl_ida_PK` = {$listId}";

        $status2 = $this->db->query($query2);

        if(!$status2) return [
            'error' => 'cant remove faces'
        ];

        return [
          'status' => true,
            'queryList' => $query,
            'queryFaces' => $query2
        ];
    }

    function getFacesForList($listId){
        $query = "SELECT * FROM tia_222_g_wl_ida_faces WHERE tia_222_g_wl_ida_PK = {$listId}";

        $status = $this->db->query($query);
//        var_dump($status, $query); exit;
        $faces = [];
        while ($row_lib = $status->fetch_assoc()) {
            $faces[] = $row_lib;
        }
        
        return [
            'status' => $status,
            '$query' => $query,
            'faces'  => $faces
        ];
    }

    function saveAllForNewCalc($newCalcPK, $equipments, $loadings) {

        $equipments = json_decode(json_encode($equipments));
        $loadings = json_decode(json_encode($loadings));

        $query1 = "INSERT INTO `tia_222_g_wl_da` (`userscalcPK`) VALUES ('$newCalcPK')";

        if($status1 = $this->db->query($query1)) {
            $equip_id_da = $this->db->insert_id;

            foreach ($equipments as $key => $value) {

                $notes = !empty($value->notes) ? $value->notes : '';
                $name = !empty($value->name) ? $value->name : '';

                $eq_old_id = $value->eqpt_id;

                $query = "INSERT INTO `tia_222_g_wl_da_lib` (`tia_222_g_wl_da_PK`, `db_pro_PK`, `name`, `notes`) VALUES ('$equip_id_da', '$value->db_pro_PK', '$name', '$notes')";

                $status = $this->db->query($query);

                if($status) {

                    $eq_new_id = $this->db->insert_id;

                    foreach ($loadings as $loading) {

                        if($loading->tia_222_g_wl_da_lib_PK == $eq_old_id) {

                            $query_loading = "INSERT INTO `tia_222_g_wl_ida` (`tia_222_g_wl_da_PK`,      `tia_222_g_wl_da_lib_PK`,    `name`,           `status`,            `frt_azm`,              `ctr_elev`,              `ice_thk`,             `q_z`,             `g_h`,            `k_a`,            `epa_a`,            `dwf`,                `quantity`) 
                                                                      VALUES ('$equip_id_da',            '$eq_new_id',                '$loading->name', '$loading->status',  '$loading->frt_azm',    '$loading->ctr_elev',    '$loading->ice_thk',   '$loading->q_z',   '$loading->g_h',  '$loading->k_a',  '$loading->epa_a',  '$loading->dwf',      '$loading->quantity')";

                            if($status = $this->db->query($query_loading)) {
                                $ida_new_id = $this->db->insert_id;

                                foreach ($loading->faces as $face) {

                                    $query_face = "INSERT INTO `tia_222_g_wl_ida_faces` (`tia_222_g_wl_ida_PK`,  `name`,           `inclusion`,            `face_name`,              `face_shape`,              `display`,             `face_azm`,            `angle_btw`,                  `exposed`,            `p_a`,            `aspect_ratio`,            `c_a`,            `epa_a`,             `notes`) 
                                                                                 VALUES ('$ida_new_id',          '$face->name',    '$face->inclusion',     '$face->face_name',       '$face->face_shape',       '$face->display',      '$face->face_azm',      '$face->angle_btw',  '$face->exposed',     '$face->p_a',     '$face->aspect_ratio',     '$face->c_a',     '$face->epa_a',      '$face->notes')";

                                    $status = $this->db->query($query_face);

                                }
                            }

                        }

                    }

                }

            }

            return array(
                'query' => $query_face,
                'success' => $status
            );
        } else {
            return array(
                'error' => 'Could not save new data'
            );
        }

    }

    function getWidConfig() {

        return array(
            'publicIds' => $this->usersID
        );

    }

}

$get = (object)$_GET;
$request = (object)$_REQUEST;
$post = json_decode(file_get_contents("php://input"));

@$method = (!empty($request->method)) ? $request->method : $post->method;
@$database = (!empty($request->database)) ? $request->database : $post->database;


$generic = new Generic($database);

switch ($method) {
    case "getProductsList":
        $users = !empty($post->users) ? $post->users : '()';
        $privateId = !empty($post->privateId) ? $post->privateId : 0;
        $result = $generic->getProductsList($users, $privateId);
        die(json_encode($result));
    case "getVPcalcsList":
        $result = $generic->getVPcalcsList($post->calcId);
        die(json_encode($result));
    case "getEquipment":
        $users = !empty($post->users) ? $post->users : '()';
        $privateId = !empty($post->privateId) ? $post->privateId : 0;
        $data = $generic->getEquipment($users, $privateId);
        die(json_encode($data));
    case "sortEq":
        $users = !empty($post->users) ? $post->users : '()';
        $data = !empty($post->data) ? $post->data : null;
        $privateId = !empty($post->privateId) ? $post->privateId : 0;
        $ddls = $generic->sortEq($data, $users, $privateId);
        die(json_encode($ddls));
    case "items":
        $data = !empty($post->data) ? $post->data : null;
        $users = !empty($post->users) ? $post->users : 0;
        $privateId = !empty($post->privateId) ? $post->privateId : 0;
        $result = $generic->items($data, $users, $privateId);
        die(json_encode($result));
    case "addEquipment":
        $data = !empty($post->data) ? $post->data : '';
        $result = $generic->addEquipment($data);
        die(json_encode($result));
    case "getProductAddInfo":
        $db_pro_PK = !empty($post->db_pro_PK) ? $post->db_pro_PK : '';
        $result = $generic->getProductAddInfo($db_pro_PK);
        die(json_encode($result));
    case "getProductsAssoc":
        $productPks = !empty($post->productPks) ? $post->productPks : '()';
        $result = $generic->getProductsAssoc($productPks);
        die(json_encode($result));
    case "getListForEquipment":
        $result = $generic->getListForEquipment($post->data);
        die(json_encode($result));
    case "recalcListRow":
        $result = $generic->recalcListRow($post->list);
        die(json_encode($result));
    case "getProductWa":
        $db_pro_PK = !empty($post->db_pro_PK) ? $post->db_pro_PK : '';
        $result = $generic->getProductWa($db_pro_PK);
        die(json_encode($result));
    case "removeEquipment":
        $id = !empty($post->id) ? $post->id : '';
        $result = $generic->removeEquipment($id);
        die(json_encode($result));
    case "updateEquipment":
        $data = !empty($post->equipment) ? $post->equipment : '';
        $result = $generic->updateEquipment($post->equipment);
        die(json_encode($result));
    case "getCalcEquipment":
        $calcPK = !empty($request->calcPK) ? $request->calcPK : '';
        $result = $generic->getCalcEquipment($calcPK);
        die(json_encode($result));
    case "getLoading":
        $calcPK = !empty($request->calcPK) ? $request->calcPK : '';
        $result = $generic->getLoading($calcPK);
        die(json_encode($result));
    case "updateList":
        $data = !empty($post->data) ? $post->data : '';
        $result = $generic->updateList($data);
        die(json_encode($result));
    case "updateLoading":
        $data = !empty($post->data) ? $post->data : '';
        $result = $generic->updateLoading($data);
        die(json_encode($result));
    case "insertList":
        $data = !empty($post->data) ? $post->data : '';
        $result = $generic->insertList($data);
        die(json_encode($result));
    case "removeList":
        $listId = !empty($post->listId) ? $post->listId : '';
        $result = $generic->removeList($listId);
        die(json_encode($result));
    case "getFacesForList":
        $listId = !empty($post->listId) ? $post->listId : '';
        $result = $generic->getFacesForList($listId);
        die(json_encode($result));
    case "saveAllForNewCalc":
        $newCalcPK = !empty($post->newCalcPK) ? $post->newCalcPK : '';
        $equipments = !empty($post->equipments) ? $post->equipments : '';
        $loadings = !empty($post->loadings) ? $post->loadings : '';
        $data = $generic->saveAllForNewCalc($newCalcPK, $equipments, $loadings);
        die(json_encode($data));
    case "updatewlda":
        $calcId = !empty($post->calcId) ? $post->calcId : '';
        $vp_calc = !empty($post->vp_calc) ? $post->vp_calc : '';
        $ice_thk = !empty($post->ice_thk) ? $post->ice_thk : '';
        $wind_dir = !empty($post->wind_dir) ? $post->wind_dir : '';        
        $data = $generic->updatewlda($calcId, $vp_calc, $ice_thk, $wind_dir);
        die(json_encode($data));
        break;
    case "getWidConfig":
        $data = $generic->getWidConfig();
        die(json_encode($data));
        break;
}
