<?php

include __DIR__ . '/../../config/config.php';

$database = new Database();
$pdo = $database->getConnection();

class User
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

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(1, $data['name']);
            $stmt->bindParam(2, $data['email']);
            $stmt->bindParam(3, $data['username']);
            $stmt->bindParam(4, $data['password']);

            $res = $stmt->execute();

            if ($res !== true) {
                echo json_encode(array("message" => "Ocorreu um erro ao cadastrar o usuário! Verifique o backend."));
            }

            echo json_encode(array("message" => "Cadastrado com sucesso!"));
            $logData = array_intersect_key($data, array_flip(['name', 'email', 'username', 'password']));
            $logEntry = json_encode($logData);
            file_put_contents('./log.txt', "Usuário cadastrado: $logEntry\n", FILE_APPEND);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }

    public function deleteUser($id)
    {
        if (!isset($id)) {
            echo json_encode(array("message" => "Id do usuário a ser deletado não está presente."));
            return;
        }

        try {
            $sql = "DELETE FROM users WHERE id = ? LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);

            $res = $stmt->execute();

            if ($res !== true) {
                echo json_encode(array("message" => "Erro ao excluir o usuário. Verifique o backend."));
                return;
            }

            echo json_encode(array("message" => "Usuário excluído!"));
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }

    public function editUser($id, $name, $email, $username, $password)
    {
        try {
            $sql = "UPDATE users SET $name = ?, $email=?, $username=?, $password=? WHERE id=?";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $username);
            $stmt->bindParam(4, $password);
            $stmt->bindParam(5, $id);

            $res = $stmt->execute();

            if ($res !== true) {
                echo json_encode(array("message" => "Erro ao editar usuário! Verifique o backend."));
            }

            echo json_encode(array("message" => "Cadastrado com sucesso."));
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }

    public function listUsers()
    {
        try {

            $sql = "SELECT * FROM users ORDER BY id DESC";

            $res = $this->pdo->query($sql);

            if ($res->rowCount() === 0 || $res->rowCount() === '') {
                return;
            }

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $row;
            }

            return $users;
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }

    protected function recoverUserById($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return null;
            }

            return $user;
            
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo json_encode(array("message" => "Erro ao recuperar usuário por id."));
        }
    }

}
