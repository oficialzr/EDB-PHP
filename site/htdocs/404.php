<?php include_once "app/database/db.php" ?>
<?php include_once "app/helper/check.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?php echo BASE_URL . "assets/images/favicon.ico" ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . "assets/css/style.css" ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />

    <title>Ой...404</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div class="err404">
            <a id="err404">
                404
            </a>
            <h1 style="font-size: 30px">
                Страница не найдена
            </h1><br><br>
            <p style="text-align: center; font-size: 24px;">
                Страница, на которую вы пытаетесь<br>попасть, не существует или была удалена<br>
                Передите на <a style="color: blue; text-decoration: underline;" href="/">Главную страницу</a>
            </p>
        </div>
    </section>

    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.3.1.slim.min.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/popper/popper-1.14.7.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.6.0.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-ui-1.13.2.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/index.js" ?> "></script>
    
</body>
</html>
