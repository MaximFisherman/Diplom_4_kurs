<?php 
session_start();

if(isset($_POST["signs"]))
	$_SESSION["signs"]=$_POST["signs"];

if(isset($_POST["business_telephone"]))
	$_SESSION["business_telephone"]=$_POST["business_telephone"];

if(isset($_SESSION["signs"])){
readfile('File_html/Full_help.html');
}

if(isset($_SESSION["business_telephone"])){
echo("
<p>
<center><h3>Телефоннi номери екстренного визову оперативних служб<h3></center><br>
01, 010, 011 - Пожежна служба (Безкоштовна)<br>
02, 020, 022 - Мiлiцiя (Безкоштовна)<br>
03, 030, 033 - Швидка медична допомога (Безкоштовна)<br>
04, 040, 044 -  Аварiйна газу (Безкоштовна)<br>
112 - Екстрена служба (Безкоштовна)<br>
</p>

");
unset($_SESSION["signs"]);
}

?>
