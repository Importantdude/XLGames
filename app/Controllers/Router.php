<?php

namespace Controllers;

class Router extends Request
{

    /**
     * @param $uri
     * @param $action
     */
    public static function route($uri, $action)
    {

        if ($uri == 'category') {
            CategoryBuilder::indexAction($action);
        }

        if ($uri == 'add') {
            require 'app/template/partial/add.phtml';
        }

        if ($uri == 'save') {
            CategoryBuilder::saveAction();
        }

        if ($uri == 'delete') {
            CategoryBuilder::deleteAction($action);
        }
    }
}