<?php
	include ("db.php");
	$dataBase = new LoginDatabase();
	$test = $dataBase->find($_POST['user_email'])[0];
	if(!isset($test)){
		echo "<script>alert('등록된 이메일이 아닙니다.');history.back();</script>";
	    exit;
	}

	echo "<script>alert('아이디 : $test[0], 비밀번호 : $test[1]');</script>";
?>
<meta http-equiv='refresh' content='0;url=login.php'>