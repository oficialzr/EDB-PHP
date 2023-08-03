<?php

require '../../path.php';
include '../database/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['last_name'])) {
	// Get data from GET request
	$_POST['author'] = $_SESSION['username'];
	$_POST['fio'] = $_POST['last_name'].' '.$_POST['first_name'].' '.$_POST['second_name'];
	// Validate data

	$per = selectOne('person', array('fio'=>$_POST['fio'], 'birthday'=>$_POST['birthday']));

	if ($per) {
		$_SESSION['warning'] = 'Такой человек уже существует!';
		header("Location:" . BASE_URL . "add-person.php");
		die();
	}

	// tt($_POST);

	// Create a record
	insertValue('person', $_POST);
	$id = $pdo->lastInsertId();
	// Return new record's ID

	$author = $_SESSION['username'];
	insertValue('logging', array('author'=>$author, 'type'=>'Создание лица', 'log_event'=>"$author создал запись лица $id"));

	// Redirect to record page

	if (isset($_GET['redirect']) && isset($_GET['id_event'])) {
		$id_event = $_GET['id_event'];
		header('Location:' . BASE_URL . "/add-person-on-event.php?id=$id_event");
		die();
	}
	header('Location:' . BASE_URL . "/person.php?id=$id");

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
	$author = $_SESSION['username'];
	$person_info = explode(' | ', $_POST['data']);
	$id = $_GET['id'];
	$role = $_POST['role'];
	$role_desc = $_POST['role_desc'];
	$a = selectOne('person', array('fio'=>$person_info[0], 'birthday'=>$person_info[1]));
	$id_person = $a['id'];
	if (!empty($a)) {
		insertValue('relation', array('id_event'=>$id, 'role'=>$role, 'role_desc'=>$role_desc, 'id_person'=>$id_person));

		insertValue('logging', array('author'=>$author, 'type'=>'Добавление отношения', 'log_event'=>"$author добавил отношение к событию: ID: $id, Лицо $id_person теперь $role"));
		echo json_encode(array('status'=>'200'));
	} else {
		echo json_encode(array('status'=>'404'));
	}
} else {
	$username = '';
}

// if 'data' in request.POST:
//             try:
//                 fio, birthday = request.POST['data'].split(' | ')
//                 person = get_object_or_404(Person, fio=fio, birthday=birthday)
//                 event_id = request.POST['event_id']
//                 role = request.POST['role']
//                 if person:
//                     related = RelatedPerson(id_event=event_id, role=role, id_person=person.id)
//                     if role == 'Другой фигурант':
//                         related.role_desc = request.POST['role_desc']
//                         related.save()
//                         person.id_related = related.id
//                     related.save()
//                     person.save()

//                     Logging(author=author, type='Создание отношения', logged_event='{} создал запись отношения к событиям {}:\nЛицо с ID {} теперь {}'.format(author, related.id, person.id, role)).save()

//                     return JsonResponse({'status': '200'})
//             except Exception as e:
//                 return JsonResponse({'status': '404'})