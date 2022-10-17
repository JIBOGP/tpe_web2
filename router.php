<?php

require_once './app/controllers/productController.php';
require_once './app/controllers/categoryController.php';
require_once './app/controllers/loginController.php';
require_once './app/views/error_404.php';


define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    header("Location: " . BASE_URL . "home");
}

$params = explode('/', $action);

$productController = new ProductController();
$categoryControler = new CategoryControler();

// tabla de ruteo
switch ($params[0]) {
    case 'login':
        $Usercontroller = new LoginController();
        $Usercontroller->showLogin();
        break;
    case 'verify':
        $categoryControler->showHead();
        $Usercontroller = new LoginController();
        $Usercontroller->verifyUser();
        break;
    case 'logout':
        $Usercontroller = new LoginController();
        $Usercontroller->logout();
        break;
    case 'home':
        $categoryControler->showHead();
        if (isset($params[1])) {
            $categoryControler->showHeader($params[1]);
            $productController->home($params[1]);
        } else {
            $categoryControler->showHeader();
            $productController->home();
        }
        break;
    case "formcategory":
        $categoryControler->showHead();
        $categoryControler->addCategoryForm($params[1]);
        break;
    case 'addcategory':
        $categoryControler->addCategory();
        break;
    case 'delcategory':
        $productController->deleteAllProduct($params[1]);
        $categoryControler->deleteCategory($params[1]);
        break;
    case "editcategoryform":
        $categoryControler->showHead();
        $categoryControler->editCategoryForm($params[1]);
        break;
    case 'updatecategory':
        $id = $params[1];
        $categoryControler->updateCategory($id);
        break;
    case 'verproducto':
        $categoryControler->showHead();
        $categoryControler->showHeader();
        if (isset($_GET["id"])) {
            $productController->seeProduct($_GET["id"]);
        }else {
            $productController->seeProduct();
        }
        break;
    case 'vender':
        if (isset($params[1])) {
            $productController->vender($params[1]);
        } else {
            header("Location: " . BASE_URL . "home");
        }
        break;
    case 'seleccionar_categoria':
        $categoryControler->showHead();
        $productController->addProductCategory();
        break;
    case "formulario_product":
        $categoryControler->showHead();
        $productController->addProductForm();
        break;
    case 'addproduct':
        $categoryControler->showHead();
        $productController->addProduct();
        break;
    case 'editproduct':
        $id = $params[1];
        $categoryControler->showHead();
        $productController->editProduct($id);
        break;
    case 'updateProduct':
        $id = $params[1];
        $productController->updateProduct($id);
        break;
    case 'delproduct':
        $productController->deleteProduct($params[1]);
        break;
    default:
        $categoryControler->showHead();
        $categoryControler->showHeader();
        $viewError = new Error404();
        $viewError->showError();
        break;
}
