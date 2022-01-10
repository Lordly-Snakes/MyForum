<? 
function connecting(){
    $host="..."; // Host name
    $username="..."; // Mysql username
    $passwordb="..."; // Mysql password
    $db_name="..."; // Database name
    $tbl_name="main"; // Table name 
    
    // Connect to server and select databse.
    
    $link = mysqli_connect($host,$username,$passwordb,$db_name)or die("Ошибка " . mysqli_error($link));
    return $link;
}

?>