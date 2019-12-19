<?php

function EPA_A($wind_dir_angle, $windAreas){
	$EPA_A_angle = 0;
            // http://www.math.wvu.edu/~hjlai/Teaching/Tip-Pdf/Tip3-2.pdf
	$wind_dir_vector = array(
		'x'=> cos($wind_dir_angle * M_PI/180),
		'y'=> 0,
		'z'=> sin($wind_dir_angle * M_PI/180),
		);

	$norm_wind_dir = sqrt( pow($wind_dir_vector['x'],2) + pow($wind_dir_vector['y'],2) + pow($wind_dir_vector['z'],2) );

	foreach($windAreas as $area){

		$area_normal_dir = array(
			'x'=> -$area->ndx,
			'y'=> -$area->ndy,
			'z'=> -$area->ndz
			);

		$Aa_N_T = $area->Aa_0;

		$Ca = 1.0; $Ka = 1.0;

		$norm_area_normal_dir = sqrt( pow($area_normal_dir['x'],2) + pow($area_normal_dir['y'],2) + pow($area_normal_dir['z'],2) );

		$dot_wind_to_area_norm = $wind_dir_vector['x'] * $area_normal_dir['x'] + $wind_dir_vector['y'] * $area_normal_dir['y'] + $wind_dir_vector['z'] * $area_normal_dir['z'];

		$angle_btw_wind_area_norm = acos( $dot_wind_to_area_norm/ ($norm_wind_dir * $norm_area_normal_dir) ) * 180/M_PI;

		if($angle_btw_wind_area_norm < 90){
			$EPA_A_angle = $EPA_A_angle + $Ka*$Ca*$Aa_N_T*pow(cos($angle_btw_wind_area_norm * M_PI/180), 2);
		}
	}
	return $EPA_A_angle;
}

?>