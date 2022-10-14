<?php
require_once './app/controllers/productController.php';
require_once './app/controllers/categoryController.php';
require_once './app/controllers/loginController.php';


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
        $id = $params[1];
        $productController->deleteAllProduct($id);
        $categoryControler->deleteCategory($id);
        break;
    case 'verproducto':
        $categoryControler->showHead();
        $categoryControler->showHeader();
        if (isset($params[1])) {
            $productController->seeProduct($params[1]);
        } else {
            header("Location: " . BASE_URL . "home");
        }
        break;
    case 'vender':
        if (isset($params[1])) {
            $productController->vender($params[1]);
        }/* else {
            header("Location: " . BASE_URL . "home");
        }*/
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
        $id = $params[1];
        $productController->deleteProduct($id);
        break;
    default:
        $categoryControler->showHead();
        $categoryControler->showHeader();
        echo "Error 404: pagina no encontrada </main>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa' crossorigin='anonymous'></script>
        </body>
        </html>";
        break;
}
