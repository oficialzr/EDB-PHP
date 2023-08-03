<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>

<?php

$redirect = 0;

if (isset($_GET['redirect']) && isset($_GET['id_event'])) {
    $redirect = 1;
    $id_event = $_GET['id_event'];
}

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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <title>EDB - Добавление лица</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <?php if($_SESSION['warning']): ?>
        <?php $q = $_SESSION['warning']; ?>
        <?php $a = "<script>window.onload = function() {alert(`$q`)};</script>"; echo $a ?>
        <?php unset($_SESSION['warning']) ?>
    <?php endif ?>

    <section>
        <h1 style="text-align: center; font-size: 40px; padding-top: 50px; margin: 0;">Создание записи</h1>
        <div class="main-content main-content-form">
            <?php if (isset($_GET['redirect']) && isset($_GET['id_event'])): ?>
            <form class="event-form" id="event" method="post" action="<?php echo "app/controllers/person-cont.php?redirect=$redirect&id_event=$id_event" ?>">
            <?php else: ?>
            <form class="event-form" id="event" method="post" action="app/controllers/person-cont.php">
            <?php endif ?>
                <div class="form-add-event">
                    <div class="main-info">
                        <h1>Заполните данные о человеке</h1>
                        Фамилия
                        <input type="text" name="last_name" maxlength="30" required id="id_last_name">
                        Имя
                        <input type="text" name="first_name" maxlength="30" required id="id_first_name">
                        Отчество
                        <input type="text" name="second_name" maxlength="30" required id="id_second_name">
                        Описание
                        <textarea name="desc" cols="40" rows="10" required id="id_description"></textarea>
                        Пол (м/ж)
                        <select style="height: 2em; width: 355px; font-size: 16px;" name="sex" id="sex">
                            <option value="м">м</option>
                            <option value="ж">ж</option>
                        </select>
                        <br>
                        Дата рождения
                        <input type="date" name="birthday" required="" id="id_birthday" value="">
                    </div>
                </div>
                
                <button id="main-form-submit" type="submit">Подтвердить данные</button>
            </form>
        </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>

    <script src="assets/js/add-person-solo.js"></script>

    
</body>
</html>