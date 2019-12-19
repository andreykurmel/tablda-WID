<?php

// $str_type = $da['str_type'];

switch ($str_type) {
	case 'Latticed':
	case 'latticed':
	$h_str = isset($h_str) ? $h_str : 0;
	$G_h = min(max(0.85 + 0.15 * ($h_str['value'] / 150 - 3.0), 0.85), 1.00);
	break;

	case 'guyed':
	case 'guyed_mast':
	case 'guyed_tower':		
	$G_h = 0.85;
	break;

	case 'tubular_pole':
	case 'other_pole':
	$G_h = 1.10;
	break;

	case 'appurtenance':
	$G_h = 0.95;
	break;
	
	case 'str_sptd_on_other_str':

	switch ($str_sptd_on_other_str) {
		case 'ballast_RT':
		$G_h = 1.0;
		break;

		case 'tubular_GT':
		case 'spine_GT':
		case 'pole_GT':
		case 'tubular_SST':
		case 'str_flexible_bldg':
		$G_h = 1.35;
		break;
		default:
		$G_h = NaN;
		break;
	}

	break;
	default:
	break;
}

return $G_h;

?>