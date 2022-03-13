<?php
class DB
{
    private $host       = 'mysql:host=localhost;dbname=e-wallet'; //or localhost
    private $database   = 'e-wallet';
    private $port       = 8081;
    private $user       = 'root';
    private $password   = '';
    private $conn;

    function __construct()
    {
        try {
            $this->conn  = new PDO($this->host, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Failed To Connected' . $e;
        }
    }
    function getConn()
    {
        return $this->conn;
    }
}