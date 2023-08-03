<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php

$id = $_GET['id'];

$person = selectOne('person', array('id'=>$id));

if (!checkValid($person['author'], $_SESSION['username'], $_SESSION['admin'])) {
	header('Location:' . BASE_URL);
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

    <title>EDB - Изменение лица</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div class="main-content main-content-form">
            <form id="edit-form" method="post" action="<?php echo "app/controllers/edit-cont.php?id=$id" ?>">
                Фамилия
                <input type="text" name="last_name" value="<?php echo $person['last_name'] ?>" maxlength="30" disabled="" id="id_last_name">
        
                Имя
                <input type="text" name="first_name" value="<?php echo $person['first_name'] ?>" maxlength="30" disabled id="id_first_name">
        
                Отчество
                <input type="text" name="second_name" value="<?php echo $person['second_name'] ?>" maxlength="30" disabled id="id_second_name">
        
                Описание
                <textarea name="desc" cols="40" rows="10" required id="id_description"><?php echo $person['desc'] ?></textarea>
        
                Пол (м/ж)
                <input type="text" name="sex" value="<?php echo $person['sex'] ?>" maxlength="1" id="id_sex" disabled>
        
                Дата рождения
                <input type="text" name="birthday" value="<?php echo convertTtoD($person['birthday']) ?>" id="id_birthday" disabled>

                <button id="accept-edit" class="accept-btn" name="submit" type="submit">Подтвердить данные</button>
            </form>
        </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>

    
</body>
</html>

