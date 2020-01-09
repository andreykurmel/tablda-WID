<?php

namespace App\Classes;


class DataReceiver
{
    protected static $tablda_data_interface;

    /**
     * Set Tablda Data interface
     */
    protected static function data_interface()
    {
        $settings = ['TABLDA_APP_NAME' => env('TABLDA_APP_NAME', 'stim_3d')];

        self::$tablda_data_interface = new TabldaReceiver($settings);
    }

    /**
     * @param string $table_name
     * @return TableConverter
     */
    public static function get(string $table_name)
    {
        if (!self::$tablda_data_interface) {
            self::data_interface();
        }
        return self::$tablda_data_interface->tableReceiver($table_name);
    }
}