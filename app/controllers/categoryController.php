<?php
include_once './app/models/categoryModel.php';
include_once './app/models/productModel.php';
include_once './app/views/category/header.php';
include_once './app/views/category/categoriaView.php';
include_once('./app/helpers/Helper.php');

define('SPECIFICATION_LIMIT', 10); //Limite de especificaciones por categoria
define('URL_SPECIFICATION_DEFAULT',  3); //Cantidad de especificaciones por categoria por defecto

class CategoryControler
{
    private $CategoryModel;
    private $viewheader;
    private $CategoryView;
    private $authHelper;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
        $this->viewheader = new Header();
        $this->CategoryView = new CategoryView();
        $this->authHelper = new Helper();

        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function showHead()
    {
        $this->viewheader->showHead();
    }
    public function showHeader($selected = -1)
    {
        $categorias = $this->CategoryModel->getCategories();
        $this->viewheader->showHeader($categorias, $selected);
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

            $this->CategoryView->addCategoryForm($cant_input);
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
        $this->CategoryModel->deleteCategoryByName($id);
        header("Location: " . BASE_URL . "home");
    }
    public function editCategoryForm($name)
    {
        $this->authHelper->checkLoggedIn("home");

        $category = $this->CategoryModel->getCategoryByName($name);
        if (!empty($category)) {
            if (isset($_GET["cant_esp"])) {
                $cant = $_GET["cant_esp"];
                if ($cant <= 0) {
                    header("Location: " . BASE_URL . "editcategoryform/" . $category->categoria . "?cant_esp=1");
                    die();
                } elseif ($cant > SPECIFICATION_LIMIT) {
                    header("Location: " . BASE_URL . "editcategoryform/" . $category->categoria . "?cant_esp=" . SPECIFICATION_LIMIT);
                    die();
                }
                $this->CategoryView->editCategoryForm($category, $cant);
            } else {
                header("Location: " . BASE_URL . "editcategoryform/" . $category->categoria .
                    "?cant_esp=" . count($category->estructura_especificaciones));
            }
        } else {
            header("Location: " . BASE_URL . "home");
        }
    }
    public function updateCategory($id)
    {
        var_dump($_POST);
        $this->authHelper->checkLoggedIn("home");
        if (!empty($_POST)) {
            $name = htmlspecialchars($_POST['name']);

            $specs = $_POST['specs'];
            $specs = $this->authHelper->sanitize_array($specs);

            if ((!empty($name)) && (!empty($specs) && !($this->authHelper->array_elemen_empty($specs)))
            ) {
                $this->CategoryModel->updateCategory($id, $name, serialize($specs));
            }
        }
        header("Location: " . BASE_URL . "home");
    }
}
