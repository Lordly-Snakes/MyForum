<?
//echo "string";
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$link = connecting();
$id_mess =$_GET['id'];
$mess = preg_replace('/\<script[^>]*\>[^<]*\<\/script[^>]*\>/is',' попытка использовать скрипт ',$_POST['message']);
$new_mess = preg_replace('/\<a[^>]*\>[^<]*\<\/a[^>]*\>/is',' ссылки запрещены ',$mess);
$new_mess = nl2br($new_mess); 
$message = mysqli_escape_string($link,$new_mess);
$tm = time();
if (mysqli_query($link,"UPDATE messages SET message='$message',time_mess='$tm' WHERE id_message='$id_mess'")) //пишем данные в БД и авторизовываем пользователя
{
	header("Location: message.php?id=poisk&id_mess=".$id_mess);
}else{
  	echo "Если вы видите это сообщение то что-то пошло не так, вы можите нам об этом сообщить вразделе 'помощь'";

}
?>