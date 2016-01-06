<?php
    include ("db.php");
    $dataBase = new LoginDatabase();
	$dataBase->remove_user($_POST["name"]);
?>