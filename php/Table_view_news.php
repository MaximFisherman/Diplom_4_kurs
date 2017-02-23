<?php
session_start();
include("../Classes/Class_base.php");
$obj = new Base();

if($_SESSION["page_number"]=='')
    $obj->view_table_news(1);

$obj->view_table_news($_SESSION["page_number"]);

if(isset($_GET["page"])) {
    //unset($_GET["page"]);
    $_SESSION["page_number"]=$_GET["page"];

    echo("<script>location.replace('../Dai_news_page.html')</script>");
}
?>