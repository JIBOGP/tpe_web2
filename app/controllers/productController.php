<?php
include_once './app/models/productModel.php';
include_once './app/models/categoryModel.php';
include_once './app/views/productoView.php';
require_once './app/views/error_404.php';
include_once('./app/helpers/Helper.php');


class ProductController
{
    private $CategoryModel;
    private $ProductModel;
    private $productView;
    private $authHelper;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel(); //Necesario para algunas funciones especificas *1

        $this->ProductModel = new ProductModel();
        $this->productView = new Product();
        $this->authHelper = new Helper();

        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    //Lista de productos
    public function home($filter = null)
    {
        if (is_null($filter)) {
            $productos = $this->ProductModel->getAllProducts();
        } else {
            $productos = $this->ProductModel->getFilteredProducts($filter);
        }
        $this->productView->showProducts($productos);
    }
    //Ver informacion de un producto
    public function seeProduct($id = -1)
    {
        $product = $this->ProductModel->getProduct($id);
        if ($product) {
            $this->productView->showProduct($product, $id);
        } else {
            $viewError = new Error404();
            $viewError->showError();
        }
    }
    //Reducir stock
    public function vender($id)
    {
        $product = $this->ProductModel->getProduct($id);
        $cant_stock = $product->stock;
        if ($cant_stock > 0) {
            $this->ProductModel->venderProducto($id);
            $cant_stock = $product->stock;
        }
        header("Location: " . BASE_URL . "verproducto/" . str_replace(" ", "-", $product->nombre)
            . "?id=" . $product->id);
    }

    //Formulario para seleccionar categoria
    public function addProductCategory()
    {
        $this->authHelper->checkLoggedIn("home");
        //*1 Si no hay categorias no puedes agregar un producto
        if ($this->CategoryModel->categoryCant() > 0) {
            $categories = $this->CategoryModel->getCategories();
            $this->productView->formularioCategoria($categories);
        } else {
            header("Location: " . BASE_URL . "home");
        }
    }
    //Formulario para agregar el producto tras seleccionar la categoria
    public function addProductForm($error = "")
    {
        $this->authHelper->checkLoggedIn("home");
        if (!empty($_POST) && !empty($_POST['name'])) {
            $name = $_POST['name'];
            //*1 Saber los datos de la categoria seleccionada
            $category = $this->CategoryModel->getCategoryByName($_POST['category']);
            if ($this->CategoryModel->categoryCant() > 0 && !empty($category)) {
                $this->productView->formulario($category, $name, $error);
            } else {
                header("Location: " . BASE_URL . "home");
            }
        } else {
            header("Location: " . BASE_URL . "seleccionar_categoria");
        }
    }
    //Agregado del producto en el db
    public function addProduct()
    {
        $this->authHelper->checkLoggedIn("home");
        if (
            !empty($_POST) && !empty($_POST['name']) && !empty($_POST['category']) &&
            !empty($_POST['specs']) && !empty($_POST['price']) && !empty($_POST['stock'])
        ) {
            $name = htmlspecialchars($_POST['name']);
            $category = $_POST['category'];

            $specs = $_POST['specs'];
            $specs = $this->authHelper->sanitize_array($specs);

            $price = $_POST['price'];
            $stock = $_POST['stock'];

            //if (!$this->authHelper->array_elemen_empty($specs)) {
            try {
                if (
                    ($_FILES['imagen']['type'] == "image/jpg" ||
                        $_FILES['imagen']['type'] == "image/jpeg" ||
                        $_FILES['imagen']['type'] == "image/png"
                    )
                ) {
                    $this->ProductModel->insertProduct($name, $category, serialize($specs), $_FILES['imagen']['tmp_name'], $price, $stock);
                    header("Location: " . BASE_URL . "home");
                } else {
                    $this->addProductForm("Formato de imagen invalido");
                }
            } catch (Exception $e) {
                $this->addProductForm("Categoria no registrada");
            }
            /*} else {
                $this->addProductForm("Especificaciones incompletas");
            }*/
        } else {
            $this->addProductForm("Campos Incompletos");
        }
    }
    //Eliminado de un producto
    public function deleteProduct($id)
    {
        $this->authHelper->checkLoggedIn("home");
        $this->ProductModel->deleteProductById($id);
        header("Location: " . BASE_URL . "home");
    }

    //Eliminado de todos los productos de una categoria
    public function deleteAllProduct($name_category)
    {
        $this->authHelper->checkLoggedIn("home");
        $this->ProductModel->deleteAllProduct($name_category);
    }

    public function editProduct($id) //No se puede cambiar la categoria del producto
    {
        $this->authHelper->checkLoggedIn("verproducto/$id");
        if (!empty($id)) {
            $product = $this->ProductModel->getProduct($id);
            if ($product) {
                $this->productView->editProduct($product, $id);
            } else {
                header("Location: " . BASE_URL . "home");
            }
        }
    }

    public function updateProduct($id)
    {
        $this->authHelper->checkLoggedIn("home");
        if (!empty($_POST)) {
            $name = htmlspecialchars($_POST['name']);

            $specs = $_POST['specs'];
            $specs = $this->authHelper->sanitize_array($specs);

            $price = abs($_POST['price']);
            $stock = abs($_POST['stock']);

            if (
                (!empty($name)) &&
                (!empty($specs)) &&
                (!empty($price) && is_numeric($price)) &&
                (!empty($stock) && is_numeric($stock))
            ) {
                if (!empty($_FILES["imagen"]["name"])) {
                    if (
                        $_FILES['imagen']['type'] == "image/jpg" ||
                        $_FILES['imagen']['type'] == "image/jpeg" ||
                        $_FILES['imagen']['type'] == "image/png"
                    ) {

                        $this->ProductModel->updateProduct($id, $name, $specs, $_FILES['imagen']['tmp_name'], $price, $stock);
                    }
                } else {
                    $this->ProductModel->updateProduct($id, $name, $specs, "", $price, $stock);
                }
            }
        }
        header("Location: " . BASE_URL . "verproducto/" . str_replace(" ", "-", $_POST['name']) . "?id=" . $id);
    }
}
