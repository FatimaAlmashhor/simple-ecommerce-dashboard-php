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
            // include './templates/category.php';
            include './controllers/init.php';
            $do = isset($_GET['do']) ? $_GET['do'] : 'add' ;
            if($do == 'add'){
                ?>
                    <form action="category.php?do=add" method='post'>
                        <input type='title' name='category' placholder='Enter Category' require/>
                        <button type='submit'>Submit </button>
                    </form>
                <?php 
                if(isset($_POST['category'])){
                    $sql = $con->prepare("INSERT INTO  categories (category_title , is_active ) VALUES (:title , 1)");

                    $sql->execute([':title' => $_POST['category']]);
                    $con->lastInsertId();
                }
            }

            else if($do == 'delete'){
                $sql = $con->prepare("DELETE FROM  categories  WHERE category_id=:catid");
                $sql->bindParam(":catid" , $_GET['catid']);
                $sql->execute();

                
            }else if($do == 'edit'){
                ?>
                    <form action="category.php?do=edit&catid=<?php echo $_GET['catid']?>" method='post'>
                        <input type='title' name='category' placholder='Enter new Category' value='<?php echo $_GET['catid']?>' require/>
                        <button type='submit'>Submit </button>
                    </form>
                <?php 
                 if(isset($_POST['category'])){
                   
                    $sql = $con->prepare("UPDATE  categories SET  category_title = :title WHERE category_id = :catid");
                    
                    $sql->execute([ 	
                        ":title" =>  $_POST['category'],
                        ":catid" => $_GET['catid'] 
                    ]);
                }
            }

            $sql = $con->prepare("SELECT * 
                    FROM categories
                   ");

            $sql->execute();
            $rows = $sql->fetchAll();
           
            echo '
            
            <div name=categories>';
            foreach($rows as $row)
            {
                echo "
                    <div value='$row[category_title] '> $row[category_title] ";
                echo "<a href='category.php?do=delete&catid=". $row['category_id'] ."'>Delete</a> <span>   </span>";
                echo "<a href='category.php?do=edit&catid=". $row['category_id'] ."'>Edit</a>";
                echo "</div>";
            }
            echo "</div>
             <a href='category.php?do=add'>Add new</a>
            ";



          
?>
           
</main>

    <!-- ===== IONICONS ===== -->
    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
    <!-- ===== MAIN JS ===== -->
    <script src="./public/js/main.js"></script>
</body>
</html>