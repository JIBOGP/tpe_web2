<?php

class AuthHelper {
    public function __construct() {}

    public function checkLoggedIn($url) {
        session_start();
        if (!isset($_SESSION['ID_USER'])) {
            header("Location: " . BASE_URL . $url);
            die();
        }       
    }
}
