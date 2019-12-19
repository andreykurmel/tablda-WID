<?php

switch ($exp_cat){
	case 'B':
	$z_g = array('value'=>1200, 'unit'=>'ft');
	$alpha = 7.0;
	$K_zmin = 0.7;
	$K_e = 0.9;

	break;

	case 'C':
	$z_g = array('value'=>900, 'unit'=>'ft');
	$alpha = 9.5;
	$K_zmin = 0.85;
	$K_e = 1.0;


	break;	

	case 'D':
	$z_g = array('value'=>700, 'unit'=>'ft');
	$alpha = 11.5;
	$K_zmin = 1.03;
	$K_e = 1.10;


	break;	

	default:
	break;
}

$exp_cat_coeff = array('z_g'=>$z_g, 'alpha'=>$alpha, 'K_zmin'=>$K_zmin, 'K_e'=>$K_e);

return $exp_cat_coeff;

?>