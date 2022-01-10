<?php
// Используется ajax
if(isset($_GET['id_u']))
{
	if (isset($_COOKIE['login'])) 
	{
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/lib_del.php");
		$id_t = $_GET['id_t'];
		$id_u = $_GET['id_u'];
		$link = connecting();
		//echo "$id_mess";
		deleteNOT($link,$id_t,$id_u);
		echo "";
	}
}
?>