<?php 
include("directory.php");

            $path =dirr();
            $login = $_COOKIE['login'];?>
            
<header>
        <div id="logo" onclick="slowScrol('#top')">
            <span>Форум pokypki.net</span>
        </div>
        <div id="about">
            <a href="#" title="О нас" onclick="slowScrol('#main')">Что такое форум</a>
            
            <a href="#" title="Блог" onclick="slowScrol('#sed')">Начать общение</a>
            <? if (isset($_SESSION['id']) || (isset($_COOKIE['login']) && isset($_COOKIE['password']))) 
            {
                echo "<a href='$path/forum/profile/profile.php' title='Вход''>$login</a>";
                echo "<a href='$path/forum/forum.php' title='Вход'>На форум</a>";
                echo"<a href='$path/forum/v.php' title='Вход'>Выход</a>";
            }else{
                echo "<a href='$path/forum/registration/registration.php' title='регистрация'>регистрация</a>";
                echo "<a href='$path/forum/authentication/authentication.php' title='Вход'>Вход</a>";
            }
             ?>
        </div>
    </header>