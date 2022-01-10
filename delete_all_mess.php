<?php
// Для запроса ajax
if(isset($_GET['id'])){
	if (isset($_COOKIE['login'])) {
		$login=$_COOKIE['login'];
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
			include("$_SERVER[DOCUMENT_ROOT]/forum/lib/lib_del.php");
		$link = connecting();
		$correct = mysqli_query($link,"SELECT login,is_admin FROM users WHERE login='$login'");
		$row = mysqli_fetch_row($correct);
		if($row[1]==1){
			$id_th = $_GET['id'];
			mysqli_query($link,"UPDATE theme SET count=0 WHERE id_them='$id_th'");
		//echo "$id_mess";
			deleteALLMESSAGE($link,$id_th);
			echo "удалены все сообщения";	
		}else{
			echo "У вас нет прав";	
		}		
	}
}
?>