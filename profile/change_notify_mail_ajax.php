<?
// Для ajax запросов
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$login=$_COOKIE['login'];
$status = $_GET['s_t'];
$type = $_GET['type'];
$link = connecting();
$result = mysqli_query($link,"SELECT id,login FROM users WHERE login ='$login'");
$id_user = mysqli_fetch_row($result)[0];
if($type==1){
	mysqli_query($link,"UPDATE users set is_mail='$status' WHERE login ='$login'");
}else{
	mysqli_query($link,"UPDATE users set is_not='$status' WHERE login ='$login'");	
}


echo "$status $type";
?>