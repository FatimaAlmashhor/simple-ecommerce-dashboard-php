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
<?php
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
                    $sql = $con->prepare("INSERT INTO  products (products_title , is_active ) VALUES (:title , 1)");

                    $sql->execute([':title' => $_POST['products']]);
                    $con->lastInsertId();
                }
            }

            else if($do == 'delete'){
                $sql = $con->prepare("DELETE FROM  products  WHERE products_id=:catid");
                $sql->bindParam(":catid" , $_GET['catid']);
                $sql->execute();

                
            }else if($do == 'edit'){
                ?>
                    <form action="products.php?do=edit&catid=<?php echo $_GET['catid']?>" method='post'>
                        <input type='title' name='products' placholder='Enter new products' value='<?php echo $_GET['catid']?>' require/>
                        <button type='submit'>Submit </button>
                    </form>
                <?php 
                 if(isset($_POST['products'])){
                   
                    $sql = $con->prepare("UPDATE  products SET  products_title = :title WHERE products_id = :catid");
                    
                    $sql->execute([ 	
                        ":title" =>  $_POST['products'],
                        ":catid" => $_GET['catid'] 
                    ]);
                }
            }

            $sql = $con->prepare("SELECT * 
                    FROM products
                   ");

            $sql->execute();
            $rows = $sql->fetchAll();
           
            echo '
            
            <div name=categories>';
            foreach($rows as $row)
            {
                echo "
                    <div value='$row[products_title] '> $row[products_title] ";
                echo "<a href='products.php?do=delete&catid=". $row['products_id'] ."'>Delete</a> <span>   </span>";
                echo "<a href='products.php?do=edit&catid=". $row['products_id'] ."'>Edit</a>";
                echo "</div>";
            }
            echo "</div>
             <a href='products.php?do=add'>Add new</a>
            ";



          
?>
           
</main>

    <!-- ===== IONICONS ===== -->
    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
    <!-- ===== MAIN JS ===== -->
    <script src="./public/js/main.js"></script>
</body>
</html>