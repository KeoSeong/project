<?php
  include_once('./admin_base.php');
  if(isset($_SESSION['user_id'])){
?>

<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

<?
   // 디렉토리에 있는 파일과 디렉토리의 갯수 구하기
  $result=opendir("upload"); //opendir함수를 이용해서 upload디렉토리의 핸들을 얻어옴
  // readdir함수를 이용해서 bbs디렉토리에 있는 디렉토리와 파일들의 이름을 배열로 읽어들임 
  while($file=readdir($result)) {
     
     if($file=="."||$file=="..") {continue;} // file명이 ".", ".." 이면 무시함
     $fileInfo = pathinfo($file);
     $fileExt = $fileInfo['extension']; // 파일의 확장자를 구함

     If (empty($fileExt)){
        $dir_count++; // 파일에 확장자가 없으면 디렉토리로 판단하여 dir_count를 증가시킴
     } else {
        $file_count++;// 파일에 확장자가 있으면 file_count를 증가시킴
     }

  }

if (!empty($_POST)) {
  // POST가 빈 요청이 아닐때.
  $upload_path = "./upload/";

  // uploader 객체를 생성한다. (라이브러리 직접 수정해도 됨)
  $extentions = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/gif');
  $uploader = new Uploader(True);

  $uploader->set_extentions($extentions);
  $uploader->set_directory($upload_path);
  $uploader->set_filename("$file_count.jpg");

  if ( $uploader->upload() ) {
  }
}

  $activation = dietwar_status();
?>

<div class="row" style="margin-left: auto; margin-right: auto;">
  <div class="container-fluid col-md-4">
    <h2>다이어트워</h2>
    <form action = "" method = "POST">
     <input type="radio" name="chk_info" value="on" <? if($activation[0][0] == 1){echo "checked";}?>> 활성화
     <input type="radio" name="chk_info" value="off" <? if($activation[0][0] == 2){echo "checked";}?>> 비활성화 
     <input type="submit" value="Save" /><br /><br />
    </form>
    <?php
      $radio = $_POST['chk_info'];
      if($radio == 'off'){
        vote('admin', 1000);
      } else if($radio == 'on'){
        voteRESET();
      }
      $activation = dietwar_status();
    ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <?
        for($i = 1; $i < $file_count; $i++){
          ?>
          <li data-target="#myCarousel" data-slide-to="<?=$i?>"></li>
      <? 
        } ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="upload/1.jpg" class="img-responsive">
      </div>
      <? 
        for($j = 1; $j < $file_count; $j++){
          ?>
          <div class="item">
            <img src="upload/<?=$j+1?>.jpg" class="img-responsive">
          </div>
      <?
        } ?>
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
</div>
<br />
<div class="row" style="margin-left: auto; margin-right: auto;">
  <!-- Trigger the modal with a button -->
  <div id="addbutton" class="container-fluid">
    <?php if($activation[0][0] == 1){?>
      <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">사진추가</button>
    <?php } ?>
  </div>
  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form enctype="multipart/form-data" action="#" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="128288">
        <div class="modal-header">
          <p><button type="button" class="close" data-dismiss="modal">&times;</button></p>
          <h4 class="modal-title">사진추가</h4>
        </div>
        <div class="modal-body">


          <div class="form-group">

          <form enctype="multipart/form-data" action="img_uploader.php" method="post">
             <!-- 8.클라이언트쪽 업로드 제한용량을 설정함-->
            <input type="hidden" name="MAX_FILE_SIZE" value="12828888">
            <b>파일:</b> 
            <input type="file" name="upload" />
            <input type="hidden" name="type" value="image"/>
            <div align="center"><input type="submit" name="upload_form" value="업로드" /></div>
            <input type="hidden" name="upload_check" value="true" />
          </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
 
<? endblock('content'); ?>
<? startblock('extra'); ?>
    <script>
      $(document).ready(function(){
          $("button").click(function(){
              $("#myCarousel").toggle();
              $("#addbutton").toggle();
          });
      });
    </script>
<? endblock('extra'); 
  }else{
      echo '<script type="text/javascript">';
      echo 'alert("접근권한이 없습니다.")';
      echo '</script>';
  }
?>