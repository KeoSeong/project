<?php
  include_once('./admin_base.php');
  if(isset($_SESSION['user_id'])){
?>

<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

<form action="" method="GET">
  <div class="row" style="margin-left: auto; margin-right: auto;">
    <div class="container-fluid col-md-4">
      <h2>오늘의운동</h2>
      <div class="panel panel-default">
        <div class="panel-heading">크로스핏</div>
        <div class="panel-body">    
          <div class="embed-responsive embed-responsive-16by9">
            <textarea name="crossfitContents" class="embed-responsive embed-responsive-16by9" style="width:100%;"></textarea>
          </div>
        </div>
        <div class="panel-footer">
            동영상주소
            <input type="text" name="crossfitLink" style="width:100%;">
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-left: auto; margin-right: auto;">
   <div class="container-fluid col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">웨이트 트레이닝</div>
        <div class="panel-body">    
          <div class="embed-responsive embed-responsive-16by9">
            <textarea name="weightContents" class="embed-responsive embed-responsive-16by9" style="width:100%;"></textarea>
          </div>
        </div>
        <div class="panel-footer">
            동영상주소
            <input type="text" name="weightLink" style="width:100%;">
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-left: auto; margin-right: auto;">
    <div class="container-fluid col-md-4">
      <?php 
        $is_there_data = showTODAYex(date("Y-m-d"));
        if($is_there_data[0][0] == 'empty'){?>
      <button style="float: right;" type="submit" class="btn btn-default" data-dismiss="modal">업로드</button>
      <?php } else{?>
      <button style="float: right;" type="submit" class="btn btn-default" data-dismiss="modal" disabled = "disabled">업로드</button>
      <?php }?>
    </div>
  </div>
</form>

<?
  if((strpos($_GET['crossfitLink'], "https://www.youtube.com/watch?v=") !== false) && (strpos($_GET['weightLink'], "https://www.youtube.com/watch?v=") !== false) ){
    $x1 = $_GET['crossfitLink'];
    $x2 = $_GET['weightLink'];
    $x1 = str_replace("https://www.youtube.com/watch?v=", "", $x1);
    $x2 = str_replace("https://www.youtube.com/watch?v=", "", $x2);
    $x1 = '<iframe width="300" height="150" src="https://www.youtube.com/embed/'.$x1.'" frameborder="0" allowfullscreen></iframe>';
    $x2 = '<iframe width="300" height="150" src="https://www.youtube.com/embed/'.$x2.'" frameborder="0" allowfullscreen></iframe>';
    saveTODAYex($_GET['crossfitContents'], $x1, $_GET['weightContents'], $x2, date("Y-m-d"));
  }
  else{ ?>
    <script>
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script>
    <br />
    <div class="row" style="margin-left: auto; margin-right: auto;">
      <div class="container-fluid">
        <a href="#" data-toggle="tooltip" title="https://www.youtube.com/watch?v=">동영상주소 형식 보기!</a>
      </div>
    </div>
<?
  }
?>
<?
  if((strpos($_GET['crossfitLink2'], "https://www.youtube.com/watch?v=") !== false) && (strpos($_GET['weightLink2'], "https://www.youtube.com/watch?v=") !== false) ){
    $x3 = $_GET['crossfitLink2'];
    $x4 = $_GET['weightLink2'];
    $x3 = str_replace("https://www.youtube.com/watch?v=", "", $x3);
    $x4 = str_replace("https://www.youtube.com/watch?v=", "", $x4);
    $x3 = '<iframe width="300" height="150" src="https://www.youtube.com/embed/'.$x3.'" frameborder="0" allowfullscreen></iframe>';
    $x4 = '<iframe width="300" height="150" src="https://www.youtube.com/embed/'.$x4.'" frameborder="0" allowfullscreen></iframe>';
    modifyTODAYex($_GET['crossfitContents2'], $x3, $_GET['weightContents2'], $x4, date("Y-m-d"));
  }
  else{ ?>
    <script>
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script>
    <br />
    <div class="row" style="margin-left: auto; margin-right: auto;">
      <div class="container-fluid">
        <a href="#" data-toggle="tooltip" title="https://www.youtube.com/watch?v=">꼭 이 형식에 맞춰주세요!</a>
      </div>
    </div>
<?
  }
?>

    <div class="row" style="margin-left: auto; margin-right: auto;">
      <div class="container-fluid col-md-4">
      <h3></h3>
      <div class="well"><?$a = showTODAYex(date("Y-m-d"));
        foreach ($a as $var)
            {?>
              <?=$var[0]?><br />
              <?=$var[1]?><br />
              <?=$var[2]?><br />
              <?=$var[3]?><br />
              <?=$var[4]?><br />
              <? } ?>
        </div>
      </div>
    </div>

    <div class="row" style="margin-left: auto; margin-right: auto;">
      <div class="container-fluid col-md-4">
        <form action="fix.php" method="GET">
          <? if($is_there_data[0][0] == 'empty'){?>
            <button style="float: right;" type="submit" class="btn btn-default" data-dismiss="modal" disabled="disabled">수정</button>
          <? } else{?>
            <button style="float: right;" type="submit" class="btn btn-default" data-dismiss="modal">수정</button>
          <? } ?>
        </form>
      </div>
    </div>




 <? endblock('content'); 
  }else{
      echo '<script type="text/javascript">';
      echo 'alert("접근권한이 없습니다.")';
      echo '</script>';
  }
?>