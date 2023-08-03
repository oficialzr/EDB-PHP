<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?php echo BASE_URL . "assets/images/favicon.ico" ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . "assets/css/style.css" ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />

    <title>EDB - Главное меню</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div class="main-content">
	    <h1 class="header-page">База данных событий</h1>
	    <h2 style="text-align: center; padding-bottom: 20px;">Добавление</h2>
	    <div class="center-col">
	        <a class="tbm-border add-btn" href="<?php echo BASE_URL . 'add-event.php' ?>">Добавить событие</a>
	        <br>
	        <a class="tbm-border add-btn" href="<?php echo BASE_URL . 'add-person.php' ?>">Добавить лицо</a>
	    </div>
	    <h2 style="text-align: center; padding-bottom: 20px;">Просмотр</h2>
	    <div class="center-col">
	        <a class="tbm-border add-btn" href="<?php echo BASE_URL . 'events.php' ?>">События</a>
	        <br>
	        <a class="tbm-border add-btn" href="<?php echo BASE_URL . 'persons.php' ?>">Лица</a>
	    </div>
    </section>

    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.3.1.slim.min.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/popper/popper-1.14.7.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.6.0.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-ui-1.13.2.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/index.js" ?> "></script>
    
</body>
</html>