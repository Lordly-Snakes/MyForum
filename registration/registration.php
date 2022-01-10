<?
if (isset($_SESSION['id']) || (isset($_COOKIE['login']) && isset($_COOKIE['password']))) 
{
        if($_SERVER['HTTP_REFERER'] != 'http://wordpress/forum/authentication/authentication.php'){header("Location: $_SERVER[HTTP_REFERER]");}else{
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
    <title>Регистрация</title>
    <meta name="referrer" content="none">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Drag-and-Drop-File-Input.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple-1.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple.css">
    <link rel="stylesheet" href="assets/css/Profile-Edit-Form-1.css">
    <link rel="stylesheet" href="assets/css/Profile-Edit-Form.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<script type="text/javascript">
	function reg(){
    var form = document.querySelector('#form');
    var email= form.elements.email.value;
    var pass= form.elements.pass.value;
    var pass2= form.elements.pass2.value;
    var login= form.elements.login.value;
    var g_captcha_response = $("#g-recaptcha-response").val();
    $.ajax({
        url: 'registration_engine.php',
        type: "POST",
        data: {"email":email,"pass":pass,"pass2":pass2,"login":login,"g-recaptcha-response":g_captcha_response},
        success: function(data) {
            //$('.banning').html(data);
            if(data == 'string'){
                if(document.referrer == 'http://wordpress/forum/authentication/authentication.php'){

                    document.location.href = 'https://pokypki.net/forum/forum.php';
                }else if(document.referrer == ''){
                    document.location.href = 'https://pokypki.net/forum/forum.php';
                    //document.location.href = document.referrer; 
                }else{
                    document.location.href = document.referrer; 
                }
                //alert(document.referrer);
            }else{
                $('.error').html(data);
                grecaptcha.reset();
            }
        }
    });
}
</script>
<style>
    .error{
        color: red;
        text-align: center;
    }
</style>
<body>
    <div class="login-dark">
        <form id="form" onsubmit="reg();return false;">
            <h2 class="sr-only">Форма регистрации</h2>
            <div class="illustration"><i class="icon ion-android-contact"></i></div>
            <div class="error">
            </div>
            <div class="form-group"><input class="form-control" type="text" name="login" placeholder="Логин"  required="" minlength="4" maxlength="20"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Почта"  required="" minlength="4"></div>
            <div class="form-group"><input class="form-control" type="password" name="pass" placeholder="Пароль" minlength="4" required></div>
            <div class="form-group"><input class="form-control" type="password" name="pass2" placeholder="Подтверждение пароля" required="" minlength="4"></div>
            <div class="g-recaptcha" data-sitekey="..." id="cap"></div>
            <div class="form-group"><input type="submit" class="btn btn-primary btn-block" name="GO" onclick="" value="Регистрация"><label style="font-size: 10px; ">Регистрируясь вы соглашаетесь с правилами форума и с использованием куки</label></div>
            <a class="forgot" href="<? echo"$dire";?>/forum/authentication/authentication.php">Уже зарегестрированы? Войдите</a>
            </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Drag-and-Drop-File-Input.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
    <script src="assets/js/Profile-Edit-Form.js"></script>
</body>

</html>