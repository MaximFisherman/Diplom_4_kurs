<?php
header("Content-Type: text/html; charset=utf-8");
include("../Classes/Class_base.php");
session_start();
  require_once 'tcpdf/tcpdf.php'; // Подключаем библиотеку
  $_SESSION['kol_vx']+=1;//Подсчет количества  перезагрузок
  
if(isset($_POST['name_second_name_pollice'])&&$_SESSION['kol_vx']==1)
{

$obj = new Base();


	$_SESSION['name_second_name_pollice'] = $_POST['name_second_name_pollice'];
	$_SESSION['number_driver'] = $_POST['number_driver'];
	
	$_SESSION['date_prigody'] = $_POST["day"]."/".$_POST["month"]."/".$_POST["year"];
	$_SESSION['day'] = $_POST["day"];
	$_SESSION["month"]=$_POST["month"];
	$_SESSION["year"]=$_POST["year"];
	$_SESSION["hours"]=$_POST["hours"];
	$_SESSION["minutes"]=$_POST["minutes"];
	
	$_SESSION["place_writting_protokol"]=$_POST["place_writting_protokol"];
	$_SESSION["name_second_name_pollice"]=$_POST["name_second_name_pollice"];
	$_SESSION["second_name"]=$_POST["second_name"];
	$_SESSION["name_offender"]=$_POST["name_offender"];
	$_SESSION["middlename"]=$_POST["middlename"];
	$_SESSION["place_of_birth"]=$_POST["place_of_birth"];
	
	$_SESSION["itizenship"]=$_POST["itizenship"];
	$_SESSION["place_of_work"]=$_POST["place_of_work"];
	$_SESSION["place_of_living"]=$_POST["place_of_living"];
	$_SESSION["telephone_offender"]=$_POST["telephone_offender"];
	$_SESSION["offender"]=$_POST["offender"];
	$_SESSION["number_driver"]=$_POST["number_driver"];
	
	$_SESSION["number_car"]=$_POST["number_car"];
	$_SESSION["name_car"]=$_POST["name_car"];
	$_SESSION["car_owner"]=$_POST["car_owner"];
	$_SESSION["place_owner"]=$_POST["place_owner"];
	$_SESSION["what_happened"]=$_POST["what_happened"];
	
	$_SESSION["article"]=$_POST["article"];
	$_SESSION["part_article"]=$_POST["part_article"];
	$_SESSION["paragraph_article"]=$_POST["paragraph_article"];
	$_SESSION["witness_1"]=$_POST["witness_1"];
	$_SESSION["witness_2"]=$_POST["witness_2"];
	
	$_SESSION["day_incident"]=$_POST["day_incident"];
	$_SESSION["month_incident"]=$_POST["month_incident"];
	$_SESSION["year_incident"]=$_POST["year_incident"];
	$_SESSION["hour_incident"]=$_POST["hour_incident"];
	$_SESSION["minutes_incident"]=$_POST["minutes_incident"];
	
	$_SESSION["place_read_incident"]=$_POST["place_read_incident"];
	$_SESSION["Document"]=$_POST["Document"];
	$_SESSION["series_pasport"]=$_POST["series_pasport"];
	$_SESSION["number_pasport"]=$_POST["number_pasport"];
	
	$_SESSION["inspection"]=$_POST["inspection"];
	$_SESSION["tool_inspection"]=$_POST["tool_inspection"];
	$_SESSION["result_inspection"]=$_POST["result_inspection"];
	$_SESSION["witness_inspection_1"]=$_POST["witness_inspection_1"];
	$_SESSION["witness_inspection_2"]=$_POST["witness_inspection_2"];
	
	

$obj->add_fine_adm($_SESSION['date_prigody'],$_SESSION['number_driver'],$_SESSION["article"]);

$id_fine = $obj->id_fines($_SESSION['date_prigody'],$_SESSION['number_driver']);

$uploaddir = 'File/';
$uploadfile = $uploaddir . basename($_FILES['police_file']['name']);


echo '<pre>';
if (move_uploaded_file($_FILES['police_file']['tmp_name'], $uploadfile)) {
    echo "";
	$type_file=pathinfo($uploadfile, PATHINFO_EXTENSION);
	$name_file=$uploaddir."".uniqid().".".$type_file;
	rename($uploadfile, $name_file);
} else {
    echo "";
}

if(isset($_SESSION['number_driver']))
$obj->add_user_file($_SESSION['number_driver'],$name_file,$id_fine,"docaz_adm");

}

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

 $pdf->AddPage();
$pdf->SetXY(0, 0);
$pdf->Image('../images/Blank.jpg', 0, 0, 472, 600, '', '', '', false, 300, '', false, false, 0);


$pdf->SetFont('dejavusans', '', 10);
$pdf->writeHTMLCell(0, 0, 3.3, 21, $_SESSION['day'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 15, 21, $_SESSION['month'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 31, 20.5, substr($_SESSION['year'],2,4), 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 45, 20.5, $_SESSION['hours'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 60, 20.5, $_SESSION['minutes'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 72, 20.5, $_SESSION['place_writting_protokol'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 6, 27.5, $_SESSION['name_second_name_pollice'], 1, 1, 0, true, 'J');
$pdf->SetFont('dejavusans', '', 10);

$Full_name_offender= $_SESSION['second_name']." ". $_SESSION['name_offender']." ". $_SESSION['middlename'];
$pdf->writeHTMLCell(0, 0, 62, 35, $Full_name_offender, 1, 1, 0, true, 'J');

$pdf->SetFont('dejavusans', '', 9);
$pdf->writeHTMLCell(0, 0, 40, 43, $_SESSION['place_of_birth'], 1, 1, 0, true, 'J');

$pdf->writeHTMLCell(0, 0, 165, 43, $_SESSION['itizenship'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 45, 49.5, $_SESSION['place_of_work'], 1, 1, 0, true, 'J');


$str_place_of_living = $_SESSION["place_of_living"]; 
$str_1 = substr($str_place_of_living,0,38);
$str_1 =$str_1."-";
$str_2 = substr($str_place_of_living,38, strlen($str_place_of_living));

$pdf->writeHTMLCell(0, 0, 150, 49.5,$str_1 , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 3, 57,$str_2 , 1, 1, 0, true, 'J');


$pdf->writeHTMLCell(0, 0, 78, 56, $_SESSION['telephone_offender'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 130, 56, $_SESSION['offender'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 125, 63.4, $_SESSION['number_car'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 37, 63.4, $_SESSION['name_car'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 172, 63.4, $_SESSION['car_owner'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 20, 72, $_SESSION['place_owner'], 1, 1, 0, true, 'J');

//Разделение строки
$str_what_happend = $_SESSION['what_happened']; 
$str_1 = substr($str_what_happend,0,181);
$str_1 =$str_1."-";
$str_2 = substr($str_what_happend,181, 193);
$str_2 =$str_2;
$str_3 = substr($str_what_happend,193, 213);

$pdf->writeHTMLCell(0, 0, 2, 78, $str_1, 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 2, 85, $str_2, 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 2, 92, $str_3, 1, 1, 0, true, 'J');

$pdf->writeHTMLCell(0, 0, 38, 100, $_SESSION['article'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 165, 99.5, $_SESSION['part_article'], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 187, 99, $_SESSION['paragraph_article'], 1, 1, 0, true, 'J');

//Разделение строки
$str_witness = $_SESSION['witness_1']; 
$str_1 = substr($str_witness,0,152);
$str_1 =$str_1."-";
$str_2 = substr($str_witness,181, 193);

$pdf->writeHTMLCell(0, 0, 30, 106.5,$str_1 , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 2, 112,$str_2 , 1, 1, 0, true, 'J');

$str_witness = $_SESSION['witness_2']; 
$str_1 = substr($str_witness,0,152);
$str_1 =$str_1."-";
$str_2 = substr($str_witness,181, 193);

$pdf->writeHTMLCell(0, 0, 30, 118,$str_1 , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 2, 125,$str_2 , 1, 1, 0, true, 'J');


$ini_1=$_SESSION["second_name"];
$ini_1 = substr($ini_1,0, 1);

$name = $_SESSION["first_name"];

$ini_2=$_SESSION["middlename"];
$ini_2 = substr($ini_2,0, 1);

$str= $name."".$ini_1.".".$ini_2.".";
$pdf->writeHTMLCell(0, 0, 10, 140,$str , 1, 1, 0, true, 'J');


$pdf->writeHTMLCell(0, 0, 82, 139,$_SESSION["day_incident"] , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 90, 139,$_SESSION["month_incident"] , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 103, 138.5, substr($_SESSION['year_incident'],2,4), 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 120, 138.5, $_SESSION["hour_incident"], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 132, 138.5, $_SESSION["minutes_incident"], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 142, 138.5, $_SESSION["place_read_incident"], 1, 1, 0, true, 'J');

$pdf->writeHTMLCell(0, 0, 138, 167, $_SESSION["Document"], 1, 1, 0, true, 'J');

$pdf->writeHTMLCell(0, 0, 69, 204, $_SESSION["inspection"], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 100, 212, $_SESSION["tool_inspection"], 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 50, 220, $_SESSION["result_inspection"], 1, 1, 0, true, 'J');


$str_witness = $_SESSION['witness_inspection_1'];
$str_1 = substr($str_witness,0,152);
$str_1 =$str_1."-";
$str_2 = substr($str_witness,181, 193);

$pdf->writeHTMLCell(0, 0, 32, 231,$str_1 , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 2, 238.5,$str_2 , 1, 1, 0, true, 'J');



$str_witness = $_SESSION['witness_inspection_2'];
$str_1 = substr($str_witness,0,152);
$str_1 =$str_1."-";
$str_2 = substr($str_witness,181, 193);

$pdf->writeHTMLCell(0, 0, 32, 245,$str_1 , 1, 1, 0, true, 'J');
$pdf->writeHTMLCell(0, 0, 2, 252,$str_2 , 1, 1, 0, true, 'J');


$pdf->Output(__DIR__ . '/File/'.$id_fine.'.pdf', 'F');
if($_SESSION['kol_vx']==1)
{
	$file_pdf='File/'.$id_fine.'.pdf';
	if(isset($id_fine))
	$obj->add_user_file($_SESSION["number_driver"],$file_pdf,$id_fine,"blank_adm");
}
//Просмотр данных 
if(isset($_POST['view'])){
$pdf->Output(__DIR__ . 'File/'.$id_fine.'.pdf', 'I');
}
//Переход на главную страницу 
if(isset($_POST['exit']))
{
	unset($_SESSION['kol_vx']);
	unset($_SESSION['blank_adm']);
	echo('<SCRIPT>
document.location.replace("../Police_start_page_blank.html");
</SCRIPT>
');
}
echo('
<form action="download_blank_adm.php" method="post" enctype="multipart/form-data"> 
ваш файл успішно створений щоб його переглянути натисніть "Переглянути"
<input name="exit" type="submit" value="На попередню сторінку">
<input name="view" type="submit" value="Перегляд">
</form>
');
?>