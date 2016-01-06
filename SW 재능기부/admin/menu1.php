<?php
  include_once('./admin_base.php');
  if(isset($_SESSION['user_id'])){
?>

<?php
  levelup($_GET['idl']);
?>

<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>

<div class="row" style="margin-left: auto; margin-right: auto;">
  <div class="container-fluid col-md-4">
    <h2>회원정보</h2>
    <form action="" method="GET">
      <input type="radio" name="search" value="all" checked="checked"> 전체 
      <input type="radio" name="search" value="id"> ID
      <input type="radio" name="search" value="name"> 이름
      <br />
      <br />
        <input type="text" class="col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6" name="searchText" placeholder="입력">
        <button type="submit" class="btn btn-default col-xs-offset-1 col-xs-2 col-md-offset-1 col-md-2">검색</button>
    </form>    
    <br />    
    <br />
    <br />
    <table class="table table-striped">
        <thead>
          <tr>
            <th>아이디</th>
            <th>이름</th>
            <th>가입상태</th>
            <th>투표진행여부</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $d = showUSER();
            if(!strcmp($_GET['search'], "all")){
              if(!strcmp($_GET['searchText'], "")){
                $d = showUSER();
              }
              else{
                $c = searchID($_GET['searchText']);
                $e = searchNAME($_GET['searchText']);
                if($c[0][0] != "empty"){
                  $d = $c;
                } 
                elseif($e[0][0] != "empty"){
                  $d = $e;
                }
                else{
                  $d = $c;
                }
              }
            }
            elseif(!strcmp($_GET['search'], "id")){
              if(!strcmp($_GET['searchText'], "")){
                $d = showUSER();
              }
              else{
                $d = searchID($_GET['searchText']);
              }
            }
            elseif(!strcmp($_GET['search'], "name")){
              if(!strcmp($_GET['searchText'], "")){
                  $d = showUSER();
              }
              else{
                  $d = searchNAME($_GET['searchText']);  
              }
            }


            foreach ($d as $var)
            {
              $var2 = "";
              $var3 = "";
              $var4 = $var[0];
              if($var[2] == 0)
              {
                  $var2 = "승인대기";
              }
              else
              {
                  $var2 = "일반회원";
              }
              if($var[3] == 1)
              {
                  $var3 = "투표 미진행";
              }
              else
              {
                  $var3 = "투표 완료";
              }

              ?>
          <tr>
            <td><?=$var[0]?></td>
            <td><?=$var[1]?></td>
            <?php if($var[2] == 0){?>
              <td><a href="?idl=<?=$var4?>">회원승인</a></td>
            <?php } else{?>
            <td><?=$var2?></td>
            <?php }?>
            <td><?=$var3?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

<? endblock('content'); 
  }else{
      echo '<script type="text/javascript">';
      echo 'alert("접근권한이 없습니다.")';
      echo '</script>';
  }
?>