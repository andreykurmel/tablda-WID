<?php

require_once("./GCALC/g_calc.php");

$g_calc = new g_calc();

class wid {
    function calc_pro_epa($data) {

        global $g_calc;

        $data = json_decode(json_encode($data));

        $result = array();

         $angles = [0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 360];
//        $angles = [0, 15, 30, 45, 60, 75, 90, 105, 120, 135, 150, 165, 180, 195, 210, 225, 240, 255, 270, 285, 300, 315, 330, 345, 360];
        $anglesSlides = [0, 5, 10, 15, 20, 25, 30, 35, 40,
                        45, 50, 55, 60, 65, 70, 75, 80, 85,
                        90, 95, 100, 105, 110, 115, 120, 125,
                        130, 135, 140, 145, 150, 155, 160, 165,
                        170, 175, 180, 185, 190, 195, 200, 205,
                        210, 215, 220, 225, 230, 235, 240, 245,
                        250, 255, 260, 265, 270, 275, 280, 285,
                        290, 295, 300, 305, 310, 315, 320, 325,
                        330, 335, 340, 345, 350, 355, 360];

        $EPA_A = array();
        // $EPAs = array();
        $EPAs_slider = array();

        // echo '$data: ';
        // print_r($data);

        $unit2use = array();

        $unit2use['length'] = 'in.';
        $unit2use['area']   = 'in.^2';
        $unit2use['amoi']   = 'in.^4';
        $unit2use['lmoi']   = 'in.^3';
        $unit2use['dmoi']   = 'in.^2';
        $unit2use['force']  = 'kips';
        $unit2use['moment'] = 'kips-ft';
        $unit2use['stress'] = 'ksi';
        $unit2use['mass']   = 'slug';
        $unit2use['angle']  = 'rad';
        $unit2use['modulus']= 'in.^3';
        $unit2use['resolution']= 'pixles';

        $data_array = (array) $data;

        $da = $g_calc->DA_faces_array($data_array, $unit2use);


        $data->da = $da;

//        $custom_ice = $data->custom_ice;

//         $data->calculate =  $data->d1 * $data->d2 * $data->d3;

//        $vol_apurt = $value->d1 * $value->d2 * $value->d3;
//        $rho_ic = 57.2/(12 * 12 * 12); // 57.2 lbf/ft^3 --> ? lbf/in.^3
//        $weight_icex  = $rho_ic * (($value->d1 + 2*$custom_ice)*($value->d2 + 2*$custom_ice)*($value->d3 + 2*$custom_ice) - $vol_apurt);

//        $data->weight_wo_mkit  = $data->weight_wo_mkit;// from input, default to 0: https://gyazo.com/3f29f70503d0febf7250d6d3a42add03, if no input

//        $data->weightx  = $data->weight_wo_mkit + $weight_icex;
        // for these cells: https://gyazo.com/c948bd91a90a1eb5f122e06e06028314

         foreach($anglesSlides as $angle){
             $EPA_A_angle = $g_calc->EPA_A($da, $unit2use, $angle);
             $EPA_A[] = $EPA_A_angle;
             // $EPAs[] = $EPA_A_angle;
             // for the plot: https://gyazo.com/e1fa12310db6d9468bc8a882bec2369b
         }
         $data->EPA_A_plot = $EPA_A;

//        foreach($anglesSlides as $angle){
//            $EPA_A_angle = $g_calc->Sec_2_6_9_2_EPA_A($angle, $data->windAreas);
//            $EPA_A[] = $EPA_A_angle;
//        }
//        $data->EPA_A_slider = $EPA_A;

        return $data;
    }
}