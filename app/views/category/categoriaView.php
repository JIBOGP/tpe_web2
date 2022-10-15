<?php
require_once './libs/smarty-4.2.1/libs/Smarty.class.php';

class Category
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
    }

    function addCategoryForm($cant_input)
    {
        $this->smarty->assign('cant', $cant_input);
        $this->smarty->display('addCategory.tpl');
    }

    function editCategoryForm($category, $cant_esp)
    {
        $this->smarty->assign('category', $category);
        $this->smarty->assign('cant_esp', $cant_esp);
        $this->smarty->display('editCategory.tpl');
    }
}
