<?php

$exp_cat = $data['exp_cat'];

$exp_cat_coeff = $this->exp_cat_coeff($exp_cat);

$z_g    = $exp_cat_coeff['z_g'];
$alpha  = $exp_cat_coeff['alpha'];
$K_zmin = $exp_cat_coeff['K_zmin'];
$K_e    = $exp_cat_coeff['K_e'];
$data['exp_cat_coeff'] = $exp_cat_coeff;

$topCAT  = $data['topCAT'];
$H_crest = $data['H_crest'];
$z 		 = $data['z'];

$top_cat_coeff = $this->top_cat_coeff($topCAT, $K_e, $z, $H_crest);
$data['top_cat_coeff'] = $top_cat_coeff;

$K_t  = $top_cat_coeff['K_t'];
$f    = $top_cat_coeff['f'];
$K_h  = $top_cat_coeff['K_h'];
$K_zt = $top_cat_coeff['K_zt'];

$K_z = $this->K_z($z, $z_g, $alpha, $K_zmin);
$data['K_z'] = $K_z;

$str_type = $data['str_type'];
$str_cros_sec = $data['str_cros_sec'];
$K_d = $this->K_d($str_type, $str_cros_sec);
$data['K_d'] = $K_d;

$str_class = $data['str_class'];
$purpose_of_calculation = $data['purpose_of_calculation'];
$I_p = $this->I_p($str_class, $purpose_of_calculation);
$data['I_p'] = $I_p;

$V = $data['V'];
// $q_z = (float)(0.00256 * $K_z * $K_zt * $K_d * (pow($V, 2)) * $I_p);
$q_z = $this->q_z($K_z, $K_zt, $K_d, $V, $I_p);
$data['q_z'] = $q_z;

// $str_type = $data['str_type'];
// $str_sptd_on_other_str = $data['str_sptd_on_other_str'];
// $G_h = $this->G_h($str_type, $str_sptd_on_other_str);
// $data['G_h'] = $G_h;

return $data;

?>