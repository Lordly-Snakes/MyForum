<?
if (isset($_SESSION['id']) || (isset($_COOKIE['login']) && isset($_COOKIE['password']))) 
{
    if($_SERVER['HTTP_REFERER'] != 'http://wordpress/forum/registration/registration.php'){header("Location: $_SERVER[HTTP_REFERER]");}else{
    	header("Location: $_SERVER[DOCUMENT_ROOT]/forum/profile/profile.php");
    }
}
include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
$dire= dirr();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Вход</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts 2/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Drag-and-Drop-File-Input.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple-1.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple.css">
    <link rel="stylesheet" href="assets/css/Profile-Edit-Form-1.css">
    <link rel="stylesheet" href="assets/css/Profile-Edit-Form.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<style>
    .error{
        margin-bottom: 20px;
        color: red;
        text-align: center;
    }
</style>
<body>
    <div class="login-dark">
        <form id="form" onsubmit="vhod();return false;">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group">
            <div class="cont-error"><span class="error"></span></div>
            <input class="form-control" type="email" name="email" placeholder="Адрес электронной почты" minlength="4" required=""></div>
            <div class="form-group"><input class="form-control" type="password" name="pass" placeholder="Пароль" minlength="4" required=""></div>
            <div class="g-recaptcha" data-sitekey="..." id="cap"></div>
            <div class="form-group"><input type="submit" class="btn btn-primary btn-block" name="GO" onclick='' value="Войти"></div><a class="forgot" href="recovery/recovery.php">Забыли свой пароль?</a><a class="forgot" href="<? echo"$dire";?>/forum/registration/registration.php">Впервые? Зарегистрируйтесь</a></form>
    </div>
    <script type="text/javascript">
function vhod(){
    var form = document.querySelector('#form');
    var email= form.elements.email.value;
    var pass= form.elements.pass.value;
    var g_captcha_response = $("#g-recaptcha-response").val();
    $.ajax({
        url: 'authentication_engine.php',
        type: "POST",
        data: {"email": email,"pass": pass,"g-recaptcha-response":g_captcha_response},
        success: function(data) {
            //$('.banning').html(data);
            if(data == 'string'){
                    if(document.referrer == 'https://pokypki.net/forum/registration/registration.php' || document.referrer == 'https://pokypki.net/forum/authentication/recovery/reset.php'){

                        document.location.href = 'https://pokypki.net/forum/forum.php';
                    }else if(document.referrer == ''){
                        document.location.href = 'https://pokypki.net/forum/forum.php';
                        //document.location.href = document.referrer; 
                    }else{
                        document.location.href = document.referrer; 
                    }
                    
                }else if(data == '1'){
                    $('.error').html("Неверный логин или пароль");
                    grecaptcha.reset();
                    $(".cont-error").css('margin-bottom', '10px');
                }else{
                    $('.error').html(data);
                    grecaptcha.reset();
                    $(".cont-error").css('margin-bottom', '10px');
                }
            }
        });
    }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Drag-and-Drop-File-Input.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
    <script src="assets/js/Profile-Edit-Form.js"></script>
</body>
</html>