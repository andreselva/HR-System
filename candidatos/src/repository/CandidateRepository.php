<?php

include __DIR__ . '/../../../config/config.php';
include __DIR__ . '/../helpers/handleRequest.php';
require_once __DIR__ . '/../entity/Candidate.php';

$request = new HandleRequest();
$request->Request(new CandidateRepository());

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

    public function registerCandidate($data)
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
                return json_encode(array("message" => "Ocorreu um erro ao realizar o cadastro!"));
            }

            return json_encode(array("message" => "Cadastrado com sucesso!"));

        } catch (PDOException $e) {
            $msg = $e->getMessage();
            return $msg;
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
            return $msg;
        }
    }

    public function deleteCandidate($id)
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
                return json_encode(array("error" => "Ocorreu um erro ao excluir o usuário."));
            }

            return json_encode(array("message" => "Usuário deletado com sucesso!"));

        } catch (PDOException $e) {
            $msg = $e->getMessage();
            return $msg;
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
            return $msg;
        }
    }

    public function editCandidate($id, $name, $cpf, $rg, $username, $email, $cep, $password, $address, $complement, $city, $state)
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

            if (!$res) {
                return json_encode(array("error" => "Ocorreu um erro ao tentar editar o usuário."));
            }

            return json_encode(array("message" => "Usuário alterado com sucesso!"));

        } catch (PDOException $e) {
            $msg = $e->getMessage();
            return $msg;
        }
    }

    public function getDataForPrint(string $filterValue = ''): array
    {
        $results = array();
        $safeFilter = filter_var($filterValue, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            if ($safeFilter === '' || $safeFilter === null) {
                $sql = "SELECT * FROM candidates ORDER BY id";
                $res = $this->pdo->query($sql);
                $results = $res->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            }

            $sql = "SELECT * FROM candidates WHERE name=? or cpf=? or rg=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $safeFilter);
            $stmt->bindValue(2, $safeFilter);
            $stmt->bindValue(3, $safeFilter);

            $res = $stmt->execute();

            if (!$res) {
                return $results;
            }

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;

        } catch (PDOException $e) {
            $msg = $e->getMessage();
            return $msg;
        }
    }
}
