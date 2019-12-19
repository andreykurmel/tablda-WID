<?php

function Table_2_8_C($design_parameters, $aprtn){

	// flow condition coefficients for a appurtenance
	// $V: basic wind speed for the loading condition under investigation
	// $D: outside diameter of the appurtenance

	$C = ($I * $K_zt * $K_z) * $V * $D;

	return $C;
}

?>