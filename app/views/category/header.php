<?php
require_once './libs/smarty-4.2.1/libs/Smarty.class.php';

class Header
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty(); // inicializo Smarty
    }

    public function showHead()
    {
        $this->smarty->display('head.tpl');
    }
    public function showHeader($categorias,$selected)
    {
        $this->smarty->assign('categorias', $categorias);
        $this->smarty->assign('selected', $selected);
        $this->smarty->assign('specification_default', URL_SPECIFICATION_DEFAULT);
        $this->smarty->display('header.tpl');
    }
}
