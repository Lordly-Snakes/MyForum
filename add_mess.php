<?php
    include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
    $dire= dirr();
		// Подключаем файл для соединения с БД
		include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
		if(isset($_COOKIE['login'])){
			// Подключаемся к БД
			$link = connecting();
			// Снимем теги для безопастности
			$mess = preg_replace('/\<script[^>]*\>[^<]*\<\/script[^>]*\>/is',' попытка использовать скрипт ',$_POST['message']);
			$new_mess = preg_replace('/\<a[^>]*\>[^<]*\<\/a[^>]*\>/is',' ссылки запрещены ',$mess);
			$new_mess = nl2br($new_mess); 
			//$text = preg_replace("~<a href=\"http://www\.aaa\">[^<]+?</a>~",'',$text);
			$message = mysqli_escape_string($link,$new_mess);
			
			$tm = time();
			$login=$_COOKIE['login'];
			$id = $_COOKIE['id_th'];
			$id_u = poiskID($link,$login);
				if (mysqli_query($link,"INSERT INTO messages (id_theme,time_mess,id_user,message) VALUES ('$id','$tm','$id_u','$message')")) //пишем данные в БД и авторизовываем пользователя
				{
					updateCOUNT($link,$id);
					check($link,$id,$message);
					updateNOTIFY($link,$id_u,$id);
					header("Location: {$_SERVER['HTTP_REFERER']}");
	            }else{
	                //header("Location: NotFound404.php");
	                echo "$rx";
	                print_r($rx);
	            }
        }
            function poiskID($link,$login)
            {

				$rez = mysqli_query($link,"SELECT id,login FROM users WHERE login='$login'");
   				$row = mysqli_fetch_row($rez);
   				return $row[0];
            }

            function updateCOUNT($link,$id_theme){
            	mysqli_query($link,"UPDATE theme SET count=count+1 WHERE id_them='$id_theme'");
            }

            function updateNOTIFY($link,$id_user,$id_theme){
            	$results = mysqli_query($link,"SELECT id,id_fav_theme,id_user FROM favorites WHERE id_fav_theme='$id_theme'");
            	if($results){
                    for ($i=0; $i < mysqli_num_rows($results); $i++) { 
	                    $row = mysqli_fetch_row($results);
    	                if($row[1]==$id_theme){
	                        $tiuser = $row[2];
	                        $result=mysqli_query($link,"SELECT id_them,name_theme FROM theme WHERE id_them='$id_theme'");
	                        $r_mess = mysqli_fetch_row($result);
	                        $message = $r_mess[1];
	                        mysqli_query($link,"INSERT INTO notification (id_user,id_theme,not_mess) VALUES ('$tiuser','$id_theme','$message')");
        	            }
                    }
            	}
            }

            function check($link,$id_theme,$string){
            	    //$string = "I loved the article, @SantaClaus! And I agree, @Jesus!";
				    if (preg_match_all('/(?<!\w)@(\w+|[а-яА-Я]+)/u', $string, $matches))
				    {
				        $users = $matches[1];
						$rezult = mysqli_query($link,"SELECT message,id_message FROM messages WHERE message='$string'");
						$r = mysqli_fetch_row($rezult);
						$id_message = $r[1];
				        // $users should now contain array: ['SantaClaus', 'Jesus']
				        foreach ($users as $user)
				        {
							$res = mysqli_query($link,"SELECT id,login FROM users WHERE login = '$user'");
							$row = mysqli_fetch_row($res);
							if($row[1] == $user){
								$message='Вас упомянули';
				        		mysqli_query($link,"INSERT INTO notification (id_user,id_theme,not_mess,id_mess) VALUES ('$row[0]','$id_theme','$message','$id_message')");
				        		
				        		//echo "$user $message $id_theme $row[0]";
							}else{
								
							}
				            // check $user in database
				        }
				        
				    }else{
				    	
				    }
            }


?>