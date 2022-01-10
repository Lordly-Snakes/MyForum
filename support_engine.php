<?
include_once("$_SERVER[DOCUMENT_ROOT]/forum/lib/captcha.php");
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    $link = connecting();
if (ReCap()) //если данные верны, запишем их в базу данных
		{

			$mess = htmlspecialchars($_POST['mess']);
			$mail = $_POST['mail'];
        		/*if (isset($_COOKIE['login'])) {
        		$log_user = $_COOKIE['login'];
        	    $rezult = mysqli_query($link,"SELECT login,mail FROM users WHERE login='$log_user'");
        	    $r = mysqli_fetch_row($rezult);
        	    $mail = $r[1];}*/
    			maili($link,$mail,$mess);
    			$mess = "Сообщение об ошибке от ".$mail." : ".$mess;
    			$rezult2 = mysqli_query($link,"SELECT id,login,mail,is_admin FROM users WHERE is_admin='1'");
    	    	$r2 = mysqli_fetch_row($rezult2);
    	    	$id_user = $r2[0];	
    			if (mysqli_query($link,"INSERT INTO notification (id_user,not_mess) VALUES ('".$id_user."','".$mess."')")) //пишем данные в БД и авторизовываем пользователя
    			{
    				echo "0";		//header("Location: profile_view.php?id=$id_user");
                }else{
                    	echo" 1 $id_user $mess";
                }
	        
		}
		else
		{
			echo "1"; //подключаем шаблон в случае некорректности данных
		}


function maili($link,$mail,$mess){

	$to  = "anton2001snake@gmail.com"; 
	//$to .= "mail2@example.com>"; 

	$subject = "Репорт о баге от пользователя с почтой: ".$mail; 

	$message = $mess;

	$headers  = "Content-type: text/html;\r\n"; 
	$headers .= "From: ...\r\n";
	$headers .= "Reply-To: <".$mail.">\r\n"; 

	mail($to, $subject, $message, $headers);

}

?>