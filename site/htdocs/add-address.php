<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php
$id = $_GET['id'];

$entity = selectAll('entity');
$division = selectAll('division');
$filial = selectAll('filial');
$represent = selectAll('represent');

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

    <title>EDB - Добавление адреса</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div class="main-content main-adress-form" id="placeholder_for_data">
        <select name="form-choice" id="form-choice">
            <option value="1">Место рождения</option>
            <option value="2">Место работы</option>
            <option value="3">Адрес регистрации</option>
            <option value="4">Другой адрес</option>
        </select>

        <form style="display: flex;" class="event-form" id="birthForm" method="post" action="">
            <div class="form-add-event">
                <div class="main-info">
                    Страна
                    <input type="text" name="country" id="id_country">
                    Область
                    <input type="text" name="region" id="id_region">
                    Адрес
                    <textarea name="address" cols="40" rows="10" id="id_adress"></textarea>
                </div>
            </div>
            <input value="1" name="role" style="display: none;">
            <button id="birth-btn" name="submit" type="submit">Подтвердить данные</button>
            <a class="back-button" href="javascript: history.go(-1)">Назад</a>
        </form>

        <form style="display: none;" class="event-form" id="workForm" method="post" action="">
            <div class="form-add-event">
                <div class="main-info">
                    Юридическое лицо
                    <select name="entity" id="id_entity">
                        <option value="">-</option>
                        <?php foreach ($entity as $a => $b): ?>
                                <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>
                    Дивизион
                    <select name="division" id="id_division">
                        <option value="">-</option>
                        <?php foreach ($division as $a => $b): ?>
                                <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>
                    Филиал
                    <select name="filial" id="id_filial">
                        <option value="">-</option>
                        <?php foreach ($filial as $a => $b): ?>
                                <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>
                    Представительство
                    <select name="repr" id="id_representation">
                        <option value="">-</option>
                        <?php foreach ($represent as $a => $b): ?>
                                <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <input value="2" name="role" style="display: none;">
            <button id="birth-btn" name="submit" type="submit">Подтвердить данные</button>
            <a class="back-button" href="javascript: history.go(-1)">Назад</a>
        </form>

        <form style="display: none;" class="event-form" id="liveForm" method="post" action="">
            <div class="form-add-event">
                <div class="main-info">
                    Страна
                    <input type="text" name="country" id="id_country">
                    Область
                    <input type="text" name="region" id="id_region">
                    Район
                    <input type="text" name="area" id="id_area">
                    Населенный пункт
                    <input type="text" name="locality" id="id_locality">
                    Улица
                    <input type="text" name="street" id="id_street">
                    Дом
                    <input type="text" name="house" id="id_house">
                    Корпус
                    <input type="text" name="frame" id="id_frame">
                    Квартира
                    <input type="text" name="apartment" id="id_apartment">
                </div>
            </div>
            <input value="3" name="role" style="display: none;">
            <button id="other-btn" name="submit" type="submit">Подтвердить данные</button>
            <a class="back-button" href="javascript: history.go(-1)">Назад</a>
        </form>

        <form style="display: none;" class="event-form" id="otherForm" method="post" action="">
            <div class="form-add-event">
                <div class="main-info">
                    Описание адреса
                    <input type="text" name="desc" id="id_description">
                    Страна
                    <input type="text" name="country" id="id_country">
                    Область
                    <input type="text" name="region" id="id_region">
                    Район
                    <input type="text" name="area" id="id_area">
                    Населенный пункт
                    <input type="text" name="locality" id="id_locality">
                    Улица
                    <input type="text" name="street" id="id_street">
                    Дом
                    <input type="text" name="house" id="id_house">
                    Корпус
                    <input type="text" name="frame" id="id_frame">
                    Квартира
                    <input type="text" name="apartment" id="id_apartment">
                </div>
            </div>
            <input value="4" name="role" style="display: none;">
            <button id="other-btn" name="submit" type="submit">Подтвердить данные</button>
            <a class="back-button" href="javascript: history.go(-1)">Назад</a>
        </form>
        <a hidden id="id"><?php echo $_GET['id'] ?></a>
    </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>

    <script src="assets/js/tools/adaptive-list.js"></script>
    <script src="assets/js/add-address.js"></script>


    
</body>
</html>