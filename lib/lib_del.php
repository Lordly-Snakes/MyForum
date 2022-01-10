<?php

function deleteTHEME($link,$id_th){
	mysqli_query($link,"DELETE FROM theme WHERE id_them='$id_th'");
	mysqli_query($link,"DELETE FROM messages WHERE id_theme='$id_th'");
	mysqli_query($link,"DELETE FROM favorites WHERE id_fav_theme='$id_th'");
	mysqli_query($link,"DELETE FROM notification WHERE id_theme='$id_th'");
}

function deleteALLTHEME($link,$id_cat){
	//mysqli_query($link,"DELETE FROM category WHERE id_category='$id_cat'");
	$rez = mysqli_query($link,"SELECT * FROM theme WHERE id_category='$id_cat'");
    $str = mysqli_num_rows($rez);
    for ($i = 0 ; $i < $str ; ++$i)
    {
    	$row = mysqli_fetch_row($rez);
    	deleteTHEME($link,$row[0]);

    }
	//mysqli_query($link,"DELETE FROM theme WHERE id_cat='$id_cat'");
	//mysqli_query($link,"DELETE FROM messages WHERE id_theme='$id_cat'");
	//mysqli_query($link,"DELETE FROM favorites WHERE id_fav_theme='$id_cat'");
	//mysqli_query($link,"DELETE FROM notification WHERE id_theme='$id_cat'");
}

function deleteCATEGORY($link,$id_cat){
	
	$rez = mysqli_query($link,"SELECT * FROM theme WHERE id_category='$id_cat'");
    $str = mysqli_num_rows($rez);
    for ($i = 0 ; $i < $str ; ++$i)
    {
    	$row = mysqli_fetch_row($rez);
    	deleteTHEME($link,$row[0]);

    }
    mysqli_query($link,"DELETE FROM category WHERE id_category='$id_cat'");
	//mysqli_query($link,"DELETE FROM theme WHERE id_cat='$id_cat'");
	//mysqli_query($link,"DELETE FROM messages WHERE id_theme='$id_cat'");
	//mysqli_query($link,"DELETE FROM favorites WHERE id_fav_theme='$id_cat'");
	//mysqli_query($link,"DELETE FROM notification WHERE id_theme='$id_cat'");
}

function deleteMESSAGE($link,$id_mess){
	mysqli_query($link,"DELETE FROM messages WHERE id_message='$id_mess'");

}

function deleteALLMESSAGE($link,$id){
	mysqli_query($link,"DELETE FROM messages WHERE id_theme='$id'");
}

function deletePROFILE($link,$id){
	deleteIMAGE($link,$id);
	setcookie ("login", $login, time() - 50000, '/');
	setcookie ("password", md5($login.$password), time() - 50000, '/');
	mysqli_query($link,"DELETE FROM users WHERE id='$id'");
	mysqli_query($link,"DELETE FROM favorites WHERE id_user='$id'");
	mysqli_query($link,"DELETE FROM notification WHERE id_user='$id'");	
}
function deleteOTHERPROFILE($link,$id){
	deleteIMAGE($link,$id);
	mysqli_query($link,"DELETE FROM users WHERE id='$id'");
	mysqli_query($link,"DELETE FROM favorites WHERE id_user='$id'");
	mysqli_query($link,"DELETE FROM notification WHERE id_user='$id'");	
}

function deleteIMAGE($link,$id_prof){
	$result = mysqli_query($link,"SELECT id,image FROM users WHERE id='$id_prof'");
	$row = mysqli_fetch_row($result);
	if($row[1] != NULL){
		unlink($row[1]);
	}
}	

function deleteFAV($link,$id){
	$result = mysqli_query($link,"DELETE FROM favorites WHERE id='$id'");
	# code...
}
function deleteALTFAV($link,$id_user,$id_theme){
	$result = mysqli_query($link,"DELETE FROM favorites WHERE id_user='$id_user' AND id_fav_theme='$id_theme'");
	# code...
}

function deleteNOT($link,$id_not,$id_user){
	$result = mysqli_query($link,"DELETE FROM notification WHERE id_user='$id_user' AND id_not='$id_not'");
	# code...
}

function deleteALTNOT($link,$id_theme,$id_user){
	$result = mysqli_query($link,"DELETE FROM notification WHERE id_user='$id_user' AND id_theme='$id_theme'");
	# code...
}

function deleteALLNOT($link,$id_user){
	$result = mysqli_query($link,"DELETE FROM notification WHERE id_user='$id_user'");
	# code...
}

?>