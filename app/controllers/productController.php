<?php
include_once './app/models/productModel.php';
include_once './app/models/categoryModel.php';
include_once './app/views/productoView.php';
include_once('./app/helpers/authHelper.php');


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
        $this->authHelper = new AuthHelper();

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
    public function seeProduct($id)
    {
        $product = $this->ProductModel->getProduct($id);
        if ($product) {
            $this->productView->showProduct($product, $id);
        } else {
            header("Location: " . BASE_URL . "home");
        }
    }
    //Reducir stock
    public function vender($id)
    {
        $cant_stock = $this->ProductModel->stockProducto($id);
        if ($cant_stock > 0) {
            $this->ProductModel->venderProducto($id);
            $cant_stock = $this->ProductModel->stockProducto($id);
            if ($cant_stock > 0) {
                header("Location: " . BASE_URL . "verproducto/" . $id);
            } else {
                //header("Location: " . BASE_URL . "home");
                header("Location: " . BASE_URL . "verproducto/" . $id);
            }
        } else {
            //header("Location: " . BASE_URL . "home");
            header("Location: " . BASE_URL . "verproducto/" . $id);
        }
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
            $category = $this->CategoryModel->getCategoryByid($_POST['category']);
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
            $specs = $this->sanitize_array($specs);

            $price = $_POST['price'];
            $stock = $_POST['stock'];

            if (!$this->array_elemen_empty($specs)) {
                try {
                    if (
                        ($_FILES['imagen']['type'] == "image/jpg" ||
                            $_FILES['imagen']['type'] == "image/jpeg" ||
                            $_FILES['imagen']['type'] == "image/png"
                        )
                    ) {
                        $this->ProductModel->insertProduct($name, $category, $specs, $_FILES['imagen']['tmp_name'], $price, $stock);
                        header("Location: " . BASE_URL . "home");
                    } else {
                        $this->addProductForm("Formato de imagen invalido");
                    }
                } catch (Exception $e) {
                    $this->addProductForm("Categoria no registrada");
                }
            } else {
                $this->addProductForm("Especificaciones incompletas");
            }
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

    public function deleteAllProduct($category)
    {
        $this->authHelper->checkLoggedIn("home");
        $this->ProductModel->deleteAllProductByCategory($category);
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
            $specs = $this->sanitize_array($specs);

            $price = abs($_POST['price']);
            $stock = abs($_POST['stock']);

            if (
                (!empty($name)) &&
                (!empty($specs) && !($this->array_elemen_empty($specs))) &&
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
        header("Location: " . BASE_URL . "verproducto/$id");
    }


    private function array_elemen_empty($array)
    {
        $bol = false;
        for ($i = 0; $i < count($array); $i++) {
            if (empty($array[$i])) {
                $bol = true;
                break;
            }
        }
        return $bol;
    }
    private function sanitize_array($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $newarray[$i] = htmlspecialchars($array[$i]);
        }
        return $newarray;
    }
}
