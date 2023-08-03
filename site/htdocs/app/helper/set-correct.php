<?php include "../database/db.php" ?>
<?php include "check.php" ?>
<?php include "validate_user.php" ?>

<?php

if (isAdmin($_SESSION['admin'])) {
	//if set
	$id = $_GET['id'];
	$id_user = $_SESSION['id'];
	$author = $_SESSION['username'];

	$user = $_SESSION['id'];
	$correct = isset($_POST['correct']) ? 1 : 0;
	$data = selectOne('information', array('id'=>$id));
	$q = update('information', "id", $id, array('correct'=>$correct, 'checked'=>1));

	insertValue('logging', array('author'=>$author, 'type'=>'Изменение статуса ОЗИ', 'log_event'=>"$author определил статус ОЗИ (ID: $id, Статус: $correct)"));

	if (isset($_GET['referer'])) {
		$referer_id = $_GET['referer'];

		header('Location:' . BASE_URL . "user/user.php?id=$id_user&person=$referer_id#an-$id");
		die();
	} else {
		header('Location:' . BASE_URL . "user/user.php?id=$id_user#an-$id");
		die();
	}
} else {
	header('Location:' . BASE_URL);
}