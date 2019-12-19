<?php	

// 2.6.9.4 Shielding

$K_a = 1.0; // default value for unspecified cases

if( $csvtv_K_a == 'Yes'){


}else{

	if($da_type == 'round'){

		if( $ca_flow_status = "transitional" || $ca_flow_status == "supercritical" ){

			$K_a = 1;

		}else{

			if($da_pos == 'in_cros_sec_lat' || $da_pos =='out_cros_sec_in_face_zone'){

				$K_a = 1 - $epsilon;

				$K_a = min( $K_a, 0.6);			
			}else{

			}

		}

	}else if($da_type == 'eqpt' || $da_type == 'mtn_pipe'){	

		if($ge_3mts_same_elev == 'Yes'){
			$K_a = 0.8;
		}else{
			$K_a = 0.9;
		}	
	

	}else if($da_type == 'mtn_frame'){

		if($ge_3mts_same_elev == 'Yes'){
			$K_a = 0.75;
		}else{
		}

	}else if($da_type == 'mount'){

		if($ge_3mts_same_elev == 'Yes' && $ca_flow_status == "subcritical" ){

			$K_a = 0.8;

		}else{

		}

	}else if($da_type == 'twr_str'){		

	}

}

return $K_a;

?>