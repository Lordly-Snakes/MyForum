<?php
if(isset($_GET['id']))
{
	if (isset($_COOKIE['login'])) 
	{
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/lib_del.php");
		$id_mess = $_GET['id'];
		$login=$_COOKIE['login'];
		$link = connecting();
		$correct = mysqli_query($link,"SELECT login,is_admin FROM users WHERE login='$login'");
		$row = mysqli_fetch_row($correct);
		if($row[1]){
			deleteMESSAGE($link,$id_mess);
			header("Location: $_SERVER[HTTP_REFERER]");
		}
	}
	else
	{
		header("Location: 404.php");	
	}
}
else
{
	header("Location: 404.php");	
}
?>