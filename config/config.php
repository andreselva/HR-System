<?php

class Database
{

    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=sistema';
        $username = 'root';
        $password = '123456';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
    
}
