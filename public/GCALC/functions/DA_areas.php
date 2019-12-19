<?php

$da_geo_type = $da['db_pro_asctn']['geometryShapeType'];

// if($da_geo_type == "Cuboid"){

//     $da['areas'] = array(
//         array('name'=>'front', 'shape'=>'rectangular', 'wth'=>array('value'=>'3', "unit"=>$unit2use['length']), 'lth'=>array('value'=>'2', "unit"=>$unit2use['length']), 'dir'=>[+1,0,0], 'azimuth'=>0),
//         array('name'=>'back',  'shape'=>'rectangular', 'wth'=>array('value'=>'3', "unit"=>$unit2use['length']), 'lth'=>array('value'=>'2', "unit"=>$unit2use['length']), 'dir'=>[-1,0,0], 'azimuth'=>180),
//         array('name'=>'top',   'shape'=>'rectangular', 'wth'=>array('value'=>'3', "unit"=>$unit2use['length']), 'lth'=>array('value'=>'4', "unit"=>$unit2use['length']), 'dir'=>[0,+1,0], 'azimuth'=>0),
//         array('name'=>'bottom','shape'=>'rectangular', 'wth'=>array('value'=>'3', "unit"=>$unit2use['length']), 'lth'=>array('value'=>'4', "unit"=>$unit2use['length']), 'dir'=>[0,-1,0], 'azimuth'=>0),
//         array('name'=>'right', 'shape'=>'rectangular', 'wth'=>array('value'=>'4', "unit"=>$unit2use['length']), 'lth'=>array('value'=>'2', "unit"=>$unit2use['length']), 'dir'=>[0,0,+1], 'azimuth'=>90),
//         array('name'=>'left',  'shape'=>'rectangular', 'wth'=>array('value'=>'4', "unit"=>$unit2use['length']), 'lth'=>array('value'=>'2', "unit"=>$unit2use['length']), 'dir'=>[0,0,-1], 'azimuth'=>270)
//         );
// }else if($da_geo_type == 'sphere'){
// }else if($da_geo_type == 'cylindrical'){
// }

$facesData = array();
if($type == 'single_object'){
    if($shapeType == 'Cuboid') {
        $facesData[] = array(
            'face_name' => 'Front',
            'face_shape' => 'Rectangular',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
        $facesData[] = array(
            'face_name' => 'Left',
            'face_shape' => 'Rectangular',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
        $facesData[] = array(
            'face_name' => 'Back',
            'face_shape' => 'Rectangular',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
        $facesData[] = array(
            'face_name' => 'Right',
            'face_shape' => 'Rectangular',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
        $facesData[] = array(
            'face_name' => 'Top',
            'face_shape' => 'Rectangular',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
        $facesData[] = array(
            'face_name' => 'Bot',
            'face_shape' => 'Rectangular',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
    } else if ( $shapeType == 'Cylinder'){
        $facesData[] = array(
            'face_name' => 'Front',
            'face_shape' => 'Cylinder',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
    } else if( $shapeType == 'Sphere' ) {
        $facesData[] = array(
            'face_name' => 'Front',
            'face_shape' => 'Sphere',
            'aspect_ratio' => round((int)$product_data['d1'] / (int)$product_data['d2'], 2)
        );
    } else {
        var_dump('UNDEFINED SHAPE TYPE'); exit;
    }
}

//        var_dump($product_data, $product_data->d1, (int)$product_data['d1']); exit;
return $facesData;
