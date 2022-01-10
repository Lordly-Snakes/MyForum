<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Изменение логина</title>
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
<body>
    <?if(isset($_GET['error'])){
echo"<style>
    .error{
        color: red;
        text-align: center;
    }
</style>";
}?>
    <div class="login-dark">
        <form method="post" action="res.php">
            <h2 class="sr-only">Изменение Логина</h2>
            <div class="illustration"><i class="icon ion-android-contact"></i></div>
            <div class="form-group"><span>Изменение Логина</span></div>
            <div class="error"><?if(isset($_GET['error'])){echo"такой логин уже есть";}?></div>
            <div class="form-group"><input class="form-control" type="text" name="log" placeholder="Новый логин" inputmode="latin-name" minlength="4" required=""></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="GO">Изменить</button></div>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
</body>
</html>