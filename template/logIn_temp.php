
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Вход</title>
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
<?
$mod = $_GET['mod'];
if(isset($_GET['error'])){
echo"<style>
    .error{
        color: red;
        text-align: center;
    }
</style>";
}?>
<body>
    <div class="login-dark">
        <form method="post" action="authentication.php">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group">
            <div class="error">
            <?if(isset($_GET['error'])){echo"Вы ввели неверный логин или пароль";}?>
            </div>
            <input class="form-control" type="email" name="email" placeholder="Email" minlength="4" required=""></div>
            <div class="form-group"><input class="form-control" type="password" name="pass" placeholder="Password" minlength="4" required=""></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="GO">Войти</button></div><a class="forgot" href="recovery/recovery.php">Забыли свой пароль?</a></form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Drag-and-Drop-File-Input.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
    <script src="assets/js/Profile-Edit-Form.js"></script>
</body>

</html>