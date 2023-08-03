<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>

<?php

$event = selectOne('event', array('id'=>$_GET['id']));

if (empty($event)) {
    header("Location:" . BASE_URL);
    die();
}

$id = $_GET['id'];

$changes = selectAll('change_event', array('id_record'=>$id), false, "id");

$files = selectAll('file_event', array('id_event'=>$id));

$persons_list = array(
    'Нарушители'=>selectAll('relation', array('id_event'=>$id, 'role'=>'Нарушитель')),
    'Свидетели'=>selectAll('relation', array('id_event'=>$id, 'role'=>'Свидетель')),
    'Потерпевшие'=>selectAll('relation', array('id_event'=>$id, 'role'=>'Потерпевший')),
    'Остальные фигуранты'=>selectAll('relation', array('id_event'=>$id, 'role'=>'Другой фигурант'))
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>EDB - Просмотр события</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <?php if($_SESSION['warning']): ?>
        <?php $q = $_SESSION['warning']; ?>
        <?php $a = "<script>window.onload = function() {alert(`$q`)};</script>"; echo $a ?>
        <?php unset($_SESSION['warning']) ?>
    <?php endif ?>

    <section>
        <div class="main-content">
            <div class="right-position">
                <a id="dwn-html" href="">Скачать Excel</a>
                <br>
                <a id="dwn-word" href="">Скачать Word</a>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 50%;">
                    <!-- FILES -->
                    <div>
                        <h1>Документы</h1>
                        <div>
                        <?php if ($files): ?>
                            <?php foreach ($files as $a => $b): ?>
                                <a download class="documents" href="<?php $q = $b['file']; echo $q; ?>"><?php echo $b['name']; ?></a><br>
                            <?php endforeach ?>
                                <br><br>
                        <?php endif ?>
                        </div>
                        <?php if (checkValid($event['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                            <form action="<?php echo "app/controllers/add-file.php?id=$id&type=event" ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: flex-start;">
                                <div class="flex-col align-center">
                                    <label style="margin: 0px" class="add-more tbm-border" type="submit" for="id_file">Добавить</label>
                                    <input type="file" accept="file/*" name="file_event" id="id_file">
                                    <span style="color: grey; font-size: 14px">Файл размером не более 20МБ</span>
                                </div>
                            </form>
                        <?php endif ?>
                    </div>
                    <!-- MAIN CONTENT  -->
                    <div class="person-table">
                        <h1>Событие</h1>
                        <table class="event-table" style="width: 100%">
                            <tr>
                            <td class="td-border"><b>№ п.п.</b></td>
                            <td class="td-border"><?php echo $event['id'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Вид события</b></td>
                            <td class="td-border"><?php echo $event['type'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Дата проишествия</b></td>
                            <td class="td-border"><?php echo $event['date_incedent'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Юридическое лицо</b></td>
                            <td class="td-border"><?php echo $event['entity'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Дивизион</b></td>
                            <td class="td-border"><?php echo $event['division'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Филиал</b></td>
                            <td class="td-border"><?php echo $event['filial'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Представительство</b></td>
                            <td class="td-border"><?php echo $event['repr'];?></td>
                        </tr>
                        
                        
                        
                        <tr>
                            <td class="td-border"><b>Способ проникновения</b></td>
                            <td class="td-border"><?php echo $event['way'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Средство совершения</b></td>
                            <td class="td-border"><?php echo $event['instr'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>В отношении</b></td>
                            <td class="td-border"><?php echo $event['relation'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Предмет посягательства</b></td>
                            <td class="td-border"><?php echo $event['object'];?></td>
                        </tr>
                        
                        <tr>
                            <td class="td-border"><b>Место</b></td>
                            <td class="td-border"><?php echo $event['place'];?></td>
                        </tr>

                        <tr>
                            <td class="td-border"><b>Описание события</b></td>
                            <td class="td-border"><?php echo $event['desc'];?></td>
                        </tr>
                        </table>
                        <br>
                    </div>
                    <?php if(checkValid($event['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                        <div class="person-buttons">
                            <a class="add-more tbm-border" href="<?php echo BASE_URL . "add-person-on-event.php?id=$id" ?>">Добавить фигуранта<span class="material-symbols-outlined">add</span></a>
                            <a class="add-more tbm-border" href="<?php echo BASE_URL . "edit-event.php?id=$id" ?>">Изменить данные<span class="material-symbols-outlined">edit</span></a>
                        </div>
                    <?php endif ?>

                    <!-- PERSONS -->
                    <?php foreach ($persons_list as $a => $b): ?>
                        <div class="person-table">
                            <h1><?php echo $a ?></h1>
                            <?php if (empty($b)): ?>
                                <h3 style="color: grey">Нет данных</h3>
                            <?php else: ?>
                                <?php foreach ($b as $i): ?>
                                    <?php if ($i['role_desc'] != ''): ?>
                                        <a class="person-link" href="<?php $id=$i['id_person']; echo BASE_URL . "person.php?id=$id" ?>"><?php $role = $i['role_desc']; $person = selectOne('person', array('id'=>$id)); $fio = $person['fio']; $birth = $person['birthday']; echo "$role: $fio | $birth" ?></a><br><br>
                                    <?php else: ?>
                                        <a class="person-link" href="<?php $id=$i['id_person']; echo BASE_URL . "person.php?id=$id" ?>"><?php $person = selectOne('person', array('id'=>$id)); $fio = $person['fio']; $birth = $person['birthday']; echo "$fio | $birth" ?></a><br><br>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>

                <!-- CHANGES -->
                <?php if($_SESSION['admin']==='1'): ?>
                    <div style="width: 45%;">
                        <h1>Изменения</h1>
                        <div>
                            <?php if (!$changes): ?>
                                <h3 style="color: grey">Нет данных</h3>
                            <?php else: ?>
                                <?php $i = 1; foreach ($changes as $a => $b): ?>
                                        <a class="person-link" href="<?php $id_change = $b['id']; echo BASE_URL . "change-page-event.php?id=$id_change" ?>">ID изменения: <?php echo $i ?></a><br><br>
                                <?php $i++; endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>    
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/js/tools/add-files.js"></script>


    
</body>
</html>