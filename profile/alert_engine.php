<?

    include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    $link = connecting();
    include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
    $dire= dirr();
    if($_POST['type'] == 1){
        $mess = $_POST['mess'];
        //mysqli_query($link,"INSERT INTO alert (text_alert) VALUES ('$mess')");
        if (mysqli_query($link,"INSERT INTO alert (text_alert) VALUES ('".$mess."')")) //пишем данные в БД и авторизовываем пользователя
    	{
    					echo "0"; //подключаем шаблон
        }else{
                    	echo"1";
        }
    }else{
        $id = $_POST['id'];
        if (mysqli_query($link,"DELETE FROM alert WHERE id='$id'")) //пишем данные в БД и авторизовываем пользователя
        {
                        echo "0"; //подключаем шаблон
        }else{
                        echo"1";
        }
        
    }
?>