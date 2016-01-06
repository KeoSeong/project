<?php
# Ex 5 : Delete a tweet
	try {
		
		include 'timeline.php';
    	require_once('base.php');
		$username=$_SESSION['user_id'];
	    $TL = new TimeLine();
	    if(isset($_POST['no'])){
	    	$no = $_POST['no'];
	 	}
	 	if(isset($_POST['author'])){
	    	$author = $_POST['author'];
	 	}
	    if(empty($username)){
?>
  		<?="<script>alert('로그인 해주세요'); location.replace(\"contents.php\")</script>";?>
<?
		}
		else if($username!=$author){
?>	
  		<?="<script>alert('다른사람 글 삭제 할 수 없다'); location.replace(\"contents.php\")</script>";?>
<?		
	}
		else{
			$TL->delete($no);?>
  		<?="<script>alert('삭제'); location.replace(\"contents.php\")</script>";?>
<?php
		}
	} catch(Exception $e) {
	    header("Location:error.php");
	}
?>