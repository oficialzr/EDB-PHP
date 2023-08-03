<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>

<?php
    
    if (isset($_GET['sort'])) {
		$sort = $_GET['sort'];
	    $sortBy = '';
	    $sorts = array('byNameUp', 'byNameDown');
	    $asc = true;
	    if (in_array($sort, $sorts)) {
            switch ($sort) {
                case 'byNameUp':
                    $sortBy = 'last_name';
                    $asc = false;
                    break;
                case 'byNameDown':
                    $sortBy = 'last_name';
                    break;
            }
            $persons = selectAll('person', array(), false, $sortBy, $asc);
        } else {
			$persons = selectAll('person', array(), false, 'id', true);	
        }
	} else {
		$persons = selectAll('person', array(), false, 'id', true);
	}

	$entity = selectAll('entity');
	$division = selectAll('division');
	$filial = selectAll('filial');
	$represent = selectAll('represent');
	$sexes = array('м', 'ж');
	$roles = array('Нарушитель', 'Свидетель', 'Потерпевший', 'Другой фигурант');

	$type = getUnique('event', 'type');

	$sex = $_GET['sex'];
	$role = $_GET['role'];
	$ent = $_GET['entity'];
	$div = $_GET['division'];
	$fil = $_GET['filial'];
	$rep = $_GET['represent'];

	$gets = array('sex'=>$sex, 'role'=>$role, 'type'=>$t, 'entity'=>$ent, 'division'=>$div, 'filial'=>$fil, 'represent'=>$rep);
	foreach ($persons as $a => $q) {
		$works = selectAll('adr_work', array('id_place'=>$q['id']));
	    foreach ($gets as $b => $c) {
	        if ($c) {
	        	if ($b == 'role') {
	        		$rel = selectAll('relation', array('id_person'=>$q['id']));
	        		$ifRel = array();
	        		$i = 0;
	        		foreach ($rel as $l => $m) {
	        			$ifRel[$i] = $m['role'];
	        			$i++;
	        		}
	        		if (!in_array($c, $ifRel)) {
	        			unset($persons[$a]);
	        		}
	        	} else {
	        		if ($b == 'sex') {
	        			if ($c != $q['sex']) {
	        				unset($persons[$a]);
	        			}
	        		} else {
			            $trues = array();
			            foreach ($works as $key => $value) {
			            	$i = 0;
			            	if (in_array($c, $value)) {
			            		$trues[$i] = true;
			            	}
			            }
			            if (!in_array(1, $trues)) {
			            	unset($persons[$a]);
			            }
		            }
	        	}
	        }
	    }
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>EDB - Лица</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
		<div hidden class="loading" id="loading">Loading&#8230;</div>

		<h1 id="head" class="header-page">Лица</h1>
		    <div class="main-content">
		        <div class="header-main">
		            <div class="add-cr-filt">
		                <a href="<?php echo BASE_URL . 'add-person.php' ?>" class="tbm-border add-btn-ev" id="add-person">Добавить лицо</a>
		    
		                <!-- CREATE REPORT -->
		    
		                <div class="place-rep">
		                    <a class="btn-rep add-btn tbm-border" id="create-report" href="<?php echo BASE_URL . 'create-report.php' ?>">Создать отчет</a>
		                </div>
		            </div>

		            <!-- SORT -->

		            <div class="sort-search">
		                <a>Сортировка:</a>
	                    <select name="sort" id="sortId">
	                        <option value="Без сортировки">Без сортировки</option>
	                        <option <?php if ($sort=='byNameUp') echo 'selected'; ?> id="byNameUp" value="По фамилии: А-Я">По фамилии: А - Я</option>
	                        <option <?php if ($sort=='byNameDown') echo 'selected'; ?> id="byNameDown" value="По фамилии: Я-А">По фамилии: Я - А</option>
	                    </select>
		            </div>
		        </div>


		        <!-- FILTERS -->

		        <div class="filter" id="filter">
		            <div class="filter-content">
		                <form class="filter-form" id="filter-person" action="" method="get">
		                    <div>
	                            Пол
	                            <select name="sex" id="id_sex">
								  <option value="">-</option>
								  <?php foreach ($sexes as $a => $b): ?>
                                        <?php if ($b === $sex): ?>
                                            <option selected value='<?php $c = $b; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
								</select>
							</div>
							<div>
	                            Роль лица
	                            <select name="role" id="id_role">
								  <option value="">-</option>
								  <?php foreach ($roles as $a => $b): ?>
                                        <?php if ($b === $role): ?>
                                            <option selected value='<?php $c = $b; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
								</select>
                        	</div>
                        	<div>
                                Юридическое лицо
                                <select name="entity" id="id_entity">
                                    <option value="">-</option>
                                    <?php foreach ($entity as $a => $b): ?>
                                        <?php if ($b['name'] === $ent): ?>
                                            <option selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div>
                                Дивизион
                                <select name="division" id="id_division">
                                    <option value="">-</option>
                                    <?php foreach ($division as $a => $b): ?>
                                        <?php if ($b['name'] === $div): ?>
                                            <option selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                             <div>
                                Филиал
                                <select name="filial" id="id_filial">
                                    <option value="">-</option>
                                    <?php foreach ($filial as $a => $b): ?>
                                        <?php if ($b['name'] === $fil): ?>
                                            <option selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div>
                                Представительство
                                <select name="represent" id="id_representation">
                                    <option value="">-</option>
                                    <?php foreach ($represent as $a => $b): ?>
                                        <?php if ($b['name'] === $rep): ?>
                                            <option selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
		                    <div class="filter-btns">
		                        <button class="filter-button-action tbm-border" id="filter-accept">Применить фильтры</button>
		                        <button class="filter-button-action tbm-border" id="filter-delete">Очистить фильтры</button>
		                    </div>
		                </form>
		            </div>
		        </div>

		        <!-- MAIN CONTENT -->

		        <div class="res-search">
		                <h3>Найдено записей: <a id="counter"></a></h3>
		                <div class="search">
		                    <div id="datezone">
		                        Период:
		                        <input type="date" name="from_date" id="from_date">
		                        -
		                        <input type="date" name="to_date" id="to_date">
		                        <span class="date-ev material-symbols-outlined" id="check-date">check_circle</span>
		                        <span class="date-ev material-symbols-outlined" id="del-date">cancel</span>
		                        
		                    </div>
		                    <input type="text" name="search_input" id="id_search_input">
		    
		                    <button type="submit" id="search-button-person"><span class="material-symbols-outlined">search</span><span class="material-symbols-outlined" id="delete-search">close</span></button>
		                </div>
		            </div>
		        <table class="table-main" id="tableMain">
	                <tr class="header-table">
	                    <th hidden>Добавлено/Обновлено</th>
	                    <th hidden></th>
	                    <th id="id"><b>№ Лица</b></th>
	                    <th id=""><b>Фамилия</b></th>
	                    <th id=""><b>Имя</b></th>
	                    <th id=""><b>Отчество</b></th>
	                    <th><b>День рождения</b></th>
	                    <th id="empty-col"><b>Действия</b></th>
	                </tr>
	                <tbody id="tbodyTable">
	                    <?php foreach($persons as $person): ?>
	                        <tr>
	                            <td hidden><?php echo $person['add_at'];?></td>
	                            <td id='fio' hidden><?php echo $person['fio'];?></td>
	                            <td id="id"><?php echo $person['id'];?></td>
	                            <td><?php echo $person['last_name'];?></td>
	                            <td><?php echo $person['first_name'];?></td>
	                            <td><?php echo $person['second_name'];?></td>
	                            <td id="date"><?php echo convertTtoD($person['birthday']);?></td>
	                            <td id="empty-col">
	                                <div>
	                                    <a href="<?php $id=$person['id']; echo BASE_URL . "person.php?id=$id"; ?>">Открыть<span class="material-symbols-outlined">open_in_new</span></a>
	                                </div>
	                            </td>
	                            <td id="fio" hidden>{{ line.fio }}</td>

	                        </tr>
	                    <?php endforeach ?>
	                </tbody>
		        </table>

		        <!-- PAGINATE -->

		        <div class="pagination">
		            <ul id="pagination-ul">
		            </ul>
		        </div>

		    </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/js/tools/sorting.js"></script>


    
</body>
</html>