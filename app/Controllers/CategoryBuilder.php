<?php


namespace Controllers;

use Helper\Request;
use Model\Product;

class CategoryBuilder
{

    /**
     * @param $action
     */
    public static function indexAction($action)
    {
        if ($action != '') {
            require 'app/template/partial/plp.phtml';
        } else {
            require 'app/template/partial/allCategory.phtml';
        }
    }

    public static function saveAction()
    {
        session_start();

        $product = new Product;
        $product->addProduct();

        if ($product->isWrong() !== '') {
            echo $product->isWrong();
        } else {
            $product->addItem();
            header("location: category?");
        }

    }

    public static function deleteAction($action)
    {
        $product = new Product;
//        var_dump($_SERVER);
        if ($action != '') {
            if (isset($_POST['delete'])) {
                foreach ($_POST['delete'] as $deleteid) {
                    $product->delete($deleteid);
                }
            } else {
                $product->allFromCategory($action);
            }
        } else {
            if (isset($_POST['delete'])) {
                foreach ($_POST['delete'] as $deleteid) {
                    $product->delete($deleteid);
                }
            } else {
                $product->deleteAll();
            }
        }
        header('Location: category?');
    }

}
