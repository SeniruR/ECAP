<?php

namespace App\Database;

use mysqli;
use Exception;

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db_name = 'ECAP';
    private $con;

    public function getConnection()
    {
        $this->con = new mysqli($this->host, $this->user, $this->password, $this->db_name);

        if ($this->con->connect_error) {
            throw new Exception("Failed to connect with MySQL: " . $this->con->connect_error);
        }

        return $this->con;
    }

    public function query($sql)
    {
        return $this->con->query($sql);
    }

    public function close()
    {
        $this->con->close();
    }
}
?>
