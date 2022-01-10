<?
// Вызывается ajax'ом не требует перехода
if (isset($_GET['id']))
{
		// Подключаем файл для соедине7ния с БД
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
		// Подключаемся к БД
		$link = connecting();
		// Вытаскиваем Логин из куки
		$login=$_COOKIE['login'];
		// Вытаскиваем идентификатор темыЫ
		$id = $_GET['id'];
		// Ищем id пользователя
		$id_u = poiskID($link,$login);
		// Проверяем есть ли такая запись
		if(valid($link,$id,$id_u))
		{
			if (mysqli_query($link,"INSERT INTO favorites (id_fav_theme,id_user) VALUES ('$id','$id_u')")) //пишем данные в БД
			{
				echo"Добавлено";// Возращаем результат
            }
            else
            {
                echo"Error";// Если вдруг ошибка сообщим об этом пользователю
            }
        }
        else
        {
        	echo"Уже было добаввлено";// Если такая запись есть говорим об эотм пользователю
        }
}
			
			// Функция для поиска ИД 
			function poiskID($link,$login)
            {

				$rez = mysqli_query($link,"SELECT id,login FROM users WHERE login='$login'");
    			$row = mysqli_fetch_row($rez);
    			return $row[0];
            }

            // Фуекция для проверки наличия избранного
            function valid($link,$id_theme,$id_user)
            {
            	$re = mysqli_query($link,"SELECT * FROM favorites WHERE id_fav_theme='$id_theme' AND id_user='$id_user'");
                if($re){
                    $row = mysqli_fetch_row($re);
                    if($row[1]==$id_theme){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
            }
?>