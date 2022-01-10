<?
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$login = $_COOKIE['login'];
$link=connecting();
if($_POST['type']==0){
        $log = htmlspecialchars($_POST['log']);
        $rez = mysqli_query($link,"SELECT id,login FROM users WHERE login='$login'");
        $row = mysqli_fetch_row($rez);
		$id=$row[0];
		if(valid($link,$log)==0)
		{
        	$rez = mysqli_query($link,"UPDATE users SET login='$log'  WHERE id='$id'");
			if($rez)
			{
        		    setcookie ("login", $log, time() + 50000, '/');
        			echo"0";
        	}
        	else
        	{
				//include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/resLogin_temp.html");
					echo"Неизвестная ошибка";
			}
		}
		else
		{
		    //$ar = valid($link,$log);
			//include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/resLogin_temp.html");
			echo"Либо такой логин уже занят, либо символы недопустимы";
		}
    
}else{
		    $log = htmlspecialchars($_POST['mail']);
            $rez = mysqli_query($link,"SELECT id,login FROM users WHERE login='$login'");
            $row = mysqli_fetch_row($rez);
            $id=$row[0];
            if(valid2($link,$log)==0)
            {
                $rez = mysqli_query($link,"UPDATE users SET mail='$log'  WHERE id='$id'");
            	if($rez)
                {
                    echo"0";
                }
                else
                {
                    echo"Неизвестная ошибка";
                }
            }
            else
            {
                echo"Либо такой адрес почты уже занят, либо символы недопустимы";
            }
}
		function valid($link,$login){
		if ($login == "") return 1; //не пусто ли поле логина 	
		if (!preg_match('/^([a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is', $login)) return 4; // соответствует ли логин регулярному выражению
		$rez = mysqli_query($link,"SELECT login FROM users");
		$str = mysqli_num_rows($rez);
		for ($i = 0 ; $i < $str ; ++$i)
		{
		$row = mysqli_fetch_row($rez);
			if($row[0]==$login){
				return 6;
			}
		}
		mysqli_free_result($rez);
		return 0;
		}
		function valid2($link,$mail){
        if ($mail == "") return 9; //не пусто ли поле e-mail
        if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $mail)) return 4; //соответствует ли поле e-mail регулярному выражению
        $rez = mysqli_query($link,"SELECT mail FROM users");
        $str = mysqli_num_rows($rez);
        for ($i = 0 ; $i < $str ; ++$i)
        {
        $row = mysqli_fetch_row($rez);
            if($row[0]==$mail){
                return 7;
            }
        }
        mysqli_free_result($rez);
        return 0;
        }
?>