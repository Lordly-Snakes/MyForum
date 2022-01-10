<?php
//sassssssssssss
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
if (isset($_SESSION['id']) || (isset($_COOKIE['login']) && isset($_COOKIE['password']))) 
{
	$login=$_COOKIE['login'];
    
    $link=connecting();
    $rez = mysqli_query($link,"SELECT login,reg_date,mail,image,id,is_admin,is_ban FROM users WHERE login='$login'");
    

        $row = mysqli_fetch_row($rez);
        if($row[0]==$login){
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


        	$id_u = $row[4];
            $mail=$row[2];
            $datein=$row[1];
            if($row[3]!=NULL){
            $path = $row[3];
            }else{
                $path="image/null.jpg";
            }
        }
    try {
        $size = getimagesize($path);
    } catch (Exception $e) {
        $path="image/null.jpg";
        $size = getimagesize($path);
    }
    
    $wid=$size[0]/5;
    $he=$size[1]/5;
}else{
    header("Location: $dire/forum/authentication/authentication.php");
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/fonts 2/ionicons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Мой профиль</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
    <script type="text/javascript">
    function editLOG(strlog){
        
        //var log = document.getElementById('log');
        //var mai = document.getElementById('mai');
        var textlog = document.querySelector('td#log').innerHTML;
        //alert(textlog);
        //var textmai =mai.value;
        if(strlog == textlog){
           // alert(textlog);
            $('.ress').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Чтобы изменить логин нажмите на него и оредактируйте<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
        }else if(textlog==""){
            $('.ress').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Пустое поле<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
        }else{
            //alert(textlog);
            $.ajax({
            url: 'edit_engine.php',
            type: "POST",
            data: {"log": textlog,"type":0},
            success: function(data) {
                if(data=="0"){
                    $('td#log').html(textlog);
                    $('#btnLOG').html("<button class='btn btn-primary'  onclick=editLOG(\'"+textlog+"\')>Изменить</button>");
                    $('.ress').html("<div class='alert alert-success alert-dismissible fade show' role='alert'>Логин успешно изменен<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span></button></div>");
                }else{
                    $('.ress').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>"+data+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
                }
                //$('.banning').html(data);
            }
            });
        }
        
    }
        function editMAIL(strlog){
        
        //var log = document.getElementById('log');
        //var mai = document.getElementById('mai');
        var textlog = document.querySelector('td#mai').innerHTML; 
        //var textmai =mai.value;
        if(strlog == textlog){
           // alert(textlog);
            $('.ress').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Чтобы изменить адрес электронной почты нажмите на него и оредактируйте<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
        }else if(textlog==""){
            $('.ress').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Пустое поле<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
        }else{
            //alert(textlog);
            $.ajax({
            url: 'edit_engine.php',
            type: "POST",
            data: {"mail": textlog,"type":1},
            success: function(data) {
                if(data=="0"){
                    $('td#mai').html(textlog);
                    $('#btnMAI').html("<button class='btn btn-primary'  onclick=editMAIL(\'"+textlog+"\')>Изменить</button>");
                    $('.ress').html("<div class='alert alert-success alert-dismissible fade show' role='alert'>Адрес электронной почты успешно изменен<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span></button></div>");
                }else{
                    $('.ress').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>"+data+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
                }
                //$('.banning').html(data);
            }
            });
        }
        
    }
    
    	function dob(){
    		
    		var element = document.getElementById('messs');
    
    		id= element.value;
    		type = 1;
    	if(id == ''){
    		$('.res').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Пустое поле<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
    	}else{	
	    $.ajax({
	        type: "POST",
	        data: {"mess":id,"type":type},
	        url: 'alert_engine.php',
	        success: function(data) {
	        	if(data == '0'){
	                $('.res').html("<div class='alert alert-success alert-dismissible fade show' role='alert'>Добавлено, обновите страницу чтобы увидеть уведомление<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
	            }else{
	                $('.res').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Неизвестная ошибка<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
	            }
	        }
	    });  
		}
    	}
    	function delALERT(id){
    		type = 0;
	    $.ajax({
	        type: "POST",
	        data: {"type":type,"id":id},
	        url: 'alert_engine.php',
	        success: function(data) {
		        if(data == '0'){
	                $('.res').html("<div class='alert alert-success alert-dismissible fade show' role='alert'>Удалено<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
	            }else{
	                $('.res').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Неизвестная ошибка<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
	            }
	        }
	    }); 
    	}
    </script>
</head>
<body>    
<? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php"; ?>

<?include_once "$_SERVER[DOCUMENT_ROOT]/forum/alert.php";?>
<div class="ress"></div>
<div class="table-responsive">
        <table class="table">
            <thead>
                <tr></tr>
            </thead>
            <tbody>
                <tr>
                    <td  width=400px height=100px><? $rnf=time(); echo "<img class='img-thumbnail' src='$path'?cache='$rnf' alt='$login'    width='80px' heigth='100%' />";?></td>
                    <td>
                        <form class="form-inline" action="download_img.php" method="post" name="file" ENCTYPE="multipart/form-data">
                            <div class="form-group">
                                <div class="file-drop-area"><span class="fake-btn" >Выберите файл</span><span class="file-msg" style="width: 100px;">or drag and drop files here</span><input type="file" class="file-input"
                                        style="width: 170px;" name="file" >
                                        </div>
                            </div>
                            
                    </td>
                    <td colspan="" style="vertical-align: auto;" align="left"><input type="submit" name="upload"  value="Загрузить" class="btn btn-success"></form></td>
                </tr>
                <tr>
                    <td>Логин</td>
                    <td colspan=""  contenteditable id="log"><?echo"$login";?></td>
                    
                    <td id="btnLOG"><!--<form action="res.php">--><button class="btn btn-primary"  onclick="editLOG('<?echo"$login";?>')">Изменить</button></td>
                </tr>

                <tr>
                	<td colspan="">Уникальный идентификатор</td>
          
                	<?  
							echo "<td>$id_u</td>";
						
 					?>
 					<td></td>
                </tr>
                <tr>
                	<td colspan="1">Статус</td>
                	<?  
							echo "<td colspan='' >$status</td>";
						
 					?>
 					<td></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td  contenteditable id="mai"><?echo"$mail";?></td>
                    
                    <td id="btnMAI" colspan="" align="left"><button class="btn btn-primary" onclick="editMAIL('<?echo"$mail";?>')">Изменить</button></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Дата регистрации</td>
                    <td colspan=""><? echo date("d.m.y H:i",$datein); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><? echo "<form action='delete.php?id=$id_u' method='post'>"; ?> <button class="btn btn-primary" onclick="return confirm('Вы уверены, что хотите удалить профиль, действие нельзя отменить')">Удалить аккаунт</button></form></td>
                    
                    <td colspan="" style="text-align: left;"><? echo "<form action='notification_settings.php' method='get'>"; ?> <button class="btn btn-primary disabled" disabled="" data-toggle="tooltip" data-placement="top" title="Настройки в данный момент не доступны, ибо мы ведем работу по настройке системы уведомлений, приносим свои извинения за доставленные неудобства">Настройки уведомлений</button></form></td>

              		
                </tr>
				<?
				 if($row[5]==1){
				 	echo "                <tr>

				                	<td colspan='2'>
				                		<textarea class='form-control' style='width: 100%' id='messs' placeholder='объявление'></textarea>
				                	</td>
				                	
				                	<td align='left'>
				                		<button class='btn btn-primary' onclick='dob()'  >Добавить объявление на форум</button>
				                	</td>
				                	
				            	</tr>";
				 }
				?>
			
			<tr>
				<td colspan="3"><div class="res"></div></td>
			</tr>
            </tbody>
        </table>
        </div>
        <div class="r">
        <?
				if($row[5]==1){
				$result_ = mysqli_query($link,"SELECT * FROM alert");
				$num = mysqli_num_rows($result_);
				for ($i=0; $i < $num; $i++) { 
						$row_=mysqli_fetch_row($result_);

				                echo"
			        <div class='alert alert-success alert-dismissible fade show' role='alert'>
					  <h4 class='alert-heading'>Объявление для всех</h4>
					  <p>$row_[1]</p>
					  <hr>
					  <p class='mb-0'>Нажмите крестик чтобы удалить это объявление с форума</p><button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='delALERT($row_[0])'>
					    <span aria-hidden='true'>&times;</span>
					  </button>
					</div>
			        ";
						# code...
					}
				}
				?>	
    </div>
    <script type="text/javascript">
	function closing(){
		
		document.getElementById('aler').style.marginTop='50px';
	}
</script>
    <style type="text/css">
        .fake-btn {
    flex-shrink: 0;
    background-color: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 3px;
    padding: 4px 9px;
    margin-right: 10px;
    font-size: 12px;
    text-transform: uppercase;
            }
            .file-drop-area {
    position: relative;
    display: flex;
    align-items: center;
    width: 260px; 
    max-width: 100%;
    padding: 10px;
    border: 1px dashed rgba(0, 0, 0, 0.8);
    border-radius: 3px;
    transition: 0.2s;
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
        
    }
    .alert.alert-success.alert-dismissible{
        width: 100%;
         
    }
    .r{
        margin-right: 20px;
    }
    .ress{
        margin-right: 20px;
    }
    
    </style>
    <script src="assets2/js/jquery.min.js"></script>
    <script src="assets2/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets2/js/Drag-and-Drop-File-Input.js"></script>
    <script src="assets2/js/Navbar---Apple.js"></script>
    <script src="assets2/js/Profile-Edit-Form.js"></script>
</body>
</html>



