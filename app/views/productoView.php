<?php
require_once './libs/smarty-4.2.1/libs/Smarty.class.php';

class Product
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
    }

    //Mostrar todos los productos de un arreglo
    function showProducts($productos)
    {
        $this->smarty->assign('count', count($productos));
        $this->smarty->assign('products', $productos);

        $this->smarty->display('productList.tpl');
    }

    //Mostrar un producto en especifico
    public function showProduct($product, $id)
    {
        $esp = unserialize($product->estructura_especificaciones);
        $this->smarty->assign('product', $product);
        $this->smarty->assign('iditem', $id);
        $this->smarty->assign('esp', $esp);
        $this->smarty->assign('esp_cant', count($esp));
        $this->smarty->assign('esp_data', unserialize($product->especificaciones));
        $this->smarty->display('product_info.tpl');
    }

    //Mostrar formulario para seleccionar categoria
    public function formularioCategoria($categoria)
    {
        $this->smarty->assign('categorias', $categoria);
        $this->smarty->display('addProductCategory.tpl');
    }
    //Mostrar formulario para agregar producto
    public function formulario($category, $name, $error)
    {
        $this->smarty->assign('category', $category);
        $this->smarty->assign('name', $name);
        $this->smarty->assign('error', $error);
        $this->smarty->display('addProduct.tpl');
    }

    public function editProduct($product, $id)
    {
        $esp = unserialize($product->estructura_especificaciones);
        $this->smarty->assign('product', $product);
        $this->smarty->assign('iditem', $id);
        $this->smarty->assign('esp', $esp);
        $this->smarty->assign('esp_cant', count($esp));
        $this->smarty->assign('esp_data', unserialize($product->especificaciones));
        $this->smarty->display('editProduct.tpl');
    }
}
