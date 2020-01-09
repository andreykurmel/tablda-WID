<?php

namespace App\Classes;


use Illuminate\Database\Eloquent\Builder;
use Tablda\DataReceiver\DataTableReceiver;

class TableConverter extends DataTableReceiver
{

    /**
     * Get Query with field mapping.
     *
     * @return Builder
     */
    public function accessToQuery()
    {
        return $this->builder;
    }

    /**
     * Map column for wheres.
     *
     * @param string $column
     * @return null
     * @throws \Exception
     */
    public function map_column(string $column) {
        try {
            $mapped = parent::map_column($column);
        } catch (\Exception $e) {
            $mapped = '';
        }
        return $mapped;
    }
}