<?php
include '../database/db.php';
include "../helper/check.php";
include "../helper/PHPExcel.php";
include '../helper/PHPExcel/Writer/Excel5.php';


if (!empty($_POST)) {
	$from_date = $_POST['start-date'] . ' 00:00:00';
	$to_date = $_POST['end-date'] . ' 23:59:59';
	$id = $_SESSION['id'];

	if ($from_date > $to_date) {
		$_SESSION['warning'] = 'Введите корректную дату';
		header('Location:' . BASE_URL . "create-report.php?id=$id");
	} else {

	}

	unset($_POST['start-date']);
	unset($_POST['end-date']);

	$xls = new PHPExcel();
	$xls->setActiveSheetIndex(0);
	$sheet = $xls->getActiveSheet();
	$sheet->setTitle('Отчет');
	$sheet->getColumnDimension('A')->setAutoSize(true);

	$sheet->setCellValue("A1", "Отчет за период " . $from_date . " - " . $to_date);

	$i = 3;

	$a = array();

	$static_params = array('entity'=>'Юридические лица', 'division'=>"Дивизионы", 'filial'=>'Филиалы', 'represent'=>'Представительства');
	$params = array('entity'=>'Юридические лица', 'division'=>"Дивизионы", 'filial'=>'Филиалы');
	$indexes = array('entity'=>1, 'division'=>2, 'filial'=>3);

	$types = array();
	$events = selectAll('event', array(), false, null, false, 'date_incedent', $from_date, $to_date);

	
	// $sql = "SELECT type FROM $table WHERE filial in (SELECT name FROM filial where `id_division` = 1)";

	$curr = null;
	foreach ($_POST as $key => $value) {
		if ($value != '') {
			$curr = $key;
		} else {
			break;
		}
	}
	$a[$curr] = $_POST[$curr]; // curr = division
	$params = array_slice($params, $indexes[$curr]);
	$curr_val = array($curr, $a[$curr]);

	// tt($curr);
	// die;

	if (isset($_POST['represent']) && $_POST['represent'] != '') {
		$i++;
		$sheet->setCellValue("A" . $i, 'Представительство');
		$sheet->getStyle("A".$i)->getFont()->setBold(true);
		$i++;
		$sheet->setCellValue("A" . $i, $_POST['represent']);
		$sheet->setCellValue("B" . $i, getCount('event', array('repr'=>$_POST['represent'])));
		$i++;
		$types = getUnique('event', 'type', array('repr'=>$_POST['represent']));
		if ($types) {
			$i++;
			$sheet->setCellValue("A" . $i, 'Типы');
			$sheet->getStyle("A".$i)->getFont()->setBold(true);
			$i++;
			foreach ($types as $key => $value) {
				$sheet->setCellValue("A" . $i, $value['type']);
				$sheet->setCellValue("B" . $i, getCount('event', array('type'=>$value['type'], 'repr'=>$_POST['represent'])));
				$i++;
			}
		}

		$author = $_SESSION['username'];


		if (!file_exists(ROOT_PATH . "reports/" . iconv("utf-8", "cp1251", "$author/"))) {
			mkdir(ROOT_PATH . "reports/" . iconv("utf-8", "cp1251", "$author/"));
		}

		$objWriter = new PHPExcel_Writer_Excel5($xls);
		$objWriter->save(ROOT_PATH . "reports/" . iconv("utf-8", "cp1251", "$author/") . iconv("utf-8", "cp1251", "Отчет_стат_") . date("mdy_H_i") . ".xls");
		echo BASE_URL . "reports/" . "$author/" . "Отчет_стат_" . date("mdy_H_i") . ".xls";
		die();
	} else {
		foreach ($params as $key => $value) {  //filial => 'Филиал'
			$a[$key] = array();
			if (is_array($a[$curr])) {
				foreach ($a[$curr] as $key_1 => $value_1) {
					$relation_table = selectOne($curr, array('name'=>$key_1));
					$rel_id = $relation_table['id_'.$curr];
					$rels = selectAll($key, array('id_'.$curr=>$rel_id));
					foreach ($rels as $key_2 => $value_2) {
						$a[$key][$value_2['name']] = 0;
					}
				}
			} else {
				$relation_table = selectOne($curr, array('name'=>$a[$curr]));   // array(1, 2, 3, 4)
				$rel_id = $relation_table['id_'.$curr];
				$rels = selectAll($key, array('id_'.$curr=>$rel_id));
				foreach ($rels as $key_1 => $value_1) {
					$a[$key][$value_1['name']] = 0;
				}
			}
			$curr = $key;  // curr_var = division#1 => filial#2
			ksort($a[$key]);
		}
	}

	$params[$curr_val[0]] = $static_params[$curr_val[0]];
	$a[$curr_val[0]] = array($curr_val[1]=>0);

	foreach ($events as $key => $value) {
		if ($value[$curr_val[0]] == $curr_val[1]) {
			if (isset($types[$value['type']])) {
				$types[$value['type']] += 1;
			} else {
				$types[$value['type']] = 1;
			}
		}
		foreach ($params as $key_1 => $value_1) {
			if (isset($a[$key_1][$value[$key_1]])) {
				// count types
				$a[$key_1][$value[$key_1]] += 1;
			}
		}
	}

	foreach ($a as $var => $var_one) {
		$i++;
		$sheet->setCellValue("A" . $i, $params[$var]);
		$sheet->getStyle("A".$i)->getFont()->setBold(true);
		$i++;
		
		foreach ($var_one as $n => $c) {
			$sheet->setCellValue("A" . $i, $n);
			$sheet->setCellValue("B" . $i, $c);
			$i++;
		}
	}

	$i++;

	if (!empty($types)) {
		$sheet->setCellValue("A" . $i, 'Типы событий');
		$sheet->getStyle("A".$i)->getFont()->setBold(true);
		$i++;
		foreach ($types as $a => $b) {
			$sheet->setCellValue("A" . $i, $a);
			$sheet->setCellValue("B" . $i, $b);
			$i++;
		}	
	}

	$author = $_SESSION['username'];

	if (!file_exists(ROOT_PATH . "reports/" . iconv("utf-8", "cp1251", "$author/"))) {
		mkdir(ROOT_PATH . "reports/" . iconv("utf-8", "cp1251", "$author/"));
	}

	$objWriter = new PHPExcel_Writer_Excel5($xls);
	$objWriter->save(ROOT_PATH . "reports/" . iconv("utf-8", "cp1251", "$author/") . iconv("utf-8", "cp1251", "Отчет_стат_") . date("mdy_H_i") . ".xls");
	echo BASE_URL . "reports/" . "$author/" . "Отчет_стат_" . date("mdy_H_i") . ".xls";
}
?>
