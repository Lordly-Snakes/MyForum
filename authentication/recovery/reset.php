<?php
if (isset($_COOKIE['mail'])) {
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта
	$tr=true;
	$correct = true;
	if (isset($_POST['GO'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		 //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
		if ($correct) //если данные верны, запишем их в базу данных
		{
			
			$password1 = $_POST['pass'];
			$password2 = $_POST['pass2'];
			//$num = htmlspecialchars($_POST['number']);
			//$num = rand(1000,9999);
			//maili($mail,$num);
			$salt = mt_rand(100, 999);
            //$tm = time();
            $mail = $_COOKIE['mail'];
            if($password1==$password2 && $password2 !=''){
				$password = md5(md5($password1).$salt);
				$link= connecting();
				$sql ="UPDATE users SET password='$password',salt='$salt',vos=0 WHERE mail='$mail'";
				$result=mysqli_query($link,$sql);
				//$result1=mysqli_query($link,$sql1);
				if($result){
					setcookie('mail',$mail,time() - 50000, '/');
					header("Location: $dire/forum/authentication/authentication.php");
				}
			}else{
			    header("Location: reset.php");
			}
			//vhod($link,$mail,$password);
			$tr=false;
			

		}
		else
		{
			include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/newPass_temp.html");
			 //подключаем шаблон в случае некорректности данных
		}
	}
	else 
		{
			include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/newPass_temp.html");
			 //подключаем шаблон в случае некорректности данных
		}
	
	}
else
{
	header("Location: recovery.php");
}
?>