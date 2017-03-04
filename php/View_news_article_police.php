

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ДПС</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        @import url("../css/Dai_news_form.css");
    </style>

</head>
<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<form class="form-horizontal" action="Edit_news.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <!-- Form Name -->
        <legend align="center" id="header_change">Редагування новини</legend>
        <!--image news-->
        <div class="form-group" style="text-align: center;">
            <img src="" id="image_news" height='400' width='600' align="center">
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="first_name">Заголовок</label>
            <div class="col-md-4">
                <input id="title_news_id" name="title_news" type="text" placeholder="" class="form-control input-md">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="tel">Им'я(марка)</label>
            <div class="col-md-4">
                <input id="name_news_id" name="name_news" type="text" placeholder="" value='' class="form-control input-md">
            </div>
        </div>


        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="comment1">Опис новини</label>
            <div class="col-md-4">
                <textarea class="form-control" id="description_news_id" name="description_news" rows="10" cols="45" ></textarea>
            </div>
        </div>

        <!-- List type -->
        <div class="form-group">
            <label class="col-md-4 control-label" >Тип новини</label>
            <div class="col-md-4">
                <select name="type_news" id="List_type_news" class="form-control">
                    <option value="Угон автомобiля">Угон автомобiля</option>
                    <option value="Людина в розшуку">Людина в розшуку</option>
                    <option value="Зниклий безвiсти"> Зниклий безвiсти </option>
                </select>
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group" id="button_save_file_photo_news">
            <label class="col-md-4 control-label">Додаток</label>
            <div class="col-md-5" >
                Фото: <input name="photo_news" enctype="multipart/form-data" multiple type="file" />
            </div>
        </div>

        <!-- Submit input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="tel"></label>
            <div class="col-md-4" id="button_save_edit_news">
                <input type="submit"   value="Сохранити" class="btn btn-danger form-control input-md">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
					<span class="button-checkbox">
						<a href="../Police_news_page.html" class="btn btn-warning" data-color="info" tabindex="7">&#8592; Повернутись</a>
                        <input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="1">
					</span>
            </div>
        </div>
        <!--Скрытое поле для передачи Id_news -->
        <input type="hidden" id="id_news" name="name_id_news" value="">
        <input type="hidden" id="id_path_photo" name="name_path_photo" value="">
    </fieldset>
</form>
</body>
</html>


<?php
if($_GET["file"]==1) {
    echo("<script>$('#id_news').val('" . $_GET['id_news'] . "');</script>");
    echo("<script>$('#image_news').attr('src','../php/" . $_GET['path_photo'] . "')</script>");
    echo("<script>$('#id_path_photo').val('../php/" . $_GET['path_photo']."')</script>");
    echo("<script>$('#description_news_id').text('" . $_GET['description_news'] . "');</script>");
    echo("<script>$('#name_news_id').val('" . $_GET['name_news'] . "');</script>");
    echo("<script>$('#title_news_id').val('" . $_GET['title_news'] . "');</script>");

    //Проверка типа новосте  и вывод соотвествуйщего типа новости
    if ($_GET["type_news"]==1){
        echo("<script>  $('#List_type_news :nth-child(1)').attr('selected', 'selected');</script> ");
    }

    if ($_GET["type_news"]==2) {
        echo("<script>  $('#List_type_news :nth-child(2)').attr('selected', 'selected');</script> ");
    }
    if ($_GET["type_news"]==3) {
        echo("<script>  $('#List_type_news :last').attr('selected', 'selected');</script> ");
    }
}

if($_GET["file"]==2) {
    echo("<script>$('#id_news').val('" . $_GET['id_news'] . "');</script>");
    echo("<script>$('#image_news').attr('src','../php/" . $_GET['path_photo'] . "')</script>");
    echo("<script>$('#id_path_photo').val('../php/" . $_GET['path_photo']."')</script>");
    echo("<script>$('#description_news_id').text('" . $_GET['description_news'] . "');</script>");
    echo("<script>$('#name_news_id').val('" . $_GET['name_news'] . "');</script>");
    echo("<script>$('#title_news_id').val('" . $_GET['title_news'] . "');</script>");


    echo("<script> $('#title_news_id').attr('disabled', true);</script>");
    echo("<script> $('#name_news_id').attr('disabled', true);</script>");
    echo("<script> $('#description_news_id').attr('disabled', true);</script>");

    //Проверка типа новосте  и вывод соотвествуйщего типа новости
    if ($_GET["type_news"]==1){
        echo("<script>  $('#List_type_news :nth-child(1)').attr('selected', 'selected');</script> ");
    }

    if ($_GET["type_news"]==2) {
        echo("<script>  $('#List_type_news :nth-child(2)').attr('selected', 'selected');</script> ");
    }
    if ($_GET["type_news"]==3) {
        echo("<script>  $('#List_type_news :last').attr('selected', 'selected');</script> ");
    }

    echo("<script> $('#header_change').empty();</script>");
    echo("<script> $('#header_change').text('Просмотр новини');</script>");
    echo("<script> $('#button_save_file_photo_news').empty();</script>");
    echo("<script> $('#button_save_edit_news').empty();</script>");
    echo("<script> $('#List_type_news').attr('disabled', true);</script>");
}
?>