<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Добавление темы</title>
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
        <form  method="post" action="add_theme.php">
        <table class="table">
            
            <thead>
                <tr>
                    <th style="">Введите название темы</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td >
                        <input class="form-control" type="text" name="name" required>
                    </td>
                </tr>
                    <TR>
                        <TD><div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="ComNot" onclick="clickNOT()" name="check">
                        <label class="custom-control-label" for="ComNot">Только для чтения(редактировать может только админ)</label>
                    </div></TD>
                     </form></TR>
                     <tr>
                         <td><button class="btn btn-primary" type="submit" name="GO2">Добавить</button></td>
                     </tr>
                
            </tbody>
        </table>
         </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Navbar---Apple.js"></script>
</body>

</html>