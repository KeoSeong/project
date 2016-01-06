<?php
  include_once('base.php');
  setTitle("운동기록 보기");
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

    
      

       
          <!--<div class="container-fluid">
            <div>
              <ul class="nav nav-tabs">
                <li class="active"><a href="exerciseRecord_mainRecord.php">주요기록</a></li>
                <li ><a href="exerciseRecord_dailyRecord.php">매일기록</a></li>
              </ul>
            </div>
          </div>-->
        
        <div class="secondTab">
          <a href="exerciseRecord_mainRecord.php?id=<?=$_SESSION['user_id']?>&exerciseName=bench_press"><p class="left" style="background-color:rgb(178,54,54)">주요기록</p></a>
          <a href="exerciseRecord_dailyRecord.php"><p class="right" >매일기록</p></a>
        </div>

        <div class="container-fluid">

          <div class="dropdown mainExercise" >
            <button id="dropdown" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" width="200px">
              <?if($_GET['exerciseName']=='bench_press'){
                echo 'Bench Press';
              }else if($_GET['exerciseName']=='squat'){
                echo 'Squat';
              }else if($_GET['exerciseName']=='shoulder_press'){
                echo 'Shoulder Press';
              }else{
                echo 'Dead Lift';
              }?>
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li value="0"><a href="exerciseRecord_mainRecord.php?id=<?=$_SESSION['user_id']?>&exerciseName=bench_press" >Bench Press</a></li>
              <li value="1"><a href="exerciseRecord_mainRecord.php?id=<?=$_SESSION['user_id']?>&exerciseName=squat" >Squat</a></li>
              <li value="2"><a href="exerciseRecord_mainRecord.php?id=<?=$_SESSION['user_id']?>&exerciseName=shoulder_press" >Shoulder Press</a></li>
              <li value="3"><a href="exerciseRecord_mainRecord.php?id=<?=$_SESSION['user_id']?>&exerciseName=deadlift" >Dead Lift</a></li>
            </ul>
          </div>
           
           <div style="width: 100%">
              <canvas id="canvas" height="450" width="600"></canvas>
            </div>

      </div>
   

<?startblock('extra');?>

<script src="js/Chart.min.js"></script>
<script>
 function showGraph(){
  <?$records=getGRAPH($_GET['id'],$_GET['exerciseName'],8);
    $x_label = array();
    $y_label = array();?>
var barChartData = {
  // 가로축 라벨
  <?foreach ($records as $key => $value) {
      array_push($x_label, '"'.$value[1].'"');
      array_push($y_label, '"'.$value[0].'"');
    }?>
  labels : [<?echo implode(',',$x_label);?>],
  datasets : [
    {
      fillColor : "rgba(220,220,220,0.5)",
      strokeColor : "rgba(220,220,220,0.8)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      // 세로축 데이터들
      data : [<?echo implode(',',$y_label);?>]
    }
  ]

}
window.onload = function(){
  var ctx = document.getElementById("canvas").getContext("2d");
  window.myBar = new Chart(ctx).Bar(barChartData, {
    responsive : true
  });
}
}
showGraph();
</script>
<?endblock('extra');?>

<?endblock('content');
  startblock('head');
  echo "<title> JUCY | ".$title."</title>";
  endblock('head');
  startblock('content-title');
  echo $title;
  endblock('content-title');
?>




<?startblock('extra');?>

<script src="js/Chart.min.js"></script>
<script>
 function showGraph(){
  <?$records=getGRAPH($_GET['id'],$_GET['exerciseName'],8);
    $x_label = array();
    $y_label = array();?>
var barChartData = {
  // 가로축 라벨
  <?foreach ($records as $key => $value) {
      array_push($x_label, '"'.$value[1].'"');
      array_push($y_label, '"'.$value[0].'"');
    }?>
  labels : [<?echo implode(',',$x_label);?>],
  datasets : [
    {
      fillColor : "rgba(220,220,220,0.5)",
      strokeColor : "rgba(220,220,220,0.8)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      // 세로축 데이터들
      data : [<?echo implode(',',$y_label);?>]
    }
  ]

}
window.onload = function(){
  var ctx = document.getElementById("canvas").getContext("2d");
  window.myBar = new Chart(ctx).Bar(barChartData, {
    responsive : true
  });
}
}
showGraph();
</script>

<?endblock('extra');?>