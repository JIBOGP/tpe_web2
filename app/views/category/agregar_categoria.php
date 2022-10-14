<?php
require_once './libs/smarty-4.2.1/libs/Smarty.class.php';

class AddCategory
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
    }

    function formulario($cant_input)
    {
        $this->smarty->assign('cant', $cant_input);
        $this->smarty->display('addCategory.tpl');
    }
}
