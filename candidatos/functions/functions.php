<?php

function getId($id)
{
    if (!isset($_GET['id'])) {
        return json_encode(array("message" => "ID não fornecido!"));
    }
    return $userId = $_GET['id'];
}
