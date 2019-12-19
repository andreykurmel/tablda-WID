<?php

function S2_6_9_2_DWF_Apptnc($aptnc){

	$q_z = ;

	$G_h = ;

	$theta = array('value'=30, 'unit'=>'deg.');

	$EPA_N = sum($C_a * $A_A);

	$EPA_T = sum($C_a * $A_A);

	$EPA_A = $k_a *( $EPA_N['value'] * cos($theta['value']) +  $EPA_T['value'] * sin($theta['value']) );

	$F_A['value'] = $q_z['value']*$G_h['value']*$G_h['value'];

	$F_A['unit'] = $unit2use('force');

	return $F_A;

}

?>