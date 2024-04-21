<?php

abstract class AbstractCandidate
{

    abstract public function registerCandidate($data) :void;
    abstract public function listCandidates();
    abstract public function deleteCandidate($id) :void;
    abstract public function getCandidateById($id);
    abstract public function editCandidate($id, $name, $cpf, $rg, $username, $email, $cep, $password, $address, $complement, $city, $state) :void;

}
