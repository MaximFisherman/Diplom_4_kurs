<?php
session_start();
if(isset($_GET["user"]))
    unset($_SESSION["type_avt_user"]);
    echo"<script>document.location.replace('../Authorization.php');</script>";
?>
