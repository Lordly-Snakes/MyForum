<?
	if(!isset($_COOKIE['login']))
	{
		header("Location: profile/profile.php");
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
    <title>Избранное</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
function delFAV(id){
	$.ajax({
  		url: 'delete_fav.php?id='+id,
  		success: function(data) {
    		$('.'+id).html(data);
  		}
	});
}
function deleteNOTIFY(id_theme,id_user){
	$.ajax({
  		url: 'delete_notify.php?id_t='+id_theme+'&id_u='+id_user,
  		success: function(data) {
    		$('.notify'+id_theme).html(data);
  		}
	});
}
function delALLNOT(id_user){
    $.ajax({
        url: 'delete_all_notify.php?id_u='+id_user,
  		success: function(data) {
    		
    		$('.resulting').detach();
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
	
<?
include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$link = connecting();
include_once "$_SERVER[DOCUMENT_ROOT]/forum/alert.php";?>
<?
include 'directory.php';
$dire= dirr();

$minus ="<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-bookmark-dash' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  <path fill-rule='evenodd' d='M11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zM4.5 2a.5.5 0 0 0-.5.5v11.066l4-2.667 4 2.667V8.5a.5.5 0 0 1 1 0v6.934l-5-3.333-5 3.333V2.5A1.5 1.5 0 0 1 4.5 1h4a.5.5 0 0 1 0 1h-4z'/>
</svg>";
if(isset($_COOKIE['login'])){
		$log_user = $_COOKIE['login'];
		$rezult = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login='$log_user'");
		$r = mysqli_fetch_row($rezult);
		$result = mysqli_query($link,"SELECT * FROM favorites INNER JOIN theme ON favorites.id_fav_theme=theme.id_them WHERE favorites.id_user = '$r[0]'");
		$str = mysqli_num_rows($result);
		include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
		echo '<div class="table-responsive" >
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>Тема</th>
	                    <th>Дата создания</th>
	                    <th></th>
	                </tr>
	            </thead>
	            <tbody>';
	            for ($i = 0 ; $i < $str ; ++$i)
			    {
			    	
				    $row = mysqli_fetch_row($result);
				    $reg = date('d.m.y H:i',$row[7]);
			        echo"
			        <tr>
			                <td>$row[5]</td>
			                <td>$reg</td>
			                <td ><div class='$row[0]'><button class='btn btn-primary' onclick='delFAV($row[0])'>$minus</button></div></td>
			        </tr>
			                

			        ";
			    }
	    echo "</tbody></table></div><hr>";
	    echo "<div style='margin-left: 10px; margin-bottom: 20px;'><h3>Уведомления</h3></div>";
		echo "<div class='resulting' style='margin-left: 0px;  	margin-right: 20px;'>";
		$not = mysqli_query($link,"SELECT * FROM notification WHERE id_user='$r[0]'  ORDER BY id_not DESC");
		$not_count = mysqli_num_rows($not);
		for ($i = $not_count; $i > 0; --$i)
			    {
				    $not_row = mysqli_fetch_row($not);
				    $string = "notify".$not_row[0];
				    if($not_row[2] !='' && $not_row[4]==NULL){
			        echo"
			        <div class='alert alert-success alert-dismissible fade show' role='alert'>
					  <h4 class='alert-heading'>Новое сообщение в избранной теме</h4>
					  <p>в теме <a href='message.php?id=$not_row[2]&page=end' onclick='deleteNOTIFY($not_row[0],$r[0])'>$not_row[3]</a> новое сообщение</p>
					  <hr>
					  <p class='mb-0'>Нажмите крестик чтобы закрыть сообщение</p><button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='deleteNOTIFY($not_row[0],$r[0])'>
					    <span aria-hidden='true'>&times;</span>
					  </button>
					</div>
			        ";
			        }else if($not_row[4] != NULL){
			        echo"<div class='alert alert-primary alert-dismissible' role='alert'>
					  <h4 class='alert-heading'>Новое упоминание</h4>
					  <p>$not_row[3] <a href='$dire/forum/message.php?id=poisk&id_mess=$not_row[4]' onclick='deleteNOTIFY($not_row[0],$r[0])'>здесь</a></td></p>
					  <hr>
					  <p class='mb-0'>Нажмите крестик чтобы закрыть сообщение</p><button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='deleteNOTIFY($not_row[0],$r[0])'>
					    <span aria-hidden='true'>&times;</span>
					  </button>
					</div>
			        ";
			        }else{
			        echo"<div class='alert alert-danger alert-dismissible' role='alert'>
					  <h4 class='alert-heading'>Сообщение от администрации</h4>
					  <p><q>$not_row[3]</q> </p>
					  <hr>
					  <p class='mb-0'>Нажмите крестик чтобы закрыть сообщение</p><button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='deleteNOTIFY($not_row[0],$r[0])'>
					    <span aria-hidden='true'>&times;</span>
					  </button>
					</div>
			        ";
			        }
			    }
			echo "</div><button onclick='delALLNOT($r[0])' style='margin-left: 10px; margin-bottom: 10px;' class='btn btn-primary'>Удалить все</button>";
			echo "<div class='result'></div>"; 	            	
	}
?>
<style type="text/css">
   q {
    font-family: Times, serif; /* Шрифт с засечками */
    font-style: italic; /* Курсивное начертание текста */
    color: navy; /* Синий цвет текста */
    quotes: "\00ab" "\00bb"; /* Кавычки в виде двойных угловых скобок */
   }
   div.alert{
   	width: 100%;

   }
</style>
</body>
<script type="text/javascript">
	function closing(){
		
		document.getElementById('aler').style.marginTop='50px';
	}
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Navbar---Apple.js"></script>
</html>