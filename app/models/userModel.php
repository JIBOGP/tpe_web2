<?php

class UserModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    public function getByUsername($name)
    {
        $query = $this->db->prepare("SELECT * FROM `users_admin` WHERE nombre = ?");
        $query->execute([$name]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }
}
