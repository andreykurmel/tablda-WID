<?php

	// $EPA_A_angle = array(); // http://www.math.wvu.edu/~hjlai/Teaching/Tip-Pdf/Tip3-2.pdf
$wind_dir = $da['wind_dir']; 	

$wind_dir_vector = array(
	'x'=> -cos($wind_dir['value']),
	'y'=> 0,
	'z'=> -sin($wind_dir['value']),
	);

$norm_wind_dir = sqrt( pow($wind_dir_vector['x'], 2) + pow($wind_dir_vector['y'], 2) + pow($wind_dir_vector['z'], 2) );

$EPA_A = array( 'value' => 0, 'unit'=>$unit2use['area'] );

$K_a = $da['k_a'];

if(isset($da['faces'])){

	for ($iface = 0; $iface < sizeof($da['faces']); $iface++) {

		$area_normal_dir = array(
			'x'=> $da['faces'][$iface]['n_dir_vec'][0],
			'y'=> $da['faces'][$iface]['n_dir_vec'][1],
			'z'=> $da['faces'][$iface]['n_dir_vec'][2],
			);

		$P_A_A_A_v = $da['faces'][$iface]['P_A_A_A']['value'];

		$C_a = $da['faces'][$iface]['C_a'];

		$dot_product_uv = $area_normal_dir['x'] * $wind_dir_vector['x'] + $area_normal_dir['z'] * $wind_dir_vector['z'];
		$lth_u = sqrt( pow($area_normal_dir['x'], 2) + pow($area_normal_dir['z'], 2) );
		$lth_v = sqrt( pow($wind_dir_vector['x'], 2) + pow($wind_dir_vector['z'], 2) );
		$angle_btw_v = acos( $dot_product_uv / ($lth_u*$lth_v) );

		// $da['wind_dir_vector'] = $wind_dir_vector;
		// $da['area_normal_dir'] = $area_normal_dir;
		// $da['dot_product_uv'] = $dot_product_uv;
		// $da['lth_u'] = $lth_u;
		// $da['lth_v'] = $lth_v;
		// $da['angle_btw_v'] = $angle_btw_v;		
										
		// $writedir = 'debug/';
		// $filename = 'da_in_epa_a0.json';
		// file_put_contents( $writedir.$filename, json_encode($da, JSON_PRETTY_PRINT) ); 		

		// $angle_btw_v = 0;

		$angle_btw = array('value' =>$angle_btw_v, 'unit' =>$unit2use['angle']);

		$da['faces'][$iface]['angle_btw'] = $angle_btw;

		if($angle_btw['value'] < M_PI/2){

            $da['faces'][$iface]['exposure'] = 1;			

			$da['faces'][$iface]['EPA_A']['value'] = $K_a*$C_a*$P_A_A_A_v*pow(cos($angle_btw['value']), 2);
		}else{

            $da['faces'][$iface]['exposure'] = 0;			
			$da['faces'][$iface]['EPA_A']['value'] = 0;
		}

		$da['faces'][$iface]['EPA_A']['unit']  = $unit2use['area'];

		$EPA_A['value'] = $EPA_A['value'] + $da['faces'][$iface]['EPA_A']['value'];

	}

}

$da['epa_a'] = $EPA_A; // array('value'=>123, 'unit'=>$unit2use['area']);

return $da;

?>