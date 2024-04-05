<?php

include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../helpers/handlePostRequest.php';

$database = new Database();
$pdo = $database->getConnection();
$user = new User($pdo);

$request = new Request();
$request->handlePostRequest($user);

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
            $sql = "INSERT INTO usuarios (name, lastname, username, email, password, adress, complement, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(1, $data['name']);
            $stmt->bindParam(2, $data['lastname']);
            $stmt->bindParam(3, $data['username']);
            $stmt->bindParam(4, $data['email']);
            $stmt->bindParam(5, $data['password']);
            $stmt->bindParam(6, $data['adress']);
            $stmt->bindParam(7, $data['complement']);
            $stmt->bindParam(8, $data['city']);
            $stmt->bindParam(9, $data['state']);

            $res = $stmt->execute();

            if ($res === true) {
                echo json_encode(array("message" => "Usuário cadastrado com sucesso!"));
                $logData = array_intersect_key($data, array_flip(['name', 'lastname', 'username', 'email', 'password', 'adress', 'complement', 'city', 'state']));
                $logEntry = json_encode($logData);
                file_put_contents('./log.txt', "Usuário cadastrado: $logEntry\n", FILE_APPEND);
            }
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }


    public function listUsers()
    {
        try {
            $usuarios = array();
            $sql = "SELECT * FROM usuarios";
            $res = $this->pdo->query($sql);

            if ($res->rowCount() === 0 || $res->rowCount() === '') {
                echo "Nenhum usuário encontrado!";
                return;
            }

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $usuarios[] = $row;
            }

            return $usuarios;
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }

    public function deleteUser($id)
    {
        try {
            if (!isset($id)) {
                echo "Erro ao realizar exclusão. O ID do usuário não está presente!";
                return;
            }

            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $res = $stmt->execute();

            if (!$res === true) {
                echo json_encode(array("error" => "Ocorreu um erro ao excluir o usuário."));
                return;
            }

            file_put_contents('./log.txt', "Usuário ID: $id excluído com sucesso\n", FILE_APPEND);
            echo json_encode(array("message" => "Usuário deletado com sucesso!"));
        } catch (PDOException $e) {
            echo json_encode(array("error" => "Erro: " . $e->getMessage()));
        }
    }

    public function obterUsuarioPorId($id)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = {$id}";
            $res = $this->pdo->query($sql);

            if ($res->rowCount() == 0 || $res->rowCount() == '') {
                return null;
            }

            return $res->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }

    public function editarUsuario($id, $name, $lastname, $username, $email, $password, $adress, $complement, $city, $state)
    {
        try {
            $sql = "UPDATE usuarios SET name=?, lastname=?, username=?, email=?, password=?, adress=?, complement=?, city=?, state=? WHERE id=?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $lastname);
            $stmt->bindParam(3, $username);
            $stmt->bindParam(4, $email);
            $stmt->bindParam(5, $password);
            $stmt->bindParam(6, $adress);
            $stmt->bindParam(7, $complement);
            $stmt->bindParam(8, $city);
            $stmt->bindParam(9, $state);
            $stmt->bindParam(10, $id);

            $res = $stmt->execute();

            if (!$res == true) {
                echo json_encode(array("error" => "Ocorreu um erro ao tentar editar o usuário: " . $stmt->error));
            }

            echo json_encode(array("message" => "Usuário alterado com sucesso!"));

        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }
}
