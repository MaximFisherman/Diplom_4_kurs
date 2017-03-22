<?php
session_start();
include("../Classes/Class_base.php");
$obj = new Base();

    $uploaddir = 'File/Police_user_photo/';
    $uploadfile = $uploaddir . basename($_FILES['photo_police_user']['name']);

    if (move_uploaded_file($_FILES['photo_police_user']['tmp_name'] , $uploadfile)) {
        $type_file = pathinfo($uploadfile , PATHINFO_EXTENSION);
        $name_file = $uploaddir . "" . uniqid() . "." . $type_file;
        rename($uploadfile , $name_file);
        echo("<script>location.replace('../Dai_patrul_page.html')</script>");
    } else {
        echo "";
    }
if((isset($_POST['name']))){
    $obj->add_police_user($_POST['position'],
        $_POST['name'],
        $_POST['number_phone'],
        $_POST['email'],
        $_POST['police_department'],
        $_POST['number_cheton'],
        $_POST['password'],
        $name_file
    );
}

if(isset($_POST["id_change"])){
    $obj->Change_police_user($_POST['id_change']);
}

if(isset($_POST['id'])){
    $obj->remove_police_user($_POST['id']);
}


$obj->view_police_user($_POST['search_position'],$_POST['search_name'],$_POST['search_email'],$_POST['search_police_department'],$_POST['search_number_cheton']);
?>