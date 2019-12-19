<?php
class Loading {
    private $db;

    private $config;

    private $usersID;

    function calculate($data) {
        $data = json_decode(json_encode($data));

        $result = array();

        $angles = [0, 45, 90, 135, 180, 225, 270, 315, 360];
        $epas = array();

        if($data->geometryShapeType == 'Cuboid') {

            $height = $data->d1;
            $width = $data->d2;
            $depth = $data->d3;

            for($k = 0; $k < count($angles); $k++) {
                $epa = $height * $width * cos($angles[$k]) + $height * $depth * sin($angles[$k]);

                $epas[] = round($epa, 2);

            }

        } else if($data->geometryShapeType == 'Cylinder') {

            $height = $data->d1;
            $width = $data->d2;
            $depth = $data->d3;

            for($k = 0; $k < count($angles); $k++) {
                $epa = $height * $width * cos($angles[$k]) + $height * $depth * sin($angles[$k]);

                $epas[] = round($epa, 2);

            }

        } else if($data->geometryShapeType == 'Sphere') {

            $height = $data->d1;
            $width = $data->d2;
            $depth = $data->d3;

            for($k = 0; $k < count($angles); $k++) {
                $epa = $height * $width * cos($angles[$k]) + $height * $depth * sin($angles[$k]);

                $epas[] = round($epa, 2);

            }

        }

        foreach ($data->loadingData as $wa) {
            $wa->ca_f2 = $data->d1 * $data->d2 * $data->d3;
            $wa->ca_f3 = $data->d1 * $data->d2 * $data->d3;
            $wa->ca_f4 = $data->d1 * $data->d2 * $data->d3;
            $wa->ca_f5 = $data->d1 * $data->d2 * $data->d3;
            $wa->ca_f6 = $data->d1 * $data->d2 * $data->d3;
        }

        $data->calculate =  $data->d1 * $data->d2 * $data->d3;

        $data->weight1 = $data->d1 * $data->d2 * $data->d3;
        $data->weight2 = $data->d1 * $data->d2 * $data->d3;
        $data->weight3 = $data->d1 * $data->d2 * $data->d3;
        $data->weight4 = $data->d1 * $data->d2 * $data->d3;
        $data->weight5 = $data->d1 * $data->d2 * $data->d3;
        $data->weight6 = $data->d1 * $data->d2 * $data->d3;

        $data->epas = $epas;

        return $data;
    }
}