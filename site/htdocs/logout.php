<?php
include 'app/database/db.php';

if (!isset($_SESSION['id'])) {
	header ('Location: ' . BASE_URL);
}

insertValue('logging_user', array('author'=>$_SESSION['username'], 'type'=>'Выход'));
session_unset();
header('Location: ' . BASE_URL);
