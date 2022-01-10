<?
$back_page = ($page*10)-20;
$forward_page = ($page)*10;
?>
<nav style="z-index: 0; float: left;">
<ul class="pagination pagination-sm">
	<li class="page-item">
<a href='message.php?id=<? echo "$id" ?>
&page=<? echo 'start' ?>' name="back" 
			<? if((int)$page <= 1)
			{
 				echo"class = 'page-link disabled'";
 			}else{
 				echo"class = 'page-link'";
 			}?>>&laquo;</a></li>
	<li class="page-item">
<a href='message.php?id=<? echo "$id" ?>
&page=<? echo $page-1; ?>' name="back" 
			<? if((int)$page <= 1)
			{
 				echo"class = 'page-link disabled'";
 			}else{
 				echo"class = 'page-link'";
 			}?>>Назад</a></li><?
for ($i=0; $i < $count_page; $i++) {
	$i1=$i+1;
if($i1 != $page ){

	$number_page = $i*10;
	echo "<li class='page-item'><a class='page-link' href='message.php?id=$id&page=$i1'> $i1 </a></li>";
} else{
	echo "<li class='page-item active'><a class='page-link disabled' href='message.php?id=$id&page=$i1'> $i1 </a></li>";
}
	 	# code...
 }
 ?><li class="page-item"><a href='message.php?id=<? echo "$id" ?>&page=<? echo $page+1; ?>' name="forward" <? if((int)$page >= $count_page){
 	echo"class = 'page-link disabled'";
 }else{
 	echo"class = 'page-link'";
 } ?>>Вперед</a>
     </li>
     <li class="page-item"><a href='message.php?id=<? echo "$id" ?>&page=<? echo 'end'; ?>' name="forward" <? if((int)$page >= $count_page){
 	echo"class = 'page-link disabled'";
 }else{
 	echo"class = 'page-link'";
 } ?>>&raquo;</a>
     </li>
  </ul>
</nav>
 <style type="text/css">
 a.page-link.disabled{
	pointer-events: none; /* делаем элемент неактивным для взаимодействия */
	cursor: default; /*  курсор в виде стрелки */
	color: #888;}
li.page-item.active{
	z-index: 0;}
	/* цвет текста серый */
</style>