<?php
  include_once('./admin_base.php');
  if(isset($_SESSION['user_id'])){
?>

<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>


<div class="row" style="margin-left: auto; margin-right: auto;">
  <div class="container-fluid">
    <div class="panel-group col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">회원정보</div>
        <div class="panel-body">
          <img src="1.png" class="img-circle" alt="icon1" width="50" height="50">
          <button type="button" class="btn btn-default col-xs-offset-7 col-md-offset-7"><a href="menu1.php" style="color:black;"><strong>Click</strong></a></button>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">다이어트워</div>
        <div class="panel-body">
          <img src="2.png" class="img-circle" alt="icon2" width="50" height="50">
          <button type="button" class="btn btn-default col-xs-offset-7 col-md-offset-7"><a href="menu2.php" style="color:black;"><strong>Click</strong></a></button>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">오늘의운동</div>
        <div class="panel-body">
          <img src="3.png" class="img-circle" alt="icon3" width="50" height="50">
          <button type="button" class="btn btn-default col-xs-offset-7 col-md-offset-7"><a href="menu3.php" style="color:black;"><strong>Click</strong></a></button>
        </div>
      </div>
    </div>
  </div>
</div>

<? endblock('content'); 
  }else{
      echo '<script type="text/javascript">';
      echo 'alert("접근권한이 없습니다.")';
      echo '</script>';
  }
?>