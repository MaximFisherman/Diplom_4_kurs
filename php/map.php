<?php
session_start();
require_once("../Classes/Class_base.php");
$obj = new Base();

if(isset($_POST["out_to_bd"]))
    $obj-> save_layers($_POST["out_to_bd"]);

if(isset($_POST["view_layers"]))
    $obj->select_layers();

if(isset($_POST["selectedItems"]))
    $obj->delete_layers($_POST["selectedItems"]);

?>