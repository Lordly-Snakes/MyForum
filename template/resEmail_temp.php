<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Изменение почты</title>
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
        <form method="post" action="res2.php">
            <h2 class="sr-only">Изменение адреса почты</h2>
            <div class="illustration"><i class="icon ion-ios-email-outline"></i></div>
            <div class="form-group"><span>Изменение E-mail&nbsp;</span></div>
            <div class="error"><?if(isset($_GET['error'])){echo"такой емаил уже есть";}?></div>
            <div class="form-group"><input class="form-control" type="email" name="mail" placeholder="новый адрес" required="" minlength="4" inputmode="email"></div>
            
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="GO">Изменить</button></div>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
    <script src="assets/js/Profile-Edit-Form.js"></script>
</body>

</html>