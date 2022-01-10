<?php
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
                setcookie ("login", $login, time() - 50000, '/');
                setcookie ("password", md5($login.$password), time() - 50000, '/');
                $_SESSION['id']=0;
                header("Location: $_SERVER[HTTP_REFERER]");
?>