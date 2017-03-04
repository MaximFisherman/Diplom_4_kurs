<?php
session_start();
include("../Classes/Class_base.php");
$obj = new Base();

if($_SESSION["page_number"]=='')
    $obj->view_table_news_police(1,$_POST["input_search_name"]);
else {
    $obj->view_table_news_police($_SESSION["page_number"],$_POST["input_search_name"]);
}
if(isset($_GET["page"])) {
    //unset($_GET["page"]);
    $_SESSION["page_number"]=$_GET["page"];

    echo("<script>location.replace('../Police_news_page.html')</script>");
}


//Удаление новости
if(isset($_GET["delete_news"])){
    $obj->delete_news($_GET['id_news']);
    echo("<script>location.replace('../Police_news_page.html')</script>");
}
?>