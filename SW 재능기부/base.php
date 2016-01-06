<?php
  session_start();
  require_once("lib/ti.php");
  require_once("lib/sqftest1.php");
  $title = "_";
  function setTitle($t)
  { 
    global $title;
    $title = $t;
  }
  $activation = dietwar_status()[0][0];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/slidebar.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <? emptyblock('head'); ?>
</head>
<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <div class="panel panel-default"> 
    <?php if(isset($_SESSION['user_id'])){ ?>
    <div class="container">
        <div id="sidebar">
          <ul>
            <li class="slidebarText">   
              <?=$_SESSION['user_name'] ?>님</li>
            <li><a href="todaysExercise.php">오늘의 운동</a></li>
            <?php if($_SESSION['user_level'] != 0){?> 
            <li><a href="exerciseRecord_mainRecord.php?id=<?=$_SESSION['user_id']?>&exerciseName=bench_press">운동기록</a></li>   
            <li><a href="dietWar.php">다이어트워</a></li>
            <?php } ?>
            <?if($_SESSION['user_id'] == 'admin'){?>
            <li><a href="admin/main.php">관리자페이지</a></li></li>
            <?}?>
            <li>
              <a href="login.php"><form action="logout.php" method="post"><button class="btn logout_btn">로그아웃</button></form></a>
            </li>
          </ul>
        </div>
        <div class="main-content"><!--<div class="swipe-area"></div>-->
              <a href="#" data-toggle=".container" id="sidebar-toggle">
                  <span class="bar"></span>
                  <span class="bar"></span>
                  <span class="bar"></span>
              </a>   
        </div>
    </div>
    <?php } ?>
    <!--END button  -->
    <div class="panel-body">
        <? emptyblock('content'); ?>
      <div class="panel-footer">Copyright 2015. JUCY all right reserved</div>
    </div><!--END panel-body  -->
  </div><!--END panel-default -->
  <? emptyblock('extra') ?>
  <script type="text/javascript">
      $(window).load(function(){
        $("[data-toggle]").click(function() {
          var toggle_el = $(this).data("toggle");
          $(toggle_el).toggleClass("open-sidebar");
        });
         $(".swipe-area").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {
                      if (phase=="move" && direction =="right") {
                           $(".container").addClass("open-sidebar");
                           return false;
                      }
                      if (phase=="move" && direction =="left") {
                           $(".container").removeClass("open-sidebar");
                           return false;
                      }
                  }
          }); 
      });     
    </script>
</body>
</html>