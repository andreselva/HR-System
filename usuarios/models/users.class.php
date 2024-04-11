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

    public function registerUser($data) 
    {
        try {
            $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?);";

            $stmt = $this->pdo>prepare($sql);

            $stmt = bindParam(1, $data['name']);
            $stmt = bindParam(2, $data['email']);
            $stmt = bindParam(3, $data['username']);
            $stmt = bindParam(4, $data['password']);

            $res = $stmt->execute();

            if (!$res === true) {
                echo json_encode(array("message" => "Ocorreu um erro ao cadastrar o usuário! Verifique o backend."));
            }

            echo json_encode(array("message" => "Cadastrado com sucesso!"));
            $logData = array_intersect_key($data, array_flip(['name', 'email', 'username', password]));
            $logEntry = json_encode($logData);
            file_put_contents('./log.txt', "Usuário cadastrado: $logEntry\n", FILE_APPEND);

        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }

}
