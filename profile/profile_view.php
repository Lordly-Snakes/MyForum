<?php
//sassssssssssss
header ("Pragma-directive: no-cache");
header ("Cache-directive: no-cache");
header ("Cache-control: no-cache");
header ("Pragma: no-cache");
header ("Expires: 0");
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
$id = $_GET['id'];
$link=connecting();
$rez = mysqli_query($link,"SELECT login,reg_date,mail,image,id,is_admin,is_ban FROM users WHERE id='$id'");
$row = mysqli_fetch_row($rez);
            $login=$row[0];
            if($_COOKIE['login'] == $login){
                header('Location: profile.php');
            }else{
            $id_u = $row[4];
            $mail=$row[2];
            $datein=$row[1];
            $ban_status  = $row[6];
            if($row[3]!=NULL){
            $path = $row[3];
            }else{
                $path="image/null.jpg";
            }
            
$log_user = $_COOKIE['login'];
$rez2 = mysqli_query($link,"SELECT login,is_admin FROM users WHERE login='$log_user'");
$row2 = mysqli_fetch_row($rez2);
$admin = $row2[1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><? echo "$login"; ?></title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<style>
    .stats p{
        margin: 0 0 0 0;

    }
    .stats{

        display: inline-block;
        margin: 0 0 0 0;
    }
</style>
<script type="text/javascript">
function ban(id_user){
    $.ajax({
        url: 'ban_now.php?id='+id_user,
        success: function(data) {
            $('.banning').html(data);
            if(data=='В бане, что бы разбанить обновите страницу'){
                $('.stats').html("<p class='badge badge-danger'>в бане</p>");    
            }
        }
    });
}
function not_ban(id_user){
    $.ajax({
        url: 'ban_not.php?id='+id_user,
        success: function(data) {
            $('.banning').html(data);
            if(data=='Разбаннен'){
                $('.stats').html('');
            }
        }
    });
}
function changeSTATUS(id_user){
    var n = document.getElementById("vubor").options.selectedIndex;
    var val = document.getElementById("vubor").options[n].value;
    $.ajax({
        url: 'change_status.php?mod='+val+'&id='+id_user,
        success: function(data) {
            $('.tres').html(data);
        }
    });
}
</script>
    <style type="text/css">
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
    <script type="text/javascript">
    function closing(){
        
        document.getElementById('aler').style.marginTop='50px';
    }
</script>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php"; ?>

<?include_once "$_SERVER[DOCUMENT_ROOT]/forum/alert.php";?>
<div class="table-responsive">
        <table class="table">

            <tbody>
                <tr>
                    <td  width=400px height=100px colspan="3"><? $rnf=time(); echo "<img class='img-thumbnail' src='$path'?cache='$rnf' alt='$login'    width='80px' heigth='100%' />";?></td>
                    
                </tr>
                <tr>
                    <td>Логин</td>
                    <td colspan="2"><?echo"$login";?></td>
                </tr>
                <tr>
                    <td>Статус</td>
                    <?          if($row[6]==1){
                                    $ban_status = "<p class='badge badge-danger'>в бане</p>";
                                }else{
                                    $ban_status = "";
                                }
                    if($admin==1){
                            if($row[5]==0){
                                echo "
                                <td colspan='2' ><select onchange='changeSTATUS($id_u)' class='custom-select' id='vubor'>
                                <option class='disabled' value='1' disabled>Админ</option>
                                <option selected value='0'>Подписчик</option>
                                <option value='2'>Модератор</option>
                                </select> <div class='stats'>$ban_status</div></td>";
                            }else if($row[5]==1){
                                echo "
                                <td colspan='2' ><select onchange='changeSTATUS($id_u)' class='custom-select' id='vubor'>
                                <option value='1' selected>Админ</option>
                                <option  value='0'>Подписчик</option>
                                <option value='2'>Модератор</option>
                                </select> <div class='stats'>$ban_status</div></td>";
                            }else{
                                echo "
                                <td colspan='2' ><select  onchange='changeSTATUS($id_u)' class='custom-select' id='vubor'>
                                <option class='disabled' value='1' disabled>Админ</option>
                                <option  value='0'>Подписчик</option>
                                <option  value='2' selected>Модератор</option>
                                </select> <div class='stats'>$ban_status</div></td>";
                            }
                            
                        }
                        else{
                                if($row[5]==1){
                                    $admin_status = "<p class='badge badge-primary'>Админ</p>";
                                }else if($row[5]==0){
                                    $admin_status = "<p class='badge badge-dark'>Подписчик</p>";
                                }else{
                                    $admin_status = "<p class='badge badge-info'>Модератор</p>";
                                }
                            echo "<td colspan='2' >$admin_status <div class='stats'>$ban_status</div></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><?echo"$mail";?></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Дата регистрации</td>
                    <td colspan="2"><? echo date("d.m.y H:i",$datein); ?></td>
                </tr>
                <tr><? 
                if($row[6]){
                    $ban_button="<button class='btn btn-success'  onclick='not_ban($id_u)'>разбан</button>";
                }else{
                    $ban_button="<button class='btn btn-danger'  onclick='ban($id_u)'>В БАН</button>";
                }
                if($admin==1){echo "
                    <td colspan='1' style='text-align: center;''><form action='delete.php?id=$id_u' method='post'> <button class='btn btn-primary' onclick='return one()'>Удалить этот аккаунт</button></form></td>
                    <td colspan='1' style='text-align: center;''><form action='add_notify_by_admin.php?id_user=$id_u' method='post'> <button class='btn btn-primary'>Написать</button></form></td><td class='banning'>$ban_button 
                    </td>";}else if($admin == 2){
                        echo "
                    <td style='text-align: center;''><form action='add_notify_by_admin.php?id_user=$id_u' method='post'> <button class='btn btn-primary'>Написать</button></form></td>
                    <td class='banning'>$ban_button 
                    </td>";
                    } ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="tres" style="margin-left: 10px;"></div>
    <script>
        function one(){
        return confirm("Вы уверены?");
    }
    </script>
    <script src="assets2/js/jquery.min.js"></script>
    <script src="assets2/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets2/js/Drag-and-Drop-File-Input.js"></script>
    <script src="assets2/js/Navbar---Apple.js"></script>
    <script src="assets2/js/Profile-Edit-Form.js"></script>
    <style type="text/css">
        .disabled{
            color: grey;
        }
    </style>
</body>
</html>



