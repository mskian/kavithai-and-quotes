<?php

include 'store.php';
(new DevCoder\DotEnv('../.env'))->load();

class Database {

    private $host = "localhost";
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->db_name = getenv('DBNAME');
        $this->username = getenv('DBUSER');
        $this->password = getenv('DBPASSWORD');
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $exception) {
            throw new Exception("Connection failed: " . $exception->getMessage());
        }

        return $this->conn;
    }
}

?>
