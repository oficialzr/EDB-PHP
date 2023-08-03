<?php include "../database/db.php" ?>
<?php include "../helper/check.php" ?>

<?php

if (isset($_POST['short_desc'])) {
	$id = $_GET['id'];
	$user = selectOne('users', array('id'=>$id));
	$author = $user['fio'];
	$id_ev = insertValue('information', array('short_desc'=>$_POST['short_desc'], 'desc'=>$_POST['desc'], 'author_id'=>$id, 'author'=>$author));
	insertValue('logging', array('author'=>$author, 'type'=>'Добавление ОЗИ', 'log_event'=>"$author добавил ОЗИ ID: $id_ev"));
	header("Location: " . BASE_URL . "user/user.php?id=$id");
}