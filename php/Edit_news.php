<?php
include("../Classes/Class_base.php");
$obj = new Base();
$name_file = $_POST["name_path_photo"];
if(isset($_FILES['photo_news']['tmp_name'])) {
    $uploaddir = 'File/Photo_news/';
    $uploadfile = $uploaddir . basename($_FILES['photo_news']['name']);

    if (move_uploaded_file($_FILES['photo_news']['tmp_name'], $uploadfile)) {
        $type_file = pathinfo($uploadfile, PATHINFO_EXTENSION);
        $name_file = $uploaddir . "" . uniqid() . "." . $type_file;
        rename($uploadfile, $name_file);
    } else {
        echo "File upload not working";
    }
}
$obj->edit_news($_POST['name_id_news'],$_POST["name_news"],$_POST["title_news"],$_POST["description_news"],$name_file,$_POST['type_news']);
echo("<script>location.replace('../Dai_news_page.html')</script>");
//echo($_POST['name_id_news']."   ".$_POST["name_news"]."  ".$_POST["title_news"]."  ".$_POST["description_news"]."  ".$name_file."   ".$_POST['type_news']);

?>