<?php
  include_once('base.php');
  setTitle("회원가입");

  /* 회원가입 페이지 html 코드 호출 함수 */
  function registerpage()
  {
      echo '<h1>회원가입</h1>';
      echo '<form action="register.php" method="post">';
      echo '<input type="text" name="id" value="'.$_POST[id].'" placeholder="아이디"/><br/>';
      echo '<input type="text" name="name" value="'.$_POST[name].'" placeholder="이름"/><br/>';
      echo '<input type="password" name="pw" value="" placeholder="비밀번호"/><br/>';
      echo '<input type="password" name="repw" value="" placeholder="비밀번호확인"/><br/>';
      echo '<input type="submit" name="" value="완료"/><br/>';
      echo '</form>';
  }
?>



<!-- 이부분만 바꿔서 수정하면 됩니다. -->
<? startblock('content'); ?>
<?php
if($_POST['id'] != '' && $_POST['pw']!='')
  {
      
      if($_POST['pw'] == $_POST['repw'])
      {
          $result = login($_POST['id'], $_POST['pw']);
          if($result[0][0] == 'fail')
          {
              $a = adduser($_POST['id'], $_POST['name'], $_POST['pw']);
              if($a[0][0] == 'success')
              {
                  // 아이디 생성완료 로그인페이지로 이동
                  echo '<script type="text/javascript">';
                  echo 'alert("회원가입이 완료되었습니다.\n로그인 페이지로 이동합니다.")';
                  echo '</script>';
                  header('Location: login.php');
              }
              else
              {
                  // 아이디 생성실패 거의 발생되지 않는 경우
                  echo '<script type="text/javascript">';
                  echo 'alert("아이디 생성 실패")';
                  echo '</script>';
                  registerpage();
              }
          }
          else
          {
              //아이디가 중복됨
              echo '<script type="text/javascript">';
              echo 'alert("아이디가 중복됩니다. 다른 아이디를 사용해 주세요.")';
              echo '</script>';
              registerpage();
          }
          
      }
      else
      {
              //아이디가 중복됨
              echo '<script type="text/javascript">';
              echo 'alert("비밀번호가 일치하지 않습니다 다시한번 확인해주세요.")';
              echo '</script>';
              registerpage();
      }
  }
    else if($_POST['id'] != '' || $_POST['pw']!='')
      {
          // id 혹은 비밀번호 입력 안함
          echo '<script type="text/javascript">';
          echo 'alert("아이디 혹은 비밀번호를 입력하지 않았습니다.")';
          echo '</script>';
          registerpage();
      } 
    else {
            // 처음 화면 열때 알림메시지 필요 없음
            registerpage();
         }
  endblock('content');
  startblock('head');
  echo "<title> JUCY | ".$title."</title>";
  endblock('head');
  startblock('content-title');
  echo $title;
  endblock('content-title');
?>