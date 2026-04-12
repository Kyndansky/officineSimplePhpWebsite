<?php
class DatabaseManager
{
    private $conn;
    public function __construct()
    {
        require_once __DIR__ . "/../config/config.php";
        $this->conn = new mysqli(
            Config::$hostname,
            Config::$username,
            Config::$password,
            Config::$dbname,
        );
    }

    public function query($q)
    {
        return $this->conn->query($q);
    }

    public function getConnection() {
        return $this->conn;
    }
}
