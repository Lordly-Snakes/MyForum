<?
include 'directory.php';
$dire= dirr();
include_once("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$link = connecting();
if(isset($_COOKIE['login'])){
    $log_user = $_COOKIE['login'];
    $rezult = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login='$log_user'");
    $r = mysqli_fetch_row($rezult);
    $admin = $r[2];
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];        # code...
}else{
    $page = 'start';
}
$pred_res  =mysqli_query($link,"SELECT COUNT('id') as 'num' FROM users");
$pred_count_theme = mysqli_fetch_row($pred_res);
$count_page_theme=ceil((int)$pred_count_theme[0] / 10);
 // проверяем что в бд именно такое кол-во
    // Подсчитываем кол-во страниц
if(!$count_page_theme){
    $count_page_theme=1;
}

    if($page == 'start'){
        header("Location: list_profile.php?page=1");
    }else if($page == 'end'){
        header("Location: list_profile.php?page=$count_page_theme");
    }else{
        if($page > $count_page_theme){
            header("Location: list_profile.php?page=$count_page_theme");
        }else if($page < 1){
            header("Location: list_profile.php?page=1");
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
    <title>Список профилей</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<style type="text/css">
    td{
        padding: 2px;
        margin: 1px;
    }
        @media (min-width:701px){

        }

        @media (max-width:700px){
            .btn-primary{
                font-size: 12px;
                padding: 2px;
            }
        }
                .alert{
            margin-left: 10px;
            
             
        }
        div.alert{
            width: 90%;
            margin-right: 10px;
        }
    .alert.alert-warning.alert-dismissible{

        width: 100%;
        margin-right: 10px;
        
    }
</style>

<body>

<?



$rez = mysqli_query($link,"SELECT id,login,reg_date,mail,image,is_admin,is_ban FROM users");
    $str = mysqli_num_rows($rez);
include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
?>
    
<?

include_once "$_SERVER[DOCUMENT_ROOT]/forum/alert.php";?>
<?
$trash_icon="<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-trash' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                          <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                        </svg>";
if(!$admin || $admin=='2'){
echo '<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                <th style="width: 30px;"></th>
                    <th>Логин</th>
                    <th>Статус</th>
                    
                    <th >Дата регистрации</th>
                    
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
    {
    	
    $row = mysqli_fetch_row($rez);
    $id = $row[0];
    $login_u = $row[1];
    $reg = date('d.m.y H:i',$row[2]);
    $mail = $row[3];
    if($row[5]==1){
        $admin_status = "<p class='badge badge-primary'>Админ</p>";
    }else if($row[5]==0){
        $admin_status = "<p class='badge badge-dark'>Подписчик</p>";
    }else{
        $admin_status = "<p class='badge badge-info'>Модератор</p>";
    }
    if($row[6]==1){
        $ban_status = " <p class='badge badge-danger'>в бане</p>";
    }else{
        $ban_status = "";
    }
    $status = $admin_status.$ban_status;
    if($row[4]!=NULL){
            $path = $row[4];
            }else{
                $path="image/null.jpg";
            }
        echo"
        <tr>
                    <td style='width: 30px;'><img src='profile/$path'?cache='$rnf' alt='profile/$path' width='30px' heigth='100%' /></td>
                    <td><a href='$dire/forum/profile/profile_view.php?id=$id'>$login_u</a></td>
                    <td>$status</td>
                    
                    <td>$reg</td>
                </tr>
                

        ";
    }
}else{
                
   echo '<div class="table-responsive" style="margin-top: 50px;">
        <table class="table">
            <thead>
                <tr>
                <th style="width: 30px;"></th>
                    <th>Логин</th>
                    <th>Статус</th>
                    
                    <th >Дата регистрации</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

            for ($i = 0 ; $i < $str ; ++$i)
    {
        
    $row = mysqli_fetch_row($rez);
    $id = $row[0];
    $login_u = $row[1];
    $reg = date('d.m.y H:i',$row[2]);
    $mail = $row[3];
        if($row[5]==1){
        $admin_status = "<p class='badge badge-primary'>Админ</p>";
    }else if($row[5]==0){
        $admin_status = "<p class='badge badge-dark'>Подписчик</p>";
    }else{
        $admin_status = "<p class='badge badge-info'>Модератор</p>";
    }
    if($row[6]==1){
        $ban_status = " <p class='badge badge-danger'>в бане</p>";
    }else{
        $ban_status = "";
    }
    $status = $admin_status.$ban_status;
 if($row[4]!=NULL){
            $path = $row[4];
            }else{
                $path="image/null.jpg";
            }
        echo"
        <tr>
                    <td style='width: 30px;'><img src='profile/$path'?cache='$rnf' alt='profile/$path' width='30px' heigth='100%' /></td>
                    <td><a href='$dire/forum/profile/profile_view.php?id=$id'>$login_u</a></td>
                    <td>$status</td>
                    
                    <td>$reg</td>
                <td><form action='profile/delete.php?id=$id' method='post'><button class='btn btn-primary' onclick='return one()'>$trash_icon</button></form></td>
                </tr>
                

        ";
    }
}
echo "</tbody></table></div>";
if(isset($_POST['delete'])){
include("lib/lib_del.php");
$idt = $_GET['id'];
deleteTHEME($link,$idt);
    echo '<script>alert("Удалено")
        location.href="forum.php"
    </script>';
}

?>
    <div style="margin-top: 30px;
    z-index: 100;
    position: relative;    
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
<a href='list_profile.php?page=<? echo 'start' ?>' name="back" 
            <? if((int)$page <= 1)
            {
                echo"class = 'page-link disabled'";
            }else{
                echo"class = 'page-link'";
            }?>>&laquo;</a></li>
    <li class="page-item">
<a href='list_profile.php?page=<? echo $page-1; ?>' name="back" 
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
    echo "<li class='page-item'><a class='page-link' href='list_profile.php?page=$i1'> $i1 </a></li>";
} else{
    echo "<li class='page-item active'><a class='page-link disabled' href='list_profile.php?page=$i1'> $i1 </a></li>";
}
        # code...
 }
 ?><li class="page-item"><a href='list_profile.php?page=<? echo $page+1; ?>' name="forward" <? if((int)$page >= $count_page_theme){
    echo"class = 'page-link disabled'";
 }else{
    echo"class = 'page-link'";
 } ?>>Вперед</a>
     </li>
     <li class="page-item"><a href='list_profile.php?page=<? echo 'end'; ?>' name="forward" <? if((int)$page >= $count_page_theme){
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
    @media (max-width: 420px){
    .table td{
    font-size: 13px;
    }
        .table th{
    font-size: 13px;
    }
    tr td:nth-child(2){
        word-break:break-all;
    }
}
</style>

    </div>
<script type="text/javascript">
    function one(){
        return confirm("Вы уверены?");
    }</script>
<script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   
    <script src="assets/js/Navbar---Apple.js"></script>
   <script type="text/javascript">
    function closing(){
        
        document.getElementById('aler').style.marginTop='50px';
    }
</script>

</body>
</html>