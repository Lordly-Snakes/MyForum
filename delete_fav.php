<?php
// Для запроса ajax
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/lib_del.php");
$link = connecting();
if(isset($_GET['id'])){
	if (isset($_COOKIE['login'])) {
			$id = $_GET['id'];
			$login=$_COOKIE['login'];
			//echo "$id_mess";
			deleteFAV($link,$id);
			echo "Удалено";
		}
	}else{
	if(isset($_GET['id_theme'])){
			if(isset($_GET['user'])){
				$id_theme=$_GET['id_theme'];
				$id_user =  $_GET['user'];
				deleteALTFAV($link,$id_user,$id_theme);
				echo "string";
			}else{
				echo "2";
			}
		}
}
?>