<?php
    try {
		include("problemdata.php");
		$database = new Problem();
		$database->insertProblem($_POST["type"], $_POST["problem"], $_POST["answer"]);
		header("Location:problem.php");
    } catch(Exception $e) {
        header("Loaction:error.php");
    }
?>