<?php
include("Classes/Class_base.php");
$obj = new Base();
$obj->authorization(trim($_POST["login"]),trim($_POST["password"]));
?>