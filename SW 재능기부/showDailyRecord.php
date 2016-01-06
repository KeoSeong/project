<?php
  include_once('base.php');
  setTitle("운동기록 보기");
  if(isset($_SESSION['user_id'])){
?>
 
 
 
<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>
<!--     <ul class="nav nav-tabs">
      <li class="active"><a href="#">CrossFit</a></li>
      <li><a href="showDailyRecord_weight.php">Weight</a></li>
      <li><a href="showDailyRecord_daily.php">DailyWork</a></li>
    </ul> -->
        <div class="secondTab">
          <?php
            $day_string="?day=".$_GET['day']."&month=".$_GET['month']."&year=".$_GET['year'];
            $addr_weight="./showDailyRecord_weight.php".$day_string;
            $addr_daily="./showDailyRecord_daily.php".$day_string;
          ?>
         <p class="left2" style="background-color:#DF314D">CrossFit</p>
          <a href=<?=$addr_weight?>><p class="center" >Weight</p></a>
          <a href=<?=$addr_daily?>><p class="right2" >DailyWork</p></a>
        </div>    
    <h1><?=$_GET['month']?>월 <?=$_GET['day']?>일</h1>
    <div class="container-fluid" style="text-align:center;">
      <h2>오늘의 운동</h2> 
      <div class="well" style="width:70%; display:inline-block;" >
        <?php
          $date = $_GET['year']."-".$_GET['month']."-".$_GET['day'];
          $a = showToDAYex($date);
          if(isset($a[0][1])){
            echo $a[0][1];
            echo "\n<br/>";
          }else{
            echo "운동 기록이 없습니다.";
          }
          ?>
      </div>
      <div class="well" style="width:70%; display:inline-block;">
        <?php
          $user = $_SESSION['user_id'];
          $date = $_GET['year']."-".$_GET['month']."-".$_GET['day'];
          $a = dailyRECORD($user,$date);
          if(isset($a[0][6])){
            echo $a[0][6];
            echo "\n<br/>";
          }else{
            echo "운동 기록이 없습니다.";
          }    
        ?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row fixButton" >
          <a href="./fillinDailyRecord.php<?=$day_string;?>"><button type="button" class="btn btn-default btn-lg btn-block" style="width:120px; float:right; margin-right:50px;"><i class="fa fa-pencil"></i></button></a>
      </div>
    </div>

 
 

<? 
  endblock('content');
  startblock('head');
  echo "<title> JUCY | ".$title."</title>";
  endblock('head');
  startblock('content-title');
  echo $title;
  endblock('content-title');
  }else{
      echo '<script type="text/javascript">';
      echo 'alert("접근권한이 없습니다.")';
      echo '</script>';
  }
?>