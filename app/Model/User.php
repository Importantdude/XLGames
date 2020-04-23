<?php

namespace Model;


use PDO;

class User extends Connect
{
    protected $username;
    protected $email;
    protected $password;
    protected $userAttribute;
    protected $attributeValue;

    /**
     * get from DB user data with exact email
     * @return false|\PDOStatement
     */
    public function getLoginData()
    {
        return $this->connect()->query('SELECT * FROM users WHERE Email like \'' . $this->email . '\'');
    }

    /**
     * @return false|\PDOStatement
     */
    public function getAttribute()
    {
        return $this->connect()->query('SELECT * FROM userattribute WHERE attributeName like \'' . $this->userAttribute . '\'');
    }

    /**
     * Login user
     */
    public function LoginData()
    {
        if (empty($this->email = $_POST['email'])) {
            return 'check email';

        } elseif (empty($this->password = $_POST['password'])) {
            return 'check password';

        } else {
            $temp = $this->getLoginData();
            $user = $temp->fetch();

            if ($user == false) {
                return 'check email carefully';
            } else {

                if ($user['Password'] == $this->password) {
                    session_start();
                    header('Location: category?');

                    if ($user['Root'] == 0) {
                        setcookie('user', json_encode([
                            'userName' => $this->email
                        ]), time() + 3600 * 24);

                    } else {
                        setcookie('root', json_encode([
                            'userName' => $this->email
                        ]), time() + 3600 * 24);
                    }
                } else {
                    return 'incorrect password';
                }
            }
        }

        return '';
    }

    /**
     * change user||root password
     */
    public function changePassword()
    {
        $email = substr($_COOKIE['root'], 13, -2);

        $this->password = $_POST['newPassword'];
        $this->email = $email;
        $this->connect()->query(
            'UPDATE users SET Password = \'' . $this->password . '\' where email = \'' . $this->email . '\''
        );

    }

    /**
     * change user||root email
     */
    public function changeEmail()
    {
        $email = substr($_COOKIE['root'], 13, -2);
        $this->email = $_POST['newEmail'];
        $this->connect()->query(
            'UPDATE users SET Email = \'' . $this->email . '\' where email = \'' . $email . '\''
        );

        if ($_COOKIE['root']) {
            unset($_COOKIE['root']);
            setcookie('root', '', time() - 3600);

            setcookie('root', json_encode([
                'userName' => $this->email
            ]), time() + 3600 * 24);

        } elseif ($_COOKIE['user']) {
            unset($_COOKIE['user']);
            setcookie('user', '', time() - 3600);

            setcookie('user', json_encode([
                'userName' => $this->email
            ]), time() + 3600 * 24);
        }

    }

    /**
     * SignUP for new user
     */
    public function addUser()
    {
        $sql = sprintf(
            '%s\'%s\', \'%s\', \'%s\')',
            'INSERT INTO users (Name, Email, Password) VALUES (',
            $this->username,
            $this->email,
            $this->password
        );
        setcookie('user', json_encode([
            'userName' => $this->email
        ]), time() + 3600 * 24);
        Connect::connect()->query($sql);

    }

    /**
     * validate if entered data is compatible for registration
     * @return string
     */
    public function addData()
    {

        $this->username = $_POST['newName'];
        $this->email = $_POST['newEmail'];
        $this->password = $_POST['Password'];

        $temp = $this->getLoginData();
        $user = $temp->fetch();

        if (empty($this->username)) {
            return 'Username is empty';
        } elseif (empty($this->email)) {
            return 'Email is empty';
        } elseif (empty($this->password)) {
            return 'Password is empty';
        } elseif ($user == true) {
            return 'Please use another email';
        } else {
            return '';
        }
    }


    /**
     * Change user right from basic user to admin
     * @return string
     */
    public function userRights()
    {

        $adminKey = 'qwerty';
        $becomeRoot = true;

        if ($_COOKIE['user'] == true) {
            $email = substr($_COOKIE['user'], 13, -2);
        } else {
            $email = substr($_COOKIE['root'], 13, -2);
        }
        echo $_POST['newAdmin'];
        if ($adminKey == $_POST['newAdmin']) {

            $this->connect()->query(
                'UPDATE users SET Root = \'' . $becomeRoot . '\' where email = \'' . $email . '\''
            );
            unset($_COOKIE['user']);
            setcookie('user', '', time() - 3600);

            setcookie('root', json_encode([
                'userName' => $email
            ]), time() + 3600 * 24);

        } else {
            return 'Incorrect password';
        }

        return '';
    }

    public function getUserID()
    {
        return $this->connect()->query('SELECT * FROM users WHERE Email like \'' . $this->email . '\'');
    }

    public function getLastAttribute()
    {
        $res = $this->connect()->query('SELECT * FROM userattribute WHERE id = ( SELECT MAX(id) FROM userattribute);');
        foreach ($res as $te) {
            $temp = $te['id'];
        }
        return $temp;
    }

    public function addNewAttribute()
    {
        $this->userAttribute = $_POST['userAttrName'];
        $this->attributeValue = $_POST['userAttrValue'];

        if (empty($this->userAttribute)) {
            return 'Attribute field is empty';
        } elseif (empty($this->attributeValue)) {
            return 'Attribute value is empty';
        } else {

            if (in_array('user', $_COOKIE)) {
                $this->email = substr($_COOKIE['user'], 13, -2);
            } else {
                $this->email = substr($_COOKIE['root'], 13, -2);
            }

            $sql = $this->getAttribute();
            $attribute = $sql->fetch();


            if ($attribute == true) {
                $tempUser = $this->getUserID();

                $user = $tempUser->fetch();
                $sql = sprintf(
                    '%s\'%s\', \'%s\', \'%s\')',
                    'INSERT INTO userattrvalue (attributeID, userID, attributeValue) VALUES (',
                    $attribute['id'],
                    $user['id'],
                    $this->attributeValue
                );
                Connect::connect()->query($sql);

            } else {

                $tempUser = $this->getUserID();
                $user = $tempUser->fetch();

                $sql = sprintf(
                    '%s\'%s\')',
                    'INSERT INTO userattribute (attributeName) VALUES (',
                    $this->userAttribute
                );

                Connect::connect()->query($sql);

                $attrID = $this->getLastAttribute();

                $sql = sprintf(
                    '%s\'%s\', \'%s\', \'%s\')',
                    'INSERT INTO userattrvalue (attributeID, userID, attributeValue) VALUES (',
                    $attrID,
                    $user['id'],
                    $this->attributeValue
                );

                Connect::connect()->query($sql);
            }

            return 'You added new  Attribute and its value';
        }

    }
}

