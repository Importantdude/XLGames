<?php
require 'app/template/head.php';

use Helper\Request;
use Controllers\Router;

?>

<div class="bodyHome">
    <?php require 'app/template/partial/categoryBlock.phtml';
    require 'app/template/partial/slider.phtml'; ?>
</div>

<?php Router::route(Request::uriController(), Request::uriAction()); ?>
