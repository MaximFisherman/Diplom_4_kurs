<?php
include("../Classes/Class_base.php");
$obj = new Base();

$uploaddir = 'File/Photo_news/';
$uploadfile = $uploaddir . basename($_FILES['photo_news']['name']);

if (move_uploaded_file($_FILES['photo_news']['tmp_name'] , $uploadfile)) {
    $type_file = pathinfo($uploadfile , PATHINFO_EXTENSION);
    $name_file = $uploaddir . "" . uniqid() . "." . $type_file;
    rename($uploadfile , $name_file);
} else {
    echo "";
}

if(isset($_POST["Title_news"])&&isset($_POST["Name_news"])&&isset($_POST["Description"])&&isset($name_file))
{
    $obj->add_new_news($_POST["Title_news"],$_POST["Name_news"],$_POST["Description"],$_POST["Type_news"],$name_file);
    echo("<script>location.replace('../Dai_news_page.html')</script>");
}
?>