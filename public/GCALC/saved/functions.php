<?php
function S2_6_9_2_DWF_Apptnc($aptnc){

	$q_z = ;

	$G_h = ;

	$theta = array('value'=30, 'unit'=>'deg.');

	$EPA_N = sum($C_a * $A_A);

	$EPA_T = sum($C_a * $A_A);

	$EPA_A = $k_a *( $EPA_N['value'] * cos($theta['value']) +  $EPA_T['value'] * sin($theta['value']) );

	$F_A['value'] = $q_z['value']*$G_h['value']*$G_h['value'];

	$F_A['unit'] = $unit2use('force');


	return $F_A;

}

$apptnc = array(array('type'=>'flat', ), array());

function table2_8_Ca_DA($data_DA, $iced_cndts, $csvtly_subcrtcl){

	$mbr_type = $data_DA['type'];

	if($mbr_type == 'flat'){

		$aspect_ratio = $data_DA['length']['value'] / $data_DA['width']['value'];		

		$pairs = array(array(2.5, 1.2), array(7, 1.4), array(25, 2.0));
		if($aspect_ratio <= $pairs[0][0]){
			$Ca = $pairs[0][1];
		}else if($aspect_ratio > $pairs[0][0] && $aspect_ratio <= $pairs[1][0]){
			$Ca = $pairs[0][1] + ($pairs[1][1] - $pairs[0][1]) / ($pairs[1][0] - $pairs[0][0]) * ($aspect_ratio - $pairs[0][0]);
		}else if($aspect_ratio > $pairs[1][0] && $aspect_ratio <= $pairs[2][0]){
			$Ca = $pairs[1][1] + ($pairs[2][1] - $pairs[1][1]) / ($pairs[2][0] - $pairs[1][0]) * ($aspect_ratio - $pairs[1][0]);
		}else{
			$Ca == $pairs[2][1];
		}

	}else if($mbr_type == 'round'){

		$C = ($I * $K_zt * $K_z) * $V * $D;

		$aspect_ratio = $data_DA['length']['value'] / $data_DA['diameter']['value'];		

		if($C < 32 or $iced_cndts == 'yes' or $csvtly_subcrtcl == 'yes'){

			$pairs = array(array(2.5, 0.7), array(7, 0.8), array(25, 1.2));
			if($aspect_ratio <= $pairs[0][0]){
				$Ca = $pairs[0][1];
			}else if($aspect_ratio > $pairs[0][0] && $aspect_ratio <= $pairs[1][0]){
				$Ca = $pairs[0][1] + ($pairs[1][1] - $pairs[0][1]) / ($pairs[1][0] - $pairs[0][0]) * ($aspect_ratio - $pairs[0][0]);
			}else if($aspect_ratio > $pairs[1][0] && $aspect_ratio <= $pairs[2][0]){
				$Ca = $pairs[1][1] + ($pairs[2][1] - $pairs[1][1]) / ($pairs[2][0] - $pairs[1][0]) * ($aspect_ratio - $pairs[1][0]);
			}else{
				$Ca == $pairs[2][1];
			}	    	

		}else if( $C >= 32 && $C <= 64){

			$v1 = 3.76 / $C^0.458;
			$v2 = 3.37 / $C^0.415;
			$v3 = 38.4 / $C^1.0;

			$pairs = array(array(2.5, 0$v1), array(7, 0$v2), array(25, $v3));
			if($aspect_ratio <= $pairs[0][0]){
				$Ca = $pairs[0][1];
			}else if($aspect_ratio > $pairs[0][0] && $aspect_ratio <= $pairs[1][0]){
				$Ca = $pairs[0][1] + ($pairs[1][1] - $pairs[0][1]) / ($pairs[1][0] - $pairs[0][0]) * ($aspect_ratio - $pairs[0][0]);
			}else if($aspect_ratio > $pairs[1][0] && $aspect_ratio <= $pairs[2][0]){
				$Ca = $pairs[1][1] + ($pairs[2][1] - $pairs[1][1]) / ($pairs[2][0] - $pairs[1][0]) * ($aspect_ratio - $pairs[1][0]);
			}else{
				$Ca == $pairs[2][1];
			}				

		}else{

			$pairs = array(array(2.5, 0.5), array(7, 0.6), array(25, 0.6));
			if($aspect_ratio <= $pairs[0][0]){
				$Ca = $pairs[0][1];
			}else if($aspect_ratio > $pairs[0][0] && $aspect_ratio <= $pairs[1][0]){
				$Ca = $pairs[0][1] + ($pairs[1][1] - $pairs[0][1]) / ($pairs[1][0] - $pairs[0][0]) * ($aspect_ratio - $pairs[0][0]);
			// }else if($aspect_ratio > $pairs[1][0] && $aspect_ratio <= $pairs[2][0]){
			// 	$Ca = $pairs[2][1];
			}else{
				$Ca == $pairs[2][1];
			}			

		}

	}

	$data_DA['C']  = $C;
	$data_DA['Ca'] = $Ca;

	return $data_DA;

}



?>