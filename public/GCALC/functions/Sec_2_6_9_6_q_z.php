<?php


if (is_numeric($I_p)) {
} else {
	$I_p = 1.0;
}


if( $V['unit'] == 'mph'){
	$q_z_coeff = 0.00256;
	$q_z_unit = 'psf';
}else if( $V['unit'] == 'mps'){
	$q_z_coeff = 0.613;
	$q_z_unit = 'nsm';	
}else{

}

$q_z_v = (float)( $q_z_coeff * $K_z * $K_zt * $K_d * (pow($V['value'], 2)) * $I_p );

$q_z = array('value'=>$q_z_v, 'unit'=>$q_z_unit);

return $q_z;

?>