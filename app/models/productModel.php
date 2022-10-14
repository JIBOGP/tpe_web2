<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    public function getAllProducts()
    {
        //productos con stock
        $query = $this->db->prepare("SELECT * FROM `lista_productos` WHERE stock>0");
        $query->execute();
        $productos_con_stock = $query->fetchAll(PDO::FETCH_OBJ);
        //productos sin stock
        $query = $this->db->prepare("SELECT * FROM `lista_productos` WHERE stock=0");
        $query->execute();
        $productos_sin_stock = $query->fetchAll(PDO::FETCH_OBJ);

        //Retorno los productos con stock y luego los productos sin stock
        return array_merge($productos_con_stock, $productos_sin_stock);
    }

    public function getFilteredProducts($id)
    {
        //productos filtrados con stock
        $query = $this->db->prepare("SELECT * FROM `lista_productos` WHERE stock>0 AND categoria_fk = ?");
        $query->execute([$id]);
        $productos_con_stock = $query->fetchAll(PDO::FETCH_OBJ);
        //productos filtrados sin stock
        $query = $this->db->prepare("SELECT * FROM `lista_productos` WHERE stock=0 AND categoria_fk = ?");
        $query->execute([$id]);
        $productos_sin_stock = $query->fetchAll(PDO::FETCH_OBJ);

        //Retorno los productos filtrados con stock y luego los productos filtrados sin stock
        return array_merge($productos_con_stock, $productos_sin_stock);
    }

    public function getProduct($id)
    {
        $query = $this->db->prepare("SELECT * FROM `lista_productos` A JOIN `categorias` B ON A.categoria_fk = B.id WHERE A.id = ?");
        $query->execute([$id]);
        $producto = $query->fetch(PDO::FETCH_OBJ);
        return $producto;
    }

    public function stockProducto($id)
    {
        $query = $this->db->prepare("SELECT * FROM `lista_productos` WHERE id = ?");
        $query->execute([$id]);
        $cant_stock = $query->fetch(PDO::FETCH_OBJ);
        return $cant_stock->stock;
    }

    public function venderProducto($id)
    {
        $query = $this->db->prepare("UPDATE `lista_productos` SET stock = stock-1 WHERE id = ?");
        $query->execute([$id]);
    }

    public function insertProduct($name, $category, $specs, $image = null, $price, $stock)
    {
        $specs = serialize($specs);

        $pathImg = null;
        if ($image) $pathImg = $this->uploadImage($image);

        $query = $this->db->prepare("INSERT INTO `lista_productos` (categoria_fk, nombre, imagen, stock, precio, especificaciones) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$category, $name, $pathImg, $stock, $price, $specs]);

        return $this->db->lastInsertId();
    }

    private function uploadImage($image)
    {
        $target = 'app/views/images/' . uniqid() . '.jpg';
        move_uploaded_file($image, $target);
        return $target;
    }

    public function deleteImage($id)
    {
        //Eliminar Imagen
        $query = $this->db->prepare("SELECT * FROM `lista_productos` WHERE id = ?");
        $query->execute([$id]);
        $producto = $query->fetch(PDO::FETCH_OBJ);
        if ($producto->imagen) unlink($producto->imagen);
    }

    public function deleteProductById($id)
    {
        //Eliminar Imagen referente al producto
        $this->deleteImage($id);
        //Eliminar producto
        $query = $this->db->prepare('DELETE FROM `lista_productos` WHERE id = ?');
        $query->execute([$id]);
    }

    public function deleteAllProductByCategory($category)
    {
        $arrProduct = $this->getFilteredProducts($category);
        foreach ($arrProduct as $key => $product) {
            $this->deleteProductById($product->id);
        }
    }

    public function updateProduct($id, $name, $specs, $image, $price, $stock)
    {
        $specs = serialize($specs);
        $pathImg = null;
        if ($image) $pathImg = $this->uploadImage($image);
        echo($image);
        if ($pathImg != null) {
            $this->deleteImage($id);
            $query = $this->db->prepare("UPDATE `lista_productos` SET nombre=?, imagen=?, stock=?, precio=?, especificaciones=? WHERE id = ?");
            $query->execute([$name, $pathImg, $stock, $price, $specs, $id]);
        } else {
            $query = $this->db->prepare("UPDATE `lista_productos` SET nombre=?, stock=?, precio=?, especificaciones=? WHERE id = ?");
            $query->execute([$name, $stock, $price, $specs, $id]);
        }
    }
}
