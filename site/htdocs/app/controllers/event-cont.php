<?php

require '../../path.php';
include '../database/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {
	// Get data from GET request
	$_POST['author'] = $_SESSION['username'];

	// Validate data


	// Create a record
	insertValue('event', $_POST);
	$id = $pdo->lastInsertId();
	// Return new record's ID

	$author = $_SESSION['username'];
	insertValue('logging', array('author'=>$author, 'type'=>'Создание события', 'log_event'=>"$author создал запись события $id"));

	// Redirect to record page

	header('Location:' . BASE_URL . "event.php?id=$id");

} else {
	$username = '';
}