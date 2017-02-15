<?php
session_start();
require_once("../Classes/Class_base.php");

$obj = new Base();

if(isset($_POST["click_change_fine"]))
{
	$obj->update_one_fines_dtp($_POST["number_fine"],$_POST["date_fine"],$_POST["article_fine"]);
}






if(isset($_SESSION['id']))
{
	$obj->select_one_fines_dtp($_SESSION['id']);
	
}

echo('
<div class="container">
    <div class="row">
        <div class="text-center">
<br><br>
Дата:
<input type="text" name="date" class="example-text-input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Номер посвідчення: <input type="text" name="number" class="example-text-input">
<input type="button" name="article_fine" onclick="Search_fine();" class="btn btn-primary" value="Шукати" >
</div>
</div>
</div>
');



$obj-> Select_fines_DTP($_POST["search_number"],$_POST["search_date"]);
if(isset($_POST['id']))
{
	$_SESSION['id']=$_POST['id'];
}



?>