<?php

namespace Helper;

class Request
{

    /**
     * @return false|string
     */
    public static function uriController()
    {
        $uri = ltrim($_SERVER['REDIRECT_URL'], '/');

        return $uri;
    }

    /**
     * @return mixed
     */
    public static function uriAction()
    {
        $uri = $_SERVER['QUERY_STRING'];

        return $uri;
    }

    /**
     * @return mixed
     */
    public static function serverMethod()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
    }

}
