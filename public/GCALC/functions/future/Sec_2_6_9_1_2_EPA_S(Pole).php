<?php


$epislon = ($A_f + $A_r) / $A_g;  // solidity ratio

if($crs_sec_shape == 'square'){
	$C_f = 4.0*pow(epislon, 2) – 5.9*epislon +  4.0;
}elseif ($crs_sec_shape == 'triangular') {
	$C_f = 3.4*pow(epislon, 2) – 4.7*epislon +  3.4;
}


$EPA_S = $C_f*$A_P;

?>