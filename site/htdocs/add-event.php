<?php include "app/database/db.php" ?>
<?php include "app/helper/check.php" ?>

<?php

    $entity = selectAll('entity');
    $division = selectAll('division');
    $filial = selectAll('filial');
    $represent = selectAll('represent');

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
    <title>EDB - Добавление события</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <h1 style="text-align: center; font-size: 34px; padding-top: 50px; margin: 0;">Добавление события</h1>
        <div class="main-content main-content-form">
            <form class="event-form" id="event" method="post" action="app/controllers/event-cont.php">
                <div class="form-add-event">
                    <div class="main-info">
                        <h1>Заполните данные о событии</h1>
                        Тип проишествия
                        <div style="margin:0" id="autocomplete" class="autocomplete">
                            <input class="autocomplete-input" name="type" required id="auto-input" type="search">
                            <ul class="autocomplete-result-list"></ul>
                        </div>

                        Дата проишествия
                        <input type="datetime-local" name="date_incedent" required="" id="id_date_incedent" value="">

                        Юридическое лицо
                        <select required name="entity" id="id_entity">
                            <option value="">-</option>
                            <?php foreach ($entity as $a => $b): ?>
                                <?php if ($b['name'] === $ent): ?>
                                    <option required selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                <?php else: ?>
                                    <option required value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>

                        Дивизион
                        <select required name="division" id="id_division">
                            <option value="">-</option>
                            <?php foreach ($division as $a => $b): ?>
                                <?php if ($b['name'] === $div): ?>
                                    <option selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                <?php else: ?>
                                    <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>

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

                        Представительство
                        <select name="repr" id="id_representation">
                            <option value="">-</option>
                            <?php foreach ($represent as $a => $b): ?>
                                <?php if ($b['name'] === $rep): ?>
                                    <option selected value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                <?php else: ?>
                                    <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>

                        Описание события
                        <textarea name="desc" cols="40" rows="10" required id="id_description"></textarea>
                        Способ проникновения
                        <input type="text" name="way" maxlength="40" required id="id_way">
                        Средство совершения
                        <input type="text" name="instr" maxlength="100" required id="id_instrument">
                        В отношении
                        <input type="text" name="relation" maxlength="100" required id="id_relation">
                        Предмет посягательства
                        <input type="text" name="object" maxlength="150" required id="id_object">
                        Место
                        <input type="text" name="place" maxlength="300" required id="id_place">
                    </div>
                </div>
                <button id="main-form-submit" type="submit">Подтвердить данные</button>
            </form>
        </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="https://unpkg.com/@trevoreyre/autocomplete-js"></script>

    <script src="assets/js/index.js"></script>
    <script src="assets/js/forms.js"></script>
    <script src="assets/js/tools/adaptive-list.js"></script>
    <script src="assets/js/tools/search.js"></script>


    
</body>
</html>
