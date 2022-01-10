<?php
if(isset($_COOKIE['login'])){
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$login = $_COOKIE['login'];
$link=connecting();

//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта

	if (isset($_POST['GO'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		
		$log = htmlspecialchars($_POST['log']);
        $rez = mysqli_query($link,"SELECT id,login FROM users WHERE login='$login'");
        $row = mysqli_fetch_row($rez);
		$id=$row[0];
		if(valid($link,$log)==0)
		{
        	$rez = mysqli_query($link,"UPDATE users SET login='$log'  WHERE id='$id'");
			if($rez)
			{
        		setcookie ("login", $log, time() + 50000, '/');
        		header("Location: profile.php");
        	}
        	else
        	{
				//include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/resLogin_temp.html");
				header("Location: res.php?error=1"); 
			}
		}
		else
		{
			//include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/resLogin_temp.html");
			header("Location: res.php?error=1");
		}
    }
    else
    {
		include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/resLogin_temp.php");
	}
	}else{
    header("Location: profile.php");
}
	function valid($link,$login){
		if ($login == "") return 1; //не пусто ли поле логина 	
		if (!preg_match('/^([a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is', $login)) return 4; // соответствует ли логин регулярному выражению
		$rez = mysqli_query($link,"SELECT login FROM users");
		$str = mysqli_num_rows($rez);
		for ($i = 0 ; $i < $str ; ++$i)
		{
		$row = mysqli_fetch_row($rez);
			if($row[0]==$login){
				return 6;
			}
		}
		mysqli_free_result($rez);
		return 0;
		}
	

	
?>