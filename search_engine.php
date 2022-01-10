<?
    include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    $link = connecting();
    include_once("$_SERVER[DOCUMENT_ROOT]/forum/directory.php");
    $dire= dirr();
    $search = $_POST['mess'];
    
    $query = "%".$search."%";
// 
    $resulting = mysqli_query($link, "SELECT messages.id_message,messages.message,theme.name_theme,theme.id_them FROM messages INNER JOIN theme ON messages.id_theme=theme.id_them WHERE message LIKE '%$search%'");
    $count = mysqli_num_rows($resulting);
    $title = "сообщение";
    echo "<div class='card' style='width: 100%; margin-bottom: 10px;'>
  <div class='card-body' style='padding:15px;'>
    <h5 class='card-title'>Результат среди сообщений</h5>
    <p class='card-text'>кол-во результатов: $count</p>
";
    for ($i=0; $i < $count; $i++) {
    $row = mysqli_fetch_row($resulting); 
    	# code...
    //echo "$query ";
    echo "<div class='card' style='width: 100%; margin-bottom: 10px; margin-right: 1px; margin-left: 1px;'>
  <div class='card-body'>
    <h5 class='card-title'>$title в теме <a href='$dire/forum/message.php?id=$row[3]&page=1' class='badge badge-primary'>$row[2]</a></h5>
    <p class='card-text'>$row[1]</p>
    <a href='$dire/forum/message.php?id=poisk&id_mess=$row[0]' class='btn btn-primary'>Перейти</a>
  </div>
</div>";	
    }
    echo "
  </div>
</div>";
// Вывод тем
$resulting_ = mysqli_query($link, "SELECT id_them,name_theme,description FROM theme WHERE name_theme LIKE '%$search%'");
 	$count_ = mysqli_num_rows($resulting_);
    echo "<div class='card' style='width: 100%; margin-bottom: 10px;'>
  <div class='card-body' style='padding:15px;'>
    <h5 class='card-title'>Результат среди названий обсуждений</h5>
    <p class='card-text'>кол-во результатов: $count_</p>
";
 	
 	    for ($i=0; $i < $count_; $i++) {
    $row = mysqli_fetch_row($resulting_);
    $resulting_m = mysqli_query($link, "SELECT * FROM messages WHERE id_theme='$row[0]'");
    $rowm = mysqli_fetch_row($resulting_m);
    	# code...
    //echo "$query ";
    echo "<div class='card' style='width: 100%; margin-bottom: 10px; margin-right: 1px; margin-left: 1px;'>
  <div class='card-body'>
    <h5 class='card-title'>Обсуждение: $row[1] </h5>
    <p class='card-text'>Первое сообщение: $rowm[4] </p>
    <a href='$dire/forum/message.php?id=$row[0]&page=1' class='btn btn-primary'>Перейти</a>
  </div>
</div>";	
    }
        echo "
  </div>
</div>";



// Вывод category
$resulting__ = mysqli_query($link, "SELECT id_category,name_category,description FROM category WHERE name_category LIKE '%$search%'");
 	$count__ = mysqli_num_rows($resulting__);
    echo "<div class='card' style='width: 100%; margin-bottom: 10px;'>
  <div class='card-body' style='padding:15px;'>
    <h5 class='card-title'>Результат среди названий тем</h5>
    <p class='card-text'>кол-во результатов: $count__</p>
";
 	
 	    for ($i=0; $i < $count__; $i++) {
    $row = mysqli_fetch_row($resulting__); 
    	# code...
    //echo "$query ";
    echo "<div class='card' style='width: 100%; margin-bottom: 10px; margin-right: 1px; margin-left: 1px;'>
  <div class='card-body'>
    <h5 class='card-title'>тема: $row[1]</h5>
    
    <a href='$dire/forum/theme.php?id=$row[0]&page=1' class='btn btn-primary'>Перейти</a>
  </div>
</div>";	
    }
        echo "
  </div>
</div>";
// Вывод профилей
$resulting_u = mysqli_query($link, "SELECT * FROM users WHERE login LIKE '%$search%' OR mail LIKE '%$search%' OR id LIKE '%$search%'");
 	$count_u = mysqli_num_rows($resulting_u);
    echo "<div class='card' style='width: 100%; margin-bottom: 10px;'>
  <div class='card-body' style='padding:15px;'>
    <h5 class='card-title'>Результат среди профилей</h5>
    <p class='card-text'>кол-во результатов: $count_u</p>
";
 	
 	    for ($i=0; $i < $count_u; $i++) {
    $row_u = mysqli_fetch_row($resulting_u); 
    	# code...
    //echo "$query ";
    echo "<div class='card' style='width: 100%; margin-bottom: 10px; margin-right: 1px; margin-left: 1px;'>
  <div class='card-body'>
    <h5 class='card-title'>логин: $row_u[1]</h5>
    <p class='card-text'>почта: $row_u[4]</p>
    <a href='$dire/forum/profile/profile_view.php?id=$row_u[0]' class='btn btn-primary'>Посмотреть</a>
  </div>
</div>";	
    }
        echo "
  </div>
</div>";
?>
