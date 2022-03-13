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
    include './controllers/categoriesController.php';
    include './templates/sidebar.php';

    $categoryInstance = new Categories();
    ?>

    <div class="page container">
        <a class="add_section" href="category.php?do=add">
            <ion-icon class='add-icon' name="add-circle-outline"></ion-icon>
        </a>
        <div class="page_warrper">

            <?php
            $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
            if ($do == 'add') {
            ?>
            <div class="controll_section">
                <h2>Add new category</h2>
                <form class="form" action='category.php?do=add' method='post'>
                    <label for="title">Category Title</label>
                    <input class='input' type="title" name="title" />

                    <button class='btn' type="submit">Add</button>
                </form>
            </div>
            <?php
                if (isset($_POST['title'])) {


                    $sql = $categoryInstance->add();

                    $sql->execute([
                        ':title' => $_POST['title']
                    ]);
                    $con->lastInsertId();
                }
            } else if ($do == 'delete') {
                $sql = $categoryInstance->delete();
                $sql->bindParam(":categoryid", $_GET['categoryid']);
                $sql->execute();
            } else if ($do == 'edit') {

                ?>
            <div class="controll_section">
                <h2>Edit this category</h2>
                <form class="form" action="category.php?do=edit&categoryid=
                    <?php echo $_GET['categoryid'] ?>
                    " method='post' enctype="multipart/form-data">
                    <label for="title">Category Title</label>
                    <input class='input' type="title" name="title" />

                    <button class='btn' type="submit">Edit</button>
                </form>
            </div>

            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $categoryid = (isset($_GET['categoryid']) && is_numeric($_GET['categoryid'])) ?  intval($_GET['categoryid']) : 0;
                    $sql = $categoryInstance->update();

                    $sql->execute([
                        ":title" =>  $_POST['title'],

                        ":categoryid" => $categoryid
                    ]);
                }
            }
            ?>
            <div class="flex manage_section">
                <div class="header_title">
                    <h1>Categories</h1>
                </div>
                <div class='items_list'>
                    <?php
                    $sql = $categoryInstance->select();

                    $sql->execute();
                    $rows = $sql->fetchAll();
                    foreach ($rows as $row) {
                    ?>
                    <div class="card">
                        <div class=" ">
                            <div class="ycenter-xbetween">
                                <h2 style="word-break: break-all;s">
                                    <?php
                                        echo $row['category_title'];
                                        ?>
                                </h2>
                                <div class="actions">
                                    <a href="category.php?do=edit&categoryid= <?php echo $row['category_id']; ?>">
                                        <ion-icon class="edit-icon" name="create-outline"></ion-icon>
                                    </a>
                                    <a class="delete-icon"
                                        href='category.php?do=delete&categoryid= <?php echo $row['category_id']; ?>'>
                                        <ion-icon name="close-circle-outline"></ion-icon>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                    };
                    ?>

                    <div>
                    </div>

                </div>

            </div>

            <script src="./public/js/main.js"></script>
</body>

</html>