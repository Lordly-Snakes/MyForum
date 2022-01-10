<?php
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$id_category = $_GET['id'];
	if (isset($_POST['GO2'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
	{
		$id_category = $_GET['id'];
		$link = connecting();
		$log_ad = $_COOKIE['login'];
		$correct = mysqli_query($link,"SELECT login,is_admin FROM users WHERE login='$log_ad'");
		$row = mysqli_fetch_row($correct); //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
		if ($row[1]==1) //если данные верны, запишем их в базу данных
		{
			$name = htmlspecialchars($_POST['name']);
			$first_mess = htmlspecialchars($_POST['first']);
			$desc = htmlspecialchars($_POST['description']);
			
			if($desc == NULL || $desc == '' || $desc == ' '){
				$desc ='Нет описания';
			}
			$tm = time();
$type=0;
			if (valid($link,$name)==0) {
				# code...
				if (mysqli_query($link,"INSERT INTO theme (id_category,name_theme,description,time,type) VALUES ('".$id_category."','".$name."','$desc','".$tm."','$type')")) //пишем данные в БД и авторизовываем пользователя
				{
					$rt = mysqli_query($link,"SELECT * FROM theme WHERE name_theme='$name'");
					$rowt = mysqli_fetch_row($rt);
					$id_theme = $rowt[0];
					mysqli_query($link,"UPDATE category SET count=count+1 WHERE id_category='$id_category'");
					if(addMESS($link,$first_mess,$id_theme)){
						header("Location: message.php?id=".$id_theme); 	
					}else{
						echo "Если Вы видите эту страницу то что-то пошло не так";
					}
					
					//echo"$name $desc $id_category";//подключаем шаблон
            	}else{
                	echo"$name $desc $id_category";
            	}
			}else{
				include_once ("template/add_question_temp.php");
				echo "Failed adding";
			}
			
		}
		else
		{
			header('Location: theme.php?id=$id_category');
		}
	}
	else
	{
		include_once ("template/add_question_temp.php");
	//	echo "$id_category"; //подключаем шаблон в случае если кнопка регистрации нажата не была, то есть, пользователь только перешёл на страницу регистрации
	}
	function valid($link,$name){
    if ($name == "") return 1; //не пусто ли поле логина 	
    $rez = mysqli_query($link,"SELECT name_theme FROM theme");
    $str = mysqli_num_rows($rez);
    for ($i = 0 ; $i < $str ; ++$i)
    {
    $row = mysqli_fetch_row($rez);
        if($row[0]==$name){
            return 6;
        }
    }
    mysqli_free_result($rez);
	return 0;
	}

	function addMESS($link,$message_,$id)
	{
		
			// Снимем теги для безопастности
			$mess = preg_replace('/\<script[^>]*\>[^<]*\<\/script[^>]*\>/is',' попытка использовать скрипт ',$message_);
			$new_mess = preg_replace('/\<a[^>]*\>[^<]*\<\/a[^>]*\>/is',' ссылки запрещены ',$mess);
			$new_mess = nl2br($new_mess); 
			//$text = preg_replace("~<a href=\"http://www\.aaa\">[^<]+?</a>~",'',$text);
			$message = mysqli_escape_string($link,$new_mess);
			
			$tm = time();
			$login=$_COOKIE['login'];
			//$id = $_COOKIE['id_th'];
			$id_u = poiskID($link,$login);
				if (mysqli_query($link,"INSERT INTO messages (id_theme,time_mess,id_user,message) VALUES ('$id','$tm','$id_u','$message')")) //пишем данные в БД и авторизовываем пользователя
				{
					updateCOUNT($link,$id);
					check($link,$id,$message);
					updateNOTIFY($link,$id_u,$id);
					return true;
	            }else{
	                //header("Location: NotFound404.php");
	                echo "$rx";
	                print_r($rx);
	                return false;
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