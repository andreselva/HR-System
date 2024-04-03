<?php

include __DIR__ . '/../../config/config.php';

$database = new Database();
$pdo = $database->getConnection();
$user = new User($pdo);

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
                // Selecionar apenas as chaves necessárias para o log
                $logData = array_intersect_key($data, array_flip(['name', 'lastname', 'username', 'email', 'password', 'adress', 'complement', 'city', 'state']));
                // Converter o array associativo em uma string JSON
                $logEntry = json_encode($logData);
                // Escrever no arquivo de log
                file_put_contents('./log.txt', "Usuário cadastrado: $logEntry\n", FILE_APPEND);
            }
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }


    public function listUsers()
    {
        $usuarios = array();

        $sql = "SELECT * FROM usuarios";

        $res = $this->pdo->query($sql);
        try {
            if ($res->rowCount() > 0) {
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    $usuarios[] = $row;
                }
                return $usuarios;
            } else {
                echo "Nenhum usuário encontrado!";
            }
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }

    public function deleteUser($id)
    {
        try {
            if (isset($id)) {
                $sql = "DELETE FROM usuarios WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    file_put_contents('./log.txt', "Usuário ID: $id excluído com sucesso\n", FILE_APPEND);
                    echo json_encode(array("message" => "Usuário deletado com sucesso!"));
                } else {
                    echo json_encode(array("error" => "Ocorreu um erro ao excluir o usuário."));
                }
            } else {
                echo json_encode(array("error" => "ID não fornecido."));
            }
        } catch (PDOException $e) {
            echo json_encode(array("error" => "Erro: " . $e->getMessage()));
        }
    }

    public function obterUsuarioPorId($id)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = {$id}";
            $res = $this->pdo->query($sql);

            if ($res->rowCount() > 0) {
                return $res->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
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

            if ($res == true) {
                echo json_encode(array("message" => "Usuário alterado com sucesso!"));
            } else {
                echo json_encode(array("error" => "Ocorreu um erro ao tentar editar o usuário: " . $stmt->error));
            }
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo $msg;
        }
    }
}


function handlePostRequest($user)
{
    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        $action = isset($data['action']) ? $data['action'] : null;

        if ($action == 'cadastrar') {
            $user->registerUser($data);
        } else if ($action == 'excluir') {
            $id = isset($data['id']) ? $data['id'] : null;

            if ($id !== null) {
                $user->deleteUser($id);
            } else {
                echo json_encode(array("error" => "ID não fornecido."));
            }
        } else if ($action == 'editar') {
            $user->editarUsuario(
                $data['id'],
                $data['name'],
                $data['lastname'],
                $data['username'],
                $data['email'],
                $data['password'],
                $data['adress'],
                $data['complement'],
                $data['city'],
                $data['state']
            );
        }
    }
}

handlePostRequest($user);
