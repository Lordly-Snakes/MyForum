<?php
// Для запроса ajax
if(isset($_GET['mod']) && isset($_GET['id'])){
	include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	$log_user = $_COOKIE['login'];
	if (isset($_COOKIE['login'])) {
		$link = connecting();
		$id_ad =  $_COOKIE['login'];
		$result = mysqli_query($link,"SELECT is_admin,login FROM users WHERE login='$id_ad'");
		$row = mysqli_fetch_row($result);
		if($row[0]==1){
			$mod = $_GET['mod'];
			$id = $_GET['id'];
			$res = mysqli_query($link,"UPDATE users SET is_admin='$mod' WHERE id='$id'");
			if($res){
				if($mod==0){
	        		$admin = 'Подписчика';
	        	}else if($mod==1){
	        		$admin = 'Админа';
	        	}else{
	        		$admin = 'Модератора';
	        	}
	        	echo "Статус изменен на $admin";
        	}else{
        		echo "Статус неизменен";
        	}
		}
		else{
			echo "У вас нет прав админа";
		}
	}else{
		echo "Войдите в аккаунт";
	}
}else{
	echo "Нет модификатора";
}
?>