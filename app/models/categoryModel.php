<?php

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    //Retorna la cantidad de categorias
    public function categoryCant()
    {
        $query = $this->db->prepare(" SELECT COUNT(id_categoria) AS cantOfCategories FROM `categorias`;");
        $query->execute();
        $cant = $query->fetch(PDO::FETCH_OBJ);
        return $cant->cantOfCategories;
    }

    //Retorna todas las categorias
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

    //Retorna los datos de una categoria por su nombre
    public function getCategoryByName($name)
    {
        $query = $this->db->prepare("SELECT * FROM `categorias` WHERE categoria = ?");
        $query->execute([$name]);
        $categoria = $query->fetch(PDO::FETCH_OBJ);
        if (!empty($categoria)) {
            $categoria->estructura_especificaciones = unserialize($categoria->estructura_especificaciones);
        }
        return $categoria;
    }

    //Agregar categoria
    public function insertCategory($categoria, $esp)
    {
        $query = $this->db->prepare("INSERT INTO `categorias` (categoria, estructura_especificaciones) VALUES (?, ?)");
        $query->execute([$categoria, serialize($esp)]);
    }

    //Eliminar categoria
    public function deleteProductById($id)
    {
        $query = $this->db->prepare('DELETE FROM `categorias` WHERE id_categoria = ?');
        $query->execute([$id]);
    }

    //Editar categoria
    public function updateCategory($id, $name, $esp)
    {
        $query = $this->db->prepare("UPDATE `categorias` SET categoria=?, estructura_especificaciones=? WHERE id_categoria = ?");
        $query->execute([$name, $esp, $id]);
    }
}
