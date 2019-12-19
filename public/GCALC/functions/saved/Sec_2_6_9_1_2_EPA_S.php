<?php

// $area    = array_unit_conversion($area,    $unit2use);
// $ice_thk = array_unit_conversion($ice_thk, $unit2use);

$rot_y = $da['frt_azm'];

// $rot_y = array('value'=>$da['frt_azm'], 'unit'=>$unit2use['angle']);


// $wind_dir = 30;

for ($iface = 0; $iface < sizeof($da['faces']); $iface++) {

	$area_shape = $da['faces'][$iface]['shape'];

	if($area_shape == "Rectangular" || $area_shape == "rectangular" || $area_shape == "rect"){

    	$wth = array('value'=>$da['faces'][$iface]['wth']['value'] + 2*$ice_thk['value'], 'unit'=>$unit2use['length']);
    	$lth = array('value'=>$da['faces'][$iface]['lth']['value'] + 2*$ice_thk['value'], 'unit'=>$unit2use['length']);

    	$da['faces'][$iface]['ar']  = $lth['value'] / $wth['value'];

    	$da['faces'][$iface]['area'] = array('value' => $lth['value'] * $wth['value'], 'unit' => $unit2use['area']);

    	// $Ca = $g_calc->Ca($member_type, $aspect_ratio);

   	 	// $da['faces'][$iface]['Ca'] = 1.2; // calculations to be done

    	// $da['faces'][$iface]['epa'] = $da['faces'][$iface]['area']; // calculation to be done        

	} else if($area_shape == "Cylinder" || $area_shape == "cylinder"){
		// $height   =  $area->d1['value'] + 2*$ice_thk['value'];
		// $diameter = $area->d2['value'] + 2*$ice_thk['value'];
		// $da['faces'][$iface]['area']  = $height*$diameter;
	} else if($area_shape == "Sphere" || $area_shape == "sphere"){
		// $diameter = $area->d1['value'] + 2* $ice_thk['value'];  
		// $da['faces'][$iface]['area']  = $diameter * $diameter * M_PI / 4;
	} else {

	}

    if($da['faces'][$iface]['azimuth']['value'] + $rot_y >= 360){
       $da['faces'][$iface]['azimuth']['value'] = $da['faces'][$iface]['azimuth']['value'] + $rot_y - 360;
    }else{
        $da['faces'][$iface]['azimuth']['value'] = $da['faces'][$iface]['azimuth']['value'] + $rot_y;
    }

    $da['faces'][$iface]['exposed'] = 1;

}

return $da;

?>