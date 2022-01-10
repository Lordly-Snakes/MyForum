<?
	if(!isset($_COOKIE['login'])){
		header('location: profile.php');
	}
	include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
	$login=$_COOKIE['login'];

	$link = connecting();
	$result = mysqli_query($link,"SELECT id,login,is_mail,is_not FROM users WHERE login ='$login'");
	$row = mysqli_fetch_row($result);
	$mailing = $row[2];
	$noting = $row[3];
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
<link rel="stylesheet" href="assets2/bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Настройка уведомлений</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">

</script>
<style type="text/css">
	th{
		text-align: center;
	}
</style>
<body>
<?
include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
?>
<div class="table-responsive" style="margin-top: 49px;">
        <table class="table">
            <thead>
                <th>Пользовательские настройки уведомлений</th>
            </thead>
            <tbody>
                <tr>
                    <td><div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="ComEmail" onclick="clickMAIL()" <? if($mailing){echo "checked='true'";} ?>>
  <label class="custom-control-label" for="ComEmail">Уведомление по почте</label>
</div></td>
                </tr>
                                <tr>
                    <td><div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="ComNot" onclick="clickNOT()"  <? if($noting){echo "checked='true'";} ?>>
  <label class="custom-control-label" for="ComNot">Уведомление в браузере</label>
</div></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
    function one(){
        return confirm("Вы уверены?");
    }
    function clickMAIL(){
    	if ($('#ComEmail').is(':checked')){
			change_not(1,1);
		} else {
			change_not(0,1);
		}
    }
    function clickNOT(){
    	if ($('#ComNot').is(':checked')){
			change_not(1,2);
		} else {
			change_not(0,2);
		}
    }
    function change_not(sostoyanie,typing){
	$.ajax({
	  		url: 'change_notify_mail_ajax.php?s_t='+sostoyanie+'&type='+typing,
	  		success: function(data) {
	    		$('.not').html('Состояние изменено');
	  		}
		});
	}
    </script>
    <div style="margin-left: 10px" class="not"></div>
    <script src="assets2/js/jquery.min.js"></script>
    <script src="assets2/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets2/js/Drag-and-Drop-File-Input.js"></script>
    <script src="assets2/js/Navbar---Apple.js"></script>
    <script src="assets2/js/Profile-Edit-Form.js"></script>
</body>
</html>
