<?php
if (isset($_COOKIE['mail'])) {
	# code...

include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта
	$tr=true;
	$correct = true;
	if (isset($_POST['GO'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		if ($correct) //если данные верны, запишем их в базу данных
		{
			
			$mail = $_COOKIE['mail'];
			$num = htmlspecialchars($_POST['number']);
			$link= connecting();
			$sql ="SELECT vos FROM users WHERE mail='$mail'";
			$result=mysqli_query($link,$sql);
			if($result){
	
					$row = mysqli_fetch_row($result);
					if($row[0]==$num){
						header("Location: reset.php");
					}else{
						header("Location: recovery_code?error=1.php");
					}
				}
			
			$tr=false;

		}
		else
		{
			include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/Code_temp.php");
		}
	}
	else 
	{
		include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/Code_temp.php");
	}
}
else
{
	header("Location: recovery.php");
}
?>