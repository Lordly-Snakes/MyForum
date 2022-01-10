<?
// Подключение библотеки для соединения с БД
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$link = connecting();
// Вытаскиваем юзер пользователя и выесняем админ ли он
if(isset($_COOKIE['login'])){
    $log_user = $_COOKIE['login'];
    $rezult = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login='$log_user'");
    $r = mysqli_fetch_row($rezult);
    $id_user = $r[0];
    $admin = $r[2];
    $res_fav = mysqli_query($link,"SELECT * FROM favorites WHERE id_user='$id_user'");
    $array = mysqli_fetch_all($res_fav);

}
if (isset($_GET['page'])) {
    $page = $_GET['page'];        # code...
}else{
    $page = 0;
    $start = 0;
}
$pred_res  =mysqli_query($link,"SELECT COUNT('id') as 'num' FROM category WHERE type='0'");
$pred_count_theme = mysqli_fetch_row($pred_res);
$count_page_theme=ceil((int)$pred_count_theme[0] / 10);
 // проверяем что в бд именно такое кол-во
    // Подсчитываем кол-во страниц
if(!$count_page_theme){
    $count_page_theme=1;
}

    if($page == 'start'){
        header("Location: forum.php?page=1");
    }else if($page == 'end'){
        header("Location: forum.php?page=$count_page_theme");
    }else{
        if($page > $count_page_theme){
            header("Location: forum.php?page=$count_page_theme");
        }else if($page < 1){
            header("Location: forum.php?page=1");
        }else{
            // с какой записис будет отображаться(зависиит от страницы)
            $start = ($page-1)*10;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta Http-Equiv="Expires" Content="0">
    <meta Http-Equiv="Pragma-directive: no-cache">
    <meta Http-Equiv="Cache-directive: no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Форум</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">

function delALLMESS(id){
    $.ajax({
        url: 'delete_all_theme.php?id='+id,
        success: function(data) {
            $('.delres'+id).html(data);
            $('.countres'+id).html(0);
        }
    });
    //alert(id);
}
</script>
<style type="text/css">
    .alert.alert-warning.alert-dismissible{
        width: 100%;
    }
</style>
<body>
    <div style="margin-left: 15px;">
<?include_once "$_SERVER[DOCUMENT_ROOT]/forum/alert.php";?>


<h2>Административные темы</h2></div>
<?
                    $trash_icon = "<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-trash' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                          <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                        </svg>";
                        $mark_icon="<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  <path fill-rule='evenodd' d='M8 12l5 3V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10.234z'/>
</svg>";
$mark_fill_icon="<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M3 3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V3z'/></svg>";

$rez2 = mysqli_query($link,"SELECT name_category,time,id_category,count,type FROM category WHERE type='1'");
// Считаем кол-во строк
$str2 = mysqli_num_rows($rez2);
include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
//////////////////////
/////////////////////
//////////////////////
//////////////////////
/////////////////////
//////////////////////
//////////////////////
/////////////////////
//////////////////////
if(isset($_COOKIE['login'])){
if($admin == 0){
echo '<div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th>Дата создания</th>
                    <th>кол-во обсуждений</th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str2 ; ++$i)
            {
                
                $row = mysqli_fetch_row($rez2);
                if(isset($_COOKIE['login'])){
                }

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                echo"
                <tr>
                    <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                    <td>$date</td>
                    <td>$count</td>

                </tr>";
            }
                
   echo'         </tbody>
       </table>
    </div>
     ';
}else if($admin == 1){
    echo '<div class="table-responsive" >
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th>Дата создания</th>
                    <th>кол-во обсуждений</th>
                    
                    <th colspan="3">Функции админа</th>
                    
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str2 ; ++$i)
            {        
                $row = mysqli_fetch_row($rez2);
                

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                $delres = 'delres'.$id;
                $countres = 'countres'.$id;
                    echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td><div class='$countres'>$count</div></td>
                                
                                <td class='$delres'><button onclick='delALLMESS($id)' class='btn btn-primary'>Очистить</button></td>
                                <td><form  method='post' action='forum.php?id_del=$id'><button class='btn btn-primary' onclick='return one()' name='delete'>$trash_icon</button></form></td>
                            </tr>";
            }
                
    echo'         </tbody>
       </table>
    </div></div>';
}else{
        echo '<div class="table-responsive">
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th>Дата создания</th>
                    <th>кол-во обсуждений</th>
                    
                    
                    
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str2 ; ++$i)
            {        
                $row = mysqli_fetch_row($rez2);
                

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                $delres = 'delres'.$id;
                $countres = 'countres'.$id;
                    echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td><div class='$countres'>$count</div></td>
                                
                            </tr>";
            }
                
    echo'         </tbody>
       </table>
    </div><div style="margin-left: 10px;">
     </div>';}

}else{

    echo '<div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th >Дата создания</th>
                    <th >кол-во обсуждений</th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str2 ; ++$i)
            {
                
                $row = mysqli_fetch_row($rez2);
                

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td>$count</td>
                                
                            </tr>";
            }
                
   echo'         </tbody>
       </table>
    </div>
     ';
}

?>
<div style="margin-top: 60px; margin-left: 15px;"><h2>Обычные темы</h2></div><?
// Вытаскиваем темы из бд
$rez = mysqli_query($link,"SELECT name_category,time,id_category,count,type FROM category WHERE type='0' LIMIT $start,10 ");
// Считаем кол-во строк
$str = mysqli_num_rows($rez);
include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
if(isset($_COOKIE['login'])){
if($admin == 0){
echo '<div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th >Дата создания</th>
                    <th>кол-во обсуждений</th>
                    
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {
                
                $row = mysqli_fetch_row($rez);
                

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td>$count</td>
                               
                            </tr>";
            }
                
   echo'         </tbody>
       </table>
    </div>
     ';
}else if($admin == 1){
    echo '<div class="table-responsive" >
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th>Дата создания</th>
                    <th>кол-во обсуждений</th>
                    
                    <th colspan="2">Функции админа</th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {        
                $row = mysqli_fetch_row($rez);
                

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                $delres = 'delres'.$id;
                $countres = 'countres'.$id;
                    echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td><div class='$countres'>$count</div></td>
                                
                                <td class='$delres'><button onclick='delALLMESS($id)' class='btn btn-primary'>Очистить</button></td>
                                <td><form  method='post' action='forum.php?id_del=$id'><button class='btn btn-primary' onclick='return one()' name='delete'>$trash_icon</button></form>
                                </td>
                            </tr>";
            }
                
    echo'         </tbody>
       </table>
    </div><div style="margin-left: 10px;">
     <form action="add_theme.php"><button class="btn btn-primary">Добавить Тему</button></form></div>';
}else{
        echo '<div class="table-responsive" >
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th>Дата создания</th>
                    <th>кол-во обсуждений</th>
                    
                    
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {        
                $row = mysqli_fetch_row($rez);
                

                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                $delres = 'delres'.$id;
                $countres = 'countres'.$id;
                    echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td><div class='$countres'>$count</div></td>
                                
                            </tr>";
            }
                
    echo'         </tbody>
       </table>
    </div><div style="margin-left: 10px;">
     </div>';
}
}else{
    echo '<div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th >Дата создания</th>
                    <th >кол-во обсуждений</th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {
                
                $row = mysqli_fetch_row($rez);
                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                echo"
                    <tr>
                                <td><a href='theme.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td>$count</td>
                                
                            </tr>";
            }
                
   echo'         </tbody>
       </table>
    </div>
     ';
}




if(isset($_POST['delete'])){
    include("lib/lib_del.php");
    $idt = $_GET['id_del'];
    deleteCATEGORY($link,$idt);
        echo '<script>alert("Удалено")
            location.href="forum.php"
        </script>';
}
?>
    <div style="margin-top: 30px;
    z-index: 100;
    position: relative; 
    margin-bottom: 100px;   
">
    
<?
$back_page = ($page*10)-20;
$forward_page = ($page)*10;
?>
<nav style="z-index: 0;
  width: 40%;
  height: 40%;
  margin: 0px auto;
  text-align: center;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  margin: auto;">
<ul class="pagination pagination-sm">
    <li class="page-item">
<a href='forum.php?page=<? echo 'start' ?>' name="back" 
            <? if((int)$page <= 1)
            {
                echo"class = 'page-link disabled'";
            }else{
                echo"class = 'page-link'";
            }?>>&laquo;</a></li>
    <li class="page-item">
<a href='forum.php?page=<? echo $page-1; ?>' name="back" 
            <? if((int)$page <= 1)
            {
                echo"class = 'page-link disabled'";
            }else{
                echo"class = 'page-link'";
            }?>>Назад</a></li><?
for ($i=0; $i < $count_page_theme; $i++) {
    $i1=$i+1;
if($i1 != $page ){

    $number_page = $i*10;
    echo "<li class='page-item'><a class='page-link' href='forum.php?page=$i1'> $i1 </a></li>";
} else{
    echo "<li class='page-item active'><a class='page-link disabled' href='forum.php?page=$i1'> $i1 </a></li>";
}
        # code...
 }
 ?><li class="page-item"><a href='forum.php?page=<? echo $page+1; ?>' name="forward" <? if((int)$page >= $count_page_theme){
    echo"class = 'page-link disabled'";
 }else{
    echo"class = 'page-link'";
 } ?>>Вперед</a>
     </li>
     <li class="page-item"><a href='forum.php?page=<? echo 'end'; ?>' name="forward" <? if((int)$page >= $count_page_theme){
    echo"class = 'page-link disabled'";
 }else{
    echo"class = 'page-link'";
 } ?>>&raquo;</a>
     </li>
  </ul>
</nav>
 <style type="text/css">
 a.page-link.disabled{
    pointer-events: none; /* делаем элемент неактивным для взаимодействия */
    cursor: default; /*  курсор в виде стрелки */
    color: #888;}
li.page-item.active{
    z-index: 0;}
    /* цвет текста серый */
</style>

    </div>
    
<script>
    function one(){
        return confirm("Вы уверены?");
    }

Notification.requestPermission().then(function(getperm) 
{ 

    console.log('Perm granted', getperm) 

});
</script>
<?
// [номер строки][столбец(id,id_fav_theme,id_user)]

?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Navbar---Apple.js"></script>
</body>
</html>