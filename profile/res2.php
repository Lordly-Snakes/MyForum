<?php
if(isset($_COOKIE['login'])){
    include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    $login = $_COOKIE['login'];
    $link=connecting();
    if (isset($_POST['GO'])) //если была нажата кнопка регистрации, проверим данные на корректность и, если данные введены и введены правильно, добавим запись с новым пользователем в БД
    {
    	$log = htmlspecialchars($_POST['mail']);
        $rez = mysqli_query($link,"SELECT id,login FROM users WHERE login='$login'");
        $row = mysqli_fetch_row($rez);
        $id=$row[0];
        if(valid($link,$log)==0)
        {
            $rez = mysqli_query($link,"UPDATE users SET mail='$log'  WHERE id='$id'");
        	if($rez)
            {
                header("Location: profile.php");
            }
            else
            {
                header("Location: res2.php?error=1");
            }
        }
        else
        {
            header("Location: res2.php?error=1");
        }
    }
    else
    {
    	include_once ("$_SERVER[DOCUMENT_ROOT]/forum/template/resEmail_temp.php");
    }
}else{
    header("Location: profile.php");
}

function valid($link,$mail){
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