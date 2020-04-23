<?php

require 'app/template/head.php';

use Helper\Request;
use Controllers\Router;

if ($_SERVER['REQUEST_URI'] == '/') {
    Router::route($_SERVER['REQUEST_URI'], Request::uriAction());
} else {
    Router::route(Request::uriController(), Request::uriAction());
}
