<?php
session_start();
unset($_SESSION['kol_vx']);
//Проверка нажатия на кнопку открыть бланк ДТП
if(isset($_POST['blank_dtp']))
$_SESSION['blank_dtp']=$_POST['blank_dtp'];

//Нажатие на кнопку открыть обычный бланк
if(isset($_POST['blank']))
    $_SESSION['blank']=$_POST['blank'];

//Проверка нажатия нажатия клавиши выйти в бланке ДТП
if(isset($_POST['blank_exit_dtp']))
    unset($_SESSION['blank_dtp']);

//Проверка нажатия нажатия клавиши выйти в обычном бланке
if(isset($_POST['blank_exit']))
    unset($_SESSION['blank']);


if(isset($_SESSION['blank']))
{
    readfile('Blank.html');
    //Возврат со странички бланка
    echo("<script>
    function click_exit_blank() {
        var exit1 = \"exit\";
        $.post(\"php/Open_blank_form.php\", {blank_exit: exit1}, function (str) {
            $('#div_blank').html(str);
        });
    }
</script>");
unset($_SESSION['blank_dtp']);
}

//Проверка входа в бланк ДТП
if(isset($_SESSION['blank_dtp']))
{
    readfile('Blank_DTP.html');
    //Возврат со странички бланка
echo("<script>
$('#h1_type_document').html(\"\");
    function click_exit_blank_dtp() {
        var exit1 = \"exit\";
        $.post(\"php/Open_blank_form.php\", {blank_exit_dtp: exit1}, function (str) {
            $('#div_blank').html(str);
        });
    }
</script>");
unset($_SESSION['blank']);
}

//Выход из бланка
if(($_SESSION['blank']==null)&&($_SESSION['blank_dtp']==null))
{
    echo("<script>
$('#h1_type_document').html(\"Тип документа\");
        </script>");

    echo('
 <div class="container" style=""  id="div_blank">
                <div class="row ">
                        <ul class="ds-btn" style="list-style-type: none;">
                            <li>
                                <a class="btn btn-lg btn-primary blanki" style="" onclick="click_prosto_blank();">
                                    <img src="/images/Blank.jpg" style="" class="img_blank img-fluid">
                                    <span>Протокол правонарушения</span>
                                </a>
                            </li>
                            <li>
                                <a class="btn btn-lg btn-primary blanki" style="" onclick="click_blank_DTP();">
                                    <img src="/images/Blank_DTP.jpg" style="" class="img_blank img-fluid" ><span>Протокол ДТП<br></span>
                                </a>
                            </li>
                        </ul>
                    </div>
    </div>
   ');
}

?>