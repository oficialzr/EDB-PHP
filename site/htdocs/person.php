<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>
<?php include "app/helper/validate_user.php" ?>


<?php

$person = selectOne('person', array('id'=>$_GET['id']));
if (empty($person)) {
    header("Location:" . BASE_URL);
    die();
}

$id = $_GET['id'];

$birth = selectAll('adr_birth', array('id_place'=>$id));
$work = selectAll('adr_work', array('id_place'=>$id));
$live = selectAll('adr_live', array('id_place'=>$id));
$other = selectAll('adr_other', array('id_place'=>$id));

$relation = selectAll('relation', array('id_person'=>$id));

$changes = selectAll('change_person', array('id_record'=>$id), false, 'id');

$image = selectOne('img_person', array('id_person'=>$id));
$files = selectAll('file_person', array('id_person'=>$id));

// $docs = ...

// tt($person);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>EDB - Просмотр лица</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>
    
    <?php if(isset($_SESSION['warning'])): ?>
        <?php $q = $_SESSION['warning']; ?>
        <?php $a = "<script>window.onload = function() {alert(`$q`)};</script>"; echo $a ?>
        <?php unset($_SESSION['warning']) ?>
    <?php endif ?>

    <section>
    <div class="main-content">
        <div class="right-position">
            <a id="dwn-html" href="">Скачать Excel</a>
            <a id="dwn-word" href="">Скачать Word</a>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 50%;">
                <div style="display: flex">
                    <div>
                        <h1>Фотография лица</h1>
                        <div>
                        <?php if ($image): ?>
                            <div class="td-border" style="background-size:cover; width: 250px; height: 300px; background-image: url('<?php $url = $image['file']; echo $url ?>'); background-position: center;"></div>
                            <?php if (checkValid($person['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                                <form action="<?php echo "app/controllers/add-file.php?id=$id&type=person" ?>" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
                                    <span style="color: grey; font-size: 14px;">Не более 20МБ</span>
                                    <label class="edit-photo add-more tbm-border" for="id_image">Изменить фото<span class="material-symbols-outlined">edit</span></label>
                                    <input type="file" accept="image/*" name="image" id="id_image">
                                </form>
                            <?php endif ?>
                        <?php else: ?>
                            <?php if (checkValid($person['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                                <div>
                                    <form style="display: flex; flex-direction: column; align-items: center" action="<?php echo "app/controllers/add-file.php?id=$id&type=person" ?>" method="post" enctype="multipart/form-data">
                                        <label style="margin: 0px" class="edit-photo add-more tbm-border" id="label-image" for="id_image"><a>Выбрать фото</a><span class="material-symbols-outlined">add</span></label>
                                        <input type="file" accept="image/*" name="image" id="id_image">
                                <span style="color: grey; font-size: 14px">Не более 20МБ</span>
                                    </form>
                                </div>
                            <?php else: ?>
                                <h3 style="color: grey">Нет фотографии</h3>
                            <?php endif ?>
                        <?php endif ?>
                        </div>
                    </div>
                    <div style="margin-left: 30px">
                        <h1>Документы</h1>
                        <div>
                        <?php if ($files): ?>
                            <?php foreach ($files as $a => $b): ?>
                                <a download class="documents" href="<?php $q = $b['file']; echo $q; ?>"><?php echo $b['name']; ?></a>
                            <?php endforeach ?>
                                <br><br>
                        <?php endif ?>
                        </div>
                        <?php if (checkValid($person['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                            <form action="<?php echo "app/controllers/add-file.php?id=$id&type=person" ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: start;">
                                <label style="margin: 0px" class="add-more tbm-border" type="submit" for="id_file">Добавить</label>
                                <input type="file" accept="file/*" name="file" id="id_file">
                                <span  style="color: grey; font-size: 14px">Файл размером не более 20МБ</span>
                            </form>
                        <?php endif ?>
                    </div>
                </div>
                <div class="person-table">
                    <h1>Лицо</h1>
                    <table style="width: 100%">
                        <tr>
                            <td class="td-border"><b>ID лица</b></td>
                            <td class="td-border"><?php echo $person['id'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>ФИО</b></td>
                            <td class="td-border"><?php echo $person['fio'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>Фамилия</b></td>
                            <td class="td-border"><?php echo $person['last_name'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>Имя</b></td>
                            <td class="td-border"><?php echo $person['first_name'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>Отчество</b></td>
                            <td class="td-border"><?php echo $person['second_name'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>Описание лица</b></td>
                            <td class="td-border"><?php echo $person['desc'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>Пол</b></td>
                            <td class="td-border"><?php echo $person['sex'];?></td>
                        </tr>
                        <tr>
                            <td class="td-border"><b>Дата рождения</b></td>
                            <td class="td-border"><?php echo $person['birthday'];?></td>
                        </tr>
                    </table>
                    <br>
                </div>
                <?php if(checkValid($person['author'], $_SESSION['username'], $_SESSION['admin'])): ?>
                    <div class="person-buttons">
                        <a class="add-more tbm-border" href="<?php echo BASE_URL . "add-address.php?id=$id"; ?>">Добавить адрес<span class="material-symbols-outlined">add</span></a>
                        <a class="add-more tbm-border" href="<?php echo BASE_URL . "edit.php?id=$id"; ?>">Изменить данные<span class="material-symbols-outlined">edit</span></a>
                    </div>
                <?php endif ?>

                
                <div class="person-table">
                        <h1>Место рождения:</h1>
                        <?php if (count($birth) == 0): ?>
                            <h3 style="color: grey">Нет данных</h3>
                        <?php endif ?>
                        <?php foreach ($birth as $a => $b): ?>
                        <table style="width: 100%;">
                            <tr>
                                <td class="td-border"><b>Страна</b></td>
                                <td class="td-border"><?php echo $b['country'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Область</b></td>
                                <td class="td-border"><?php echo $b['region'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Адрес</b></td>
                                <td class="td-border"><?php echo $b['address'];?></td>
                            </tr>
                        </table>
                        <br>
                        <?php endforeach ?>
                    </div>
                

                
                <div class="person-table">
                        <h1>Место работы:</h1>

                        <?php if (count($work) == 0): ?>
                            <h3 style="color: grey">Нет данных</h3>
                        <?php endif ?>

                        <?php foreach ($work as $a => $b): ?>
                        <table style="width: 100%;">
                            <tr>
                                <td class="td-border"><b>Юридическое лицо</b></td>
                                <td class="td-border"><?php echo $b['entity'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Дивизион</b></td>
                                <td class="td-border"><?php echo $b['division'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Филиал</b></td>
                                <td class="td-border"><?php echo $b['filial'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Представительство</b></td>
                                <td class="td-border"><?php echo $b['repr'];?></td>
                            </tr>
                        </table>
                        <br>
                        <?php endforeach ?>
                    </div>

                
                <div class="person-table">
                        <h1>Адрес регистрации:</h1>

                        <?php if (count($live) == 0): ?>
                            <h3 style="color: grey">Нет данных</h3>
                        <?php endif ?>

                        <?php foreach ($live as $a => $b): ?>
                        <table style="width: 100%;">
                            <tr>
                                <td class="td-border"><b>Страна</b></td>
                                <td class="td-border"><?php echo $b['country'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Область</b></td>
                                <td class="td-border"><?php echo $b['region'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Район</b></td>
                                <td class="td-border"><?php echo $b['area'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Населенный пункт</b></td>
                                <td class="td-border"><?php echo $b['locality'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Улица</b></td>
                                <td class="td-border"><?php echo $b['street'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Дом</b></td>
                                <td class="td-border"><?php echo $b['house'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Корпус</b></td>
                                <td class="td-border"><?php echo $b['frame'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Квартира</b></td>
                                <td class="td-border"><?php echo $b['apartment'];?></td>
                            </tr>
                        </table>
                        <br>
                        <?php endforeach ?>
                    </div>
                

                
                <div class="person-table">
                        <h1>Остальные адреса:</h1>

                        <?php if (count($other) == 0): ?>
                            <h3 style="color: grey">Нет данных</h3>
                        <?php endif ?>

                        <?php foreach ($other as $a => $b): ?>
                        <table style="width: 100%;">
                            <tr>
                                <td class="td-border"><b>Описание</b></td>
                                <td class="td-border"><?php echo $b['desc'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Страна</b></td>
                                <td class="td-border"><?php echo $b['country'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Область</b></td>
                                <td class="td-border"><?php echo $b['region'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Район</b></td>
                                <td class="td-border"><?php echo $b['area'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Населенный пункт</b></td>
                                <td class="td-border"><?php echo $b['locality'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Улица</b></td>
                                <td class="td-border"><?php echo $b['street'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Дом</b></td>
                                <td class="td-border"><?php echo $b['house'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Корпус</b></td>
                                <td class="td-border"><?php echo $b['frame'];?></td>
                            </tr>
                            <tr>
                                <td class="td-border"><b>Квартира</b></td>
                                <td class="td-border"><?php echo $b['apartment'];?></td>
                            </tr>
                        </table>
                        <br>
                        <?php endforeach ?>
                    </div>
            
                <h1>Где фигурирует:</h1>

                <?php if (count($relation) == 0): ?>
                    <h3 style="color: grey">Нет данных</h3>
                <?php else: ?>
                    <?php foreach ($relation as $a => $b): ?>
                        <a href="<?php $id=$b['id_event']; echo BASE_URL . "event.php?id=$id" ?>" class="event-href"><?php $id=$b['id_event']; $role = $b['role']; echo "ID события: $id | Роль: $role" ?></a><br>
                    <?php endforeach ?>
                <?php endif ?>
            </div>

            <?php if($_SESSION['admin']==1): ?>
                <div style="width: 45%;">
                    <h1>Изменения</h1>
                    <div>
                        <?php if (count($changes) == 0): ?>
                            <h3 style="color: grey">Нет данных</h3>
                        <?php else: ?>
                            <?php $i = 1; foreach ($changes as $a => $b): ?>
                                <a class="person-link" href="<?php $id_rec = $b['id']; echo BASE_URL . "change-page-person.php?id=$id_rec" ?>">ID изменения: <?php echo $i;?></a><br><br>
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