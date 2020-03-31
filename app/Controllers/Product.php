<?php

namespace Controllers;


class Product
{



    public function deleteAction()
    {
        if (isset($_POST['delete1'])) {
            $make = $_POST['pr_Action'];
            if ($make == 'some_Delete' && isset($_POST['del'])) {
                $product->specialDelete();
            }
            if ($make == 'mas_Delete') {
                $product->deleteAll();
            }
            header("location: index.php");
        }
    }

}
