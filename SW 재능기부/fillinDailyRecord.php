<?php
  include_once('base.php');
  setTitle("운동기록 하기");
  if(isset($_SESSION['user_id'])){
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

     <form action="#" method="post">
    <div class="row">
        <div class="secondTab">
         <p class="left" style="background-color:#DF314D">CrossFit</p>
          <a href="fillinDailyRecord_weight.php"><p class="right" >Weight</p></a>
        </div>
    <h1><?=$_GET['month']?>월 <?=$_GET['day']?>일</h1>
    <!--if) crossfit을 선택했다면-->
    <div class="container-fluid" style="text-align:center;">
      <h2>오늘의 운동</h2> 
      <div class="well" style="width:70%; display:inline-block;">
        <?php
          $date = $_GET['year']."-".$_GET['month']."-".$_GET['day'];
          $a = showToDAYex($date);
          if(isset($a[0][1])){
            echo $a[0][1];
             echo "\n<br/>";
           }else{
            echo "운동 기록이 없습니다.\n<br/>";
           }
        ?>
      </div>
             
      <div class="form-group">
        <label for="comment"></label>
        <textarea class="form-control" name="crossfit_record" rows="1" id="comment" style="width:70%; display:inline-block;">
        </textarea>
      </div>
    </div>


    <div class="container-fluid" id="daily-row-container">
      <h2>기타 운동</h2> 
      <div id="daily-row">
      <div class="row" style="margin-top:2%">
        <div class="col-xs-5 col-xs-offset-2" style="width:160px;">
         <select class="form-control" name="daily_record_name[]">
          <option>Bench Press</option>
          <option>Shoulder Press</option>
          <option>Dead Lift</option>
          <option>Squat</option>
        </select>
        </div>
        <div class="col-xs-3">
         <select class="form-control" name="daily_record[]">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
        </select> 
        </div>
        <div class="col-xs-1">
          <button type="button" class="btn btn-default btn-sm" id="row_add" style="margin-bottom:10%; width:30px; border-radius:30px;"> <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        </div>
      </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row storeButton">
        <button type="submit" class="btn btn-default btn-lg btn-block" style="width:30%; float:right; margin-top:10px; margin:auto;"><i class="fa fa-check"></i></button>
      </div>
    </div>

  </form>


<?startblock('extra');?>
<script>
  var i=0;
  function a() {
    if(i<3){
      var row = '<div id="daily-row">\
      <div class="row" style="margin-top:2%">\
        <div class="col-xs-5 col-xs-offset-1">\
         <select class="form-control" name="daily_record_name[]">\
          <option>Bench Press</option>\
          <option>Shoulder Press</option>\
          <option>Dead Lift</option>\
          <option>Squat</option>\
        </select>\
        </div>\
        <div class="col-xs-3">\
         <select class="form-control" name="daily_record[]">\
          <option>1</option>\
          <option>2</option>\
          <option>3</option>\
          <option>4</option>\
        </select> \
        </div>\
        <div class="col-xs-1">\
        </div>\
      </div>\
      </div>';
      console.log(row);
      $("#daily-row-container")[0].innerHTML += row;
      
      i++;
    }
  }
  $(".btn-sm").click(a);

</script>
<?endblock('extra');?>

<?php
  
  $crossfit = null;
  $shoulder_press = 0;
  $deadlift = 0;
  $bench_press = 0;
  $squat = 0;

  $result = array();

  if(!empty($_POST['crossfit_record'])) {
    $crossfit = $_POST['crossfit_record'];
  }

  if(isset($_POST['daily_record_name'])){
    for ($i=0; $i < count($_POST['daily_record_name']); $i++) { 
      switch ($_POST['daily_record_name']) {
        case 'Bench Press':
          $bench_press = intval($_POST['daily_record']);
          break;
        case 'Shoulder Press':
          $shoulder_press = intval($_POST['daily_record']);
          break;
        case 'Dead Lift':
          $deadlift = intval($_POST['daily_record']);
          break;
        case 'Squat':
          $squat = intval($_POST['daily_record']);
          break;
        default:
          # code...
          break;
      }
    }
  }

  
  $id = $_SESSION['user_id'];
  $date = $_GET['year']."-".$_GET['month']."-".$_GET['day'];;
  $weight = "";
  $a = saveRECORD($id, $date, $bench_press, $shoulder_press, $deadlift, $squat, $crossfit, $weight);
  echo $a[0][0];
?>


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