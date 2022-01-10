<?php
// Для ajax запросов
if(isset($_COOKIE['login'])){
	include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	$id = $_GET['id'];
	$login=$_COOKIE['login'];
	$link = connecting();
	$result_admin = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login ='$login'");
	$result_user = mysqli_query($link,"SELECT id,is_admin FROM users WHERE id ='$id'");
	if($result_user){
		$row_user = mysqli_fetch_row($result_user);
		$status_user = $row_user[1];
		if($result_admin){
			$row_admin = mysqli_fetch_row($result_admin);
			$status_admin=$row_admin[2];
			if($status_admin == 1){
				FunBan($link,$id);
			}else if($status_user == 0 && $status_admin == 2){
				FunBan($link,$id);
			}else{
				echo "Нет прав";
			}
		}else{
			echo "failed";
		}
	}
}
function FunBan($link,$id)
{
	$res = mysqli_query($link,"UPDATE users SET is_ban=1 WHERE id ='$id'");
	if($res){
	$mess = "вас забанили";
	mysqli_query($link,"INSERT INTO notification (id_user,not_mess) VALUES ('".$id."','".$mess."')");
		echo "В бане, что бы разбанить обновите страницу";
	}else{
		echo "Неизвестная ошибка";
	}
	
}
?>