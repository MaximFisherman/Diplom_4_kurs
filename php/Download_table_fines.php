<?php
session_start();
include("../Classes/Class_base.php");
$obj = new Base();
$obj->Select_user_fines($_SESSION["avt_user"]);
?>