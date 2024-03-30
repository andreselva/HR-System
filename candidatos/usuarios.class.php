<?php

include(__DIR__ . '/../config.php');

$database = new Database();
$conn = $database->getConnection();
$user = new User($conn);

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function registerUser($data)
    {
        // Utilize prepared statements para prevenir SQL Injection
        $sql = "INSERT INTO usuarios (name, lastname, username, email, password, adress, complement, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        // Bind dos parâmetros
        $stmt->bind_param("sssssssss", $data['name'], $data['lastname'], $data['username'], $data['email'], $data['password'], $data['adress'], $data['complement'], $data['city'], $data['state']);

        $res = $stmt->execute();

        if ($res === true) {
            echo json_encode(array("message" => "Usuário cadastrado com sucesso!"));
        } else {
            echo json_encode(array("error" => "Erro no SQL: " . $stmt->error));
        }

        $stmt->close();
    }


    public function listUsers()
    {
        $usuarios = array();

        $sql = "SELECT * FROM usuarios";

        $res = $this->conn->query($sql);

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $usuarios[] = $row;
            }
            return $usuarios;
        } else {
            echo "Nenhum usuário encontrado!";
        }
    }

    public function deleteUser($id)
    {
        try {
            if (isset($id)) {
                $sql = "DELETE FROM usuarios WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    file_put_contents('log.txt', "Usuário ID: $id excluído com sucesso\n", FILE_APPEND);
                    echo json_encode(array("message" => "Usuário deletado com sucesso!"));
                } else {
                    echo json_encode(array("error" => "Ocorreu um erro ao excluir o usuário."));
                }
            } else {
                echo json_encode(array("error" => "ID não fornecido."));
            }
        } catch (Exception $e) {
            echo json_encode(array("error" => "Erro: " . $e->getMessage()));
        } finally {
            $stmt->close();
        }
    }

    public function obterUsuarioPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = {$id}";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function editarUsuario($id, $name, $lastname, $username, $email, $password, $adress, $complement, $city, $state)
    {
        $sql = "UPDATE usuarios SET name=?, lastname=?, username=?, email=?, password=?, adress=?, complement=?, city=?, state=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $name, $lastname, $username, $email, $password, $adress, $complement, $city, $state, $id);

        $res = $stmt->execute();

        if ($res == true) {
            echo json_encode(array("message" => "Usuário alterado com sucesso!"));
        } else {
            echo json_encode(array("error" => "Ocorreu um erro ao tentar editar o usuário: " . $stmt->error));
        }

        $stmt->close();
        
    }
}

function handlePostRequest($user) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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