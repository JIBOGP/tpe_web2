<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    //Retorna todos los productos (con stock primero y sin stock al final)
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

        //Retorno los productos con stock y sin stock
        return array_merge($productos_con_stock, $productos_sin_stock);
    }

    //Retorna todos los productos filtrados junto con la categoria (con stock primero y sin stock al final)
    public function getFilteredProducts($name)
    {
        //productos filtrados con stock
        $query = $this->db->prepare("SELECT A.id, nombre, imagen, stock, precio,categoria FROM `lista_productos` A JOIN `categorias` B ON A.categoria_fk = B.id WHERE stock>0 AND categoria = ?");
        $query->execute([$name]);
        $productos_con_stock = $query->fetchAll(PDO::FETCH_OBJ);
        //productos filtrados sin stock
        $query = $this->db->prepare("SELECT A.id, nombre, imagen, stock, precio,categoria FROM `lista_productos` A JOIN `categorias` B ON A.categoria_fk = B.id WHERE stock<=0 AND categoria = ?");
        $query->execute([$name]);
        $productos_sin_stock = $query->fetchAll(PDO::FETCH_OBJ);

        //Retorno los productos filtrados con stock y los productos filtrados sin stock
        return array_merge($productos_con_stock, $productos_sin_stock);
    }
    
    //Retorna los datos de un producto especifico junto con la categoria
    public function getProduct($id)
    {
        $query = $this->db->prepare("SELECT A.id,categoria_fk, nombre, imagen, stock, precio, especificaciones,categoria,estructura_especificaciones  FROM `lista_productos` A JOIN `categorias` B ON A.categoria_fk = B.id WHERE A.id = ?");
        $query->execute([$id]);
        $producto = $query->fetch(PDO::FETCH_OBJ);
        return $producto;
    }

    //Vende un producto
    public function venderProducto($id)
    {
        $query = $this->db->prepare("UPDATE `lista_productos` SET stock = stock-1 WHERE id = ?");
        $query->execute([$id]);
    }

    //Agregar producto con su imagen
    public function insertProduct($name, $category, $specs, $image = null, $price, $stock)
    {
        $pathImg = null;
        if ($image) $pathImg = $this->uploadImage($image);

        $query = $this->db->prepare("INSERT INTO `lista_productos` (categoria_fk, nombre, imagen, stock, precio, especificaciones) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$category, $name, $pathImg, $stock, $price, $specs]);

        return $this->db->lastInsertId();
    }

    //Subir imagen
    private function uploadImage($image)
    {
        $target = 'app/views/images/' . uniqid() . '.jpg';
        move_uploaded_file($image, $target);
        return $target;
    }

    //Eliminar imagen
    public function deleteImage($id)
    {
        //Eliminar Imagen
        $query = $this->db->prepare("SELECT imagen FROM `lista_productos` WHERE id = ?");
        $query->execute([$id]);
        $producto = $query->fetch(PDO::FETCH_OBJ);
        if (file_exists($producto->imagen)) {unlink($producto->imagen);}
    }

    //Eliminar Producto
    public function deleteProductById($id)
    {
        //Eliminar Imagen referente al producto
        $this->deleteImage($id);
        //Eliminar producto
        $query = $this->db->prepare('DELETE FROM `lista_productos` WHERE id = ?');
        $query->execute([$id]);
    }

    //Eliminar todos los productos de una categoria
    public function deleteAllProduct($name_category)
    {
        $arrProduct = $this->getFilteredProducts($name_category);
        foreach ($arrProduct as $product) {
            var_dump($product->id);
            $this->deleteProductById($product->id);
        }
    }

    //Editar producto
    public function updateProduct($id, $name, $specs, $image, $price, $stock)
    {
        $specs = serialize($specs);
        $pathImg = null;
        if ($image) $pathImg = $this->uploadImage($image);
        echo ($image);
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
