<?php
require_once('./global_config.php');

$config['data'] = array(
    'all' => array(
        'table' => 'Equipment',
        'columns' => array(
            'type' => "Type",
            'sub_type' => "Sub Type",
            'shape' => "Shape",
            'mftr' => "Manufacturer",
            'model' => "Model"
        ),
        'size' => array(
            100,
            100,
            100,
            100,
            250
        )
    ),
    'geometry' => array(
        'table' => 'Geometry',
        'columns' => array(
            'Type_G' => "Type",
            'Sub_type_G' => "Sub Type",
            'Shape_G' => "Shape",
            'Mftr_G' => "Manufacturer",
            'Model_G' => "Model"
        ),
        'size' => array(
            100,
            100,
            100,
            100,
            250,
            90
        )
    ),
     'publicUsersID' => '155,140,175'  // '0,1,2,3,...' wlda
//    'publicUsersID' => '140, 155'  // '0,1,2,3,...' wlda   // 140 - test test; 155 - Data Manager
);

$config['database'] = array(
    'wid' => array(
        'host' => DB_HOSTNAME,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'db' => DB_WID_NAME
    ),
    'shared' => array(
        'host' => DB_HOSTNAME,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'db' => DB_SHARED_NAME
    )

);
