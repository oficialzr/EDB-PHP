<?php include "../app/database/db.php" ?>
<?php include "../app/helper/check.php" ?>
<?php include "../app/helper/validate_user.php" ?>

<?php

if (!isset($_GET['id'])) {
    header("Location:" . BASE_URL);
    die();
} else {
	$is_author = selectOne("information", array('id'=>$_GET['id']));
	if ($is_author['author_id'] != $_SESSION['id']) {
		header("HTTP/1.1 404 Not Found");
		include("../404.php");
		die();
	}
}


$id = $_GET['id'];

$info = selectOne('information', array('id'=>$id));

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

    <title>EDB - ОЗИ</title>

</head>
<body>
    <?php include '../app/include/header.php' ?>

    <section>
        <div class="info-page">
		    <div class="info-cur">
		    	<span onclick="javascript:window.history.back();" class="material-symbols-outlined back-span">arrow_back</span>
		    	<p><b>ОЗИ</b></p>
		    	<div>
		    		<div class="info-flex">
		    			<p><b>Краткое описание</b></p>
		    			<div><p><?php echo $info['short_desc'] ?></p></div>
		    		</div>
		    		<div class="info-flex">
		    			<p><b>Описание</b></p>
		    			<div><p><?php echo $info['desc'] ?></p></div>
		    		</div>
		    		<div class="info-flex">
		    			<p><b>Дата добавления</b></p>
		    			<div><p><?php echo convertTtoD($info['add_at']) ?></p></div>
		    		</div>
		    		<?php if (isAdmin($_SESSION['admin'])): ?>
		    			<div class="info-flex">
			    			<p><b>Автор</b></p>
			    			<div><p><?php echo $info['author'] ?></p></div>
			    		</div>
		    		<?php endif ?>
		    		<div class="info-flex">
		    			<p><b>Статус</b></p>
		    			<?php if ($info['checked'] == 0): ?>
		    				<div><p class="grey-dot">Не просмотрено</p></div>
		    			<?php else: ?>
		    				<?php if ($info['correct'] == 1): ?>
								<div><p class="green-dot">Значимая информация</p></div>
							<?php else: ?>
								<div><p class="red-dot">Незначимая информация</p></div>
							<?php endif ?>
		    			<?php endif ?>
		    		</div>
		    	</div>
		    </div>
	    </div>
	    <?php if (isAdmin($_SESSION['admin'])): ?>
		    <div class="do-correct">
		    	<?php $id_person = isset($_GET['referer_person']) ? $_GET['referer_person'] : false; $referer = $id_person != 0 ? "app/helper/set-correct.php?id=$id&referer=$id_person" : "app/helper/set-correct.php?id=$id" ?>
		    	<form method="post" action="<?php echo BASE_URL . $referer ?>">
			    	<button name="correct" type="submit" class="sh sh-green add-info" id="add-info">Значимая информация</button>
			    	<button name="uncorrect" type="submit" class="sh sh-red add-info" id="add-info">Незначимая информация</button>
		    	</form>
		    </div>
		<?php endif ?>
    </section>

    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.3.1.slim.min.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/popper/popper-1.14.7.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-3.6.0.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/jquery/jquery-ui-1.13.2.js" ?> "></script>
    <script src="<?php echo BASE_URL . "assets/js/index.js" ?> "></script>
    
</body>
</html>