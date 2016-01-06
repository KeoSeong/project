<?php
  include_once('base.php');
  setTitle("운동기록 하기");
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>
    <h1>시즌7 다이어트워</h1>
    <?php
      $file_count=0;
      $result=glob("admin/upload/*.png");
      foreach ($result as $val) {
        $file_count+=1;
      }
    ?>
    <div class="container-fluid">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php
        for ($i=0; $i<$file_count ;$i++) {?>
          <li data-target="#myCarousel" data-slide-to=<?=$val?>></li>
       <?php }
      ?>
<!--       <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li> -->
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <?php
        for ($i=1; $i<=$file_count ;$i++) {
            if($i==1){
              echo '<div class="item active">';
            }else{
              echo '<div class="item">';
            }?>
              <img src="<?=$i?>.png" alt="Chania" width="460" height="345">
              </div>
          <?php }?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>


    <div class="container-fluid" style="margin-top:5%;">

	<div class="row">		
		<div class="col-xs-3 col-xs-offset-3" style="line-height:1px;">
		 <select class="form-control" style="height:30px;">
      <?php
        for ($i=1; $i<=$file_count ;$i++) {?>
          <option><?=$i?></option>
       <?php }
      ?>
	   </select> 
    </div> 

	<div class="col-xs-3 row voteButton">
	<button type="button" class="btn btn-default btn-sm">투표하기</button>
	</div>
	</div>          
    </div>

<?endblock('content');
  startblock('head');
  echo "<title> JUCY | ".$title."</title>";
  endblock('head');
  startblock('content-title');
  echo $title;
  endblock('content-title');
?>