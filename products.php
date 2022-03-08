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
                    $sql = $con->prepare("INSERT INTO  books (book_name , is_active ) VALUES (:title , 1)");

                    $sql->execute([':title' => $_POST['products']]);
                    $con->lastInsertId();
                }
            }

            else if($do == 'delete'){
                $sql = $con->prepare("DELETE FROM  books  WHERE book_id=:bookid");
                $sql->bindParam(":bookid" , $_GET['bookid']);
                $sql->execute();

                
            }else if($do == 'edit'){
                ?>
                    <form action="products.php?do=edit&bookid=<?php echo $_GET['bookid']?>" method='post'>
                        <input type='title' name='products' placholder='Enter new products' value='<?php echo $_GET['bookid']?>' require/>
                        <button type='submit'>Submit </button>
                    </form>
                <?php 
                 if(isset($_POST['products'])){
                   
                    $sql = $con->prepare("UPDATE  books SET  book_name = :title WHERE book_id = :bookid");
                    
                    $sql->execute([ 	
                        ":title" =>  $_POST['products'],
                        ":bookid" => $_GET['bookid'] 
                    ]);
                }
            }

            $sql = $con->prepare("SELECT * 
                    FROM books
                   ");

            $sql->execute();
            $rows = $sql->fetchAll();
           
            echo '
            
            <div name=books>';
            foreach($rows as $row)
            {
                echo "
                    <div value='$row[book_name] '> $row[book_name] ";
                echo "<a href='products.php?do=delete&bookid=". $row['book_id'] ."'>Delete</a> <span>   </span>";
                echo "<a href='products.php?do=edit&bookid=". $row['book_id'] ."'>Edit</a>";
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