<?php 
// Проверяем id темы
if(isset($_GET['id']) && $_GET['id'] != ''){
    include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    $link = connecting();
    include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
    $dire= dirr();
    // Получаем id темы
    $id = $_GET['id'];
    if($id=='poisk'){
        $id_mess_poisk = $_GET['id_mess'];
        $count_mess_poisk  =mysqli_query($link,"SELECT id_message,id_theme FROM messages WHERE id_message='$id_mess_poisk'");
        $row_poisk_mess = mysqli_fetch_assoc($count_mess_poisk);
        $id_th_p = $row_poisk_mess['id_theme'];
        if($id_th_p != NULL && $id_th_p != ''){
            $rez_poisk = mysqli_query($link,"SELECT name_theme,time,id_them,description,count FROM theme WHERE id_them='$id_th_p'");
            $rez_p = mysqli_fetch_assoc($rez_poisk);
            $count_page=ceil((int)$rez_p['count'] / 10);
            if($count_page > 0){
                for ($i=1; $i <= $count_page; $i++) {
                    $start = ($i-1)*10; 
                    $poisk = mysqli_query($link,"SELECT message,id_message,id_theme,id_user,time_mess FROM messages WHERE id_theme='$id_th_p' LIMIT $start,10");
                    for ($j=0; $j < 10; $j++) { 
                        $poisk_page = mysqli_fetch_assoc($poisk);
                        if($poisk_page['id_message'] == $id_mess_poisk){
                        	if($j == 9){
                        		$id_mess_poisk--;
                        	}
                            $query = "message.php?id=$id_th_p&page=$i&mod=$id_mess_poisk";
                            break 2;
                        }
                    }
                }
                if(isset($query)){
                    header("Location: $query");    
                }else{
                    header("Location: message.php?id=$id_th_p");    
                }
            }else{
                header("Location: message.php?id=$id_th_p");
            }    
        }else{
            header("Location: forum.php");
        }
        
    }else{
    // Получаем номер страницы
        if (isset($_GET['page'])) {
            $page = $_GET['page'];        # code...
        }else{
            $page = 'start';
        }
        // ??????????????
        setcookie ("id_th", $id, time() + 50000, '/');
        // Подключаем библиотеку для соединения с БД
        
        $login = $_COOKIE['login'];
        $rez_log = mysqli_query($link,"SELECT id,is_admin,login,is_ban FROM users WHERE login='$login'");
        $r_admin = mysqli_fetch_row($rez_log);
        $admin = $r_admin[1];
        $ban_status = $r_admin[3];
        // Получаем данные о теме в которой находимся
        $rez = mysqli_query($link,"SELECT name_theme,time,id_them,description,count,type FROM theme WHERE id_them='$id'");
        
        $row = mysqli_fetch_row($rez);
        $type_theme = $row[5];
        $name=$row[0];
        if($name != '' && $name != NULL){
            $description=$row[3];
            $count = $row[4];
            // Считаем кол-во записей в этой теме
            $count_mess  =mysqli_query($link,"SELECT COUNT('id') as 'num' FROM messages WHERE id_theme='$id'");
            $count_res = mysqli_fetch_row($count_mess);
            // проверяем что в бд именно такое кол-во
            if($count_res[0] != $count){
                mysqli_query($link,"UPDATE theme SET count='$count_res[0]' WHERE id_them='$id'");
            }
            // Подсчитываем кол-во страниц

            $count_page=ceil((int)$count_res[0] / 10);
            if(!$count_page){
                $count_page=1;
            }
            // проверяем что модификатор page в диапозоне доступных страниц для этой темы
            if($page == 'start'){
                header("Location: message.php?id=$id&page=1");
            }else if($page == 'end'){
                header("Location: message.php?id=$id&page=$count_page");
            }else{
                if($page > $count_page){
                    header("Location: message.php?id=$id&page=$count_page");
                }else if($page < 1){
                    header("Location: message.php?id=$id&page=1");
                }else{
                    // с какой записис будет отображаться(зависиит от страницы)
                    $start = ($page-1)*10;
                }
            }

            // Запрос на получение записей
            $rez2 = mysqli_query($link,"SELECT message,id_message,id_theme,id_user,time_mess FROM messages WHERE id_theme='$id' LIMIT $start,10");
            $num_mess = mysqli_num_rows($rez2);
            // подключения шаблона навбара специально для сообщений    
            include 'template/message_temp.php';
        }else{
            //header("Location: forum.php");    
        }
    }
    }
    
    else
    {
        //header("Location: forum.php");
    }
    $start++;
?>
<script type="text/javascript">

function slowScrol(id) {
    $('html,body').animate({
        scrollTop: $(id).offset().top
    },600);
    
        <?
   // if(isset($_GET['mod'])){
       // $id_mess = $_GET['mod'];
   //    echo "slowScrol('#$id_mess);";
    //}
    ?>
}
    //document.body.scrollTop = document.body.scrollHeight - document.body.clientHeight;
function copy(id_mess){
 mess ='<? echo($dire); ?>/forum/message.php?id=poisk&id_mess='+id_mess;   
 cop(mess,id_mess);
}
function cop(str,id){
  let tmp   = document.createElement('INPUT'), // Создаём новый текстовой input
      focus = document.activeElement; // Получаем ссылку на элемент в фокусе (чтобы не терять фокус)

  tmp.value = str; // Временному input вставляем текст для копирования

  document.body.appendChild(tmp); // Вставляем input в DOM
  tmp.select(); // Выделяем весь текст в input
  document.execCommand('copy'); // Магия! Копирует в буфер выделенный текст (см. команду выше)
  document.body.removeChild(tmp); // Удаляем временный input
  focus.focus();
  $('#'+id).html('Скопировано'); // Возвращаем фокус туда, где был
}
</script>
<style>
    .a{
        text-decoration: none;
        text-decoration-color: black;
        text-decoration-line: none;
        color: black;
    }
    .a:hover{
        text-decoration: none;
        text-decoration-color: black;
        text-decoration-line: none;
        color: black;
    }
    #word{
        word-break: break-all;
    }
    .ss{
        cursor: pointer;
            outline: none;
      -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none;   /* Chrome/Safari/Opera */
  -khtml-user-select: none;    /* Konqueror */
  -moz-user-select: none;      /* Firefox */
  -ms-user-select: none;       /* Internet Explorer/Edge */
  user-select: none;
    }
    .ss:hover{
        color: blue;
    }
    .messss{
        cursor: pointer;

    }
</style>
<body <? if(isset($_GET['mod'])){
        $f = $_GET['mod'] - 1;
        $id_mess = '#'.$f;
       echo "onload=slowScrol('$id_mess')";
    }?>>
<div id="main">
 <div class="table-responsive table-bordered  shadow-sm" style="margin-bottom: 0px; width: 100%;">
        <table class="table table-bordered"  id="tab">
            <tbody>
                <tr style=" ">
                    <td class="text-center" style="padding-top: 60px;border-top: black 2px solid; border-right: black 2px solid; border-left: black 2px solid; color: white; height: 41px; background-image: url('back/colors.jpg');" colspan="3"><? echo"<h2> $name </h2>"; ?></td>
                </tr>
                <!-- "Это  блок сообщений должен быть в цикле"  -->
                <?php 
                for ($i = 0 ; $i < $num_mess ; ++$i)
    			{
    				$row = mysqli_fetch_row($rez2);
                    $id_mess=$row[1];
                    $timin = date("d.m.y H:i:s",$row[4]);
    				//$date=date('d.m.y H:i',$row[1]);
    				$mess=$row[0];
                    $rx=preg_replace('/(?<!\w)<(\w+|[а-яА-Я]+|@)>(@)/u',"<a href='$dire/forum/message.php?id=poisk&id_mess=\\1'><\\1></a>@",$mess);
                    $str_mess = (string)$rx;
                    $array_=seacrh_($link,$row[3]);
                    $path=$array_['image'];
                    $user = (string)$array_['account'];
                    $status = $array_['status'];
                    $str_id = $id_mess.'mess';
                    $id_span_mess = 'mess'.$id_mess;
                    $id_user_mess = 'user'.$id_mess;
                    $edit_icon="<svg width='1.5em' height='1.5em' viewBox='0 0 16 16' class='bi bi-pen' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  <path fill-rule='evenodd' d='M5.707 13.707a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391L10.086 2.5a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-7.793 7.793zM3 11l7.793-7.793a1 1 0 0 1 1.414 0l.586.586a1 1 0 0 1 0 1.414L5 13l-3 1 1-3z'/>
  <path fill-rule='evenodd' d='M9.854 2.56a.5.5 0 0 0-.708 0L5.854 5.855a.5.5 0 0 1-.708-.708L8.44 1.854a1.5 1.5 0 0 1 2.122 0l.293.292a.5.5 0 0 1-.707.708l-.293-.293z'/>
  <path d='M13.293 1.207a1 1 0 0 1 1.414 0l.03.03a1 1 0 0 1 .03 1.383L13.5 4 12 2.5l1.293-1.293z'/>
</svg>";
                    $reply_icon = "<svg width='1.5em' height='1.5em' viewBox='0 0 16 16' class='bi bi-reply' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  <path fill-rule='evenodd' d='M9.502 5.013a.144.144 0 0 0-.202.134V6.3a.5.5 0 0 1-.5.5c-.667 0-2.013.005-3.3.822-.984.624-1.99 1.76-2.595 3.876C3.925 10.515 5.09 9.982 6.11 9.7a8.741 8.741 0 0 1 1.921-.306 7.403 7.403 0 0 1 .798.008h.013l.005.001h.001L8.8 9.9l.05-.498a.5.5 0 0 1 .45.498v1.153c0 .108.11.176.202.134l3.984-2.933a.494.494 0 0 1 .042-.028.147.147 0 0 0 0-.252.494.494 0 0 1-.042-.028L9.502 5.013zM8.3 10.386a7.745 7.745 0 0 0-1.923.277c-1.326.368-2.896 1.201-3.94 3.08a.5.5 0 0 1-.933-.305c.464-3.71 1.886-5.662 3.46-6.66 1.245-.79 2.527-.942 3.336-.971v-.66a1.144 1.144 0 0 1 1.767-.96l3.994 2.94a1.147 1.147 0 0 1 0 1.946l-3.994 2.94a1.144 1.144 0 0 1-1.767-.96v-.667z'/>
</svg>";
                    $trash_icon = "<svg width='1.5em' height='1.5em' viewBox='0 0 16 16' class='bi bi-trash' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
						  <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
						  <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
						</svg>";
                    if($admin){
                            echo "
                    <tr>
                        <td class='text-center' colspan='3' style='height: 6px;font-size: 10px;padding: 2px; border-top:  solid 2px; border-left: solid 2px; border-right: solid 2px;' >$timin <span class='ss' id='$id_mess' ondblclick='copy($id_mess)'>дважды нажмите чтобы скопировать ссылку на сообщение</span></td>
                    </tr>
                    <tr>
                        <td rowspan='2' style='width: 110px; border-left: solid 2px'><a href='profile/profile_view.php?id=$row[3]'><img class='img-thumbnail' src='profile/$path'?cache='$rnf' alt='profile/$path' width='80px' heigth='100%' /></a></td>
                        <td class='text-left' rowspan='3' id='word'><span class='messss' id='$id_span_mess' onclick=addCITE($id_mess)>$rx</span></td>
                        <td style='width: 97px; border-right: solid 2px'>$start</td>
                    </tr>
                    <tr>
                        <td style='border-right: solid 2px'>
                        <form action='delete_mess.php?id=$id_mess' method='post'><button  style='font-size: 10px;' onclick='return one()' class='btn  btn-outline-danger'>$trash_icon</button></form>
                        </td>
                    </tr>
                    <tr style='font-size: 12px;'>
                        <td class='text-center' style='border-left: solid 2px;'><a class='a' href='profile/profile_view.php?id=$row[3]'><b><span id='$id_user_mess'>$user</span><br>$status</b></a></td>
                        <td colspan='2' style='border-right: solid 2px'><button  style='font-size: 10px;' onclick=addCITE($id_mess) class='btn  btn-outline-info'>$reply_icon</button><button  style='margin-top:10px;font-size: 10px;' onclick=editing($id_mess) class='btn  btn-outline-primary'>$edit_icon</button></td>
                    </tr>";
                    }else{
                        echo "
                    <tr>
                        <td class='text-center' colspan='3' style='height: 6px;font-size: 10px;padding: 2px; border-top:  solid 2px; border-left: solid 2px; border-right: solid 2px;' ondblclick='copy($id_mess)'>$timin <span class='ss' id='$id_mess' ondblclick='copy($id_mess)'>нажмите правой кнопкой чтобы скопировать ссылку на сообщение</span></td>
                    </tr>
                    <tr>
                        <td rowspan='2' style='width: 110px; border-left: solid 2px'><a href='profile/profile_view.php?id=$row[3]'><img class='img-thumbnail' src='profile/$path'?cache='$rnf' alt='profile/$path' width='80px' heigth='100%' /></a></td>
                        <td class='text-left' rowspan='3' id='word'><span class='messss' id='$id_span_mess' onclick=addCITE($id_mess)>$rx</span></td>
                        <td style='width: 97px; border-right: solid 2px'>$start</td>
                    </tr>
                    <tr>
                        <td style='border-right: solid 2px'></td>
                    </tr>
                    <tr style='border-bottom:  solid 2px;font-size: 12px;'>
                        <td class='text-center' style='border-left: solid 2px;'><a class='a' href='profile/profile_view.php?id=$row[3]'><b><span id='$id_user_mess'>$user</span><br>$status</b></a></td>
                        <td  style='border-right: solid 2px'><button  style='font-size: 10px;' onclick=addCITE($id_mess) class='btn  btn-outline-info'>$reply_icon</button>
                        </td>
                    </tr>
                    ";
                    } 
    		    	//include_once('block.php');
    		    	
                    $start++;
    			}

                function seacrh_($link,$id){
                    $rez = mysqli_query($link,"SELECT id,is_admin,is_ban,login,image FROM users WHERE id='$id'");
                        $row = mysqli_fetch_row($rez);
                        if($row[1] == 0){
                           $ad = "<p style='margin: 0 0 0 0;' class='badge badge-dark'>Подписчик</p>";
                        }else if($row[1] == 1){
                            $ad ="<p style='margin: 0 0 0 0;' class='badge badge-primary'>Админ</p>";
                        }else{
                            $ad ="<p style='margin: 0 0 0 0;' class='badge badge-info'>Модератор</p>";
                        }
                        if($row[2] == 0){
                           $bd =  "";
                        }else if($row[2] == 1){
                            $bd = "<span style='margin: 0 0 0 0;' class='badge badge-danger'>в бане</span>";
                        }
                        $one = $ad.$bd;
                        
                        if($row[3]!=NULL){
                            $two = $row[3];
                        }else{
                            $two = "Удаленный аккаунт";
                        }
                        if($row[4]!=NULL){
                            $three = $row[4];
                        }else{
                            $three = "image/null.jpg";
                        }
                        $res = array('status' => $one,'account' => $two,'image' => $three);
                        return $res;
                }
                ?>
                <!-- "Это  блок сообщений должен быть в цикле"  -->
            </tbody>
        </table>
        <div class="navigation" style=""><a  style="font-size: 10px; margin-top: 2px;" class='btn btn-primary ' href="#" onclick="slowScrol('#ending')">Вниз</a></div>
        <div class="ads" >
            <div>Реклама</div>
        </div>
    </div>
    <style type="text/css">
    	html{
    		overflow-x:  hidden;
    	}
		@media (min-width:701px){
			.ads{
				float: left;
				background-color: var(--primary); 
				margin-top: 2px;
			}
			#tab{
				width: 80%; float: left; 
			}
			.navigation{
				width: 20%; display: inline-block; margin-top: 50px;
			}
		}
.footer{
    
        width:80%;
    
}

		@media (max-width:700px){

			.ads{
				float: none;
				background-color: var(--primary); 
				margin-bottom: 5px;
			}
			.navigation{
				position: fixed;
				width: 100%;
				top: 52px;

			}
			#tab{
				width: 100%;
				margin-bottom: 2px;
			}

		}
    	.ads{

    	}
        .footer>button,a{
            
            display: inline-block;
            padding: 3px;
            
                        
        }
        .footer{
            margin-bottom: 500px; 
            margin-left: 20%; 
            
        }
        	#tab{

        	}
    </style>
    <div class="footer">

        <?
        // подключаем переключатель страниц 
        include_once('template/DrivePage_temp.php');?>

    <div><a style="float: left; font-size: 10px; margin-left: 10px;" class='btn btn-outline-primary' href="#" onclick="slowScrol('#upp')">Вверх</a></div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
    <script type="text/javascript">
        function one(){
        return confirm("Вы уверены?");
    }
    </script>
    <div style="z-index: 100;" id="ending">
                <div>
    <?
    if(!$type_theme || $admin==1){
    if(isset($_COOKIE['login'])){
            if ($ban_status) {
                include_once('template/ban_mess_temp.html');
            }else{
                include_once('template/add_mess_temp.php');    
            }
        }else{
            include_once('template/NoLogAddMessTemp.html');
        }} 
    // Подключаем блок для добавления сообщений
    ?>    
    </div>
</div>
</body>
</html>