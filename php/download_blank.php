<?php
header("Content-Type: text/html; charset=utf-8");
include("../Classes/Class_base.php");
session_start();
require_once 'tcpdf/tcpdf.php'; // Подключаем библиотеку
$_SESSION['kol_vx'] += 1;//Подсчет количества  перезагузок

if (isset($_POST['date_prigody']) && isset($_POST['driver_number_a']) && $_SESSION['kol_vx'] == 1) {

    $obj = new Base();


    $_SESSION['date_prigody'] = $_POST['date_prigody'];
    $_SESSION['time_prigody'] = $_POST['time_prigody'];
    $_SESSION['country_prigody'] = $_POST['country_prigody'];
    $_SESSION['place_prigody'] = $_POST['place_prigody'];
    $_SESSION['demage_health'] = $_POST['demage_health'];
    $_SESSION['krim_car_A_B'] = $_POST['krim_car_A_B'];
    $_SESSION['krim_car'] = $_POST['krim_car'];
    $_SESSION['any_people'] = $_POST['any_people'];
    $_SESSION['surname_strax_a'] = $_POST['surname_strax_a'];
    $_SESSION['name_strax_a'] = $_POST['name_strax_a'];
    $_SESSION['address_strax_a'] = $_POST['address_strax_a'];
    $_SESSION['pochta_index_strax_a'] = $_POST['pochta_index_strax_a'];
    $_SESSION['country_strax_a'] = $_POST['country_strax_a'];
    $_SESSION['tel_email_strax_a'] = $_POST['tel_email_strax_a'];
    $_SESSION['type_car_a'] = $_POST['type_car_a'];
    $_SESSION['number_car_a'] = $_POST['number_car_a'];
    $_SESSION['country_reg_car_a'] = $_POST['country_reg_car_a'];
    $_SESSION['number_trailer_a'] = $_POST['number_trailer_a'];
    $_SESSION['country_reg_trailer_a'] = $_POST['country_reg_trailer_a'];
    $_SESSION['Strax_com_name_a'] = $_POST['Strax_com_name_a'];
    $_SESSION['Strax_com_number_blank_a'] = $_POST['Strax_com_number_blank_a'];
    $_SESSION['Strax_com_number_green_card_a'] = $_POST['Strax_com_number_green_card_a'];
    $_SESSION['Strax_com_green_card_date_start_a'] = $_POST['Strax_com_green_card_date_start_a'];
    $_SESSION['Strax_com_green_card_date_end_a'] = $_POST['Strax_com_green_card_date_end_a'];
    $_SESSION['Strax_com_agen_a'] = $_POST['Strax_com_agen_a'];
    $_SESSION['Strax_com_name_agen_a'] = $_POST['Strax_com_name_agen_a'];
    $_SESSION['Strax_com_address_a'] = $_POST['Strax_com_address_a'];
    $_SESSION['Strax_com_country_a'] = $_POST['Strax_com_country_a'];
    $_SESSION['Strax_com_tel_email_a'] = $_POST['Strax_com_tel_email_a'];
    $_SESSION['Strax_com_pokritie_a'] = $_POST['Strax_com_pokritie_a'];
    $_SESSION['driver_surname_a'] = $_POST['driver_surname_a'];
    $_SESSION['driver_name_a'] = $_POST['driver_name_a'];
    $_SESSION['driver_address_a'] = $_POST['driver_address_a'];
    $_SESSION['driver_country_a'] = $_POST['driver_country_a'];
    $_SESSION['driver_birthday_a'] = $_POST['driver_birthday_a'];
    $_SESSION['driver_tel_email_a'] = $_POST['driver_tel_email_a'];
    $_SESSION['driver_number_a'] = $_POST['driver_number_a'];
    $_SESSION['driver_category_a'] = $_POST['driver_category_a'];
    $_SESSION['driver_date_end_a'] = $_POST['driver_date_end_a'];
    $_SESSION['crach_car_a'] = $_POST['crach_car_a'];
    $_SESSION['notatki_a'] = $_POST['notatki_a'];
    $_SESSION['surname_strax_b'] = $_POST['surname_strax_b'];
    $_SESSION['name_strax_b'] = $_POST['name_strax_b'];
    $_SESSION['address_strax_b'] = $_POST['address_strax_b'];
    $_SESSION['pochta_index_strax_b'] = $_POST['pochta_index_strax_b'];
    $_SESSION['country_strax_b'] = $_POST['country_strax_b'];
    $_SESSION['tel_email_strax_b'] = $_POST['tel_email_strax_b'];
    $_SESSION['type_car_b'] = $_POST['type_car_b'];
    $_SESSION['number_car_b'] = $_POST['number_car_b'];
    $_SESSION['country_reg_car_b'] = $_POST['country_reg_car_b'];
    $_SESSION['number_trailer_b'] = $_POST['number_trailer_b'];
    $_SESSION['country_reg_trailer_b'] = $_POST['country_reg_trailer_b'];
    $_SESSION['Strax_com_name_b'] = $_POST['Strax_com_name_b'];
    $_SESSION['Strax_com_number_blank_b'] = $_POST['Strax_com_number_blank_b'];
    $_SESSION['Strax_com_number_green_card_b'] = $_POST['Strax_com_number_green_card_b'];
    $_SESSION['Strax_com_green_card_date_start_b'] = $_POST['Strax_com_green_card_date_start_b'];
    $_SESSION['Strax_com_green_card_date_end_b'] = $_POST['Strax_com_green_card_date_end_b'];
    $_SESSION['Strax_com_agen_b'] = $_POST['Strax_com_agen_b'];
    $_SESSION['Strax_com_name_agen_b'] = $_POST['Strax_com_name_agen_b'];
    $_SESSION['Strax_com_address_b'] = $_POST['Strax_com_address_b'];
    $_SESSION['Strax_com_country_b'] = $_POST['Strax_com_country_b'];
    $_SESSION['Strax_com_tel_email_b'] = $_POST['Strax_com_tel_email_b'];
    $_SESSION['Strax_com_pokritie_b'] = $_POST['Strax_com_pokritie_b'];
    $_SESSION['driver_surname_b'] = $_POST['driver_surname_b'];
    $_SESSION['driver_name_b'] = $_POST['driver_name_b'];
    $_SESSION['driver_address_b'] = $_POST['driver_address_b'];
    $_SESSION['driver_country_b'] = $_POST['driver_country_b'];
    $_SESSION['driver_birthday_b'] = $_POST['driver_birthday_b'];
    $_SESSION['driver_tel_email_b'] = $_POST['driver_tel_email_b'];
    $_SESSION['driver_number_b'] = $_POST['driver_number_b'];
    $_SESSION['driver_category_b'] = $_POST['driver_category_b'];
    $_SESSION['driver_date_end_b'] = $_POST['driver_date_end_b'];
    $_SESSION['crach_car_b'] = $_POST['crach_car_b'];
    $_SESSION['notatki_b'] = $_POST['notatki_b'];

    $obj->add_fine_dtp($_SESSION['date_prigody'] , $_SESSION['driver_number_a']);
    $obj->add_fine_dtp($_SESSION['date_prigody'] , $_SESSION['driver_number_b']);

    $id_fine_a = $obj->id_fines($_SESSION['date_prigody'] , $_SESSION['driver_number_a']);
    $id_fine_b = $obj->id_fines($_SESSION['date_prigody'] , $_SESSION['driver_number_b']);

    $uploaddir = 'File/';
    $uploadfile = $uploaddir . basename($_FILES['plan_dtp']['name']);

    echo '<pre>';
    if (move_uploaded_file($_FILES['plan_dtp']['tmp_name'] , $uploadfile)) {
        echo "";

        $type_file = pathinfo($uploadfile , PATHINFO_EXTENSION);
        $name_file = $uploaddir . "" . uniqid() . "." . $type_file;
        rename($uploadfile , $name_file);
    } else {
        echo "";
    }

    if (isset($_SESSION['driver_number_a']))
        $obj->add_user_file($_SESSION['driver_number_a'] , $name_file , $id_fine_a , "plan_dtp");

    if (isset($_SESSION['driver_number_b']))
        $obj->add_user_file($_SESSION['driver_number_b'] , $name_file , $id_fine_b , "plan_dtp");


    $uploaddir = 'File/';
    $uploadfile = $uploaddir . basename($_FILES['police_file']['name']);


    echo '<pre>';
    if (move_uploaded_file($_FILES['police_file']['tmp_name'] , $uploadfile)) {
        echo "";
        $type_file = pathinfo($uploadfile , PATHINFO_EXTENSION);
        $name_file = $uploaddir . "" . uniqid() . "." . $type_file;
        rename($uploadfile , $name_file);
    } else {
        echo "";
    }

    if (isset($_SESSION['driver_number_b']))
        $obj->add_user_file($_SESSION['driver_number_b'] , $name_file , $id_fine_b , "docaz_dtp");

    if (isset($_SESSION['driver_number_a']))
        $obj->add_user_file($_SESSION['driver_number_a'] , $name_file , $id_fine_a , "docaz_dtp");

}

$pdf = new TCPDF('P' , 'mm' , 'A4' , true , 'UTF-8');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();
$pdf->SetXY(0 , 0);
$pdf->Image('tcpdf/Blank_DTP_PDF.jpg' , 0 , 0 , 472 , 600 , '' , '' , '' , false , 300 , '' , false , false , 0);

$s = $_SESSION['place_prigody'];//Входные данные для обрезки
$s1 = mb_substr($s , 0 , 29 , 'UTF-8');
$s2 = mb_substr($s , 29 , strlen($s) , 'UTF-8');


$pdf->SetFont('dejavusans' , '' , 10);
$pdf->writeHTMLCell(0 , 0 , 15 , 14 , $_SESSION['date_prigody'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 43 , 14 , $_SESSION['time_prigody'] , 1 , 1 , 0 , true , 'J');
$pdf->SetFont('dejavusans' , '' , 6);
$pdf->writeHTMLCell(0 , 0 , 65 , 14.5 , $_SESSION['country_prigody'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 96 , 11 , $s1 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 90 , 14.5 , $s2 , 1 , 1 , 0 , true , 'J');

if ($_SESSION['demage_health'] == "Yes")
    $pdf->writeHTMLCell(0 , 0 , 194 , 14.5 , "✓" , 1 , 1 , 0 , true , 'J');
if ($_SESSION['demage_health'] == "No")
    $pdf->writeHTMLCell(0 , 0 , 146 , 14.5 , "✓" , 1 , 1 , 0 , true , 'J');


if ($_SESSION['krim_car_A_B'] == "Yes")
    $pdf->writeHTMLCell(0 , 0 , 33.7 , 27.5 , "✓" , 1 , 1 , 0 , true , 'J');
if ($_SESSION['krim_car_A_B'] == "No")
    $pdf->writeHTMLCell(0 , 0 , 18.8 , 27.5 , "✓" , 1 , 1 , 0 , true , 'J');


if ($_SESSION['krim_car'] == "Yes")
    $pdf->writeHTMLCell(0 , 0 , 69.8 , 27.5 , "✓" , 1 , 1 , 0 , true , 'J');
if ($_SESSION['krim_car'] == "No")
    $pdf->writeHTMLCell(0 , 0 , 54.5 , 27.5 , "✓" , 1 , 1 , 0 , true , 'J');


$s = $_SESSION['any_people']; //Входные данные для обрезки Свидетели
$s1 = mb_substr($s , 0 , 65 , 'UTF-8');
$s2 = mb_substr($s , 65 , strlen($s) , 'UTF-8');

$pdf->writeHTMLCell(0 , 0 , 115 , 20 , $s1 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 80 , 23 , $s2 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 80 , 27 , $s3 , 1 , 1 , 0 , true , 'J');


////////Сторона А///////////////////////////////////////////////////
$pdf->writeHTMLCell(0 , 0 , 26 , 44 , $_SESSION['surname_strax_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 20 , 47.7 , $_SESSION['name_strax_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 23 , 51.5 , $_SESSION['address_strax_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 30 , 55.5 , $_SESSION['pochta_index_strax_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 50 , 55.5 , $_SESSION['country_strax_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 28 , 60.5 , $_SESSION['tel_email_strax_a'] , 1 , 1 , 0 , true , 'J');

$pdf->SetFont('dejavusans' , '' , 5);


$pdf->writeHTMLCell(0 , 0 , 11 , 76 , $_SESSION['type_car_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 11 , 83 , $_SESSION['number_car_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 11 , 90 , $_SESSION['country_reg_car_a'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 47 , 83 , $_SESSION['number_trailer_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 47 , 90 , $_SESSION['country_reg_trailer_a'] , 1 , 1 , 0 , true , 'J');


$pdf->SetFont('dejavusans' , '' , 6);
$pdf->writeHTMLCell(0 , 0 , 24 , 100 , $_SESSION['Strax_com_name_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 25 , 104 , $_SESSION['Strax_com_number_blank_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 37 , 107.7 , $_SESSION['Strax_com_number_green_card_a'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 41 , 115 , $_SESSION['Strax_com_green_card_date_start_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 58 , 115 , $_SESSION['Strax_com_green_card_date_end_a'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 48 , 118 , $_SESSION['Strax_com_agen_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 24 , 122 , $_SESSION['Strax_com_name_agen_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 24 , 126 , $_SESSION['Strax_com_address_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 50 , 130 , $_SESSION['Strax_com_country_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 30 , 135 , $_SESSION['Strax_com_tel_email_a'] , 1 , 1 , 0 , true , 'J');


if ($_SESSION['Strax_com_pokritie_a'] == "Yes")
    $pdf->writeHTMLCell(0 , 0 , 48.5 , 141.5 , "✓" , 1 , 1 , 0 , true , 'J');
if ($_SESSION['Strax_com_pokritie_a'] == "No")
    $pdf->writeHTMLCell(0 , 0 , 29.7 , 141.5 , "✓" , 1 , 1 , 0 , true , 'J');


$pdf->writeHTMLCell(0 , 0 , 30 , 152 , $_SESSION['driver_surname_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 25 , 156 , $_SESSION['driver_name_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 25 , 164 , $_SESSION['driver_address_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 50 , 168 , $_SESSION['driver_country_a'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 40 , 160 , $_SESSION['driver_birthday_a'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 30 , 172.5 , $_SESSION['driver_tel_email_a'] , 1 , 1 , 0 , true , 'J');

$pdf->SetFont('dejavusans' , '' , 5);
$pdf->writeHTMLCell(0 , 0 , 40 , 176 , $_SESSION['driver_number_a'] , 1 , 1 , 0 , true , 'J');

$pdf->SetFont('dejavusans' , '' , 6);
$pdf->writeHTMLCell(0 , 0 , 33 , 179.5 , $_SESSION['driver_category_a'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 44 , 183.5 , $_SESSION['driver_date_end_a'] , 1 , 1 , 0 , true , 'J');


$s = $_SESSION['crach_car_a'];//Входные данные для обрезки
$s1 = mb_substr($s , 0 , 20 , 'UTF-8');
$s2 = mb_substr($s , 20 , 25 , 'UTF-8');
//if(strlen($s1)>=38)$s1="dasaas";
$s3 = mb_substr($s , 30 , 150 , 'UTF-8');


$pdf->writeHTMLCell(0 , 0 , 13 , 230 , $s1 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 , 233.5 , $s2 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 , 236.5 , substr($s , 80 , 100) , 1 , 1 , 0 , true , 'J');


$s = $_POST['notatki_a'];//Входные данные для обрезки
$s1 = mb_substr($s , 0 , 40 , 'UTF-8');
$s2 = mb_substr($s , 40 , 50 , 'UTF-8');
$s3 = mb_substr($s , 50 , 180 , 'UTF-8');

$pdf->writeHTMLCell(0 , 0 , 13 , 248 , $s1 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 , 251 , $s2 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 , 254 , $s3 , 1 , 1 , 0 , true , 'J');


///////////////Сторона B////////////////////////////////////////
$znach = 125;


$pdf->writeHTMLCell(0 , 0 , 26 + $znach , 44 , $_SESSION['surname_strax_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 20 + $znach , 47.7 , $_SESSION['name_strax_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 23 + $znach , 51.5 , $_SESSION['address_strax_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 30 + $znach , 55.5 , $_SESSION['pochta_index_strax_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 50 + $znach , 55.5 , $_SESSION['country_strax_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 28 + $znach , 60.5 , $_SESSION['tel_email_strax_b'] , 1 , 1 , 0 , true , 'J');

$pdf->SetFont('dejavusans' , '' , 5);
$pdf->writeHTMLCell(0 , 0 , 11 + $znach , 76 , $_SESSION['type_car_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 11 + $znach , 83 , $_SESSION['number_car_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 11 + $znach , 90 , $_SESSION['country_reg_car_b'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 47 + $znach , 83 , $_SESSION['number_trailer_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 47 + $znach , 90 , $_SESSION['country_reg_trailer_b'] , 1 , 1 , 0 , true , 'J');

$znach = 122;
$pdf->SetFont('dejavusans' , '' , 6);
$pdf->writeHTMLCell(0 , 0 , 24 + $znach , 100 , $_SESSION['Strax_com_name_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 25 + $znach , 104 , $_SESSION['Strax_com_number_blank_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 37 + $znach , 107.7 , $_SESSION['Strax_com_number_green_card_b'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 41 + $znach , 115 , $_SESSION['Strax_com_green_card_date_start_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 58 + $znach , 115 , $_SESSION['Strax_com_green_card_date_end_b'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 48 + $znach , 118 , $_SESSION['Strax_com_agen_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 24 + $znach , 122 , $_SESSION['Strax_com_name_agen_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 24 + $znach , 126 , $_SESSION['Strax_com_address_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 50 + $znach , 130 , $_SESSION['Strax_com_country_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 30 + $znach , 135 , $_SESSION['Strax_com_tel_email_b'] , 1 , 1 , 0 , true , 'J');

$znach = 123;
if ($_SESSION['Strax_com_pokritie_b'] == "Yes")
    $pdf->writeHTMLCell(0 , 0 , 48.5 + $znach , 141.5 , "✓" , 1 , 1 , 0 , true , 'J');
if ($_SESSION['Strax_com_pokritie_b'] == "No")
    $pdf->writeHTMLCell(0 , 0 , 29.7 + $znach , 141.5 , "✓" , 1 , 1 , 0 , true , 'J');

$znach = 122;
$pdf->writeHTMLCell(0 , 0 , 30 + $znach , 152 , $_SESSION['driver_surname_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 25 + $znach , 156 , $_SESSION['driver_name_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 25 + $znach , 164 , $_SESSION['driver_address_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 50 + $znach , 168 , $_SESSION['driver_country_b'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 40 + $znach , 160 , $_SESSION['driver_birthday_b'] , 1 , 1 , 0 , true , 'J');

$pdf->writeHTMLCell(0 , 0 , 30 + $znach , 172.5 , $_SESSION['driver_tel_email_b'] , 1 , 1 , 0 , true , 'J');

$pdf->SetFont('dejavusans' , '' , 5);
$pdf->writeHTMLCell(0 , 0 , 40 + $znach , 176 , $_SESSION['driver_number_b'] , 1 , 1 , 0 , true , 'J');

$pdf->SetFont('dejavusans' , '' , 6);
$pdf->writeHTMLCell(0 , 0 , 33 + $znach , 179.5 , $_SESSION['driver_category_b'] , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 44 + $znach , 183.5 , $_SESSION['driver_date_end_b'] , 1 , 1 , 0 , true , 'J');

$znach = 155;
$s = $_SESSION['crach_car_b'];//Входные данные для обрезки
$s1 = mb_substr($s , 0 , 20 , 'UTF-8');
$s2 = mb_substr($s , 20 , 30 , 'UTF-8');
//if(strlen($s1)>=38)$s1="dasaas";
$s3 = mb_substr($s , 30 , 150 , 'UTF-8');


$pdf->writeHTMLCell(0 , 0 , 13 + $znach , 230 , $s1 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 + $znach , 233.5 , $s2 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 + $znach , 236.5 , substr($s , 80 , 100) , 1 , 1 , 0 , true , 'J');

$znach = 130;
$s = $_SESSION['notatki_b'];//Входные данные для обрезки
$s1 = mb_substr($s , 0 , 40 , 'UTF-8');
$s2 = mb_substr($s , 40 , 50 , 'UTF-8');
$s3 = mb_substr($s , 50 , 180 , 'UTF-8');

$pdf->writeHTMLCell(0 , 0 , 13 + $znach , 248 , $s1 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 + $znach , 251 , $s2 , 1 , 1 , 0 , true , 'J');
$pdf->writeHTMLCell(0 , 0 , 13 + $znach , 254 , $s3 , 1 , 1 , 0 , true , 'J');


$pdf->Output(__DIR__ . '/File/' . $_SESSION['number_car_a'] . '-' . $_SESSION['number_car_b'] . '.pdf' , 'F');
if ($_SESSION['kol_vx'] == 1) {
    $file_pdf = '/File/' . $_SESSION['number_car_a'] . '-' . $_SESSION['number_car_b'] . '.pdf';
    if (isset($_SESSION['driver_number_a']))
        $obj->add_user_file($_SESSION['driver_number_a'] , $file_pdf , $id_fine_a , "blank_dtp");

    if (isset($_SESSION['driver_number_b']))
        $obj->add_user_file($_SESSION['driver_number_b'] , $file_pdf , $id_fine_b , "blank_dtp");
}
//Просмотр данных
if (isset($_POST['view'])) {
    $pdf->Output(__DIR__ . 'File/' . $_SESSION['number_car_a'] . '-' . $_SESSION['number_car_b'] . '.pdf' , 'I');
}
//Переход на главную страницу
if (isset($_POST['exit'])) {
    unset($_SESSION['kol_vx']);
    unset($_SESSION['blank_dtp']);
    echo('<SCRIPT>
document.location.replace("../Police_start_page_blank.html");
</SCRIPT>
');
}
echo('
<form action="download_blank.php" method="post" enctype="multipart/form-data"> 
ваш файл успішно створений щоб його переглянути натисніть "Переглянути"
<input name="exit" type="submit" value="На попередню сторінку">
<input name="view" type="submit" value="Перегляд">
</form>
');
?>