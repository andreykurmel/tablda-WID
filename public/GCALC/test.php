<?php

require_once "g_calc.php";

$calc = new g_calc();

$H  =100; 
echo 'height of crest above surrounding terrain: '.$H. '<br/>';

$exp_cat = 'C'; echo 'exposure category: '.$exp_cat. '<br/>';

$exp_cat_coeff = $calc->exp_cat_coeff($exp_cat);

$z_g    = $exp_cat_coeff['z_g'];
$alpha  = $exp_cat_coeff['alpha'];
$K_zmin = $exp_cat_coeff['K_zmin'];
$K_e    = $exp_cat_coeff['K_e'];

echo 'exp_cat_coeff: <br/>';
echo 'z_g: '. $z_g. '<br/>';
echo 'alpha: '. $alpha. '<br/>';
echo 'K_zmin: '. $K_zmin. '<br/>';
echo 'K_e: '. $K_e. '<br/>';
echo '<br/>';

echo 'exp_cat_coeff: ';
print_r($exp_cat_coeff);
echo '<br/>';

echo '--------------------------------------------<br/>';

$z = 100; //ft
echo 'height above ground at the base of the structure: '. $z. '<br/>';

$K_z = $calc->K_z($z, $z_g, $alpha, $K_zmin);

echo 'velocity pressure coefficient, K_z: '. $K_z. '<br/>';
echo '--------------------------------------------<br/>';

$topCAT = 2;
$top_cat_coeff = $calc->top_cat_coeff($topCAT, $K_e, $z, $H);

$K_t  = $top_cat_coeff['K_t'];
$f    = $top_cat_coeff['f'];
$K_h  = $top_cat_coeff['K_h'];
$K_zt = $top_cat_coeff['K_zt'];

echo 'top_cat_coeff: <br/>';
echo 'K_t: '. $K_t. '<br/>';
echo 'f: '. $f. '<br/>';
echo 'K_h: '. $K_h. '<br/>';
echo 'K_zt: '. $K_zt. '<br/>';
echo '<br/>';

$str_type = 'Latticed'; echo 'str_type: '.$str_type. '<br/>';

$str_cros_sec = 'triangular'; echo 'str_cros_sec: '.$str_cros_sec. '<br/>';

$K_d = $calc->K_d($str_type, $str_cros_sec);

echo 'K_d: '. $K_d. '<br/>';

echo '--------------------------------------------<br/>';


$str_class = 'I'; echo 'str_class: '.$str_class. '<br/>';

$purpose_of_calculation = 'wl_woIce'; echo 'purpose_of_calculation: '.$purpose_of_calculation. '<br/>';

$I_p = $calc->I_p($str_class, $purpose_of_calculation);

echo 'I_p: '. $I_p. '<br/>';

echo '--------------------------------------------<br/>';

$V = 85; // mph
$q_z = $calc->q_z($K_z, $K_zt, $K_d, $V, $I_p);
echo 'velocity pressure q_z, psf: '. $q_z. '<br/>';

echo '--------------------------------------------<br/>';


$t_i = 0.25; 
echo 'design ice thickness t_i : '. $t_i. '<br/>';
$t_iz = $calc->t_iz($t_i, $I_p, $z, $K_zt);
echo 'the factored thickness of radial glaze ice at height z : '. $t_iz. '<br/>';
echo '--------------------------------------------<br/>';

$data['exp_cat'] = 'C';
$data['topCAT'] = 2;
$data['H'] = 100;
$data['z'] = 90;
$data['str_type'] = 'Latticed';
$data['str_cros_sec'] = 'triangular';
$data['str_class'] = 'I';
$data['purpose_of_calculation'] = 'wl_woIce';
$data['V'] = 85;
$data['str_type'] = 'str_sptd_on_other_str';
$data['str_sptd_on_other_str'] = 'pole_GT';

$data = $calc->q_z_api($data);
echo 'data(q_z): '. $data['q_z']. '<br/>';
echo '--------------------------------------------<br/>';

$str_type = 'str_sptd_on_other_str';
$str_sptd_on_other_str = 'pole_GT';
$G_h = $calc->G_h($str_type, $str_sptd_on_other_str);
echo 'G_h: '. $G_h. '<br/>';
echo '--------------------------------------------<br/>';

$member_type = 'round';
$C = 67;
$aspect_ratio = 27;
$C_a = $calc->C_a($member_type, $C, $aspect_ratio);
echo 'member type: '. $member_type. '<br/>';
echo 'C: '. $C. '<br/>';
echo 'aspect ratio: '. $aspect_ratio. '<br/>';
echo 'force coefficient C_a: ';
print_r($C_a);
echo '<br/>';
echo '--------------------------------------------<br/>';




?>