<?php

include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
include_once("$_SERVER[DOCUMENT_ROOT]/forum/lib/captcha.php");
$dire= dirr();
//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта
	$tr=true;
	$correct = true;
	if (isset($_POST['GO'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		 //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
			if (ReCap()) //если данные верны, запишем их в базу данных
			{
			

			$mail = htmlspecialchars($_POST['email']);
			setcookie('mail',$mail,time() + 50000, '/');
			$num = rand(1000,9999);
			maili($mail,$num);
			$link= connecting();
			$result = mysqli_query($link,"SELECT mail FROM users WHERE mail='$mail'");
				if($result){
					$sql ="UPDATE users SET vos = $num WHERE mail='$mail'";
					if(mysqli_query($link,$sql)){
						$tr=false;

						header("Location: recovery_code.php");
					}
				}else
				{
					header("Location: recovery.php");
				}

			}
			else
			{
				include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/vosEmail_temp.html");
			 //подключаем шаблон в случае некорректности данных
			}
	}
	else 
	{
		include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/vosEmail_temp.html");
			 //подключаем шаблон в случае некорректности данных
	}
	
	
	
	

function maili($mail,$num){
	$to  = $mail; 
	//$to .= "mail2@example.com>"; 

	$subject = "Заголовок письма"; 

	$message = ' <p>Здравствуйте вы сделали запрос на восстановления пароля</p> </br> <b>Ваш код: </b> </br><i> </i> </br> '.$num;

	$headers  = "Content-type: text/html;\r\n"; 
	$headers .= "...\r\n";
	$headers .= "Reply-To: reply-to@example.com\r\n"; 

	mail($to, $subject, $message, $headers); 
}
?>