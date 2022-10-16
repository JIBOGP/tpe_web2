<?php
require_once './libs/smarty-4.2.1/libs/Smarty.class.php';;

class Error404 {

    private $smarty;

    public function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->assign('basehref', BASE_URL);
    }

    public function showError() {
        $this->smarty->display('templates/error404.tpl');
    }

}