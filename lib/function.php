<?php
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
function valid($link,$login,$password,$tm,$mail,$salt,$password2){
    if ($login == "") return "пустой логин"; //не пусто ли поле логина 	
	if ($password == "") return "пустой 1 пароль"; //не пусто ли поле пароля
	if ($password2 == "") return "пустой 2 пароль"; //не пусто ли поле подтверждения пароля
	if ($mail == "") return "пустая почта"; //не пусто ли поле e-mail
	//if ($_POST['lic'] != "ok") return false; //приняты ли правила
	if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $mail)) return "Запрещенные символы"; //соответствует ли поле e-mail регулярному выражению
	if (!preg_match('/^([a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is', $login)) return "Логин содержит неверные символы"; // соответствует ли логин регулярному выражению
 	if ($password != $password2) return "Пароли не совпадают"; //равен ли пароль его подтверждению
    $rez = mysqli_query($link,"SELECT login FROM users WHERE login='$login'");
    if($rez){
        $str = mysqli_num_rows($rez);
        $row = mysqli_fetch_row($rez);
        if($row[0]==$login){
            return "такой логин уже есть";
        }
    }    
    mysqli_free_result($rez);
    $rez = mysqli_query($link,"SELECT mail FROM users WHERE mail='$mail'");
    if($rez){
        $str = mysqli_num_rows($rez);
        $row = mysqli_fetch_row($rez);
        if($row[0]==$mail){
            return "такая почта уже есть";
        }
    }
    mysqli_free_result($rez);
	return '0';
	}//если выполнение функции дошло до этого места, возвращаем true 

function registration($link,$login,$password,$tm,$mail,$salt,$password2,$passwordcon){
            if(valid($link,$login,$password,$tm,$mail,$salt,$password2)=='0'){
			if (mysqli_query($link,"INSERT INTO users (login,password,salt,mail_reg,mail,reg_date,last_act,image,vos) VALUES ('".$login."','".$passwordcon."','".$salt."','".$mail."','".$mail."','".$tm."','".$tm."',NULL,0)")) //пишем данные в БД и авторизовываем пользователя
			{
				setcookie ("login", $login, time() + 50000, '/');
				setcookie ("password", md5($login.$passwordcon), time() + 50000, '/');
				$rez = mysqli_query($link,"SELECT * FROM users WHERE login=".$login);
				@$row = mysqli_fetch_assoc($link,$rez);
				$_SESSION['id'] = $row['id'];
                echo "string";
            }else{
               echo "error_log base data";
            }
        }else{
            $r =valid($link,$login,$password,$tm,$mail,$salt,$password2);
            echo "$r";
        }
    }


function poisk($link,$mail,$pass){
    $rez = mysqli_query($link,"SELECT mail,salt,login,password FROM users");
    $str = mysqli_num_rows($rez);
    for ($i = 0 ; $i < $str ; ++$i)
    {
        $row = mysqli_fetch_row($rez);
        if($row[0]==$mail){
            $salt=$row[1];
            $login =$row[2];
            $password_two =$row[3];
        }
    }
    if($password_two == md5(md5($pass).$salt)){
        return $login;
    }else{
        
        return 0;
        
    }
}

function vhod($link,$mail,$password){
                $login=poisk($link,$mail,$password);
                if($login != "" || $login != 0){
                    setcookie ("login", $login, time() + 50000, '/');
                    setcookie ("password", md5($login.$password), time() + 50000, '/');
                    $rez = mysqli_query($link,"SELECT * FROM users WHERE login=".$login);
                    @$row = mysqli_fetch_assoc($link,$rez);
                    $_SESSION['id'] = $row['id'];
                    //header("Location: $dire/forum/");
                    echo "string";
                    //header("Location: $_SERVER[HTTP_REFERER]");
 //подключаем шаблон
                }else{
                    echo "1";
                     //подключаем шаблон
                }
                
            
        
        }
?>
