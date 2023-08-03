<?php include 'app/controllers/users.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />

    <title>ED - Вход</title>

</head>
<body>
    <?php include 'app/include/header.php' ?>

    <section>
        <div hidden class="loading" id="loadingauth">Loading&#8230;</div>
        <div class="login-main">
            <div class="login-content">
                    <div>
                        Вход в систему
                    </div>
                    <form action="" method="post" class="login-form" id="auth-form">
                        <label for="username">Имя пользователя</label>
                        <input type="text" name="username" value="<?php echo $username ?>" id="username">
                        <br>
                        <label for="username">Пароль</label>
                        <input type="password" name="password" value="<?php echo $password ?>" id="password">
                        <button id="submit-login" name="btn-log" type="submit">Войти</button>
                    </form>
                    <p class='warning-auth'><?php echo $a ?></p>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper/popper-1.14.7.js"></script>
    <script src="assets/js/jquery/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery/jquery-ui-1.13.2.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/js/tools/auth.js"></script>


    
</body>
</html>