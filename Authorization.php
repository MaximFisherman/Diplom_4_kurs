<?php
session_start();
include("Classes/Class_base.php");
$obj = new Base();
$obj->authorization(trim($_POST["login"]),trim($_POST["password"]));
if($_SESSION["type_avt_user"]=="dai")
    echo"<script>document.location.replace('Dai_start_page.html');</script>";
if($_SESSION["type_avt_user"]=="police")
    echo"<script>document.location.replace('Police_start_page_blank.html');</script>";
if($_SESSION["type_avt_user"]=="user")
    echo"<script>document.location.replace('User_start_page_fines.html');</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Authorization</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        @import url("css/Authorization_page.css");

        body {
            background: url(images/Authorization_background.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>

</head>
<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>



<div class="login-box">
    <form id="loginForm" action="Authorization.php" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading"><b>Авторизация</b> <span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span></div>
            <div class="panel-body">
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">Номер водійського посвідчення<span class="regForm text-danger">*</span></label>
                    <input type="text" class="form-control" name="login" id="login" aria-describedby="login" required>
                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="password">Пароль<span class="regForm text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" class="btn btn-success" id="goToChat" value="Увійти" />
                <a href="Registr.html" class="btn btn-warning pull-right">Зереєструватися</a>
            </div>
        </div>
    </form>
</div>
<div class="text-center">
    <a href="#">Забули пароль?</a>
</div>

<script>
</script>

</body>
</html>
