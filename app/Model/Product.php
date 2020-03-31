<?php

namespace Model;

class Product extends Connect
{

    public $sku;
    public $name;
    public $price;
    public $type;
    public $value;
    public $attribute;

    /**
     * Get product type
     * @return false|\PDOStatement
     */
    public function getProductType()
    {
        return $this->connect()->query('SELECT * FROM prvalue');
    }

    /**
     * Get all products
     * @return false|\PDOStatement
     */
    public function getProduct()
    {
        return $this->connect()->query('SELECT * FROM product');
    }

    /**
     * Get product from exact category
     * @param $uri
     * @return false|\PDOStatement
     */
    public function categoryProduct($uri)
    {
        return $this->connect()->query("SELECT * FROM product WHERE Attribute ='$uri'");
    }

    /**
     * Input Validation
     * @return string
     */
    public function isWrong()
    {
        $res = '';
        if ($this->name === '') {
            $res = "Name is empty";
        } elseif (($this->price === '') && (!is_numeric($this->price))) {
            $res = "Please provide correct price";
        } elseif ($this->sku === '') {
            $res = "SKU is empty";
        } elseif ($this->type === 'Type Switcher') {
            $res = "Choose type";
        } elseif (($this->value === '') && (!is_numeric($this->value))) {
            $res = "Please provide correct value";
        }
        return $res;
    }

    /**
     *add product to Db
     */
    public function addItem()
    {
        $sql = sprintf(
            '%s\'%s\', \'%s\', \'%s\', \'%s\', \'%s\')',
            'INSERT INTO product (Name, Price, SKU, Value,Attribute) VALUES (',
            $this->name,
            $this->price,
            $this->sku,
            $this->value,
            $this->attribute
        );
        $result = Connect::connect()->query($sql);
    }

    /**
     * user add product
     */
    public function addProduct()
    {
        $this->price = $_POST['Price'];
        $this->sku = $_POST['SKU'];
        $this->name = $_POST['Name'];
        $this->type = $_POST['TO'];
        $this->addType();
    }

    /**
     * user add product type
     */
    public function addType()
    {
        switch ($this->type) {
            case "DVD":
                $this->value = $_POST['DVD'];
                $this->attribute = 'cat1';
                break;
            case "Book":
                $this->value = $_POST['Book'];
                $this->attribute = 'cat2';
                break;
            case "Furniture":
                $this->value = $_POST['Value1'] . "x" . $_POST['Value2'] . "x" . $_POST['Value3'];
                $this->attribute = 'cat3';
                break;
        }
    }

    /**
     * delete this id from db
     * @param $id
     */
    public function delete($id)
    {
        $this->connect()->query('DELETE FROM product where id=' . $id);
    }

    /**
     * delete all records in exact category
     * @param $id
     * @param $category
     */
    public function allFromCategory($category)
    {
        $this->connect()->query("DELETE FROM product WHERE Attribute ='$category'");
    }

    /**
     *delete all records from DB
     */
    public function deleteAll()
    {
        $this->connect()->query('DELETE FROM product');
    }

}