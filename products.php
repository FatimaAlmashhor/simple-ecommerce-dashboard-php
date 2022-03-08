<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./public/css/sidebar.css">
    <link rel="stylesheet" href="./public/css/main.css">
</head>
<body>
<!--______________ LEFT MAIN ______________ -->
<?php include './templates/sidebar.php';?>
<main class='main container'>
    <div class='page-content flex '>
        
<?php
            echo "<div>";
            // include './templates/products.php';
            include './controllers/init.php';
            $do = isset($_GET['do']) ? $_GET['do'] : 'add' ;
            if($do == 'add'){
                ?>
                    <form action="products.php?do=add" method='post'>
                        <input type='title' name='products' placholder='Enter products' require/>
                        <button type='submit'>Submit </button>
                    </form>
                <?php 
                if(isset($_POST['products'])){
                    $sql = $con->prepare("INSERT INTO  products (product_title , is_active ) VALUES (:title , 1)");

                    $sql->execute([':title' => $_POST['products']]);
                    $con->lastInsertId();
                }
            }

            else if($do == 'delete'){
                $sql = $con->prepare("DELETE FROM  products  WHERE product_id=:productid");
                $sql->bindParam(":productid" , $_GET['productid']);
                $sql->execute();

                
            }else if($do == 'edit'){
                ?>
                <div class=''>
                    <form action="products.php?do=edit&productid=<?php echo $_GET['productid']?>" method='post'>
                        <input type='title' name='products' placholder='Enter new products' value='<?php echo $_GET['productid']?>' require/>
                        <button type='submit'>Submit </button>
                    </form>
                </div>
                   
                <?php 
                 if(isset($_POST['products'])){
                   
                    $sql = $con->prepare("UPDATE  products SET  product_title = :title WHERE product_id = :productid");
                    
                    $sql->execute([ 	
                        ":title" =>  $_POST['products'],
                        ":productid" => $_GET['productid'] 
                    ]);
                }
            }
            echo "</div>";
            $sql = $con->prepare("SELECT * 
                    FROM products
                   ");

            $sql->execute();
            $rows = $sql->fetchAll();
            echo '
            
            <div name=products>';
            foreach($rows as $row)
            {
                echo "
                    <div value='$row[product_title] '> $row[product_title] ";
                echo "<a href='products.php?do=delete&productid=". $row['product_id'] ."'>Delete</a> <span>   </span>";
                echo "<a href='products.php?do=edit&productid=". $row['product_id'] ."'>Edit</a>";
                echo "</div>";
            }
            echo "
                 <a href='products.php?do=add'>Add new</a>
             </div>
            ";



          
?>
        </div>   
</main>

    <!-- ===== IONICONS ===== -->
    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
    <!-- ===== MAIN JS ===== -->
    <script src="./public/js/main.js"></script>
</body>
</html>