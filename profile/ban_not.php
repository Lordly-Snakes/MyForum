<?php
// Для ajax запросов
if(isset($_COOKIE['login'])){
	include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	$id = $_GET['id'];
	$login=$_COOKIE['login'];
	$link = connecting();
	$result = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login ='$login'");
	if($result){
		$row = mysqli_fetch_row($result);
		$iid =$row[2];
		if($iid == 1 || $iid == 2){
			if(mysqli_query($link,"UPDATE users SET is_ban=0 WHERE id ='$id'")){
				$mess = "вас разбанили";
				mysqli_query($link,"INSERT INTO notification (id_user,not_mess) VALUES ('".$id."','".$mess."')");
				echo "Разбаннен";	
			}else{
				echo "Error failed connect";
			}
		}else{
			echo "нет прав $iid";
		}
	}
	//header("Location: $_SERVER[HTTP_REFERER]");
}else{
	echo "failed";
}
?>