<?php

namespace Controllers;

use Helper\Request;

class Router extends Request
{

    /**
     * @param $uri
     * @param $action
     */
    public static function route($uri, $action)
    {
        $hideInPlaces = ['/', 'login', 'logOut', 'userAdmin', 'beAdmin', 'save', 'newPassword', 'newEmail',
            'delete', 'signup'];

        if (!in_array($uri, $hideInPlaces)) {
            require 'app/template/partial/navMenu.phtml';
        }

        switch ($uri) {
            case 'beAdmin':
                CategoryBuilder::updateUser();
                break;
            case 'userAdmin':
                require 'app/template/partial/userAdmin.phtml';
                break;
            case 'category':
                CategoryBuilder::indexAction($action);
                break;
            case 'add':
                require 'app/template/partial/add.phtml';
                break;
            case 'save':
                CategoryBuilder::saveAction();
                break;
            case 'newPassword':
                CategoryBuilder::newPassword();
                break;
            case 'newUserAttribute':
                CategoryBuilder::newAttribute();
                break;
            case 'newEmail':
                CategoryBuilder::newEmail();
                break;
            case 'delete':
                CategoryBuilder::deleteAction($action);
                break;
            case 'logOut':
                CategoryBuilder::logOutAction();
                break;
            case '/':
                require 'app/template/partial/authentication.phtml';
                break;
            case 'login':
                CategoryBuilder::loginAction();
                break;
            case 'signup':
                CategoryBuilder::singUpAction();
                break;

        }
    }
}

