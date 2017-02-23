<?php 
session_start();


class Base 
{
	public $dlink;
	public $ERROR;//Ошибки в БД
	function __construct()
	{
		$user='root';
		$host='localhost';
		$pas='';
		$this->dlink=mysql_connect($host,$user,$pas);
		if(!$this->dlink)
			$ERROR="Not have connect Base";else 
		mysql_select_db('kvark');
	}
	//добавление пользователя в БД
	function add_user($type_user,$number,$email,$number_phone,$place_living,$first_name,$second_name,$password,$car_number_user,$length)
	{
		$str="INSERT INTO user (type_user,email,number_phone,place_living,first_name,second_name,number,password) VALUES('".$type_user."','".$email."','".$number_phone."','".$place_living."','".$first_name."','".$second_name."','".$number."','".$password."');";
		$rez=mysql_query($str,$this->dlink);
		
		for($i=1;$i<=$length;$i++)
		{
			echo("KOl ".$i.": ".$car_number_user[$i]."<br> number: ".$number."<br>");
			$str="INSERT INTO car_number (number,car_number) VALUES('".$number."','".$car_number_user[$i]."');"; 	
			if(mysql_query($str,$this->dlink))
				echo("OK");else echo("You have some problem");
		}
	}
	
	//Просмотр таблицы для нахождения совпадений номера(логина)
	function select_table_user_number_proverka($number){
		$str='Select number from user where number like "%'.$number.'%";';
		$res= mysql_query($str,$this->dlink);
		$sovp=null;
			while($arr = mysql_fetch_array($res)){
                $sovp=$arr['number'];				
				}
	  return $sovp;
	}
	
	//Просмотр таблицы для нахождения совппадений email
	function select_table_user_email_proverka($email){
	$str='Select email from user where email like "%'.$email.'%";';
		$res= mysql_query($str,$this->dlink);
		$sovp=null;
			while($arr = mysql_fetch_array($res)){
                $sovp=$arr['email'];				
				}
	  return $sovp;
	}
	
	//Механизм авторизации 
	function authorization($login,$password){
		$str='Select number,type_user,password from user where number like "%'.trim($login).'%";';
		$res= mysql_query($str,$this->dlink);
		while($arr = mysql_fetch_array($res)){
                $number=$arr['number'];	
				$password_bd=$arr['password'];	
				$type_user=$arr['type_user'];				
		} 
		
		if($login==$number&&$password==$password_bd&&$type_user=="dai")
		{ 
			$_SESSION["avt_user"]=$number;
			echo"<script>document.location.replace('Dai_start_page.html');</script>";
		}else{
	
		}
		
		if($login==$number&&$password==$password_bd&&$type_user=="police")
		{ 
			$_SESSION["avt_user"]=$number;
			echo"<script>document.location.replace('Police_start_page_blank.html');</script>";
		}else{
		
		}
		
		if($login==$number&&$password==$password_bd&&$type_user=="user")
		{
			$_SESSION["avt_user"]=$number;
			echo"<script>document.location.replace('User_start_page_fines.html');</script>";
		}else{
			
		}
		echo"<script>document.location.replace('Authorization_page.html');</script>";
		
	}
	
	//Функция которая сохраняет информацию о местонахождении файлов пользователя
	function add_user_file($user_number,$path_file,$id_fine,$type_document)
	{
		$str="INSERT INTO Path_file_fine (number, path_name,id_fine,type_document) VALUES ('".$user_number."','".$path_file."',".$id_fine.",'".$type_document."');";
		mysql_query($str,$this->dlink);
	}
	
	//Вывод списка штрафов
	function Select_fines_DTP($search_number,$search_date)
	{
		$str="Select number,date,article,id_fine from fines_dtp";
		
		
		if($search_number!="")
			$str="Select number,date,article from fines_dtp where number like '%".$search_number."%'";
		if($search_date!="")
			$str="Select number,date,article from fines_dtp where date like '%".$search_date."%'";
		$res= mysql_query($str,$this->dlink);
	echo("<BR>
	<table id='acrylic' >
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Статья</th>
                    <th>Номер посвідчення</th>
					<th>Справа</th>
                </tr>
            </thead>
			<tbody>
	");
	$i=0;
	while($arr = mysql_fetch_array($res)){
				echo("
				<tr>
                    <td data-label=\"Дата\">".$arr['date']."</td>");
					if($arr['article']==null)
                    echo("<td data-label=\"Статья\">(статья не визначена)</td>");else
						echo("<td data-label=\"Статья\">".$arr['article']."</td>");
					echo("
                    <td data-label=\"number\">".$arr['number']."</td>
                    <td data-label=\"Подробнее\">
					<form action='php/Download_files_dai.php' method='POST'>
					<submit type='button' id='".$arr['number']."' onclick=\"Read_more();\" class=\"id_class btn btn-default \">Змінити</submit>
					
					<input type='submit' value='Файли по справі' class='btn btn-primary'>
					<input type='hidden' name='id_fine' value='".$arr["id_fine"]."'>
					</form>
					</td>
                </tr>
				");	
$i++;				
		} 
		
	echo("          
	</tbody>
        </table>
    </div>
   </div>");
	}
	
	
	function select_one_fines_dtp($number){
		$str="Select number,article,date from fines_dtp where number like '%".$number."%';";
		$res= mysql_query($str,$this->dlink);
	while($arr = mysql_fetch_array($res)){
				echo("
				<br><br><br><br><br>
					Номер водійского посвідчення: <input type='text' name='number_fine' class='form-control' value='".$arr['number']."' /><br><br>
					Дата події       			: <input type='text' name='date_fine' class='form-control' value='".$arr['date']."' /><br><br>
					Статья          			: <input type='text' name='article_fine' class='form-control' value='".$arr['article']."' /><br>
				");		
		echo("<input type='button' onclick='Change_fine();' class='btn btn-primary' value='Змінити данні'/>");
		} 
	}
	
	function update_one_fines_dtp($number,$date,$article){
		$str="UPDATE `fines_dtp` SET `article`='".$article."',`number`='".$number."',`date`='".$date."' WHERE number like '%".$number."%'";
		mysql_query($str,$this->dlink);
	}
	
	function add_fine_dtp($date,$number){
		$str="INSERT INTO `fines_dtp`(`number`, `date`, type) VALUES ('".$number."','".$date."','dtp')";
		 mysql_query($str,$this->dlink);
	}
	
	function add_fine_adm($date,$number,$article){
		$str="INSERT INTO `fines_dtp`(`number`, `date`, type,article) VALUES ('".$number."','".$date."','adm','".$article."')";
		 mysql_query($str,$this->dlink);
	}
	
	 function id_fines($date,$number){
		$str="Select id_fine,number,date from fines_dtp where number like '%".$number."%' and date like '%".$date."%';";
		$res= mysql_query($str,$this->dlink);
	while($arr = mysql_fetch_array($res)){
				 return  $arr['id_fine'];
		} 
	}

	
	//Функция вывода на экран пользователю его правонарушений
	function Select_user_fines($number)
	{
		$str="Select email,number_phone,place_living,first_name,second_name,number from user where number like '%".$number."%' and type_user like 'user';";
		$res= mysql_query($str,$this->dlink);
	while($arr = mysql_fetch_array($res)){
					
					echo("
					<script type='text/javascript'>
					$('#first_name').text('Им\'я: ".$arr["first_name"]."');
					$('#second_name').text('Фамілія: ".$arr["second_name"]."');
					$('#driver_number').text('Номер ВУ: ".$arr["number"]."');
					$('#number_phone').text('Номер телефону: ".$arr["number_phone"]."');
					</script>
					");		
		} 
		
	$str="Select number,car_number from car_number where number like '%".$number."%';";
	$res= mysql_query($str,$this->dlink);
	$i=0;
	while($arr = mysql_fetch_row($res)){
		$i++;
		echo("
					<script type='text/javascript'>
					$('#number_car_user').append('<br>Автомобиль ".$i.": &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$arr[1]."');
					</script>
					");		
	} 

		
		$str="Select number,date,article,type,id_fine from fines_dtp where number like '%".$number."%' ";
		$res= mysql_query($str,$this->dlink);
	echo("<BR>
	<table id='acrylic' >
            <thead>
                <tr>
                    <th>Дата</th>
					<th>Тип правонарушения</th>
                    <th>Статья</th>
                    <th>Номер посвідчення</th>
					<th>Файли по справі</th>
                </tr>
            </thead>
			<tbody>
			
			
	");
	$i=0;
	while($arr = mysql_fetch_array($res)){
				echo("
				<tr>
                    <td data-label=\"Дата\">".$arr['date']."</td>");
					if($arr['type']=="dtp")
						echo("<td data-label=\"Статья\">ДТП</td>");else
							echo("<td data-label=\"Статья\">Адміністративне правопорушення</td>");
					
					if($arr['article']==null)
                    echo("<td data-label=\"Статья\">(статья не визначена)</td>");else
						echo("<td data-label=\"Статья\">".$arr['article']."</td>");
					echo("
                    <td data-label=\"number\">".$arr['number']."</td>
                    <td data-label=\"Подробнее\">
					<form action='php/Download_files_user.php' method='POST'>
					<input type='submit' value='Файли по справі' class='btn btn-warning'>
					<input type='hidden' name='id_fine' value='".$arr["id_fine"]."'>
					</form> 
					</td>
					
                </tr>
				");	
$i++;				
		} 
		
	echo("      
   
	</tbody>
        </table>
    </div>
   </div>");
	}
	
	function view_file($id_fine){
		$str="Select path_name,number,date,type_document,id_fine from Path_file_fine where id_fine like '%".$id_fine."%'";
		
		$res= mysql_query($str,$this->dlink);
	echo("<BR>
	<table id='acrylic' >
            <thead>
                <tr>
                    <th>Дата</th>
					<th>Тип файла</th>
					<th>Файл</th>
                </tr>
            </thead>
			<tbody>
			
			
	");
	$i=0;
	while($arr = mysql_fetch_array($res)){
				echo("
				<tr>
                    <td>".$arr['date']."</td>");

					if($arr['type_document']=="plan_dtp")
						echo("<td data-label=\"Статья\">План ДТП</td>");
					if($arr['type_document']=="docaz_dtp")
						echo("<td data-label=\"Статья\">Видео-фото доказ</td>");
					if($arr['type_document']=="blank_dtp")
						echo("<td data-label=\"Статья\">Бланк ДТП</td>");
                    if($arr['type_document']=="docaz_adm")
                        echo("<td data-label=\"Статья\">Видео-фото доказ</td>");
                    if($arr['type_document']=="blank_adm")
                        echo("<td data-label=\"Статья\">Бланк адміністративного правопорушення</td>");

					echo("
                    <td data-label=\"закачаты\">
					<form action='Download_file_fine.php' method='POST'>
					<input type='submit' value='Відкрити' id='".$arr['path_name']."' onclick='file_click();' class='id_file btn btn-warning'>
					<input type='hidden' name='id_fine' value='".$arr["path_name"]."'>
					</FORM>
					
					</td>
				</tr>
				");	
$i++;				
		} 
		
	echo("      
   
	</tbody>
        </table>
    </div>
   </div>");
	}
/////////////////////////////////////Police_user//////////////////////////////////////////////////////////////////////////////////////
	function add_police_user($position,$name,$number_phone,$email,$police_department,$number_cheton,$password,$name_file){
        $str="INSERT INTO user (type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo) VALUES('police','".$email."','".$number_phone."','".$name."','".$number_cheton."','".$password."','".$police_department."','".$position."','".$name_file."');";
		mysql_query($str,$this->dlink);
    }

    function remove_police_user($number){
        $str="Delete from user where number like '".$number."'";
        mysql_query($str,$this->dlink);
    }
    function view_police_user($position,$name,$email,$police_department,$number_cheton){
        $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' ";

        if($position!="")
            $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' and position like '%".$position."%' ";
        if($name!="")
            $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' and first_name like '%".$name."%' ";
        if($email!="")
            $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' and email like '%".$email."%' ";
        if($police_department!="")
            $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' and police_department like '%".$police_department."%' ";
        if($number_cheton!="")
            $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' and number like '%".$number_cheton."%' ";

        $res= mysql_query($str,$this->dlink);
	    echo(' 
 <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12"  >
                        <table class="table table-hover table-striped">
                        <tbody> ');

        while($arr = mysql_fetch_array($res)) {
            echo('          <tr>
                            <td>
                                <h4>
                                    <b>' . $arr['position'] . '</b>
                                </h4>
                                <p></p>
                            </td>
                            <td>
                                <img src="php/'.$arr['path_user_police_photo'].'" class="img-circle" width="60">
                            </td>
                            <td>
                                <h4>
                                    <b>' . $arr['first_name'] . '</b>
                                </h4>
                                <a href="#"> ' . $arr['email'] . '</a>
                            </td>
                            <td> <h4>Номер жетона:' . $arr['number'] . '</h4></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-default id_class" value="left" type="button" onclick="Delete_user_police();" id="'.$arr['number'].'">
                                        <i class="fa fa-fw s fa-remove"></i>Удалить</button>
                                    
                                    <a class="btn btn-primary id_class" data-toggle="modal" data-target="#usuario" onclick="Change_user_police();" id="'.$arr['number'].'"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Правка</a>

                                </div>
                            </td>
                        </tr>
            ');
        }
                    echo('</tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
');
    }



    function add_new_news($title,$name,$description,$type_news,$path_file){
            $str="Insert into News(Name,Article,Description,Path_photo,type_news) VALUES ('".$name."','".$title."','".$description."','".$path_file."','".$type_news."');";
            mysql_query($str,$this->dlink);
    }

    function view_table_news($number_page){
        //Высчитываем общее количество страниц
        $str="Select id_news,Name,Article,Description,Path_photo,type_news from News";
        $res= mysql_query($str,$this->dlink);
        $col_rows=mysql_num_rows($res);


        //Постраничное отображение
        $count = 10;// Количество записей на странице.
        $shift = $count * ($number_page - 1);// Смещение в LIMIT. Те записи, порядковый номер которого больше этого числа, будут выводиться.
        $str="Select id_news,Name,Article,Description,Path_photo,type_news from News limit ".$shift.",".$count.";";
        $res= mysql_query($str,$this->dlink);




        while($arr = mysql_fetch_array($res)) {
            if (trim($arr["type_news"]) == "Угон автомобiля") echo("<tr class=\"Car_wanted\">");
            if (trim($arr["type_news"]) == "Людина в розшуку") echo("<tr class=\"Criminals_wanted\">");
            if (trim($arr["type_news"]) == "Зниклий безвiсти") echo("<tr class=\"Missing_people\">");
            $sub_description =  substr($arr["Description"],0,50);
            echo(" 
                                <tr class=\"Missing_people\">
                                    <td class=\"avatar\"><img src=\"php/" . $arr["Path_photo"] . "\"></td>
                                    <td>" . $arr["Name"] . "</td>
                                    <td>" . $arr["Article"] . "</td>
                                    <td>" .$sub_description. " </td>
                                    <td align=\"center\">
                                        <a href=\"#\" class=\"btn btn-primary\" title=\"Edit\"   id='" . $arr["id_news"] . "' ><i class=\"fa fa-pencil\">    	</i></a>
                                        <a href=\"#\" class=\"btn btn-warning\" title=\"Прочитати\"	id='" . $arr["id_news"] . "' ><i class=\"glyphicon glyphicon-folder-open\"   ></i></a>
                                        <a href=\"#\" class=\"btn btn-danger\"  title=\"delete\" id='" . $arr["id_news"] . "' ><i class=\"fa fa-trash\" >		</i></a>
                                    </td>
                                </tr>");
        }

            $col_page = $col_rows / 10;

            for ($i = 0; $i <= $col_page; $i++) {
                $count_page = $i + 1;
                echo("<script>$('#position_page').append('<li id=\"".$count_page."\"> <a  href=\"php/Table_view_news.php?page=" . $count_page . " \">" . $count_page . "</a></li>');</script>");
            }
            $number_page += 1;
            echo("<script>$('#position_page').append('<li><a href=\"php/Table_view_news.php?page=" . $number_page . " \">»</a></li>');</script>");
            //echo("<script>$('#position_page').append('<li ><a>«</a></li><li class=\"active\"><a href=\"#\">1</a></li><li ><a href=\"#\">2</a></li> <li ><a href=\"#\">3</a></li><li ><a>»</a></li>');</script>"); }
        }

    function Change_police_user($number){
        $str="Select type_user,email,number_phone,first_name,number,password,police_department,position,path_user_police_photo from user where type_user like '%police%' and number like '%".$number."%'";
        $res= mysql_query($str,$this->dlink);
        while($arr = mysql_fetch_array($res)) {
            echo("<script> $('#email').text('".$arr["email"]."');</script>");
        }
    }

	function __destruct ()
	{
		mysql_close($this->dlink);
	}
	
	function view_eror()
	{
	echo ($this->ERROR);
	}
}
?>