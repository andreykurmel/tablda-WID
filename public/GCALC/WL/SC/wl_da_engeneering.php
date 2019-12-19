<?php

include "unit2use.php"; // the units for plotting process and calculation.
include "./../../../../../../../../../SHARED/php/array_unit_conversion.php";

require_once "./../g_calc.php";
require 'unit2use.php';

class da_eng {
    function __construct() {
        $this->calc = new g_calc();
    }
    
    // function calc($type, $shapeType, $product_data){    
    function calc($product_data){
        global $unit2use;

        $da = $product_data[0];

        $unit2show = $da['units'];

        // $writedir = 'debug/';
        // $filename = 'da_input_bf_unit_conv.json';
        // file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT));

        $da = array_unit_conversion($da, $unit2use);

        // $writedir = 'debug/';
        // $filename = 'da_input.json';
        // file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT));

        // if( empty($da['frt_azm']) ){
        //     $da['frt_azm'] = array('value'=>0, 'unit'=>$unit2use['angle']);
        // };

        if( isset($da['vp_calc_id']) ){
            $da['vp']['z'] = $da['z'];
            $da['vp'] = $this->calc->q_z_api($da['vp']);
        }

        // $filename = 'da_af_q_z_api.json';
        // file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT));    

        if( !empty($da['q_z']['value']) && is_numeric($da['q_z']['value']) ){
            // user entered customized value for q_z, will not be replaced.
        }else{
            $da['q_z'] = $da['vp']['q_z'];
        }

        if( !empty($da['t_iz']['value']) && is_numeric($da['t_iz']['value']) ){
            // user entered non-zero customized value for t_iz, will be used.
        }else{

            if( isset($da['vp_calc_id']) ){
                $vp = $da['vp'];                

                $t_i = $da['t_i'];
                $I_p = $vp['I_p'];

                $z = $da['z'];

                $K_zt = $vp['top_cat_coeff']['K_zt'];

                $t_iz = $this->calc->t_iz($t_i, $I_p, $z, $K_zt);

                $da['t_iz']  = $t_iz;
            }
        }

        // $filename = 'da_af_t_iz.json';
        // file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT) );         

        //faces
        $da = $this->calc->DA_faces_array($da, $unit2use);
        // $da = $this->calc->DA_faces('single_object', $da['geometryShapeType'], $da, $unit2use);

        // $da = $this->calc->q_z($da);


        // A_A_P_A
        $ice_thk = $da['t_iz']; // array('value'=>0, 'unit'=>$unit2use['length']);
        // $da = $this->calc->A_A_P_A($da, $ice_thk);        


        // G_h
        if( !empty($da['g_h']) && is_numeric($da['g_h']) ){
            // a valid value for G_h has been entered by user.
        }else{

            $str_type = $data['vp']['str_type'];
            $str_sptd_on_other_str = $data['vp']['str_sptd_on_other_str'];

            // $str_type = 'appurtenance';
            // $str_sptd_on_other_str = '';

            $G_h = $this->calc->G_h($str_type, $str_sptd_on_other_str);
            $da['g_h'] = $G_h;  
        }

        //k_a
        // $da = $this->calc->K_a($da);

        if( !empty($da['k_a']) && is_numeric($da['k_a']) ){
            // a valid value for K_a has been entered by user.            
        }else{
            $csvtv_K_a = 'Yes';
            $da_type = '';
            $ca_flow_status = '';
            $da_pos = '';
            $epsilon = '';
            $ge_3mts_same_elev = '';
            $da['k_a'] = $this->calc->K_a($csvtv_K_a, $da_type, $ca_flow_status, $da_pos, $epsilon, $ge_3mts_same_elev);
        }


        if( !empty($da['epa_a']['value']) && is_numeric($da['epa_a']['value']) ){
        }else{
            $da = $this->calc->EPA_A($da, $unit2use);
        }       

        $writedir = 'debug/';
        $filename = 'da_bf_DWF_A.json';
        file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT) ); 

        if( !empty($da['dwf']['value']) && is_numeric($da['dwf']['value']) ){
        }else{
            $da = $this->calc->DWF_A($da, $unit2use);
        }

        $filename = 'da_af_DWF_A.json';
        file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT) );           

        $da['frt_azm']  = unitConversion($da['frt_azm'], $unit2show->frt_azm);
        $da['z']        = unitConversion($da['z'], $unit2show->ctr_elev);
        $da['t_iz']     = unitConversion($da['t_iz'], $unit2show->ice_thk);
        $da['epa_a']    = unitConversion($da['epa_a'], $unit2show->epa_a);
        $da['dwf']      = unitConversion($da['dwf'], $unit2show->dwf);        

        $da['resultData'] = [
        'faces' => $da['faces'],

        'frt_azm'   => isset($da['frt_azm']['value'])  ?   $da['frt_azm']['value'] :   0,            
        'ctr_elev'  => isset($da['z']['value']) ?   $da['z']['value'] :  0,
        'ice_thk'   => isset($da['t_iz']['value'])  ?   $da['t_iz']['value'] :   0,

        'q_z'       => isset($da['q_z']['value']) ?   $da['q_z']['value'] :   0,
        'g_h'       => isset($da['g_h']) ?   $da['g_h'] :   0,
        'k_a'       => isset($da['k_a']) ?   $da['k_a'] :   0,
        'epa_a'     => isset($da['epa_a']['value']) ? $da['epa_a']['value'] : 0,
        'dwf'       => isset($da['dwf']['value']) ?   $da['dwf']['value'] : 0
        ];

        $filename = 'da_output.json';
        file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT));

        return $da;
    }
}

//$g_calc = new g_calc();

// for a selected equipment, get the data $da (data of appurtenance) for that equipment from (db_product.sql, db_pro_3d.sql, db_pro_asctn.sql, db_pro_file.sql, db_pro_wa) to here for further calculations.
// $da = db_pro //for a selected equipment



//$da = $g_calc->DA_areas($da); // to get the areas defined for a product.



//$da = $g_calc->A_A_P_A($da, $front_azimuth, $ice_thk); // to calculate the projected areas (A_A, PA) for a product.
//
//$da = $g_calc->EPA_A($da, $wind_dir_angle); // to calculate the effective projected areas (EPA_A) for a product.
//
//$da = $g_calc->DWF_A($da);


// vp_calc = selected from DDL // to be finished later
// ice_thk = input for the whole calc.

//list.name    // auto $da['name']
//list.frt_azm // input $da['frt_azm']
//list.ctr_elev // input $da['ctr_elev']
//list.ice_thk // input $da['ice_thk'] / for current DA
//list.q_z = $da['q_z'] //
//list.G_h = $da['G_h'];
//list.K_a = $da['K_a'];
//list.EPA_A = $da['EPA_A']['value'];
//list.dwf = $da['DWF']['value'];
//list.quantity = $da['quantity']
//
//
//for ($iarea = 0; $iarea < sizeof($da['areas']); $iarea++) {
//	row.geo_shape_type = $da_geo_type;
//	// row.display = user's input
//	row.face_name = $da['areas'][$iarea]['name'];
//	// row.view_check = user's input;
//	row.face_norm_azm = $da['areas'][$iarea]['azimuth'];
//	row.face_exposed = $da['areas'][$iarea]['exposed'];
//	row.projected_area = $da['areas'][$iarea]['area'];
//	row.aspect_ratio = $da['areas'][$iarea]['ar'];
//	row.force_coeff = $da['areas'][$iarea]['ca'];
//	row.epa = $da['areas'][$iarea]['epa'];
//}

?>