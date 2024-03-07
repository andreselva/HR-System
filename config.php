<?php

class Database
{

    private $conn;

    public function __construct()
    {
        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '123456');
        define('BASE', 'sistema');
        define('PORT', '3306');

        $this->conn = new mysqli(HOST, USER, PASS, BASE, PORT);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
