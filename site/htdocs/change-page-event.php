<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php
$event = selectOne('change_event', array('id'=>$_GET['id']));
$data_from = json_decode($event['edit_from'], true);
$data_to = json_decode($event['edit_to'], true);

checkValid($event['author'], $_SESSION['username'], $_SESSION['admin']);
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
	            <div class="change-data-event change-data" id="from">
	                    <h3>Описание</h3>
	                    <div style="display: flex; align-items: center; justify-content: space-between;">
		                    <p><?php echo $data_from['desc'] ?></p>
		                    <p><?php echo $data_to['desc'] ?></p>
	                	</div>
		                <hr>
	                    <h3>Способ проникновения</h3>
	                    <div style="display: flex; align-items: center; justify-content: space-between;">
		                    <p><?php echo $data_from['way'] ?></p>
		                    <p><?php echo $data_to['way'] ?></p>
	                	</div>
		                <hr>

	                    <h3>Средство совершения</h3>
	                    <div style="display: flex; align-items: center; justify-content: space-between;">
		                    <p><?php echo $data_from['instr'] ?></p>
		                    <p><?php echo $data_to['instr'] ?></p>
	                	</div>
		                <hr>

	                    <h3>В отношении</h3>
	                    <div style="display: flex; align-items: center; justify-content: space-between;">
		                    <p><?php echo $data_from['relation'] ?></p>
		                    <p><?php echo $data_to['relation'] ?></p>
	                	</div>
		                <hr>

	                    <h3>Предмет посягательства</h3>
	                    <div style="display: flex; align-items: center; justify-content: space-between;">
		                    <p><?php echo $data_from['object'] ?></p>
		                    <p><?php echo $data_to['object'] ?></p>
	                	</div>
		                <hr>

	                    <h3>Место</h3>
	                    <div style="display: flex; align-items: center; justify-content: space-between;">
		                    <p><?php echo $data_from['place'] ?></p>
		                    <p><?php echo $data_to['place'] ?></p>
	                	</div>
		                <hr>
	            </div>
	            <!-- <div style="width: 0px; border-left: 1px solid grey;">

	            </div>
	            <div class="change-data" id="to">
	                <h1>Стало</h1><br><hr>
	                    <h3>Тип</h3>
	                    <p><?php echo $data_to['type'] ?></p>
	                    <hr>
	                    <h3>Описание</h3>
	                    <p><?php echo $data_to['desc'] ?></p>
	                    <hr>
	                    <h3>Способ проникновения</h3>
	                    <p><?php echo $data_to['way'] ?></p>
	                    <hr>
	                    <h3>Средство совершения</h3>
	                    <p><?php echo $data_to['instr'] ?></p>
	                    <hr>
	                    <h3>В отношении</h3>
	                    <p><?php echo $data_to['relation'] ?></p>
	                    <hr>
	                    <h3>Предмет посягательства</h3>
	                    <p><?php echo $data_to['object'] ?></p>
	                    <hr>
	                    <h3>Место</h3>
	                    <p><?php echo $data_to['place'] ?></p>
	                    <hr>
	            </div>-->
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