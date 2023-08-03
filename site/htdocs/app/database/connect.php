<?php

$driver = 'mysql';
$host = 'localhost';
$db_name = 'eventdb';
$db_user = 'root';
$db_pass = 'root';
$charset = 'utf8';

try {
	$pdo = new PDO(
		"$driver:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_pass, array(PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC)
	);
	
} catch (PDOException $e) {
	die("Ошибка подключения к базе даных");
}