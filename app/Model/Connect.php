<?php

// to call this class from any other class or file we will type Core/connect

namespace Model;

use PDO;

class Connect
{
    private $servername;
    private $username;
    private $password;
    private $dbname;



    /**
     * @return PDO
     */
    public function connect()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "mytodo";

        return new PDO("mysql:dbname=" . $this->dbname . ";host=" . $this->servername, $this->username, $this->password);

    }
}
