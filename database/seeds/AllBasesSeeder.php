<?php

use Illuminate\Database\Seeder;

class AllBasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::unprepared("
                DROP DATABASE IF EXISTS `".env('APP_DB_NAME', 'app_e3c_bc_sitelok')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_NAME', 'app_e3c_bc_sitelok')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
                
                DROP DATABASE IF EXISTS `".env('APP_DB_CALC_NAME', 'app_e3c_calculations')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_CALC_NAME', 'app_e3c_calculations')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
                
                DROP DATABASE IF EXISTS `".env('APP_DB_WID_NAME', 'app_e3c_wid')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_WID_NAME', 'app_e3c_wid')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
                
                DROP DATABASE IF EXISTS `".env('APP_DB_BA_NAME', 'app_e3c_ba')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_BA_NAME', 'app_e3c_ba')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
                
                DROP DATABASE IF EXISTS `".env('APP_DB_PC_NAME', 'app_e3c_pc')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_PC_NAME', 'app_e3c_pc')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
                
                DROP DATABASE IF EXISTS `".env('APP_DB_SHARED_NAME', 'app_e3c_shared')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_SHARED_NAME', 'app_e3c_shared')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
                
                DROP DATABASE IF EXISTS `".env('APP_DB_QUIZ_NAME', 'app_e3c_quiz')."`;
                CREATE DATABASE IF NOT EXISTS `".env('APP_DB_QUIZ_NAME', 'app_e3c_quiz')."` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;
            ");


        $conn = $this->make_conn( env('APP_DB_NAME', 'app_e3c_bc_sitelok') );
        $conn->unprepared(file_get_contents('database/seeds/bc_sitelok.sql'));

        $conn = $this->make_conn( env('APP_DB_CALC_NAME', 'app_e3c_calculations') );
        $conn->unprepared(file_get_contents('database/seeds/calculations.sql'));

        $conn = $this->make_conn( env('APP_DB_WID_NAME', 'app_e3c_wid') );
        $conn->unprepared(file_get_contents('database/seeds/wid.sql'));
        $conn->unprepared(file_get_contents('database/seeds/wid1.sql'));

        $conn = $this->make_conn( env('APP_DB_BA_NAME', 'app_e3c_ba') );
        $conn->unprepared(file_get_contents('database/seeds/ba.sql'));

        $conn = $this->make_conn( env('APP_DB_PC_NAME', 'app_e3c_pc') );
        $conn->unprepared(file_get_contents('database/seeds/pc.sql'));

        $conn = $this->make_conn( env('APP_DB_SHARED_NAME', 'app_e3c_shared') );
        $conn->unprepared(file_get_contents('database/seeds/shared.sql'));

        $conn = $this->make_conn( env('APP_DB_QUIZ_NAME', 'app_e3c_quiz') );
        $conn->unprepared(file_get_contents('database/seeds/quiz.sql'));
    }

    /**
     * @param string $database
     * @return mixed
     */
    private function make_conn(string $database) {
        $factory = app()->make(\Illuminate\Database\Connectors\ConnectionFactory::class);
        return $factory->make([
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '3306'),
            'database'  => $database,
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict'    => false,
            'engine'    => 'InnoDB'
        ]);
    }
}
