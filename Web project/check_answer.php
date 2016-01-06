<?php
    try {
		include("problemdata.php");
		$database = new Problem();
		$result = $database->checkAnswer($_POST["problem_no"] * 1, $_POST["answer"]);
		$checkpast = $database->checkRepeatSolve($_POST["user_id"], $_POST["problem_no"]*1);
		$ret = "problem.php?case=".$_POST["case"] * 1;
		if($result == 'good'){
			if($_POST["user_id"] != 'null' && $checkpast == 0) {
				$database->insertAnswer($_POST["user_id"], $_POST["problem_no"] * 1, $_POST["answer"], 1);
			}else {
			}
			?><script> alert("정답");location.replace("<?= $ret ?>")</script><?php
		}else{
			if($_POST["user_id"] != 'null' && $checkpast == 0) {
				$database->insertAnswer($_POST["user_id"], $_POST["problem_no"] * 1, $_POST["answer"], 0);
			}else {
			}
			?><script> alert("틀렸어");location.replace("<?= $ret ?>")</script><?php
		}
    } catch(Exception $e) {
        header("Loaction:error.php");
    }
?>