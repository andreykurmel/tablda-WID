<?php


$da = json_decode(json_encode($da));

$result = array();


$da = $this->DA_areas($da);

$EPA_A = array();
// $EPAs = array();
$EPAs_slider = array();

// echo '$data: ';
// print_r($data);

$custom_ice = $data->custom_ice;

foreach($data->windAreas as $value){
    $Area_Shape = $value->shape;
    $face_name = $value->face_name;
    if($Area_Shape == "Rectangular"){
        // we need to know what is current area (A1, A2, A3, ...) AND the equations would be different.
        if($face_name == "Front" || $face_name == "Back"){
            $d1 = $value->d1;
            $d2 = $value->d2;
        }else if($face_name == "Left" || $face_name == "Right"){
            $d1 = $value->d1;
            $d2 = $value->d3;
        }else if($face_name == "Top" || $face_name == "Bot."){
            $d1 = $value->d2;
            $d2 = $value->d3;
        }else{
        }

        $Aa_0  = ($d1 + 2*0.0) * ($d2 + 2*0.0);
        $Aa_05 = ($d1 + 2*0.5) * ($d2 + 2*0.5);
        $Aa_1  = ($d1 + 2*1.0) * ($d2 + 2*1.0);
        $Aa_2  = ($d1 + 2*2.0) * ($d2 + 2*2.0);
        $Aa_4  = ($d1 + 2*4.0) * ($d2 + 2*4.0);
        $Aa_x  = ($d1 + 2*$custom_ice) * ($d2 + 2*$custom_ice);
    } else if($Area_Shape == "Ｃylinder"){
        $height  =  $value->d1;
        $diameter = $value->d2;

        $Aa_0  = ($height + 2* 0.0)*($height + 2* 0.0);
        $Aa_05 = ($height + 2* 0.5)*($height + 2* 0.5);
        $Aa_1  = ($height + 2* 1.0)*($height + 2* 1.0);
        $Aa_2  = ($height + 2* 2.0)*($height + 2* 2.0);
        $Aa_4  = ($height + 2* 3.0)*($height + 2* 4.0);
        $Aa_x  = ($height + 2* $custom_ice)*($height + 2* $custom_ice);
    } else if($Area_Shape == "Sphere"){
        $diameter = $value->d1 + 2* 0.0;          $Aa_0  = $diameter * $diameter * M_PI / 4;
        $diameter = $value->d1 + 2* 0.5;          $Aa_05 = $diameter * $diameter * M_PI / 4;
        $diameter = $value->d1 + 2* 1.0;          $Aa_1  = $diameter * $diameter * M_PI / 4;
        $diameter = $value->d1 + 2* 2.0;          $Aa_2  = $diameter * $diameter * M_PI / 4;
        $diameter = $value->d1 + 2* 3.0;          $Aa_4  = $diameter * $diameter * M_PI / 4;
        $diameter = $value->d1 + 2* $custom_ice;  $Aa_x  = $diameter * $diameter * M_PI / 4;
    } else {
        $Aa_0 = 0;
        $Aa_05 = 0;
        $Aa_1 = 0;
        $Aa_2 = 0;
        $Aa_4 = 0;
        $Aa_x = 0;
    }

    $value->Aa_0  = $Aa_0;
    $value->Aa_05 = $Aa_05;
    $value->Aa_1  = $Aa_1;
    $value->Aa_2  = $Aa_2;
    $value->Aa_4  = $Aa_4;
    $value->Aa_x  = $Aa_x;
    // then fill these fields: https://gyazo.com/c60716e81a947a9231491fc325812836, with above values obtained.
}

// $data->calculate =  $data->d1 * $data->d2 * $data->d3;
$vol_apurt = $value->d1 * $value->d2 * $value->d3; $rho_ic = 57.2/(12 * 12 * 12); // 57.2 lbf/ft^3 --> ? lbf/in.^3
$weight_ice05 = $rho_ic * (($value->d1 + 2*0.5)*($value->d2 + 2*0.5)*($value->d3 + 2*0.5) - $vol_apurt);
$weight_ice1  = $rho_ic * (($value->d1 + 2*1.0)*($value->d2 + 2*1.0)*($value->d3 + 2*1.0) - $vol_apurt);
$weight_ice2  = $rho_ic * (($value->d1 + 2*2.0)*($value->d2 + 2*2.0)*($value->d3 + 2*2.0) - $vol_apurt);
$weight_ice4  = $rho_ic * (($value->d1 + 2*4.0)*($value->d2 + 2*4.0)*($value->d3 + 2*4.0) - $vol_apurt);
$weight_icex  = $rho_ic * (($value->d1 + 2*$custom_ice)*($value->d2 + 2*$custom_ice)*($value->d3 + 2*$custom_ice) - $vol_apurt);

// $data->weight0  = $data->weight0;// from input, default to 0: https://gyazo.com/3f29f70503d0febf7250d6d3a42add03, if no input
$data->weight05 = $data->weight0 + $weight_ice05;
$data->weight1  = $data->weight0 + $weight_ice1;
$data->weight2  = $data->weight0 + $weight_ice2;
$data->weight4  = $data->weight0 + $weight_ice4;
$data->weightx  = $data->weight0 + $weight_icex;

// for these cells: https://gyazo.com/c948bd91a90a1eb5f122e06e06028314
foreach($angles as $angle){
    $EPA_A_angle = $loading->Sec_2_6_9_2_EPA_A($angle, $data->windAreas);
    $EPA_A[] = $EPA_A_angle;
    // $EPAs[] = $EPA_A_angle;
    // for the plot: https://gyazo.com/e1fa12310db6d9468bc8a882bec2369b
}
$data->EPA_A_plot = $EPA_A;

foreach($anglesSlides as $angle){
    $EPA_A_angle = $loading->Sec_2_6_9_2_EPA_A($angle, $data->windAreas);
    $EPA_A[] = $EPA_A_angle;
}
$data->EPA_A_slider = $EPA_A;

return $data;

?>