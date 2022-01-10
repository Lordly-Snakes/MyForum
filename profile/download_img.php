<?php
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$login = $_COOKIE['login'];
$link=connecting();

if(!empty($_FILES['file']['tmp_name'])){ 
  

    //Получаем временный файл
    $tmp = $_FILES['file']['tmp_name'];
    $rez = mysqli_query($link,"SELECT id,login,image FROM users WHERE login='$login'");
    $row = mysqli_fetch_row($rez);
    $id=time();//$row[0];
    $str_path=$row[2];
    //Получаем имя присланного файла
    $name = $id.'.jpg';
    $path = "image/".$_SERVER['PATH_TRANSLATED'].$name;
    //Пишем куда в дальнейшем, надо будет впихнуть файл, 
    //в данном случае в папку images, имя файла оставляем родное
    if(($_FILES['file']['type'] == 'image/gif' || $_FILES['file']['type'] == 'image/jpeg' || $_FILES['file']['type'] == 'image/png') && ($_FILES['file']['size'] != 0 and $_FILES['file']['size']<=2097152)) 
    { 
// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб 
    if (move_uploaded_file($tmp, $path)) 
    { 
    //Здесь идет процесс загрузки изображения 
    $size = getimagesize($path); 
    // с помощью этой функции мы можем получить размер пикселей изображения 
     if ($size[0] <= 1280  && $size[1]<=1280) 
     { 
     // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
        header ("Pragma-directive: no-cache");
        header ("Cache-directive: no-cache");
        header ("Cache-control: no-cache");
        header ("Pragma: no-cache");
        header ("Expires: 0");
        header("Location: profile.php"); 
     move_uploaded_file($tmp, $path);
     unlink($str_path);
     //echo"ssssssss";
     $rez = mysqli_query($link,"UPDATE users SET image='$path'  WHERE login='$login'");
     } else {
      
     echo "<div style='text-align: center;margin-top: 20px;'>Загружаемое изображение превышает допустимые нормы (ширина не более - 1280; высота не более 1280)</div>";
     include_once("img.php") ;
     unlink($path); 
     // удаление файла 
     } 
    } else {
      
    echo "<div style='text-align: center; margin-top: 20px;'>Файл не загружен, вернитеcь и попробуйте еще раз</div>";
    include_once("img.php") ;
    } 
    } else { 
      
    echo "<div style='text-align: center;margin-top: 20px;'>Размер файла не должен превышать 2 Мб или Вы пытались загрузить не картинку </div>";
    include_once("img.php") ;
    }
  }else{
    $rez = mysqli_query($link,"UPDATE users SET image=NULL  WHERE login='$login'");
    header("Location: profile.php");
  }
  
  ?>