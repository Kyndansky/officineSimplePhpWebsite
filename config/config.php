<?php
require_once __DIR__ . "/../vendor/autoload.php";

class Config
{
    static public $hostname = "localhost";
    static public $username = "root";
    static public $password = "";
    static public $dbname = "officine_simulazione";
    static public $domain = "officinariccobene5b.netsons.org";

    static function init()
    {
        $dotEnv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotEnv = $dotEnv->load();
        Config::$hostname = $dotEnv['DB_HOST'];
        Config::$dbname = $dotEnv['DB_NAME'];
        Config::$username = $dotEnv['DB_USER'];
        Config::$password = $dotEnv['DB_PASS'];
    }
}
