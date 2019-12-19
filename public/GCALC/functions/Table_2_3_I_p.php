<?php

$I_p = 1.0;

switch ($str_class){
	case 'I':
	switch ($purpose_of_calculation){
		case "wl_woIce": $I_p = 0.87; break;
		case "wl_wIce": $I_p = "N/A"; break;
		case "iceThk": $I_p = "N/A"; break;
		case "earthquake": $I_p = "N/A"; break;
	}
	break;

	case 'II':
	switch ($purpose_of_calculation){
		case "wl_woIce": $I_p = 1.00; break;
		case  "wl_wIce": $I_p = 1.00; break;
		case "iceThk": $I_p = 1.00; break;
		case "earthquake": $I_p = 1.00; break;
	}
	break;

	case 'III':
	switch ($purpose_of_calculation){
		case "wl_woIce": $I_p = 1.15; break;
		case "wl_wIce": $I_p = 1.00; break;
		case "iceThk": $I_p = 1.25; break;
		case "earthquake": $I_p = 1.50; break;
	}

	break;

	default:
	break;

}

return $I_p;

?>