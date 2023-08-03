<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php


    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sortBy = '';
        $sorts = array('byDateUp', 'byDateDown', 'byNameUp', 'byNameDown');
        $asc = true;
        if (in_array($sort, $sorts)) {
            switch ($sort) {
                case 'byDateUp':
                    $sortBy = 'date_incedent';
                    break;
                case 'byDateDown':
                    $sortBy = 'date_incedent';
                    $asc = false;
                    break;
                case 'byNameUp':
                    $sortBy = 'filial';
                    $asc = false;
                    break;
                case 'byNameDown':
                    $sortBy = 'filial';
                    break;
            }
            $events = selectAll('event', array(), false, $sortBy, $asc);
        } else {
            $events = selectAll('event', array(), false, 'id', true);
        }
    } else {
        $sort = '';
        $events = selectAll('event', array(), false, 'id', true);
    }


    $entity = selectAll('entity');
    $division = selectAll('division');
    $filial = selectAll('filial');
    $represent = selectAll('represent');

    $type = getUnique('event', 'type');



    $t = $_GET['type'];
    if (isset($_GET['entity'])) {
        $ent = $_GET['entity'];
    } else {
        $ent = '';
    }
    if (isset($_GET['division'])) {
        $div = $_GET['division'];
    } else {
        $div = '';
    }
    if (isset($_GET['filial'])) {
        $fil = $_GET['filial'];
    } else {
        $fil = '';
    }
    if (isset($_GET['represent'])) {
        $rep = $_GET['represent'];
    } else {
        $rep = '';
    }
    $gets = array('type'=>$t, 'entity'=>$ent, 'division'=>$div, 'filial'=>$fil, 'represent'=>$rep);
    foreach ($events as $a => $q) {
        foreach ($gets as $b => $c) {
            if ($c) {
                if ($q["$b"] != $c) {
                    unset($events[$a]);
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <title>EDB - События</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div hidden class="loading" id="loading">Loading&#8230;</div>

        <h1 id="head" class="header-page">События</h1>
            <div class="main-content">
                <div class="header-main">
                    <div class="add-cr-filt">
                        <a href="<?php echo BASE_URL . 'add-event.php' ?>" class="tbm-border add-btn-ev" id="add-event">Добавить событие</a>
            
            
                        <!-- CREATE REPORT -->
            


                        <?php if (!checkValid($person['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                            <div class="place-rep">
                                <a class="btn-rep add-btn tbm-border" id="create-report" href="<?php echo BASE_URL . 'create-report.php' ?>">Создать отчет</a>
                            </div>
                        <?php endif ?>

                    </div>

                    <!-- SORT -->

                    <div class="sort-search">
                        <a>Сортировка:</a>
                        <select name="sort" id="sortId">
                            <option value="Без сортировки">Без сортировки</option>
                            <option <?php if ($sort=='byDateUp') echo 'selected'; ?> id="byDateUp" value="По дате: раньше">По дате события: недавно</option>
                            <option <?php if ($sort=='byDateDown') echo 'selected'; ?> id="byDateDown" value="По дате: позже">По дате события: давно</option>
                            <option <?php if ($sort=='byNameUp') echo 'selected'; ?> id="byNameUp" value="По фамилии: Я-А">По филиалу: А - Я</option>
                            <option <?php if ($sort=='byNameDown') echo 'selected'; ?> id="byNameDown" value="По фамилии: А-Я">По филиалу: Я - А</option>
                        </select>
                    </div>
                </div>


                <!-- FILTERS -->

                <div class="filter" id="filter">
                    <div class="filter-content">
                        <form class="filter-form" id="filter-event" action="" method="get">
                            <div>
                                Вид события
                                <select name="type" id="id_type">
                                    <option value="">-</option>
                                    <?php foreach ($type as $a => $b): ?>
                                        <?php if ($b['type'] === $t): ?>
                                            <option selected value='<?php $c = $b['type']; echo "$c" ?>'><?php echo $c ?></option>
                                        <?php else: ?>
                                            <option value='<?php $c = $b['type']; echo "$c" ?>'><?php echo $c ?></option>
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

                <table class="table-main" id="tableMain">
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
                    <tr class="header-table">
                        <th hidden>desc</th>
                        <th id="id">№ События</th>
                        <th id="date">Дата события</th>
                        <th id="type">Вид события</th>
                        <th id="division">Дивизион</th>
                        <th id="filial">Филиал</th>
                        <th id="filial">Представительство</th>
                        <th id="empty-col">Действия</th>
                    </tr>
                    <tbody id="tbodyTable">
                        <?php foreach($events as $event): ?>
                        <tr>
                            <td id="desc" hidden><?php echo $event['desc'];?></td>
                            <td id="id"><?php echo $event['id'];?></td>
                            <td id="date"><?php echo convertTtoD($event['date_incedent']);?></td>
                            <td id="type"><?php echo $event['type'];?></td>
                            <td id="division"><?php echo $event['division'];?></td>
                            <td id="filial"><?php echo $event['filial'];?></td>
                            <td id="repr"><?php echo $event['repr'];?></td>
                            <td id="empty-col">
                                <div>
                                    <a href="<?php $id=$event['id']; echo BASE_URL . "event.php?id=$id"; ?>">Открыть<span class="material-symbols-outlined">open_in_new</span></a>                       
                                </div>
                            </td>
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


    <!-- JS SCRIPTS -->
    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/js/tools/sorting.js"></script>
    
</body>
</html>




