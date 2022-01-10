<?
include_once("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
$link = connecting();
$log_user = $_COOKIE['login'];
$rezult = mysqli_query($link,"SELECT id,login,is_admin FROM users WHERE login='$log_user'");
$r = mysqli_fetch_row($rezult);
$id_user_nav = $r[0];
function IsUpdateCount($link,$id_user){
    $count_mess  = mysqli_query($link,"SELECT COUNT('id_user') as 'num' FROM notification WHERE id_user='$id_user'");
    $count_res = mysqli_fetch_row($count_mess);
    if ($count_res[0] > 0) {
        $count_notify =$count_res[0];
    }else
    {
        $count_notify = 0;
    }
    return $count_notify;
}
?>
<style type="text/css">
    .n{
        color: white;
        display: inline-block;
        margin-left: 2px;
        width: 20px; 
        height: 20px;
        background: red;
        border-radius: 50%;
        text-align: center;
    }
    .navbar--apple::before{
        background-color: #008CF0;
        #1974D2;
        #2A52BE;
        #1F75FE
    }
    .navbar--opened .navbar--apple::before{background-color: rgba(0, 140, 240, .9);}
    .d-none {
    display: block!important; 
}
</style>
<nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark navbar--apple"  id="upp">
        <div class="container"><button data-toggle="collapse" class="navbar-toggler" data-target="#menu"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"><i class="la la-navicon"></i></span></button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav flex-grow-1 justify-content-between">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="/forum/forum.php">Главная форума</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="/forum/favorites.php">Избранное<? $res = IsUpdateCount($link,$id_user_nav); if($res != 0){echo"<p class='n'> $res</p>";}?></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="/forum/list_profile.php">Профили</a></li>
                    

                    <li class="nav-item" role="presentation"><a class="nav-link" href="/forum/support.php">Помощь</a></li>
                                        <?
                    if(isset($_COOKIE['login'])){
                        $logggg=$_COOKIE['login'];
                        echo"<li class='nav-item ' role='presentation'><a class='nav-link' href='/forum/profile/profile.php' style='font-weight:bold;'>$logggg</a></li>
                        <li class='nav-item' role='presentation'><a class='nav-link' href='/forum/v.php'>Выход</a></li>";    
                    }else{
                        echo"<li class='nav-item' role='presentation'><a class='nav-link' href='/forum/profile/profile.php'>Войти</a></li>";
                    }
                    ?>
                    <li class="nav-item d-none d-xs-block d-md-block" role="presentation"><a class="nav-link" href="/forum/search.php"><i class="icon ion-ios-search-strong"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
