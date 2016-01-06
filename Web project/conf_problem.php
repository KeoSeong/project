<?php
    try {
		include("problemdata.php");
		$database = new Problem();
		$database->confProblem($_POST["problem_no"]);
		?><script> alert("문제가 추가 되었습니다.");location.replace("problem.php?case=5")</script><?php
    } catch(Exception $e) {
    	?><script> alert("문제가 추가 되지않았습니다.");location.replace("problem.php?case=5")</script><?php
    }

?>