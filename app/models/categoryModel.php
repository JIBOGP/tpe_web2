<?php

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    public function categoryCant()
    {
        $query = $this->db->prepare(" SELECT COUNT(id) AS cantOfCategories FROM `categorias`;");
        $query->execute();
        $cant = $query->fetch(PDO::FETCH_OBJ);
        return $cant->cantOfCategories;
    }
    public function getCategories()
    {
        $query = $this->db->prepare("SELECT * FROM `categorias`");
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($categorias as $categoria) {
            $categoria->estructura_especificaciones = unserialize($categoria->estructura_especificaciones);
        }
        return $categorias;
    }

    public function getCategoryByid($id)
    {
        $query = $this->db->prepare("SELECT * FROM `categorias` WHERE id = ?");
        $query->execute([$id]);
        $categoria = $query->fetch(PDO::FETCH_OBJ);
        $categoria->estructura_especificaciones = unserialize($categoria->estructura_especificaciones);
        return $categoria;
    }

    public function insertCategory($categoria, $especificaciones)
    {
        $esp_result = serialize($especificaciones);
        $query = $this->db->prepare("INSERT INTO `categorias` (categoria, estructura_especificaciones) VALUES (?, ?)");
        $query->execute([$categoria, $esp_result]);

        return $this->db->lastInsertId();
    }

    public function deleteProductById($id)
    {
        //Eliminar categoria
        $query = $this->db->prepare('DELETE FROM `categorias` WHERE id = ?');
        $query->execute([$id]);
    }
}
