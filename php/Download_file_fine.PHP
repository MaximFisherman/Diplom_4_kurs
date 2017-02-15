<?PHP
$file = $_POST["id_fine"];
$file_sle=$_POST["id_fine"];
$file=$_POST["id_fine"];
if($file_sle[0]=="/")
$file=substr($_POST["id_fine"], 1);

  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream .pdf');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
?>