<?php
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/function.php");
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");



	if (true) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		$correct = true; //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
		if ($correct) //если данные верны, запишем их в базу данных
		{
			//$login = htmlspecialchars($_POST['login']);
			$password = $_POST['pass'];
			//$password2 = $_POST['pass2'];
			$mail = htmlspecialchars($_POST['email']);
			//$salt = mt_rand(100, 999);
			//$tm = time();
			//$password = md5(md5($password1).$salt);
			$link= connecting();
			 //header("Location: $_SERVER[HTTP_REFERER]");
			vhod($link,$mail,$password);
// 			echo $mail;
// 			echo $password;
		}
	}
	else
	{
		echo "Капча не пройдена";
//подключаем шаблон в случае если кнопка регистрации нажата не была, то есть, пользователь только перешёл на страницу регистрации
	}

?>