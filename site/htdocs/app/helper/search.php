<?php include "../database/db.php" ?>

<?php

if (isset($_GET['term'])) {
	$person = $_GET['term'];
	$persons = array();

	if ($person != '') {
		$intruders_list = iRegex('person', 'fio', "$person");
		foreach ($intruders_list as $a => $b) {
			$persons[$a] = $b['fio'] . ' | ' . $b['birthday'];
		}
		echo json_encode(array('data'=>$persons));
	} else {
		echo json_encode(array('data'=>array()));
	}
} elseif (isset($_GET['type'])) {
	$type = $_GET['type'];
	$types = array();
	if ($type) {
		$types_list = iRegex('event', 'type', "$type");
		foreach ($types_list as $a => $b) {
			if (!in_array($b['type'], $types)) {
				array_push($types, $b['type']);
			}
		}
		echo json_encode(array('data'=>$types));
	} else {
		echo json_encode(array('data'=>array()));
	}
}


