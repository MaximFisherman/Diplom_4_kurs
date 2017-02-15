<?php
include("../Classes/Class_base.php");
$obj = new Base();
	
if($obj->select_table_user_email_proverka(trim($_POST["email"])))
	echo("<script>
	$('#div_email').html('Не правильно введены данные');
	</script>
	");else{
		echo("
		<script>
	$('#div_email').html('');
	</script>");
	}
	
if($obj->select_table_user_number_proverka(trim($_POST["identify_number"])))
	echo("
	<script>
	$('#div_identify_number').html('Не правильно введены данные');
	</script>
	");else 
	{
		echo("
	<script>
	$('#div_identify_number').html('');
	</script>");
	}
	

		//echo("Есть совпадение ".$obj->select_table_user_email_proverka($_POST["email"])."   ".$_POST["email"]);
?>