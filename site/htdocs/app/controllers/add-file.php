<?php include "../database/db.php" ?>
<?php include "../helper/check.php" ?>

<?php

try {
	$id = $_GET['id'];
	if (isset($_FILES['image'])) {
		$size = intval($_FILES["image"]['size']);
		$direct = 'person';
	} else {
		if (isset($_FILES['file'])) {
			$index = 'file';
			$direct = 'person';
		} else {
			$index = 'file_event';
			$direct = 'event';
		}
		$size = intval($_FILES["$index"]['size']);
	}
	if ($size > 15728640) {
		$_SESSION['warning'] = 'Файл слишком большой!';
		header("Location:" . BASE_URL . "$direct" . ".php?id=$id");
		die();
	}
} catch (Exception $e) {

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id = $_GET['id'];
	$direct = $_GET['type'];
	$person = selectOne('person', array('id'=>$id));
	$name = $person['fio'];
	$name_for = iconv("UTF-8", "CP1251", $person['fio']);
	$author = $_SESSION['username'];
	if (!empty($_FILES)) {
		if (isset($_FILES['image'])) {
			if (strpos($_FILES['image']['type'], 'image') === false) {
				$_SESSION['warning'] = 'Можно загружать только изображения!';
				header("Location:" . BASE_URL . "person.php?id=$id");
				die();
			}

			$imgName = date("d_m_Y") . "_" . $_FILES['image']['name'];
			$forWinName = date("d_m_Y") . "_" . iconv("UTF-8", "CP1251", $_FILES['image']['name']);
			$fileTmpName = $_FILES['image']['tmp_name'];

			if (!file_exists(ROOT_PATH . "files\persons\\$name_for")) {
				mkdir(ROOT_PATH . "files\persons\\$name_for");
			}

			if (!file_exists(ROOT_PATH . "files\persons\\$name_for\images")) {
				mkdir(ROOT_PATH . "files\persons\\$name_for\images");
			}
			$dest = ROOT_PATH . "files\persons\\$name_for\images\\" . $forWinName;
			
			$result = move_uploaded_file($fileTmpName, $dest);

			$dest = str_replace("\\", "/", "files\persons\\$name\images\\" . $imgName);

			if ($result) {
				if (!selectOne('img_person', array('id_person'=>$id))) {
					insertValue('img_person', array('id_person'=>$id, 'file'=>$dest));
				} else {
					update('img_person', 'id_person', $id, array('file'=>$dest));
				}
				insertValue('logging', array('author'=>$author, 'type'=>'Добавление изображения лицу', 'log_event'=>"$author добавил изображение лицу $id"));
			} else {
				$_SESSION['warning'] = 'Ошибка загрузки изображения';
				header("Location:" . BASE_URL . "person.php?id=$id");
			}

		} else {
			if (isset($_FILES['file'])) {
				$name_i = 'persons';
				$db_name = 'person';
				$db_cont = 'лицу';
				$new_name = $name_for;
				$db_for = 'file_person';
				$index = 'file';
			} elseif (isset($_FILES['file_event'])) {
				$name_i = 'events';
				$db_name = 'event';
				$db_cont = 'событию';
				$new_name = $id;
				$name = $id;
				$db_for = 'file_event';
				$index = 'file_event';
			}

			$fileName = date("d_m_Y") . "_" . $_FILES["$index"]['name'];
			$forWinName = date("d_m_Y") . "_" . iconv("UTF-8", "CP1251", $_FILES["$index"]['name']);
			$fileTmpName = $_FILES["$index"]['tmp_name'];
			if (!file_exists(ROOT_PATH . "files\\$name_i\\$new_name")) {
				mkdir(ROOT_PATH . "files\\$name_i\\$new_name");
			}
			if (!file_exists(ROOT_PATH . "files\$name_i\\" . "$new_name" . "\\files\\")) {
				mkdir(ROOT_PATH . "files\\$name_i\\" . "$new_name" . "\\files\\");
			}

			$dest = ROOT_PATH . "files\\$name_i\\" . "$new_name" . "\\files\\" . $forWinName;

			$result = move_uploaded_file($fileTmpName, $dest);

			$dest = str_replace("\\", "/", "files\\$name_i\\" . "$name" . "\\files\\" . $fileName);

			if ($result) {
				insertValue("$db_for", array('id_' . $db_name=>$id, 'file'=>$dest, 'name'=>$fileName));

				insertValue('logging', array('author'=>$author, 'type'=>"Добавление файла $db_cont", 'log_event'=>"$author добавил файл $db_cont $id"));
			} else {
				$_SESSION['warning'] = 'Ошибка загрузки файла';
				header("Location:" . BASE_URL . "$direct" . ".php?id=$id");
			}

		}
		
	}
	header("Location:" . BASE_URL . "$direct" . ".php?id=$id");
}