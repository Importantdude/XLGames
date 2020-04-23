<?php


namespace Controllers;

use Model\Product;
use Model\User;

class CategoryBuilder
{

    /**
     * LogIN
     */
    public static function loginAction()
    {
        $user = new User;
        $res = $user->LoginData();
        if ($res == '') {
            header('Location: category?');
        } else {
            echo $res;
            require 'app/template/partial/authentication.phtml';
        }
    }

    /**
     * Change user Password
     */
    public static function newPassword()
    {
        $password = new User;
        $password->changePassword();
        header('Location: userAdmin?');
    }

    /**
     * Change user email
     */
    public static function newEmail()
    {
        $password = new User;
        $password->changeEmail();
        header('Location: userAdmin?');
    }

    public static function newAttribute()
    {
        $password = new User;
        $res = $password->addNewAttribute();
        if ($res == '') {
            header('Location: userAdmin?');
        } else {
            echo $res;
        }
    }

    /**
     * LogOut and release cookies
     *
     */
    public static function logOutAction()
    {
        unset($_COOKIE['user']);
        setcookie('user', '', time() - 3600);
        unset($_COOKIE['root']);
        setcookie('root', '', time() - 3600);
        header('location: /');
    }

    /**
     * User Registration
     */
    public static function singUpAction()
    {
        $user = new User;
        $result = $user->addData();
        if ($result == '') {
            $user->addUser();
            header('Location: category?');
        } else {
            echo $result;
            require 'app/template/partial/authentication.phtml';
        }
    }

    /**
     * Change user status to root
     */
    public static function updateUser()
    {
        $user = new User;
        $res = $user->userRights();
        if ($res == '') {
            header('Location: category?');
        } else {
            echo $res;
            require 'app/template/partial/userAdmin.phtml';
        }
    }

    /**
     * product List page with categories
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

    /**
     * Add new product to db
     */
    public static function saveAction()
    {

        $product = new Product;
        $product->addProduct();

        if ($product->isWrong() !== '') {
            echo $product->isWrong();
        } else {
            $product->addItem();
            header('location: category?');
        }

    }

    /**
     * Delete product
     * @param $action
     */
    public static function deleteAction($action)
    {
        $product = new Product;
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

