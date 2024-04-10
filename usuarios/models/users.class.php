<?php

include __DIR__ . '/../../config/config.php';

$database = new Database();
$pdo = $database->getConnection();

class Usuario
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

}
