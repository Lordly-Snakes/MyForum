<?
// Подключение библотеки для соединения с БД
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$link = connecting();
$id_cat = $_GET['id'];
//
$rezult = mysqli_query($link,"SELECT * FROM category WHERE id_category='$id_cat'");
$r1 = mysqli_fetch_row($rezult);
$name_cat = $r1[1];
$question_can = $r1[5];
$count_ques = $r1[4];

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
$pred_res  =mysqli_query($link,"SELECT COUNT('id') as 'num' FROM theme WHERE id_category='$id_cat'");
$pred_count_theme = mysqli_fetch_row($pred_res);
$count_page_theme=ceil((int)$pred_count_theme[0] / 10);
 // проверяем что в бд именно такое кол-во
    // Подсчитываем кол-во страниц
if($pred_count_theme[0]!=$count_ques){
    mysqli_query($link,"UPDATE category SET count='$pred_count_theme[0]' WHERE id_category='$id_cat'");
}
if(!$count_page_theme){
    $count_page_theme=1;
}

    if($page == 'start'){
        header("Location: theme.php?id=".$id_cat."&page=1");
    }else if($page == 'end'){
        header("Location: theme.php?id=".$id_cat."&page=$count_page_theme");
    }else{
        if($page > $count_page_theme){
            header("Location: theme.php?id=".$id_cat."&page=$count_page_theme");
        }else if($page < 1){
            header("Location: theme.php?id=".$id_cat."&page=1");
        }else{
            // с какой записис будет отображаться(зависиит от страницы)
            $start = ($page-1)*10;
        }
    }
    function poiskFavorites($id_theme_search,$array)
{
    $count_fav = is_array($array) ? count($array) : 0;
    
    $res=0;
    for ($i=0; $i < $count_fav; $i++) {
        if($array[$i][1]==$id_theme_search){

            $res = 1;
            break;

        } 
        # code                                    
    }
    return $res;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="<? echo"$name_cat"; ?>">
    <meta name="keywords" content='<?
    $pieces = explode(" ", $name_cat);
    for($i=0;$i<count($pieces);$i++){
        if(count($pieces) < 2){
            $str = $pieces[$i];
            echo"$str";
        }else{
            if($i == count($pieces)-1)
            {
                $str = $pieces[$i];
                echo"$str";
            }
            else
            {
                $str = $pieces[$i].", ";
                echo"$str";
            }
        }
    }
    ?>'>
    <!--<meta Http-Equiv="Cache-Control" Content="no-cache">
    <!--<meta Http-Equiv="Pragma" Content="no-cache">
    <!--<meta Http-Equiv="Expires" Content="0">
    <!--<meta Http-Equiv="Pragma-directive: no-cache">
    <!--<meta Http-Equiv="Cache-directive: no-cache">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><? echo "$name_cat"; ?></title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
function addFAV(id_theme,user){
    $.ajax({
        url: 'add_favorite.php?id='+id_theme,
        success: function(data) {
            $('.'+id_theme).html("<button class='btn btn-primary' onclick='delFAV("+id_theme+","+user+")' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M3 3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V3z'/></svg></button>");

        }
    });
    //alert(id);
}
function delFAV(id_theme,user){
    $.ajax({
        url: 'delete_fav.php?id_theme='+id_theme+'&user='+user,
        success: function(data) {
            $('.'+id_theme).html("<button class='btn btn-outline-primary' onclick='addFAV("+id_theme+","+user+")' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 12l5 3V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10.234z'/></svg></button>");
        }
    });
}
function delALLMESS(id){
    $.ajax({
        url: 'delete_all_mess.php?id='+id,
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



<?
                    $trash_icon = "<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-trash' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                          <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                        </svg>";
                        $mark_icon="<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  <path fill-rule='evenodd' d='M8 12l5 3V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10.234z'/>
</svg>";
$mark_fill_icon="<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M3 3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V3z'/></svg>";

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
?>
<h2><? echo "Тема: $name_cat"; ?></h2></div><?
// Вытаскиваем темы из бд
$rez = mysqli_query($link,"SELECT name_theme,time,id_them,count,type FROM theme WHERE id_category='$id_cat' LIMIT $start,10 ");
// Считаем кол-во строк
$str = mysqli_num_rows($rez);
include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
if(isset($_COOKIE['login'])){
if($admin == 0){
echo '<div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Обсуждение</th>
                    <th>Дата создания</th>
                    <th>Кол-во сообщений</th>
                    <th>Избранное</th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {
                
                $row = mysqli_fetch_row($rez);
                $fav_true = poiskFavorites($row[2],$array);
                $typ = $row[4];
                if($fav_true){
                    $p = "<h1>AAAAAAA</h1>";
                    $button = "<button class='btn btn-primary' onclick='delFAV($row[2],$id_user)' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M3 3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V3z'/></svg></button>";
                }else{
                    $button ="<button class='btn btn-outline-primary' onclick='addFAV($row[2],$id_user)' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 12l5 3V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10.234z'/></svg></button>";
                }
                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                echo"
                    <tr>
                                <td><a href='message.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td>$count</td>
                                <td class='$id'><div class='$id'>$button</div></td>
                            </tr>";
            }
                
if($question_can==0){
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     <a href='add_question.php?id=$id_cat' class='btn btn-primary'>Добавить обсуждение</a></div>
     ";
}else{
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     В этой теме нельзя добавлять обсуждение</div>
     ";
}
}else if($admin == 1){
    echo '<div class="table-responsive" >
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>Обсуждение</th>
                    <th>Дата создания</th>
                    <th>Кол-во сообщений</th>
                    <th></th>
                    <th colspan="2">Функции админа</th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {        
                $row = mysqli_fetch_row($rez);
                $fav_true = poiskFavorites($row[2],$array);
                if($fav_true){
                    $p = "<h1>AAAAAAA</h1>";
                    $button = "<button class='btn btn-primary' onclick='delFAV($row[2],$id_user)' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M3 3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V3z'/></svg></button>";
                }else{
                    $button ="<button class='btn btn-outline-primary' onclick='addFAV($row[2],$id_user)' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 12l5 3V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10.234z'/></svg></button>";
                }
                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                $delres = 'delres'.$id;
                $countres = 'countres'.$id;
                    echo"
                    <tr>
                                <td><a href='message.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td><div class='$countres'>$count</div></td>
                                <td class='$id'><div class='$id'>$button</div></td>
                                <td class='$delres'><button onclick='delALLMESS($id)' class='btn btn-primary'>Удалить все</button></td>
                                <td><form  method='post' action='theme.php?id_del=$id&id=$id_cat'><button class='btn btn-primary' onclick='return one()' name='delete'>$trash_icon</button></form>
                                </td>
                            </tr>";
            }
if($question_can==0 || $admin==1){
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     <a href='add_question.php?id=$id_cat' class='btn btn-primary'>Добавить обсуждение</a></div>
     ";
}else{
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     В этой теме нельзя добавлять обсуждения</div>
     ";
}

                
   
}else{
        echo '<div class="table-responsive" >
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>Обсуждение</th>
                    <th>Дата создания</th>
                    <th>Кол-во сообщений</th>
                    <th>Избранное</th>
                    
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
            {        
                $row = mysqli_fetch_row($rez);
                $fav_true = poiskFavorites($row[2],$array);
                if($fav_true){
                    $p = "<h1>AAAAAAA</h1>";
                    $button = "<button class='btn btn-primary' onclick='delFAV($row[2],$id_user)' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M3 3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V3z'/></svg></button>";
                }else{
                    $button ="<button class='btn btn-outline-primary' onclick='addFAV($row[2],$id_user)' name='add'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 12l5 3V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v10.234z'/></svg></button>";
                }
                $date=date('d.m.y H:i',$row[1]);
                $id=$row[2];
                $count=$row[3];
                $delres = 'delres'.$id;
                $countres = 'countres'.$id;
                    echo"
                    <tr>
                                <td><a href='message.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td><div class='$countres'>$count</div></td>
                                <td class='$id'><div class='$id'>$button</div></td>
                            </tr>";
            }
                
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     <a href='add_question.php?id=$id_cat' class='btn btn-primary'>Добавить обсуждение</a></div>
     ";

}
}else{
    echo '<div class="table-responsive" >
        <table class="table">
            <thead>
                <tr>
                    <th>Обсуждение</th>
                    <th >Дата создания</th>
                    <th >Кол-во сообщений</th>
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
                                <td><a href='message.php?id=$id&page=1'>$row[0]</a></td>
                                <td>$date</td>
                                <td>$count</td>
                                
                            </tr>";
            }
                
if($question_can==0){
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     Чтобы добавлять обсуждение зарегестрируйтесь</div>
     ";
}else{
    echo"         </tbody>
       </table>
    </div><div style='margin-left: 10px;'>
     В этой теме нельзя добавлять обсуждения</div>
     ";
}
}




if(isset($_POST['delete']) && $admin==1){
    include("lib/lib_del.php");
    $idt = $_GET['id_del'];
    $id_cat = $_GET['id'];
    deleteTHEME($link,$idt);
        echo "<script>alert('Удалено')
            location.href='theme.php?id=$id_catt'
        </script>";
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
<a href='theme.php?id=<? echo "$id_cat";?>&page=<? echo 'start' ?>' name="back" 
            <? if((int)$page <= 1)
            {
                echo"class = 'page-link disabled'";
            }else{
                echo"class = 'page-link'";
            }?>>&laquo;</a></li>
    <li class="page-item">
<a href='theme.php?id=<? echo "$id_cat";?>&page=<? echo $page-1; ?>' name="back" 
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
    echo "<li class='page-item'><a class='page-link' href='theme.php?id_cat=$id_cat&page=$i1'> $i1 </a></li>";
} else{
    echo "<li class='page-item active'><a class='page-link disabled' href='theme.php?id_cat=$id_cat&page=$i1'> $i1 </a></li>";
}
        # code...
 }
 ?><li class="page-item"><a href='theme.php?id=<? echo "$id_cat";?>&page=<? echo $page+1; ?>' name="forward" <? if((int)$page >= $count_page_theme){
    echo"class = 'page-link disabled'";
 }else{
    echo"class = 'page-link'";
 } ?>>Вперед</a>
     </li>
     <li class="page-item"><a href='theme.php?id=<? echo "$id_cat";?>&page=<? echo 'end'; ?>' name="forward" <? if((int)$page >= $count_page_theme){
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
//echo "$id_cat $question_can";
?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Navbar---Apple.js"></script>
</body>
</html>