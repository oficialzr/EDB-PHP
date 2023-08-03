<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php

$id = $_GET['id'];

$event = selectOne('event', array('id'=>$id));

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

    <title>EDB - Изменение события</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div class="main-content main-content-form">
            <form id="edit-form" method="post" action="<?php echo "app/controllers/edit-cont.php?id=$id" ?>">
                Тип проишествия
                <input disabled type="text" name="type" value="<?php echo $event['type'] ?>" maxlength="100" required id="id_type">
        
                Дата проишествия
                <input disabled type="text" name="date_incedent" value="<?php echo $event['date_incedent'] ?>" required id="id_date_incedent">
        
                Юридическое лицо
                <select disabled name="entity" id="id_entity">
                	<option><?php echo $event['entity'] ?></option>
                </select>

                Дивизион
                <select disabled name="division" id="id_division">
                	<option><?php echo $event['division'] ?></option>
                </select>

            	Филиал
                <select disabled name="filial" id="id_filial">
                	<option><?php echo $event['filial'] ?></option>
                </select>

	            Представительство
                <select disabled name="repr" id="id_representation">
                	<option><?php echo $event['repr'] ?></option>
                </select>

                Описание события
                <textarea name="desc" cols="40" rows="10" required id="id_description"><?php echo $event['desc'] ?></textarea>
        
                Способ проникновения
                <input type="text" name="way" value="<?php echo $event['way'] ?>" maxlength="40" required id="id_way">
        
                Средство совершения
                <input type="text" name="instr" value="<?php echo $event['instr'] ?>" maxlength="100" required id="id_instrument">
        
                В отношении
                <input type="text" name="relation" value="<?php echo $event['relation'] ?>" maxlength="100" required id="id_relation">
        
                Предмет посягательства
                <input type="text" name="object" value="<?php echo $event['object'] ?>" maxlength="150" required id="id_object">
        
                Место
                <input type="text" name="place" value="<?php echo $event['place'] ?>" maxlength="300" required id="id_place">

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

