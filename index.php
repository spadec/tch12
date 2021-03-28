<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();

require_once 'classes/Auth.class.php';
if (User::isAuthorized()){
    header("Location:dashboard.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Автоматизация учетной ведомости ПЭВМ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>
    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">

                            <p class="text-white h2">СИСТЕМА ДЛЯ УЧЕТА ПЭВМ</p>

                            <p class="white mb-0">
                                Введите свой логин в системе учета ПЭВМ
                                <br>Регистрация в системе
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="#">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">Вход</h6>
                            <form method="post" class="form-signin ajax" action="./ajax.php">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="username"  />
                                    <span>Логин</span>
                                </label>
                                <input type="hidden" name="act" value="login">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="password" type="password" placeholder="" />
                                    <span>Пароль</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#">Забыли пароль?</a>
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">Вход</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
    <script src="./js/ajax-form.js"></script>
</body>
</html>