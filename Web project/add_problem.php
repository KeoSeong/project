<?php
    try {
		include("problemdata.php");
		$database = new Problem();
		$database->insertProblem(htmlspecialchars($_POST["type"]), htmlspecialchars($_POST["problem"]), htmlspecialchars($_POST["answer"]));
		?><script> alert("문제가 추가 되었습니다.");location.replace("problem.php?case=4")</script><?php
    } catch(Exception $e) {
    	?><script> alert("문제가 추가 되지않았습니다.");location.replace("problem.php?case=4")</script><?php
    }
?>
