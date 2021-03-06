<?php 
    require_once("lib/ti.php");
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>컴취기</title>
        <link rel="stylesheet" href="css/base.css">
        <link href="img/favicon.png" type="image/png" rel="shortcut icon" />
        <? emptyblock('head'); ?>
    </head>
    <body>
    	<div id="topclass">
    		   <div id=contents><a href="index.php">
    		   <div id=logodown>Interview Solutions for C.S.E</a></div>
    		   
    		   </div>
        <header>
          <div id="brand">
            <a href="index.php"></a>
          </div>
        </header>
        <nav>
          <div>
            <div><a href="index.php">HOME</a></div>
            <div><a href="problem.php">PROBLEM</a></div>
            <div><a href="ranking.php">RANKING</a></div>
            <div><a href="contents.php">COMMUNITY</a></div>
            <div><a href="feedback.php">FEEDBACK</a></div>
            <div><a href="admin.php">MANAGE</a></div>
         <div>
	            <?php
	            	if(!isset($_SESSION['user_id'])){ ?>
	            <div><div><a href="login.php">LOGIN</a></div></div>
	            	<?php } else{?>
	            <div><a href="myinfo.php"><?=$_SESSION['user_id']?></a></div>
	            <div><a href='logout.php'><div>LOGOUT</div></a></div>
	            <?php } ?>
	        </div>
          </div>
        </nav>
       </div> 
        <? emptyblock('content'); ?>
    </body>    
</html>
