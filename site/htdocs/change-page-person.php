<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php
$person = selectOne('change_person', array('id'=>$_GET['id']));

checkValid($person['author'], $_SESSION['username'], $_SESSION['admin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />

    <title>EDB - Просмотр изменений</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div style="display: flex; flex-direction: column; align-items: center; padding-top: 50px;">
            <h1>Просмотр изменений</h1>
            <div class="change-page">
                <div class="change-data" id="from">
                    <h1>Было</h1><br><hr>

                    <h3>Описание</h3>
                    <p><?php echo $person['edit_from'] ?></p>
                </div>
                <div style="width: 0px; border-left: 1px solid grey;">

                </div>
                <div class="change-data" id="to">
                    <h1>Стало</h1><br><hr>

                    <h3>Описание</h3>
                    <p><?php echo $person['edit_to'] ?></p>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>

    
</body>
</html>