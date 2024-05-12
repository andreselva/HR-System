<?php

include __DIR__ . '/../../config/config.php';
include __DIR__ . '/../helpers/handlePostRequest.php';

$request = new Request();
$request->handlePostRequest(new CandidateRepository());

class CandidateRepository
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    private static function returnObject($data): object
    {
        return new Candidate(
            $data['id'],
            $data['name'],
            $data['cpf'],
            $data['rg'],
            $data['username'],
            $data['email'],
            $data['cep'],
            $data['password'],
            $data['address'],
            $data['complement'],
            $data['city'],
            $data['state']
        );
    }

    public function registerCandidate($data): void
    {

        try {
            $sql = "INSERT INTO candidates (name, cpf, rg, username, email, cep, password, address, complement, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(1, $data['name']);
            $stmt->bindParam(2, $data['cpf']);
            $stmt->bindParam(3, $data['rg']);
            $stmt->bindParam(4, $data['username']);
            $stmt->bindParam(5, $data['email']);
            $stmt->bindParam(6, $data['cep']);
            $stmt->bindParam(7, $data['password']);
            $stmt->bindParam(8, $data['address']);
            $stmt->bindParam(9, $data['complement']);
            $stmt->bindParam(10, $data['city']);
            $stmt->bindParam(11, $data['state']);

            $res = $stmt->execute();

            if ($res !== true) {
                echo json_encode(array("message" => "Ocorreu um erro ao realizar o cadastro!"));
            }

            echo json_encode(array("message" => "Cadastrado com sucesso!"));
            $logData = array_intersect_key($data, array_flip(['name', 'cpf', 'rg', 'username', 'email', 'address', 'complement', 'city', 'state']));
            $logEntry = json_encode($logData);
            file_put_contents('./log.txt', "Usuário cadastrado: $logEntry\n", FILE_APPEND);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }


    public function listCandidates()
    {
        try {
            $candidatos = array();
            $sql = "SELECT * FROM candidates ORDER BY id DESC";
            $res = $this->pdo->query($sql);

            if ($res->rowCount() === 0 || $res->rowCount() === '') {
                echo "Nenhum candidato encontrado!";
                return;
            }

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $candidatos[] = $row;
            }

            $objCandidates = array_map(function ($data) {
                return $this->returnObject($data);
            }, $candidatos);

            return $objCandidates;
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }

    public function searchInformation(string $valueInformation): array
    {
        $valueInformation = addslashes($valueInformation);

        try {
            $candidates = [];

            $sql = "SELECT * FROM candidates WHERE name LIKE ? OR cpf = ? OR rg = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["%$valueInformation%", $valueInformation, $valueInformation]);

            $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($candidates)) {
                return [];
            }
            $objCandidates = array_map(function ($data) {
                return $this->returnObject($data);
            }, $candidates);

            return $objCandidates;
            
        } catch (PDOException $e) {
            throw $e;
        }
    }


    public function deleteCandidate($id): void
    {
        try {
            if (!isset($id)) {
                echo "Erro ao realizar exclusão. O ID do usuário não está presente!";
                return;
            }

            $sql = "DELETE FROM candidates WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $res = $stmt->execute();

            if ($res !== true) {
                echo json_encode(array("error" => "Ocorreu um erro ao excluir o usuário."));
                return;
            }

            file_put_contents('./log.txt', "Usuário ID: $id excluído com sucesso\n", FILE_APPEND);
            echo json_encode(array("message" => "Usuário deletado com sucesso!"));
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }


    public function getCandidateById($id)
    {
        try {
            $sql = "SELECT * FROM candidates WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            $candidate = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$candidate) {
                return null;
            }

            return $this->returnObject($candidate);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }

    public function editCandidate($id, $name, $cpf, $rg, $username, $email, $cep, $password, $address, $complement, $city, $state): void
    {
        try {
            $sql = "UPDATE candidates SET name=?, cpf=?, rg=?, username=?, email=?, cep=?, password=?, address=?, complement=?, city=?, state=? WHERE id=?;";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $cpf);
            $stmt->bindParam(3, $rg);
            $stmt->bindParam(4, $username);
            $stmt->bindParam(5, $email);
            $stmt->bindParam(6, $cep);
            $stmt->bindParam(7, $password);
            $stmt->bindParam(8, $address);
            $stmt->bindParam(9, $complement);
            $stmt->bindParam(10, $city);
            $stmt->bindParam(11, $state);
            $stmt->bindParam(12, $id);

            $res = $stmt->execute();

            if ($res !== true) {
                echo json_encode(array("error" => "Ocorreu um erro ao tentar editar o usuário."));
            }

            echo json_encode(array("message" => "Usuário alterado com sucesso!"));
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            file_put_contents('./log.txt', $msg, FILE_APPEND);
        }
    }
}
