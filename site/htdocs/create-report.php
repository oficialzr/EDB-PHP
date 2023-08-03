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

    <title>EDB - Создание отчета</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <?php if(isset($_SESSION['warning'])): ?>
        <?php $q = $_SESSION['warning']; ?>
        <?php $a = "<script>window.onload = function() {alert(`$q`)};</script>"; echo $a ?>
        <?php unset($_SESSION['warning']) ?>
    <?php endif ?>

    <div hidden class="loading" id="loadingauth">Loading&#8230;</div>

    <section>
        <div class="rep-main flex-col align-center">
            <h1 class="font-30 pb-20">Создание отчета</h1>
            <div class="create-rep" id="create-rep">
                <span onclick="javascript:window.history.back();" class="back-span material-symbols-outlined">arrow_back</span>
                <form class="reports" method="post" action="app/helper/reps.php" id="event">
                    
                   Юридическое лицо
                    <select required name="entity" id="entity_rep">
                        <option value="">-</option>
                        <?php foreach ($entity as $a => $b): ?>
                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>
                    
                    Дивизион
                    <select name="division" id="division_rep">
                        <option value="">-</option>
                        <?php foreach ($division as $a => $b): ?>
                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>
        
                    Филиал
                    <select name="filial" id="filial_rep">
                        <option value="">-</option>
                        <?php foreach ($filial as $a => $b): ?>
                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select>

                    Представительство
                    <select name="represent" id="repr_rep">
                        <option value="">-</option>
                        <?php foreach ($represent as $a => $b): ?>
                            <option value='<?php $c = $b['name']; echo "$c" ?>'><?php echo $c ?></option>
                        <?php endforeach ?>
                    </select><br>


                    Период
                    <div>
                        <input type="date" name="start-date" id="start-date" required>
                        - <input type="date" name="end-date" id="end-date" required>
                    </div>
                    <div class="center-col">
                        <button class="add-info" id="create-button" type="submit">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>


    <script src="assets/js/index.js"></script>
    <script src="assets/js/tools/adaptive-list.js"></script>
    <script src="assets/js/tools/create-report.js"></script>
    
</body>
</html>
