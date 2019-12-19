<?php

$K_t = '';
$f = '';

$K_h = '';
$K_zt = '';

switch ($topCAT) {
	case "1":
	case "5":
	break;

	case "2":
	$K_t = 0.43;
	$f = 1.25;
	break;

	case "3":
	$K_t = 0.53;
	$f = 2.0;
	break;

	case "4":
	$K_t = 0.72;
	$f = 1.5;
	break;
}

if($topCAT == 1){
	$K_zt = 1;

}elseif($topCAT == 5){

}else{
	$e = 2.718;
	$K_h = pow($e, $f*$z['value']/$H_crest['value']);
	$K_zt = pow(1 + $K_e*$K_t/$K_h, 2);
}

$top_cat_coeff = array('K_t'=>$K_t, 'f'=>$f, 'K_h'=>$K_h, 'K_zt'=>$K_zt);

return $top_cat_coeff;

?>