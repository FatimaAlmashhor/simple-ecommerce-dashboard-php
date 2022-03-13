<?php
include 'db.php';
include 'CRUD.php';

class Categories implements CRUD
{
    private $conn;

    function __construct()
    {
        $conn = new DB();
        $this->conn = $conn->getConn();
    }
    function select()
    {
        $sql = $this->conn->prepare("SELECT * 
        FROM categories
    ");

        return $sql;
    }
    function update()
    {
        $sql = $this->conn->prepare("UPDATE  categories SET  category_title = :title 
                    
                    WHERE category_id = :categoryid");
        return $sql;
    }

    function add()
    {
        $sql = $this->conn->prepare("INSERT INTO  categories 
        (category_title , is_active )
         VALUES
          (:title  , 1)");
        return $sql;
    }
    function delete()
    {
        $sql = $this->conn->prepare("DELETE FROM  categories  WHERE category_id=:categoryid");
        return $sql;
    }
}