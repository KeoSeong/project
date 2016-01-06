<?php
	try{

		include ("db.php");
		$dataBase = new LoginDatabase();

		if(!isset($_POST['user_id']) || !isset($_POST['user_name']) || !isset($_POST['user_age']) || !isset($_POST['user_comment']) || !isset($_POST['user_pw1']) || !isset($_POST['user_pw2']) || !isset($_POST['user_school'])) {
			echo "<script>alert('모든 필드를 채워주세요.');history.back();</script>";
			header("Loaction:join.php");
			exit;
		}

		if($_POST['user_pw1'] != $_POST['user_pw2']){
			echo "<script>alert('비밀번호를 다시 확인해주세요.');history.back();</script>";
			header("Loaction:join.php");
			exit;
		} 

		$user_id = $_POST['user_id'];
		$user_pw = $_POST['user_pw2'];
		$user_comment = $_POST['user_comment'];
		$user_school = $_POST['user_school'];
		$user_age = $_POST['user_age'];
		$user_name = $_POST['user_name'];
		$user_email = $_POST['user_email'];
		$dataBase->join($user_id, $user_pw, $user_comment, $user_school, $user_age, $user_name, $user_email);
		echo "<script>alert('가입이 완료되었습니다.');</script>";

	} catch(Exception $e) {
		echo "<script>alert('존재하는 아이디이거나 모든 필드를 채우지 않았습니다.');history.back();</script>";
    	header("Loaction:join.php");
	}
?>
<meta http-equiv='refresh' content='0;url=login.php'>