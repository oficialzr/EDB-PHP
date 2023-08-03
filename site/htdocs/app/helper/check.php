<?php

if ($_SESSION['id']) {
	
} else {
	header("Location: " . BASE_URL . 'login.php');
}