<?php
  require_once('../lib/ti.php');
  require_once('../lib/uploader.php');
  require_once('../lib/sqftest1.php');
  date_default_timezone_set("Asia/Seoul");
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>GYM</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <? emptyblock('head'); ?>
</head>
<body style="font-family: verdana;">
  <div class="row" style="margin-left: auto; margin-right: auto;">
    <div class="navbar navbar-inverse col-md-4" style="background-color: rgb(174, 54, 54); border-color: rgb(174, 54, 54);">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="main.php" style="color:white;">#ADMIN PAGE</a>
          <a class="navbar-brand" href="../todaysExercise.php" style="color:white;">#APP PAGE</a>
        </div>
      </div>
    </div>
  </div>
<? emptyblock('content'); ?>
<? emptyblock('extra'); ?>
</body>
</html>
