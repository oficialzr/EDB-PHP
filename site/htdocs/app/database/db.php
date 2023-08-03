<?php
session_start();
require "C:/www/htdocs/path.php";
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');


// Test
function tt($value) {
	echo '<pre>';
	print_r($value);
	echo '</pre>';
}

// Check errors in db query
function dbCheckError($query) {
	$errInfo = $query->errorInfo();
	if ($errInfo[0] !== PDO::ERR_NONE) {
		echo $errInfo[2];
		exit();
	}
	return True;
}

// Func for start query
function doQuery($sql) {
	global $pdo;
	$query = $pdo->prepare($sql);
	$query->execute();
	dbCheckError($query);
	return $query;
}

// Query select all from anyone table
function selectAll($table, $params=array(), $one=false, $sortBy=null, $desc=false, $between_id=null, $between_from=null, $between_to=null) {
	global $pdo;
	$sql = "SELECT * FROM $table";



	if (!empty($params)) {
		$cnt = 0;
		foreach ($params as $i => $j) {
			if ($cnt === 0) {
				$sql = $sql." WHERE `$i` = '$j'";
			} else {
				$sql = $sql . " AND `$i` = '$j'";
			}
			$cnt++;
		}
	}

	if (!is_null($between_id) && !is_null($between_from) && !is_null($between_to)) {
		if (empty($params)) {
			$sql = $sql." WHERE $between_id BETWEEN '$between_from' AND '$between_to'";	
		} else {
			$sql = $sql." AND $between_id BETWEEN '$between_from' AND '$between_to'";	
		}
	}

	if ($sortBy != null) {
		$sql = $sql . " ORDER BY `$sortBy`";
	}

	if ($desc) {
		$sql = $sql . " DESC";
	}

	if ($one) {
		$sql = $sql." LIMIT 1";
	}

	$q = doQuery($sql);

	if ($one) {
		return $q->fetch();
	}
	return $q->fetchAll();
}


// Query select one from anyone table
function selectOne($table, $params=array()) {
	return selectAll($table, $params, $one=True);
}

// Query insert into table
function insertValue($table, $params=array()) {
	global $pdo;
	$sql = "INSERT INTO $table ";

	$keys = "";
	$values = "";

	$i = 0;
	foreach ($params as $key => $value) {
		if ($i == count($params)-1) {
			$keys = $keys."`$key`";
			$values = $values."'$value'";
		} else {
			$keys = $keys."`$key`".",";
			$values = $values."'$value',";
		}
		$i++;
	}

	$sql = $sql . '(' . $keys . ')' . ' VALUES ' . '(' . $values . ')';

	// tt($sql);

	doQuery($sql);

	return $pdo->lastInsertId();
}



// Query update into table
function update($table, $id_col, $id, $params) {
	global $pdo;
	$sql = "UPDATE $table SET ";

	$keys = "";
	$i = 0;

	foreach ($params as $key => $value) {
		if ($i == count($params)-1) {
			$sql = $sql . "`$key`='$value'";
		} else {
			$sql = $sql . "`$key`='$value', " ;
		}
		++$i;
	}

	$sql = $sql . " WHERE $table.$id_col = $id";
	doQuery($sql);
}

// Query delete from table
function delete($table, $id) {
	global $pdo;
	$sql = "DELETE FROM $table WHERE id = $id";
	doQuery($sql);
}

function getCount($table, $params, $between_id=null, $between_from=null, $between_to=null) {
	global $pdo;
	$sql = "SELECT COUNT(*) FROM $table";

	if (!empty($params)) {
		$cnt = 0;
		foreach ($params as $i => $j) {
			if ($cnt === 0) {
				$sql = $sql." WHERE `$i` = '$j'";
			} else {
				$sql = $sql . " AND `$i` = '$j'";
			}
			$cnt++;
		}
	}

	if (!is_null($between_id) && !is_null($between_from) && !is_null($between_to)) {
		if (empty($params)) {
			$sql = $sql." WHERE $between_id BETWEEN '$between_from' AND '$between_to'";
		} else {
			$sql = $sql." AND $between_id BETWEEN '$between_from' AND '$between_to'";
		}
	}

	$q = doQuery($sql);
	$b = $q->fetchAll();
	
	return $b[0]['COUNT(*)'];
}

// function filterBy($table, $column, $filter, $param) {
// 	global $pdo;
// 	$sql = "SELECT $column WHERE '$filter' = '$param' AS `filter` FROM $table";
// 	$q = doQuery($sql);
// 	$b = $q->fetchAll();
// }

function convertTtoD($string) {
	$a = explode(' ', $string);
    $b = explode('-', $a[0]);
    $a = $b[2].'.'.$b[1].'.'.$b[0];
    return $a;
}

function getNames($table) {
	global $pdo;
	$sql = "SHOW FULL COLUMNS FROM $table WHERE `Comment` != ''";

	$q = doQuery($sql);
	$b = $q->fetchAll();
	$r = array();
	foreach ($b as $n) {
		$r[$n['Field']] = $n['Comment'];
	}
	return $r;
}

function getUnique($table, $column, $params=array(), $between_id=null, $between_from=null, $between_to=null) {
	global $pdo;
	$sql = "SELECT DISTINCT $column FROM $table";

	if (!empty($params)) {
		$cnt = 0;
		foreach ($params as $i => $j) {
			if ($cnt === 0) {
				$sql = $sql." WHERE `$i` = '$j'";
			} else {
				$sql = $sql . " AND `$i` = '$j'";
			}
			$cnt++;
		}
	}

	if (!is_null($between_id) && !is_null($between_from) && !is_null($between_to)) {
		if (empty($params)) {
			$sql = $sql." WHERE $between_id BETWEEN '$between_from' AND '$between_to'";
		} else {
			$sql = $sql." AND $between_id BETWEEN '$between_from' AND '$between_to'";
		}
	}

	$q = doQuery($sql);
	$b = $q->fetchAll();
	
	return $b;
}

// tt(getUnique('event', 'type', array('repr'=>$_POST['represent'])));

function iRegex($table, $param1, $param2) {
	global $pdo;
	$sql = "SELECT * FROM $table WHERE LOWER($param1) LIKE LOWER('%$param2%')";
	$q = doQuery($sql);
	return $q->fetchAll();
}


// Helpers


function json_encode_cyr($str) {
	$arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
	'\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
	'\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
	'\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
	'\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
	'\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
	'\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
	'\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
	$arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
	'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
	'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
	'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
	$str1 = json_encode($str);
	$str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str1);
	return $str2;
}

function currentQuart() {
	$month = date('m');
	if (in_array($month, array('01', '02', '03'))) {
	    $date_from = date('Y/01/01 00:00:00');
	    $date_to = date("Y/03/31 23:59:59", strtotime($date_from));
	} elseif (in_array($month, array('04', '05', '06'))) {
	    $date_from = date('Y/04/01 00:00:00');
	    $date_to = date("Y/06/30 23:59:59", strtotime($date_from));
	} elseif (in_array($month, array('07', '08', '09'))) {
		$date_from = date('Y/07/01 00:00:00');
	    $date_to = date("Y/09/30 23:59:59", strtotime($date_from));
	} elseif (in_array($month, array('10', '11', '12'))) {
		$date_from = date('Y/10/01 00:00:00');
	    $date_to = date("Y/12/31 23:59:59", strtotime($date_from));
	}
	return array($date_from, $date_to);
}