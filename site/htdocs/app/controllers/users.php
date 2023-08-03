<?php
require 'path.php';
include 'app/database/db.php';
$a = '';

if (isset($_SESSION['id'])) {
	header ('Location: ' . BASE_URL);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-log'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	if ($username === '' || $password === '') {
		$a = 'Не все поля заполнены!';
	}

	$user = selectOne('users', array('username'=>$username, 'password'=>md5($password)));

	if ($user) {
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $user['fio'];
		$_SESSION['admin'] = $user['admin'];

		insertValue('logging_user', array('author'=>$user['fio'], 'type'=>'Вход'));

		header('Location: ' . BASE_URL);
	} else {
		$a = 'Неправильно введены данные!';
	}
} else {
	$username = '';
}
