<?php include "../app/database/db.php" ?>
<?php include "../app/helper/check.php" ?>
<?php include "../app/helper/validate_user.php" ?>

<?php

// check user
if (!isset($_GET['id'])) {
    header("Location:" . BASE_URL);
    die();
}

$id = $_GET['id'];

if ($id != $_SESSION['id']) {
    $new_id = $_SESSION['id'];
    header("Location:" . BASE_URL . "user/user.php?id=$new_id");
    die();
}

if (isset($_GET['person'])) {
    if (isAdmin($_SESSION['admin'])) {
        $person_filter = $_GET['person'];
    } else {
        $new_id = $_SESSION['id'];
        header("Location:" . BASE_URL . "user/user.php?id=$id");
    }
}

if (!empty($_POST) && $_POST['from_d'] != '' && $_POST['to_d'] != '') {
    $all_from = $_POST['from_d'];
    $all_to = $_POST['to_d'];
    $url = "Location: " . BASE_URL . "user/user.php?id=$id";
    if (isset($_GET['person'])) {
        $url = $url . "&person=$person_filter";
    }
    $url = $url . "&from_d=$all_from&to_d=$all_to#select-person";
    header($url);
}

$quart = currentQuart();

$date_from = $quart[0];
$date_to = $quart[1];


// get user


$user = selectOne('users', array('id'=>$_GET['id']));

$stat_person = getCount('person', array('author'=>$user['fio']), "add_at", $date_from, $date_to);
$stat_event = getCount('event', array('author'=>$user['fio']), "change_date", $date_from, $date_to);

$stat_month = $stat_event + $stat_person;

$stat_correct = getCount('information', array('author_id'=>$_GET['id'], 'correct'=>1), "add_at", $date_from, $date_to);

$procent = intval(($stat_correct / 7) * 100) < 100 ? intval(($stat_correct / 7) * 100) : 100;

if (isAdmin($_SESSION['admin'])) {
    $person_names = selectAll('users');
    if ($person_filter) {
        if (!empty($_GET) && $_GET['from_d'] != '' && $_GET['to_d'] != '') {
            $all_from = $_GET['from_d'];
            $all_to = $_GET['to_d'];
            $allInfo = selectAll("information", array('author_id'=>$person_filter), false, 'id', true, 'add_at', $all_from, $all_to);
        } else {
            $allInfo = selectAll("information", array('author_id'=>$person_filter), false, 'id', true);
        }
    } else {
        if (!empty($_GET) && $_GET['from_d'] != '' && $_GET['to_d'] != '') {
            $all_from = $_GET['from_d'];
            $all_to = $_GET['to_d'];
            $allInfo = selectAll("information", array(), false, 'id', true, 'add_at', $all_from, $all_to);
        } else {
            $allInfo = selectAll("information", array(), false, 'id', true, "add_at");
        }
    }
}

if (isset($_GET['all-info'])) {
    $information = selectAll("information", array('author_id'=>$user['id']), false, 'id', true);
} else {
    $information = selectAll("information", array('author_id'=>$user['id']), false, 'id', true, "add_at", $date_from, $date_to);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?php echo BASE_URL . "assets/images/favicon.ico" ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . "assets/css/style.css" ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />

    <title>EDB - Личный кабинет</title>

</head>
<body>
    <div class="dark" id="dark">
        <div class="modal">
        <span class="red-dot material-symbols-outlined" id="close-modal">close</span>
            <form action='<?php echo BASE_URL . "app/helper/add-info.php?id=$id" ?>' method='post' id="info-post">
                <p><b>Заполните информацию</b></p>
                <label for='short_desc'>Краткое описание (до 30 символов)</label>
                <input required name='short_desc' id='short_desc'>
                <label for='desc'>Описание</label>
                <textarea required name='desc' id='desc' type='text'></textarea>
                <button type="submit">Отправить</button>
            </form>
        </div>
    </div>
    <?php include '../app/include/header.php' ?>


    <section>
        <div class="center-col">
            <div class="width-100">
                <div class="lk">
                    <div class="flex-col user-stack">
                        <div class="user-info">
                            <div>
                                <p><b><?php echo $user['fio'] ?></b></p>
                                <p>Почта: <?php echo $user['email'] ?></p>
                                <br>
                                <p><b>Статистика за квартал</b></p>
                                <p>Создано записей лиц: <?php echo $stat_person ?></p>
                                <p>Создано записей событий: <?php echo $stat_event ?></p>
                                <p>Создано всего: <?php echo $stat_month ?></p>
                                <p>ОЗИ: <?php echo $stat_correct ?> (<?php echo $procent ?>% от плана)</p>
                            </div>
                        </div>
                        <a class="add-info" href="<?php echo BASE_URL . "../create-report.php?id=$id" ?>">Создать отчет</a><br><br>
                    </div>
                    <div class="info-stack">
                        <div class="flex just-bet info-head">
                            <div class="w-3 flex align-center just-center">
                                <select class="bt-select" id="select-person" onchange="location = this.value;">
                                    <option <?php if (!isset($_GET['all-info'])) {echo "selected";} ?> value="<?php echo BASE_URL . "user/user.php?id=$id" ?>">За квартал</option>
                                    <option <?php if (isset($_GET['all-info'])) {echo "selected";} ?> value="<?php echo BASE_URL . "user/user.php?id=$id&all-info=1" ?>">За все время</option>
                                </select>
                            </div>
                            <div class="w-7">
                                <p><b>Добавленная ОЗИ за <?php if (isset($_GET['all-info'])) {echo "все время";} else {echo 'квартал';} ?></b></p>
                            </div>
                        </div>
                        <div>
                           <?php foreach ($information as $a => $b): ?>
                                <div class="stack">
                                    <div class="info-base">
                                        <a class="underlink" href="<?php $idPost = $b['id']; echo BASE_URL . "user/info.php?id=$idPost" ?>"></a>
                                        <?php $checked = $b['checked'] == 0 ? 0 : 1?>
                                        <?php $correct = $b['correct'] == 0 ? 0 : 1?>
                                        <?php if($checked == 0): ?>
                                            <span class="dot <?php echo "grey-dot" ?> material-symbols-outlined">
                                                <?php echo "pending" ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="dot <?php $color = $correct == 0 ? "red" : "green"; echo $color . "-dot"?> material-symbols-outlined">
                                                <?php if ($correct == 1){echo "check_circle";} else {echo "cancel";} ?>
                                            </span>
                                        <?php endif ?>
                                        <div>
                                            <a><?php echo $b['short_desc']; ?></a> <!-- max 30 char -->
                                            <a>Дата: <?php echo convertTtoD($b['add_at']) ?> </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <br>
                        </div>
                        <a class="add-info" id="add-info">Добавить информацию</a><br><br>
                    </div>
                </div>
            </div>
            <?php if (isAdmin($_SESSION['admin'])): ?>
                <div class="all-info">
                    <div class="all-stack">
                        <p><b>Добавленная ОЗИ сотрудников</b></p>
                        <div class="around flex just-center">
                            <form method='post' id="date-accept" class="flex date-input" action="<?php $uri = isset($_GET['person']) ? "user/user.php?id=$id&person=$person_filter" : "user/user.php?id=$id"; echo BASE_URL . $uri . "#select-person" ?>">
                                <input class="bt-select" type="date" id="from_d" name="from_d" value="<?php if($all_from){echo $all_from;}else{echo '';} ?>">
                                <span class="material-symbols-outlined">go_to_line</span>
                                <input class="bt-select" type="date" id="to_d" name="to_d" value="<?php if($all_to){echo $all_to;}else{echo '';} ?>">
                                <button type='submit' class="unvis-bt hover-gr clicked font-35 material-symbols-outlined">done</button>
                                <button onclick="javascript: document.getElementById('from_d').value=''; document.getElementById('to_d').value=''" class="unvis-bt hover-red clicked font-30 material-symbols-outlined">refresh</button>
                            </form>
                            <select class="bt-select" id="select-person" onchange="location = this.value;">
                                <option value="<?php echo BASE_URL . "user/user.php?id=$id#select-person" ?>">Все сотрудники</option>
                                <?php foreach ($person_names as $a => $b): ?>
                                    <?php $id_person = $b['id']; ?>
                                    <?php if ($person_filter && $b['id'] == $person_filter): ?>
                                        <option selected value="<?php echo BASE_URL . "user/user.php?id=$id&person=$id_person#select-person" ?>"><?php echo $b['fio'] ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo BASE_URL . "user/user.php?id=$id&person=$id_person#select-person" ?>"><?php echo $b['fio'] ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div>
                            <?php foreach ($allInfo as $a => $b): ?>
                                <div class="stack" id="<?php $idEv = $b['id']; echo "an-$idEv"?>">
                                    <div class="info-base">
                                        <?php if (isset($_GET['person'])): ?>
                                            <?php $referer = $_GET['person'] ?>
                                            <a class="underlink" href="<?php $idPost = $b['id']; echo BASE_URL . "user/info.php?id=$idPost&referer_person=$referer" ?>"></a>
                                        <?php else: ?>
                                            <a class="underlink" href="<?php $idPost = $b['id']; echo BASE_URL . "user/info.php?id=$idPost" ?>"></a>
                                        <?php endif ?>
                                        <?php $checked = $b['checked'] == 0 ? 0 : 1?>
                                        <?php $correct = $b['correct'] == 0 ? 0 : 1?>
                                        <div class="icons">
                                            <?php if($checked == 0): ?>
                                                <span class="dot <?php echo "grey-dot" ?> material-symbols-outlined">
                                                    <?php echo "pending" ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="dot <?php $color = $correct == 0 ? "red" : "green"; echo $color . "-dot"?> material-symbols-outlined">
                                                    <?php if ($correct == 1){echo "check_circle";} else {echo "cancel";} ?>
                                                </span>
                                            <?php endif ?>
                                        </div>
                                        <div>
                                            <a><?php echo $b['short_desc'] ?></a> <!-- max 30 char -->
                                            <div class="author-date">
                                                <a><?php echo $b['author'] ?></a>
                                                <a>Дата: <?php echo convertTtoD($b['add_at']) ?> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <br>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </section>



    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.3.1.slim.min.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/popper/popper-1.14.7.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.6.0.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-ui-1.13.2.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/index.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/tools/modal.js" ?> "></script>
    
</body>
</html>
