<?php

if (is_numeric($I_p)) {
} else {
	$I_p = 1.0;
}


if( $z['unit'] == 'in' || $z['unit'] == 'in.' ||  $z['unit'] == 'inch' ){
	$denominator = 33;
}else if( $z['unit'] == 'm' || $z['unit'] == 'meter' ){
	$denominator = 10;
}else{

}

$K_iz = min( pow( $z['value']/12 /$denominator, 0.10), 1.4 );

$t_iz_v = 2.0*$t_i['value']*$I_p*$K_iz*pow($K_zt, 0.35);

$t_iz = array('value'=>$t_iz_v, 'unit'=>$t_i['unit']);

return $t_iz;

?>