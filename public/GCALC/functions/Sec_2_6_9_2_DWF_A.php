<?php

$dwf_v = 0;

$G_h = $da['g_h']; // calculations to be done. 

if(isset($da['faces'])) {
	for ($iface = 0; $iface < sizeof($da['faces']); $iface++) {

		$idwf_v = $da['q_z']['value'] * $G_h * $da['faces'][$iface]['EPA_A']['value']/144;

		$idwf   = array('value' => $idwf_v, 'unit' => $unit2use['force'] );

		$da['faces'][$iface]['dwf'] = $idwf;

		$dwf_v = $dwf_v + $idwf_v;

	}
}

$dwf = array('value'=>$dwf_v, 'unit'=>$unit2use['force']);

$da['dwf']  = $dwf;

return $da;

?>