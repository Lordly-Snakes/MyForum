<?
    //include("$_SERVER[DOCUMENT_ROOT]/forum/lib/connect.php");
    //$link = connecting();
    
			$result_ = mysqli_query($link,"SELECT * FROM alert");
				$num = mysqli_num_rows($result_);
				if($num>0){
					echo"<div id='aler' style='margin-top: 60px; margin-right: 20px; '>";
				}else{
					echo"<div id='aler' style='margin-top: 50px; margin-right: 20px; '>";
				}
				
				for ($i=0; $i < $num; $i++) { 
						$row_=mysqli_fetch_row($result_);
	                echo"
	                
			        <div class='alert alert-warning alert-dismissible fade show' role='alert' >
					  <h4 class='alert-heading'>Внимание</h4>
					  <p>$row_[1]</p>
					  <hr>
					  <p class='mb-0'>Нажмите крестик чтобы закрыть сообщение</p><button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='closing()'>
					    <span aria-hidden='true'>&times;</span>
					  </button>
					</div>
					
			        ";
						# code...
					}
					echo "</div>";
				
?>