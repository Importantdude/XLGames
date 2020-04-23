<?php

namespace Model;

class Product extends Connect
{

    public $id;
    public $sku;
    public $name;
    public $price;
    public $type;
    public $value;
    public $category;
    public $attribute;
    public $attrValue;
    public $attr_ID;

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
        return $this->connect()->query('SELECT * FROM product WHERE Category = \'' . $uri . '\'');
    }

    /**
     * Input Validation
     * @return string
     */
    public function isWrong()
    {
        $res = '';
        if ($this->name === '') {
            $res = 'Name is empty';
        } elseif (($this->price === '') && (!is_numeric($this->price))) {
            $res = 'Please provide correct price';
        } elseif ($this->sku === '') {
            $res = 'SKU is empty';
        } elseif ($this->type === 'Type Switcher') {
            $res = 'Choose type';
        } elseif (($this->value === '') && (!is_numeric($this->value))) {
            $res = 'Please provide correct value';
        }
        return $res;
    }

    /**
     *add product to Db
     */
    public function addItem()
    {

        $this->attribute = $_POST['AttributeName'];
        $this->attrValue = $_POST['AttributeValue'];

        $sql = sprintf(
            '%s\'%s\', \'%s\', \'%s\', \'%s\', \'%s\')',
            'INSERT INTO product (Name, Price, SKU, Value, Category) VALUES (',
            $this->name,
            $this->price,
            $this->sku,
            $this->value,
            $this->category
        );

        $this->connect()->query($sql);
        $this->id = $this->getID();
        if (!empty($this->attribute) && !empty($this->attrValue)) {
            $this->addAttribute();
        }

    }

    /**
     * Get last product id
     * @return mixed
     */
    public function getID()
    {
        $res = $this->connect()->query('SELECT * FROM product WHERE id = ( SELECT MAX(id) FROM product);');
        foreach ($res as $te) {
            $temp = $te['id'];
        }
        return $temp;
    }

    /**
     * Validate if exact attribute exists in db
     * @return false|\PDOStatement
     */
    public function existsAttributeID()
    {
        return $this->connect()->query('SELECT * FROM attribute WHERE Name_attr like \'' . $this->attribute . '\'');
    }

    /**
     * Add new product attribute to DB
     */
    public function addAttribute()
    {
        $temp = $this->existsAttributeID();
        $attr = $temp->fetch();
        $this->attr_ID = $attr['id'];
        var_dump($attr);
        if ($attr != false) {
            echo 'This attribute already exists in DB';
            $sql = sprintf(
                '%s\'%s\', \'%s\', \'%s\')',
                'INSERT INTO attr_value (Attr_id, Prod_id, Attr_value) VALUES (',
                $this->attr_ID,
                $this->id,
                $this->attrValue
            );
            $result = Connect::connect()->query($sql);
        } else {
            $sql = sprintf('%s\'%s\')',
                'INSERT INTO attribute (Name_attr) VALUES(',
                $this->attribute);
            $result = Connect::connect()->query($sql);
            $temp = $this->existsAttributeID();
            $attr = $temp->fetch();
            $this->attr_ID = $attr['id'];
            echo ' new attribute were added with this ID' . $this->attr_ID;
            $sql = sprintf(
                ' %s\'%s\', \'%s\', \'%s\')',
                'INSERT INTO attr_value (Attr_id, Prod_id, Attr_value) VALUES (',
                $this->attr_ID,
                $this->id,
                $this->attrValue
            );
            $result = Connect::connect()->query($sql);
        }
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
            case 'DVD':
                $this->value = $_POST['DVD'];
                $this->category = 'cat1';
                break;
            case 'Book':
                $this->value = $_POST['Book'];
                $this->category = 'cat2';
                break;
            case 'Furniture':
                $this->value = $_POST['Value1'] . 'x' . $_POST['Value2'] . 'x' . $_POST['Value3'];
                $this->category = 'cat3';
                break;
        }
    }

    /**
     * delete this product id from db
     * @param $id
     */
    public function delete($id)
    {
        $this->connect()->query('DELETE FROM product where id=' . $id);
    }

    /**
     * delete all product records in exact category
     * @param $category
     */
    public function allFromCategory($category)
    {
        $this->connect()->query('DELETE FROM product WHERE Category =' . $category);
    }

    /**
     *delete all product records from DB
     */
    public function deleteAll()
    {
        $this->connect()->query('DELETE FROM product');
    }


}


