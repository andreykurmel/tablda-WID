<?php

function Table_2_8_Ca_DA($data_DA, $iced_cndts, $csvtly_subcrtcl){

	$mbr_type = $data_DA['type'];

	$Ra = 0.1; // irregularities percentage/ratio, for both cylindrical/flat appurtenances.

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

		if($Ra <= 0.1){
			// projected area of irregularities may be ignored.
		}else{
			// projected area of irregularities shall be considered separately in addition to apurt itself.
		}

	}else if($mbr_type == 'round'){

		$C = pow($I * $K_zt * $K_z, 0.5) * $V * $D;

		$aspect_ratio = $data_DA['length']['value'] / $data_DA['diameter']['value'];	

		if($C < 32){
			$flow_cndtn = 'subcritical';
		}else if( $C >= 32 && $C <= 64){
			$flow_cndtn = 'transitional';
		}else{
			$flow_cndtn = 'supercritical';
		}
		$flow_cndtn_to_be_cnsdrd_as = $flow_cndtn;

		if($iced_cndts == 'yes' || $csvtly_subcrtcl == 'yes'){ $flow_cndtn_to_be_cnsdrd_as = 'subcritical'; }

		if($flow_cndtn_to_be_cnsdrd_as='subcritical'){

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

		}else if( $flow_cndtn_to_be_cnsdrd_as = 'transitional' ){

			$v1 = 3.76 / $C^0.458;
			$v2 = 3.37 / $C^0.415;
			$v3 = 38.4 / $C^1.0;

			$pairs = array(array(2.5, $v1), array(7, $v2), array(25, $v3));
			if($aspect_ratio <= $pairs[0][0]){
				$Ca = $pairs[0][1];
			}else if($aspect_ratio > $pairs[0][0] && $aspect_ratio <= $pairs[1][0]){
				$Ca = $pairs[0][1] + ($pairs[1][1] - $pairs[0][1]) / ($pairs[1][0] - $pairs[0][0]) * ($aspect_ratio - $pairs[0][0]);
			}else if($aspect_ratio > $pairs[1][0] && $aspect_ratio <= $pairs[2][0]){
				$Ca = $pairs[1][1] + ($pairs[2][1] - $pairs[1][1]) / ($pairs[2][0] - $pairs[1][0]) * ($aspect_ratio - $pairs[1][0]);
			}else{
				$Ca == $pairs[2][1];
			}				

		}else if( $flow_cndtn_to_be_cnsdrd_as = 'supercritical' ){

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

		}else{}

		if($Ra <= 0.1){
			// projected area of irregularities may be ignored.
		}else if($Ra > 0.1 && $Ra <= 0.2){
			$Ca = $Ca * (1.0 + 3*($Ra - 0.1)).
		}else{
			// projected area of irregularities shall be considered separately in addition to apurt itself.			
		}
	}

	$data_DA['C']  = $C;
	$data_DA['Ca'] = $Ca;

	return $data_DA;

}

?>