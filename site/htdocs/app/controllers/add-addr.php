<?php
include '../database/db.php';
include "../helper/check.php";

if ($_POST) {
	// Create constants
	$role = $_POST['role'];
	$author = $_SESSION['username'];
	$id = $_GET['id'];
	$valueList = array('1'=>'adr_birth', '2'=>'adr_work', '3'=>'adr_live', '4'=>'adr_other');
	$headerList = array('1'=>'Место рождения', '2'=>'Место работы', '3'=>'Адрес регистрации', '4'=>'Другой адрес');
	$adr = $valueList[$role];

	// Create DATA
	unset($_POST['role']);
	$data = $_POST;
	$data['id_place'] = $id;

	
	// Insert value
	$id_adr = insertValue($valueList[$role], $data);

	// Insert log
	insertValue('logging', array('author'=>$author, 'type'=>'Добавление адреса', 'log_event'=>"$author добавил адрес (Name: $adr, ID: $id_adr) лицу $id"));

	// Return JSON response
	unset($data['id_place']);
	$data['header'] = $headerList[$role];
    echo json_encode(array('data'=>$data, 'names'=>getNames($adr)));
}