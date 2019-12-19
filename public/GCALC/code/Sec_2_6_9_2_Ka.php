<?php

function S2_6_9_2_Ka($aptnc){

	// The Reynolds number, which we explored in assignment 2, 
	// allows us to classify stream flow as either laminar or turbulent. 
	// he key difference between these flow conditions is whether water molecules are 
	// flowing in parallel paths in a downstream direction at a constant velocity or 
	// whether water molecules are traveling along paths going in different directions and/or at different velocities. 

	// The Froude number provides a second way of classifying flow conditions and is based not on the paths that strands of
	// water molecules follow, but on the relationship between flow velocity and flow depth. Similar to the Reynolds number, the
	// Froude number helps assess the energy state of water flow. 

	// F = (gravitational forces) / (intertial forces)

	// Another similarity to the Reynolds number is the fact that the Froude
	// number is dimensionless – there are no units associated with the Froude number.

	// Subcritical flow is deep, slow flow with a low energy state and has a Froude number less than one (F<1). 
	// Critical flow occurs when the Froude number equals one (F=1); there is a perfect balance between the gravitational and inertial forces.
	// Supercritical flow is shallow, fast flow with a high energy state and has a Froude number greater than one (F>1).	

	$aptnc_shape = 'round';
	$flow_cndtn = 'subcritical';
	$aptnc_position = 'round'; // inside_crosec_lat, outside_crosec_lat_within_facezone, others

	if($aptnc_shape = "round" && ($flow_cndtn == 'supercritical' or $flow_cndtn == 'critical')){
		$Ka = 1.0;
	}else if($aptnc_shape = "round"){		
		$Ka = 1 - $epsilon;
	}else if($aptnc_shape = "round"){
		$Ka = 0.8;
	}else{
		$Ka = 1;
	}

	return $Ka;

}

?>