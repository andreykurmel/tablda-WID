<?php

switch ($str_type) {
	case 'Latticed':
	case 'latticed':
	case 'guyed_mast':
	case 'guyed_tower':
	case 'guyed':

	switch ($str_cros_sec) {
		case 'triangular':
		case 'square':
		case 'rectangular':
		$K_d = 0.85;
		break;

		case 'others':
		$K_d = 0.95;
		break;

		default:
		break;
	}
	break;

	case 'tubular_pole':
	case 'other_pole':
	case 'appurtenance':
	$K_d = 0.95;
	break;

	default:
	$K_d = 0.95; // to be verified.	
	break;
}

return $K_d;


?>