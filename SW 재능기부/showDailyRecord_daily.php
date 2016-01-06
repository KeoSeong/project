<?php
  include_once('base.php');
  setTitle("운동기록 보기");
  if(isset($_SESSION['user_id'])){
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>


        <div class="secondTab">
          <?php
            $day_string="?day=".$_GET['day']."&month=".$_GET['month']."&year=".$_GET['year'];
            $addr_crossfit="./showDailyRecord.php".$day_string;
            $addr_weight="./showDailyRecord_weight.php".$day_string;
          ?>
         <a href=<?=$addr_crossfit?>><p class="left2" >CrossFit</p></a>
          <a href=<?=$addr_weight?>><p class="center" >Weight</p></a>
          <a href="#" ><p class="right2" style="background-color:#DF314D;">DailyWork</p></a>
        </div>   
        <h1><?=$_GET['month']?>월 <?=$_GET['day']?>일</h1>
      <div class="container-fluid">
        <h2>기타 운동</h2> 
        <div class="col-xs-5 col-xs-offset-1">
          <div class="well" style="text-align:left; width:160px;">
            <ul>
            <li>Bench Press</li>
            <li>Shoulder Press</li>
            <li>Dead Lift</li>
            <li>Squat</li>
            </ul>
          </div>  
        </div>
        <div class="col-xs-4 col-xs-offset-1">
          <div class="well" style="text-align:center; height:135px;">
            <?php
              $user = $_SESSION['user_id'];
              $date = $_GET['year']."-".$_GET['month']."-".$_GET['day'];
              $a = dailyRECORD($user,$date);
              for($i=2;$i<6;$i++){
                if(isset($a[0][$i])){
                  echo $a[0][$i];
                  echo "\n<br/>";
                }else{
                  echo "운동 기록이 없습니다.";
                }  
              }    
            ?>
          </div>
        </div>        
      </div>
    <div class="container-fluid">
      <div class="row fixButton" >
          <a href="./fillinDailyRecord.php<?=$day_string;?>"><button type="button" class="btn btn-default btn-lg btn-block" style="width:120px; float:right; margin-right:30px;"><i class="fa fa-pencil"></i></button></a>
      </div>
    </div>


<?endblock('content');
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