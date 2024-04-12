<?php

require_once 'users.class.php';

class UserController extends User
{
    public function getUser($id)
    {
        $this->recoverUserById($id);
    }

    public function getListUsers()
    {
        $this->listUsers();
    }

}
