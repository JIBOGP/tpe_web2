<?php
include_once './app/views/loginView.php';
include_once './app/models/userModel.php';

class LoginController
{

    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new LoginView();
        $this->userModel = new UserModel();
    }

    public function showLogin()
    {
        $this->view->showLogin();
    }

    public function verifyUser()
    {
        if (!empty($_POST) && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->getByUsername($username);

            if (!empty($user) && password_verify($password, $user->contrasenia)) {

                session_start();
                $_SESSION['ID_USER'] = $user->id;
                $_SESSION['USERNAME'] = $user->nombre;
                header("Location: " . BASE_URL . "home");
            } else {
                $this->view->showLogin("El usuario o la contraseña incorrecto");
            }
        } else {
            $this->view->showLogin("No se pasaron parametros");
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL . "home");
    }
}
