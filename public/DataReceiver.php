<?php

class DataReceiver
{
    /**
     * @param string $table_name
     * @return \Tablda\DataReceiver\DataTableReceiver
     */
    public static function get(string $table_name)
    {
        $settings = ['TABLDA_APP_NAME' => env('TABLDA_APP_NAME', 'stim_3d')];

        $tablda_data_interface = app(\Tablda\DataReceiver\TabldaDataInterface::class, ['settings' => $settings]);

        return $tablda_data_interface->tableReceiver($table_name);
    }
}