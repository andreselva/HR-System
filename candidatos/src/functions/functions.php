<?php

function getId($id)
{
    if (!isset($id) || $id === null) {
        return json_encode(array("message" => "ID não fornecido!"));
    }
    return $id;
}
