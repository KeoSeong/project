<?php
	include ("db.php");
	$dataBase = new LoginDatabase();

	if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
	$user_id = $_POST['user_id'];
	$user_pw = $_POST['user_pw'];
	$isset_id = $dataBase->login($user_id, $user_pw);

	if(!$isset_id) {
	        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
	        exit;
	}

	session_start();
	$_SESSION['user_id'] = $user_id;
?>
<meta http-equiv='refresh' content='0;url=index.php'>