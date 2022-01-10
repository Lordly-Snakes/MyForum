<?
ini_set ("session.use_trans_sid", true);
session_start();
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/function.php");
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
include_once("$_SERVER[DOCUMENT_ROOT]/forum/lib/captcha.php");

//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта
	 //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	
		 //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
		if (ReCap()) //если данные верны, запишем их в базу данных
		{
			$login = htmlspecialchars($_POST['login']);
			$password1 = $_POST['pass'];
			$password2 = $_POST['pass2'];
			$mail = htmlspecialchars($_POST['email']);
			$salt = mt_rand(100, 999);
			$tm = time();
			$password = md5(md5($password1).$salt);
			$link= connecting();
			registration($link,$login,$password1,$tm,$mail,$salt,$password2,$password);
			
		}
		else
		{
			echo "Capthca"; //подключаем шаблон в случае некорректности данных
		}
	


?>