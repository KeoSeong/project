<?php
    include 'feedbackmete.php';
    require_once('base.php');
    $userid = $_SESSION['user_id'];
	$FB = new Feedback();
	$content = $_POST['content'];

	try{

        if(isset($userid)){
                $FB->addFeedback($userid,$content);
                
?> 
                <?="<script>location.replace(\"feedback.php?&feedbackbutton=1\")</script>";?>
 
<?
        }else{
?>
            <?="<script>alert('로그인해주세요.'); location.replace(\"feedback.php\")</script>";?>
<?
        }
    } catch(Exception $e) {
        header("Loaction:error.php");
    }
?>
