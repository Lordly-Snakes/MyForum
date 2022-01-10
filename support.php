<?
// Проверяем id темы
    include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    $link = connecting();
    include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
    $dire= dirr();
    $start++;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta Http-Equiv="Expires" Content="0">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Помощь</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript"></script>
<?
    include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
?>
<script>

function search(){
    var element = document.getElementById('mess');
    var mal = document.getElementById('mail');
    id= element.value;
    mail = mal.value;
    var g_captcha_response = $("#g-recaptcha-response").val();
    //alert(mail);
    if(id != ''){
        
        $.ajax({
        type: "POST",
        data: {"mess":id,"mail":mail,"g-recaptcha-response":g_captcha_response},
        url: 'support_engine.php',
        success: function(data) {
            if(data == '0'){
                $('.res').html("<div class='alert alert-success alert-dismissible fade show' role='alert'>Отправлено<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
            }else if(data == '1'){
                $('.res').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Пройдите капчу<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
            }else{
                $('.res').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Либо войдите, либо укажите почту<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
            }
        }
    });            
    }else{
        $('.res').html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>Введите сообщение<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span  aria-hidden='true'>&times;</span>  </button></div>");
    }
    grecaptcha.reset();
    
}

</script>
<style type="text/css">
	.alert{
		margin-top: 10px;
		
	}
	.close{
		margin: 0;
	}
</style>
<div class='card' style='width: 100%; margin-top: 50px;'>
	<FORM onsubmit='search();return false;'>
  <div class='card-body' style='padding:15px;'>
    <h5 class='card-title'>Отправьте нам сообщение</h5>
    <p class='card-text'>мы обязательно ответим вам</p>
    <div class='card' style='width: 100%; margin-bottom: 10px; margin-right: 1px; margin-left: 1px;'>
  <div class='card-body'>
    <h5 class='card-title'>Ваша почта</h5>
    <input class="form-control" type="email" name="" id="mail" REQUIRED>
    <!--<p class='card-text'>Это необязательно если вы вошли в аккаунт</p>-->
    <h5 class='card-title'>Ваше сообщение</h5>
    <textarea class="form-control" type="text" name="" id="mess"></textarea>
    <p class='card-text'>Здесь опишите свою проблему или пожелание</p>
    <div style="margin-bottom: 10px;" class="g-recaptcha" data-sitekey="..." id="cap"></div>
    <div class="res"></div>
    <button class='btn btn-primary' type="submit">Отправить</button>
  </div>
</div></div>
</FORM>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Navbar---Apple.js"></script>
</body>
</html>