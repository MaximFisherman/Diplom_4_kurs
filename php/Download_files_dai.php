<?php
session_start();

if(isset($_POST["id_file"]))
{
	$file_sle=$_POST["id_file"];
	$file=$_POST["id_file"];
	if($file_sle[0]=="/")
	$file=substr($_POST["id_file"], 1);

}
 
 require_once("../Classes/Class_base.php");
$obj = new Base();

if(isset($_POST["id_fine"]))
{$obj->view_file($_POST['id_fine']);}
echo("<input type='button' value='<- повернутись до голоовного вікна' class='btn btn-warning' onclick='exit_file_menu();'>")
?>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Page user</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	
    <style type="text/css">
   @import url("../css/User_start_page.css");
	</style>

  </head>
  <body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
<script>
function exit_file_menu()
{
	document.location.replace("../Dai_start_page.html");
}
</script>
   </body>
</html>