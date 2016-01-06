<?php
  include_once('base.php');
  setTitle("오늘의 운동");
  if(isset($_SESSION['user_id'])){
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

        <div class="secondTab">
          <a href="todaysExercise.php"><p class="left">CrossFit</p></a>
          <p class="right" style="background-color:#DF314D">Weight</p>
        </div>

        <?php
          $weight_url=showTODAYex(date("Y-m-d"));
          $weight_url=$weight_url[0][4];
        ?>
        <div class="container-fluid">
          <div style="margin:10px;">
          <?=$weight_url?>
          </div>
          <div class="well">
            <?php
              $a = showToDAYex(date("Y-m-d"));
              if(isset($a[0][3])){
                $aa = explode(",", $a[0][3]);
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