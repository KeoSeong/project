<?php
  include_once('./admin_base.php');
?>

<? startblock('content'); ?>
<?$a = showTODAYex(date("Y-m-d"));
	foreach ($a as $var)
	{
		$data = array($var[0], $var[1], $var[2], $var[3], $var[4]);
	} 
	$crossfit = str_replace('<iframe width="300" height="150" src="https://www.youtube.com/embed/', "", $var[2]);
	$crossfit = str_replace('" frameborder="0" allowfullscreen></iframe>', "", $crossfit);
	$crossfit = "https://www.youtube.com/watch?v=".$crossfit;
	$weight = str_replace('<iframe width="300" height="150" src="https://www.youtube.com/embed/', "", $var[4]);
	$weight = str_replace('" frameborder="0" allowfullscreen></iframe>', "", $weight);
	$weight = "https://www.youtube.com/watch?v=".$weight;
?>
<form action="menu3.php" method="GET">
  <div class="row" style="margin-left: auto; margin-right: auto;">
    <div class="container-fluid col-md-4">
      <h2>오늘의운동 수정하기 <br />  <?=$data[0]?></h2>
      <div class="panel panel-default">
        <div class="panel-heading">크로스핏</div>
        <div class="panel-body">    
          <div class="embed-responsive embed-responsive-16by9">
            <textarea name="crossfitContents2" class="embed-responsive embed-responsive-16by9" style="width:100%;"><?=$data[1]?></textarea>
          </div>
        </div>
        <div class="panel-footer">
            동영상주소
            <input type="text" name="crossfitLink2" value="<?=$crossfit?>" style="width:100%;">
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
            <textarea name="weightContents2" class="embed-responsive embed-responsive-16by9" style="width:100%;"><?=$data[3]?></textarea>
          </div>
        </div>
        <div class="panel-footer">
            동영상주소
            <input type="text" name="weightLink2" value="<?=$weight?>" style="width:100%;">
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-left: auto; margin-right: auto;">
    <div class="container-fluid col-md-4">
      <button type="submit" class="btn btn-default" data-dismiss="modal" style="float:right;">수정</button>
    </div>
  </div>
</form>

<? endblock('content'); ?>