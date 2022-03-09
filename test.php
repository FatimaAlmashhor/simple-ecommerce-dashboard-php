<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="./public/css/sidebar.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <title>Document</title>
</head>

<body>
    <?php 
         include './controllers/init.php';
         include './templates/sidebar.php';
    ?>
    <div class="page container">
        <a class="add_section"  href="products.php?do=add">
            <ion-icon class='add-icon' name="add-circle-outline"></ion-icon>
        </a>
        <div class="page_warrper">
            <div class="flex manage_section">
                <div class="header_title">
                    <h1>Products</h1>
                </div>
                <div class='items_list'>
                    <?php 
                     $sql = $con->prepare("SELECT * 
                        FROM products
                    ");

                    $sql->execute();
                    $rows = $sql->fetchAll();
                    foreach($rows as $row)
                    {
                        ?>
                            <div class="card">
                                <div class="card_warrper ">
                                    <div class="cart_image">
                                        <img
                                            src="https://images.pexels.com/photos/3018845/pexels-photo-3018845.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" />
                                    </div>
                                    <div>
                                        <div class="ycenter-xbetween">
                                            <h2>
                                                <?php 
                                                    echo $row['product_title'];
                                                ?>
                                            </h2>
                                            <div class="actions">
                                                <a href="products.php?do=edit&productid= <?php echo $row['product_id']; ?>">
                                                    <ion-icon class="edit-icon" name="create-outline"></ion-icon>
                                                </a>
                                                <a class="delete-icon" href='products.php?do=delete&productid= <?php echo $row['product_id']; ?>'>
                                                    <ion-icon name="close-circle-outline"></ion-icon>
                                                </a>
                                            </div>
                                        </div>
                                        <p> 
                                            <?php 
                                                echo $row['product_des'];
                                            ?>
                                        </p>
                                        <p>$
                                        <?php 
                                            echo $row['product_price'];
                                        ?>
                                        </p>
                                        <p>Qty : 
                                            <?php 
                                                echo $row['product_qty'];
                                            ?>
                                        </p>
                                    </div>
                                </div>
                             </div>
                        <?php
                    }
                    ?>

                <div>
            </div>
            
        </div>
        
    </div>
    <?php 
         $do = isset($_GET['do']) ? $_GET['do'] : 'add' ;
         if($do == 'add'){
             ?>
                <div class="controll_section">
                    <h2>Add new product</h2>
                    <form class="form" action='post' method='products.php?do=add' >
                        <label for="title">Product Title</label>
                        <input class='input' type="title" name="title" />
                        <label for="title">Product Des</label>
                        <input class='input' type="title" name="title" />
                        <div class="flex ">
                            <div>
                                <label for="title">Product price</label>
                                <input class='input' type="number" name="title" />
                            </div>
                            <div>
                                <label for="title">Product qty</label>
                                <input class='input' type="number" name="title" />
                            </div>
                        </div>
                        <label for="title">Product image</label>
                        <input class='input' type="file" name="title" />
                        <button class='btn' type="submit">Add</button>
                    </form>
                </div>
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
             <div class="controll_section">
                    <h2>Edit this product</h2>
                    <form class="form" action="products.php?do=add" method='post' >
                        <label for="title">Product Title</label>
                        <input class='input' type="title" name="title" />
                        <label for="title">Product Des</label>
                        <input class='input' type="title" name="title" />
                        <div class="flex ">
                            <div>
                                <label for="title">Product price</label>
                                <input class='input' type="number" name="title" />
                            </div>
                            <div>
                                <label for="title">Product qty</label>
                                <input class='input' type="number" name="title" />
                            </div>
                        </div>
                        <label for="title">Product image</label>
                        <input class='input' type="file" name="title" />
                        <button class='btn' type="submit">Add</button>
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


        ?>
<script src="./public/js/main.js"></script>
</body>

</html>