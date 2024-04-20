<?php

class Candidate
{
    private ?int $id;
    private string $name;
    private string $cpf;
    private string $rg;
    private string $username;
    private string $email;
    private string $cep;
    private string $password;
    private string $address;
    private string $complement;
    private string $city;
    private string $state;

    public function __construct(?int $id, string $name, string $cpf, string $rg, string $username, string $email, string $cep, string $password, string $address, string $complement, string $city, string $state)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->username = $username;
        $this->email = $email;
        $this->cep = $cep;
        $this->password = $password;
        $this->address = $address;
        $this->complement = $complement;
        $this->city = $city;
        $this->state = $state;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCPF()
    {
        return $this->cpf;
    }

    public function getRG()
    {
        return $this->rg;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCEP()
    {
        return $this->cep;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getComplement()
    {
        return $this->complement;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }
}
