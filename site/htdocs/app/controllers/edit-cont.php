<?php

include '../database/db.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$id = $_GET['id'];
	$author = $_SESSION['username'];
	if (isset($_POST['way'])) {
		$event = selectOne('event', array('id'=>$id));
		$data = $_POST;
		$data_from = array('desc'=>$event['desc'], 'way'=>$event['way'], 'instr'=>$event['instr'], 'relation'=>$event['relation'], 'object'=>$event['object'], 'place'=>$event['place']);
		$hold = 'событие';
		$hold_main = 'события';
		$relocate = 'event';
		
		unset($data['submit']);

		update('event', 'id', $id, $data);

		insertValue('change_event', array('author'=>$author, 'id_record'=>$id, 'edit_from'=>json_encode_cyr($data_from), 'edit_to'=>json_encode_cyr($data)));
	} else {
		$person = selectOne('person', array('id'=>$id));
		$data_from = $person['desc'];
		$hold = 'описание лица';
		$hold_main = 'лица';
		$relocate = 'person';

		$data = $_POST['desc'];


		update('person', 'id', $id, array('desc'=>$data));

		insertValue('change_person', array('author'=>$author, 'id_record'=>$id, 'edit_from'=>$data_from, 'edit_to'=>$data));
	}

	insertValue('logging', array('author'=>$author, 'type'=>"Изменение $hold_main", 'log_event'=>"$author изменил $hold $id"));

	header('Location:' . BASE_URL . "$relocate" . ".php?id=$id");
	// check type 

	// check data

	// insert into person/event

	// insert into changes

	// insert into log

	// relocate
	
}