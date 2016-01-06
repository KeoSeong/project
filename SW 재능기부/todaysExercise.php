<?php
  include_once('base.php');
  setTitle("오늘의 운동");
  if(isset($_SESSION['user_id'])){
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

        <div class="secondTab">
          <p class="left"  style="background-color:#DF314D">CrossFit</p>
          <a href="todaysExercise_weight.php"><p class="right">Weight</p></a>
        </div>

        <?php
          $crossfit_url=showTODAYex(date("Y-m-d"));
          $crossfit_url=$crossfit_url[0][2];
        ?>
        <div class="container-fluid">
          <div style="margin:10px;">
            <?=$crossfit_url?>
          </div>
          <div class="well">
            <?php
              $a = showToDAYex(date("Y-m-d"));
              if(isset($a[0][1])){
                $aa = explode(",", $a[0][1]);
                echo "<ul>";
                foreach ($aa as $value) {
                  echo "<li>".$value."</li>";
                  echo "\n<br/>";
                }
                echo"</ul>";
              }else{
                echo "설명이 없습니다.";
              }
            ?>
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