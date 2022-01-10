<?php
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	if (isset($_POST['GO2'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		$link = connecting();
		$log_ad = $_COOKIE['login'];
		$correct = mysqli_query($link,"SELECT login,is_admin FROM users WHERE login='$log_ad'");
		$row = mysqli_fetch_row($correct); //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
		if ($row[1]==1) //если данные верны, запишем их в базу данных
		{
			$name = htmlspecialchars($_POST['name']);
			$desc = htmlspecialchars($_POST['description']);
			if($desc == NULL || $desc == '' || $desc == ' '){
				$desc ='Нет описания';
			}
			$tm = time();
			if ($_POST['check']) {
				$type = 1;
			}else{
				$type = 0;
			}
			if (valid($link,$name)==0) {
				# code...
				if (mysqli_query($link,"INSERT INTO category (name_category,description,time,type) VALUES ('".$name."','$desc','".$tm."','$type')")) //пишем данные в БД и авторизовываем пользователя
				{
					header("Location: forum.php"); //подключаем шаблон
            	}else{
                	echo"$name $desc";
            	}
			}else{
				include_once ("template/add_theme_temp.php");
				echo "Failed adding";
			}
			
		}
		else
		{
			header("Location: forum.php");
		}
	}
	else
	{
		include_once ("template/add_theme_temp.php"); //подключаем шаблон в случае если кнопка регистрации нажата не была, то есть, пользователь только перешёл на страницу регистрации
	}
	function valid($link,$name){
    if ($name == "") return 1; //не пусто ли поле логина 	
    $rez = mysqli_query($link,"SELECT name_category FROM category");
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
	}
?>