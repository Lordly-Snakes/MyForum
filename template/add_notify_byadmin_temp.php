<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Сообщение пользователю</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple-1.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php"; ?>
    <div class="table-responsive" style="margin-top: 50px;">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 591px;">Введите сообщение</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><form  method="post" action="add_notify_by_admin.php?id_user=<? echo($_GET['id_user']); ?>">
                        <textarea class="form-control" type="text" name="description" placeholder="Нет сообщения" minlength="2" required></textarea>
                    </td>
                    
                </tr>
                <tr>
                    <td><button class="btn btn-primary" type="submit" name="GO2">Добавить</button></td>
                </tr> </form>
            </tbody>
        </table>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
</body>
</html>
