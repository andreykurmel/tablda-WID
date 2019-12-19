<?php

	// $ar_C_a = array([1.2, 0.7, 3.76/pow(C, 0.485), 0.50], 
	// 				[1.4, 0.8, 3.37/pow(C, 0.415), 0.60], 
	// 				[2.0, 1.2, 38.4/pow(C, 1.000), 0.60]);

$ar_C_a = array(
	[1.2, 1.4, 2.0], 
	[0.7, 0.8, 1.2],
	[3.76/pow($C, 0.485), 3.37/pow($C, 0.415), 38.4/pow($C, 1.000)],
	[0.5, 0.6, 0.6]);

if($aspect_ratio <= 2.5){
	$ar_e = 2.5;
	$ar_s = $ar_e - 1;
}elseif ($aspect_ratio > 2.5 && $aspect_ratio <= 7.0) {
	$ar_s = 2.5;
	$ar_e = 7.0;
}elseif ($aspect_ratio > 7 && $aspect_ratio <= 25) {
	$ar_s = 7.0;
	$ar_e = 25;
}elseif($aspect_ratio > 25) {
	$ar_s = 25;
	$ar_e = $ar_s + 1;
}

switch ($member_type){

	case 'Flat':
	case 'flat':
	$irow = 0;
	break;

	case 'Round':
	case 'round':

	if($C < 32){
		$irow = 1;
	}elseif ($C>=32 && $C<=64 ) {
		$irow = 2;
	}else{
		$irow = 3;
	}

	break;

	default:
	break;
}

if($aspect_ratio <= 2.5){
	$C_a_s = $ar_C_a[$irow][0];
	$C_a_e = $ar_C_a[$irow][0];
}elseif ($aspect_ratio > 2.5 && $aspect_ratio <= 7.0) {
	$C_a_s = $ar_C_a[$irow][0];
	$C_a_e = $ar_C_a[$irow][1];
}elseif ($aspect_ratio > 7 && $aspect_ratio <= 25) {
	$C_a_s = $ar_C_a[$irow][1];
	$C_a_e = $ar_C_a[$irow][2];
}elseif($aspect_ratio > 25) {
	$C_a_s = $ar_C_a[$irow][2];
	$C_a_e = $ar_C_a[$irow][2];
}

$C_a = $C_a_s + ($C_a_e - $C_a_s) / ($ar_e - $ar_s) * ($aspect_ratio - $ar_s);

return $C_a;

?>