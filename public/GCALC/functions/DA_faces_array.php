<?php

$type = $da['geometryType']; // 'single_object';

$shapeType = $da['geometryShapeType'];

$frt_azm = $da['frt_azm'];

$facesData = array();
if($type == 'single_object') {
    if ($shapeType == 'Cuboid' || $shapeType == 'FlatPanel' ) {

        $t_iz_v = $da['t_iz']['value']; // array('value'=>0.2, 'unit'=>$unit2use['length']);

        $d1_v = $da['d1']['value'] + 2*$t_iz_v;
        $d2_v = $da['d2']['value'] + 2*$t_iz_v;
        $d3_v = $da['d3']['value'] + 2*$t_iz_v;

        $da['faces'] = array(
            array('name' => 'front',   'n_dir_vec' => [+1,+0, +0], 'azimuth' => array('value' =>        0,  "unit" => $unit2use['angle'])),
            array('name' => 'right',   'n_dir_vec' => [+0, 0, +1], 'azimuth' => array('value' =>   M_PI/2,  "unit" => $unit2use['angle'])),
            array('name' => 'back',    'n_dir_vec' => [-1, 0, +0], 'azimuth' => array('value' =>     M_PI,  "unit" => $unit2use['angle'])),
            array('name' => 'left',    'n_dir_vec' => [+0, 0, -1], 'azimuth' => array('value' => M_PI*3/2,  "unit" => $unit2use['angle']))
        );

        // $da['faces'] = array(
        //     array('name' => 'front',  'shape' => 'rectangular', 'wth' => array('value' => $d2_v, "unit" => $unit2use['length']), 'lth' => array('value' => $d1_v, "unit" => $unit2use['length']), 'dir' => [+1, 0, 0], 'azimuth' => array('value' => 0,   "unit" => $unit2use['length'])),
        //     array('name' => 'back',   'shape' => 'rectangular', 'wth' => array('value' => $d2_v, "unit" => $unit2use['length']), 'lth' => array('value' => $d1_v, "unit" => $unit2use['length']), 'dir' => [-1, 0, 0], 'azimuth' => array('value' => 180, "unit" => $unit2use['length'])),
        //     array('name' => 'top',    'shape' => 'rectangular', 'wth' => array('value' => $d2_v, "unit" => $unit2use['length']), 'lth' => array('value' => $d3_v, "unit" => $unit2use['length']), 'dir' => [0, +1, 0], 'azimuth' => array('value' => 0,   "unit" => $unit2use['length'])),
        //     array('name' => 'bottom', 'shape' => 'rectangular', 'wth' => array('value' => $d2_v, "unit" => $unit2use['length']), 'lth' => array('value' => $d3_v, "unit" => $unit2use['length']), 'dir' => [0, -1, 0], 'azimuth' => array('value' => 0,   "unit" => $unit2use['length'])),
        //     array('name' => 'right',  'shape' => 'rectangular', 'wth' => array('value' => $d3_v, "unit" => $unit2use['length']), 'lth' => array('value' => $d1_v, "unit" => $unit2use['length']), 'dir' => [0, 0, +1], 'azimuth' => array('value' => 90,  "unit" => $unit2use['length'])),
        //     array('name' => 'left',   'shape' => 'rectangular', 'wth' => array('value' => $d3_v, "unit" => $unit2use['length']), 'lth' => array('value' => $d1_v, "unit" => $unit2use['length']), 'dir' => [0, 0, -1], 'azimuth' => array('value' => 270, "unit" => $unit2use['length']))
        // );

        for ($iface = 0; $iface < sizeof($da['faces']); $iface++) {

            $v_azm = $da['faces'][$iface]['azimuth']['value'] + $frt_azm['value'];
            $da['faces'][$iface]['azimuth']['value'] = $v_azm;

            $face_name = $da['faces'][$iface]['name'];

            $da['faces'][$iface]['n_dir_vec'] = [cos($v_azm), 0, sin($v_azm)];

            $da['faces'][$iface]['shape'] = 'rectangular';
            $da['faces'][$iface]['type']  = 'flat';   

            // $da['faces'][$iface]['azimuth']['value'] = $da['faces'][$iface]['azimuth']['value'] + 5; // $da['front_azimuth']['value']; -- dont know what is it
            // $da['faces'][$iface]['azimuth']['unit']  = $unit2use['angle'];

            if(      $face_name =='front'  || $face_name == 'back'){
                $wth = array('value' => $d2_v, "unit" => $unit2use['length']); $lth = array('value' => $d1_v, "unit" => $unit2use['length']);
            }else if($face_name == 'right' || $face_name == 'left'){
                $wth = array('value' => $d3_v, "unit" => $unit2use['length']); $lth = array('value' => $d1_v, "unit" => $unit2use['length']);
            }else{
            }
            $da['faces'][$iface]['wth'] = $wth;
            $da['faces'][$iface]['lth'] = $lth;     

            $da['faces'][$iface]['position']  = array('value'=>[0, 0, 0], 'unit'=>$unit2use['length']);                                  

            $P_A_A_A = array('value' => $lth['value'] * $wth['value'],   'unit'=>$unit2use['area']);

            $da['faces'][$iface]['P_A_A_A'] = $P_A_A_A;

            // $face_name = $da['faces']['name'];

            $member_type = 'Flat';
            $flow_status = 'Subcritical'; // Subcritical / Transitional / Supercritical
            $C = 30; // <32 // Subcritical force coefficients may conservatively be used for any value of C.
            $ar = $lth['value'] / $wth['value'];

            $da['faces'][$iface]['ar'] = $ar;

            $C_a = $this->C_a($member_type, $C, $ar);
            // $C_a = $calc->C_a($member_type, $C, $aspect_ratio);

            $da['faces'][$iface]['C_a'] = $C_a;

            // $da['faces'][$iface]['EPA_A'] = array('value' =>$C_a*$P_A_A_A['value'], 'unit'=>$unit2use['area']);
        }
        
        

    } else if ($shapeType == 'Cylinder') {


    } else if ($shapeType == 'Sphere') {


    }
}

return $da;

?>