<?php

class Request
{

    public function handlePostRequest($user)
    {
        if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);
            $action = isset($data['action']) ? $data['action'] : null;

            if ($action == 'cadastrar') {
                $user->registerCandidate($data);
                exit;
            }

            if ($action == 'excluir') {
                $id = isset($data['id']) ? $data['id'] : null;

                if ($id == null) {
                    echo json_encode(array("error" => "ID não fornecido."));
                    return;
                }

                $user->deleteCandidate($id);
                exit;
            }

            if ($action == 'editar') {
                $user->editCandidate(
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
                exit;
            }
        }
    }
}
