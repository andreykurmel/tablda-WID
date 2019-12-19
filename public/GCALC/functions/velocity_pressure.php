<?php

// $data->I = $extra['table']['importance_factor'][$data->str_class][$data->purpose_of_calculation];
$data->I = $this->I_p($str_class, $purpose_of_calculation)
$I = $data->I;

// $prmtr_based_on_expCAT = $extra['table']['prmtr_based_on_expCAT'][$data->expCAT];
$exp_cat_coeff = $this->exp_cat_coeff[$data->expCAT];
$data->z_g    = $exp_cat_coeff['z_g'];
$data->alpha  = $exp_cat_coeff['alpha'];
$data->K_zmin = $exp_cat_coeff['K_zmin'];
$data->K_e    = $exp_cat_coeff['K_e'];

$z_g = $data->z_g;
$alpha = $data->alpha;
$K_zmin = $data->K_zmin;
$K_e = $data->K_e;

// $prmtr_based_on_topCAT = $extra['table']['prmtr_based_on_topCAT'][$data->topCAT];
$top_cat_coeff = $this->$this->exp_cat_coeff[$data->expCAT];
$data->K_t = $top_cat_coeff['K_t'];
$data->f   = $top_cat_coeff['f'];

$K_t = $data->K_t;
$f = $data->f;

$z = $data->z;

$data->K_z = (float)(min(max(2.01 * (pow(($z / $z_g), (2 / $alpha))), $K_zmin), 2.01));

$K_z = $data->K_z;
$e = $data->exp;
$H_crest = $data->H_crest;
$f = $data->f;

if ($H_crest == 0) {
    $data->K_h = 0;
} else {
    $data->K_h = (float)(pow($e, $f * $z / $H_crest));
}

$K_e = $data->K_e;
$K_h = $data->K_h;
$K_t = $data->K_t;

switch ($data->topCAT) {
    case '1':
    case 1:
    $data->K_zt = 1.0;
    break;

    case '2':
    case '3':
    case '4':
    if ($K_h == 0) {
        $data->K_zt = 0;
    } else {
        $data->K_zt = pow(1 + $K_e * $K_t / $K_h, 2);
    }            
    break;

    case '5':
    $data->K_zt = $data->K_zt5;
    break;
    default:
    break;
}

$K_zt = $data->K_zt;
$K_d = $data->K_d;
$V = $data->V;

if (!is_numeric($I)) {
    $I = 1.0;
}

$data->q_z = (float)(0.00256 * $K_z * $K_zt * $K_d * (pow($V, 2)) * $I);
?>