<?php
if(isset($_COOKIE['login'])){
	include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	include("$_SERVER[DOCUMENT_ROOT]/forum/lib/lib_del.php");
	$id = $_GET['id'];
	$login=$_COOKIE['login'];
	$link = connecting();
	$result = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login ='$login'");
	if($result){
		$row = mysqli_fetch_row($result);
		$iid =$row[0];
		if($id == $iid){
			deletePROFILE($link,$id);
		}else if($row[2]){
			deleteOTHERPROFILE($link,$id);
		}
	}
	header("Location: $_SERVER[HTTP_REFERER]");
}else{
	header("Location: profile.php");
}
?>