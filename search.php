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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Поиск</title>
    <? include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/header_temp.html"; ?>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript"></script>
<?
    include_once "$_SERVER[DOCUMENT_ROOT]/forum/template/navbar_temp.php";
?>
<script>
function search(){
    var element = document.getElementById('poisk');
    id= element.value;
    if(id != ''){
        
        $.ajax({
        type: "POST",
        data: {"mess":id},
        url: 'search_engine.php?mess='+id,
        success: function(data) {
            $('.result').html(data);
        }
    });            
    }else{
        $('.result').html("Вы ввели пустой запрос");
    }
    
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
    <script type="text/javascript">
    function closing(){
        
        document.getElementById('aler').style.marginTop='50px';
    }
</script>

<?include_once "$_SERVER[DOCUMENT_ROOT]/forum/alert.php";?>
    <div class="table-responsive">
        <table class="table" >
            <thead>
                <tr>
                    <th colspan="2">Поиск(регистр учитывается)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding-left: 7px;">
                        <input class="form-control" type="search"  autofocus name="poisk" id="poisk" minlength="1" required style="padding-left:15px;">
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="search()">поиск</button>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </div>
<div class="result" style="margin-left: 7px; margin-right: 7px;"></div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/Navbar---Apple.js"></script>
</body>
</html>