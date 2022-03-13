<?php
include 'db.php';
include 'CRUD.php';
class Products implements CRUD
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
                        FROM products
                    ");
        return $sql;
    }

    function add()
    {
        $sql = $this->conn->prepare("INSERT INTO  products 
        (product_title , product_des , product_price , product_qty  ,category_id,product_image ,is_active )
         VALUES
          (:title ,:descr ,:price , :qty ,:categoryid ,:images , 1)");
        return $sql;
    }
    function delete()
    {
        $sql = $this->conn->prepare("DELETE FROM  products  WHERE product_id=:productid");
        return $sql;
    }
    function update()
    {
        $sql = $this->conn->prepare("SELECT * 
        FROM products WHERE product_id = :productid
        ");
        return $sql;
    }
}