<?php
include_once './app/models/categoryModel.php';
include_once './app/views/category/header.php';
include_once './app/views/category/agregar_categoria.php';
include_once('./app/helpers/authHelper.php');

define( 'SPECIFICATION_LIMIT' , 10); //Limite de especificaciones por categoria
define('URL_SPECIFICATION_DEFAULT',  3); //Cantidad de especificaciones por categoria por defecto

class CategoryControler
{
    private $CategoryModel;
    private $viewheader;
    private $addCategory;
    private $authHelper;

   

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
        $this->viewheader = new Header();
        $this->addCategory = new AddCategory();
        $this->authHelper = new AuthHelper();
    }

    public function showHead()
    {
        $this->viewheader->showHead();
    }
    public function showHeader($selected = -1)
    {
        session_start();
        $categorias = $this->CategoryModel->getCategories();
        $this->viewheader->showHeader($categorias, $selected);
    }

    public function categoryCant()
    {
        return $this->CategoryModel->categoryCant();
    }

    public function addCategoryForm($cant_input)
    {
        $this->authHelper->checkLoggedIn("home");
        if (is_numeric($cant_input)) {
            if ($cant_input < 1) {
                header("Location: " . BASE_URL . "formcategory/1");
            } elseif ($cant_input > SPECIFICATION_LIMIT) {
                header("Location: " . BASE_URL . "formcategory/" . SPECIFICATION_LIMIT);
            }

            $this->addCategory->formulario($cant_input);
        } else {
            header("Location: " . BASE_URL . "formcategory/" . URL_SPECIFICATION_DEFAULT);
        }
    }
    public function addCategory()
    {
        $this->authHelper->checkLoggedIn("home");

        $name = htmlspecialchars($_POST['name']);
        $especificaciones = $_POST['specs'];

        for ($i = 0; $i < count($especificaciones); $i++) {
            $especificaciones[$i] = htmlspecialchars($especificaciones[$i]);
        }
        try {
            if (!empty($name) and !in_array("", $especificaciones, true)) {
                $this->CategoryModel->insertCategory($name, $especificaciones);
            }
        } catch (Exception $e) {
            header("Location: " . BASE_URL . "newcategory/1");
        }

        header("Location: " . BASE_URL . "home");
    }
    public function deleteCategory($id)
    {
        $this->authHelper->checkLoggedIn("home/$id");
        $this->CategoryModel->deleteProductById($id);
        header("Location: " . BASE_URL . "home");
    }
}
