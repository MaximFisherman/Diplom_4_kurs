<?php
session_start();

if (isset($_POST["signs"]))
    $_SESSION["signs"] = $_POST["signs"];

if (isset($_POST["business_telephone"]))
    $_SESSION["business_telephone"] = $_POST["business_telephone"];

if (isset($_POST["road_marking"]))
    $_SESSION["road_marking"] = $_POST["road_marking"];

if (isset($_SESSION["road_marking"])) {
    echo("<div id='road_marking_div'>");
    readfile('File_html/Road_marking.html');
    echo("</div>");
}


if (isset($_SESSION["signs"])) {
    echo("<div id='full_help_div'>");
    readfile('File_html/Full_help.html');
    echo("</div>");
}

if (isset($_SESSION["business_telephone"])) {
    echo("
<div id='business_telephone_div'>
<script>$(\"#Service_number\").addClass(\"active\")</script>
<p>
<center><h3>Телефоннi номери екстренного визову оперативних служб<h3></center><br>
01, 010, 011 - Пожежна служба (Безкоштовна)<br>
02, 020, 022 - Мiлiцiя (Безкоштовна)<br>
03, 030, 033 - Швидка медична допомога (Безкоштовна)<br>
04, 040, 044 -  Аварiйна газу (Безкоштовна)<br>
112 - Екстрена служба (Безкоштовна)<br>
</p>
</div>
");
    unset($_SESSION["road_marking"]);
    unset($_SESSION["signs"]);
}
?>
