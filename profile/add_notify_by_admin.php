<?php
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	if (isset($_POST['GO2'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		$id_user = $_GET['id_user'];
		$link = connecting();
		$log_ad = $_COOKIE['login'];
		$correct = mysqli_query($link,"SELECT login,is_admin FROM users WHERE login='$log_ad'");
		$row = mysqli_fetch_row($correct); //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
		if ($row[1]==1) //если данные верны, запишем их в базу данных
		{
			$mess = htmlspecialchars($_POST['description']);
			//$desc = htmlspecialchars($_POST['description']);
			$tm = time();
			
			if (true) {
				# code...
				if (mysqli_query($link,"INSERT INTO notification (id_user,not_mess) VALUES ('".$id_user."','".$mess."')")) //пишем данные в БД и авторизовываем пользователя
				{
					header("Location: profile_view.php?id=$id_user");
            	}else{
                	echo" 1 $id_user $mess";
            	}
			}else{
				include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/add_notify_byadmin_temp.php");
				echo "Failed adding";
			}
			
		}
		else
		{
			header("Location: profile_view.php?id=$id_user");
		}
	}
	else
	{
		include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/add_notify_byadmin_temp.php"); //подключаем шаблон в случае если кнопка регистрации нажата не была, то есть, пользователь только перешёл на страницу регистрации
	}
/*	function valid($link,$name){
    if ($name == "") return 1; //не пусто ли поле логина 	
    $rez = mysqli_query($link,"SELECT name_theme FROM theme");
    $str = mysqli_num_rows($rez);
    for ($i = 0 ; $i < $str ; ++$i)
    {
    $row = mysqli_fetch_row($rez);
        if($row[0]==$name){
            return 6;
        }
    }
    mysqli_free_result($rez);
	return 0;
	}*/
?>