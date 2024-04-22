<?php

class Request
{

    public function handlePostRequest()
    {
        $user = new CandidateRepository();

        if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);
            $action = isset($data['action']) ? $data['action'] : null;

            switch ($action) {
                case 'cadastrar':
                    $user->registerCandidate($data);
                    break;
                case 'excluir':
                    $id = isset($data['id']) ? $data['id'] : null;
                    if ($id == null) {
                        throw new Exception('Id não encontrado.');
                        break;
                    };
                    $user->deleteCandidate($id);
                    break;
                case 'editar':
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
                    break;
                default:
                    throw new Exception('Ação não reconhecida!');
            }
        }
    }
}
