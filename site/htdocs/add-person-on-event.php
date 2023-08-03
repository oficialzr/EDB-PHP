<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php
$id_event = $_GET['id'];

$event = selectOne('event', array('id'=>$id_event));

if (!checkValid($event['author'], $_SESSION['username'], $_SESSION['admin'])) {
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

    <title>EDB - Добавление фигуранта</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div class="main-content main-adress-form" id="placeholder_for_data">
        <h1>Создайте новое лицо</h1>
        <a id="addPerson" class="add-more" style="justify-self: center" href="<?php echo "add-person.php?redirect=1&id_event=$id_event" ?>">Добавить новое лицо</a>

        <br><br><br>
        <h1>Или выберите лицо из списка</h1>
        
        <div id="autocomplete" class="autocomplete">
            <label style="color: grey; padding-bottom: 5px; font-size: 20px;" for="search">Найдите лицо</label>
            <input class="autocomplete-input" name="search" id="auto-input" type="search">
            <ul class="autocomplete-result-list"></ul>
        </div>
        <h3>Выберите роль лица</h3>
        <select name="form-choice" id="form-choice">
            <option value="1">Нарушитель</option>
            <option value="2">Свидетель</option>
            <option value="3">Потерпевший</option>
            <option value="4">Другой фигурант</option>
        </select>
        <div id="hidden-desc" style="display: none; flex-direction: column;">
            <label style="padding-bottom: 5px; font-size: 20px;" for="desc">Кем является?</label>
            <input class="default-input" type="text" name="desc" id="input-desc">
        </div>
        <a id="confBtn" class="add-more" style="align-self: center; display: flex;">Добавить лицо</a>
        <br><br>
        <br>
        <a id="backBtn" class="add-more" style="color:crimson; font-size: 24px;">Назад</a>
    </div>

    <input hidden id="event_id" value="<?php echo $_GET['id'] ?>">
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>

    <script src="assets/js/autocomp-js.js"></script>
    <script src="assets/js/add-person-on-event.js"></script>

    
</body>
</html>
