<?php

class AuthHelper
{
    public function __construct()
    {
    }

    public function checkLoggedIn($url)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['ID_USER'])) {
            header("Location: " . BASE_URL . $url);
            die();
        }
    }

    public function array_elemen_empty($array)
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
    public function sanitize_array($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $newarray[$i] = htmlspecialchars($array[$i]);
        }
        return $newarray;
    }
}
