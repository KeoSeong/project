<?php
  include_once('base.php');
  setTitle("로그인");
  if(isset($_POST['id']) && isset($_POST['pw']))
  {
      $result = login($_POST['id'], $_POST['pw']);

      if($result[0][0] == 'success')
      {   
          echo "string";
          $_SESSION['user_id'] = $result[1][0];
          $_SESSION['user_name'] = $result[1][1];
          $_SESSION['user_level'] = $result[1][2];
          echo "<meta http-equiv='refresh' content='0;url=todaysExercise.php'>";
      }
      else
      {
          // 존재하지 않는 아이디거나 비밀번호가 틀림
          echo '<script type="text/javascript">';
          echo 'alert("비밀번호가 틀렷거나 등록되지 않은 아이디 입니다.")';
          echo '</script>';
          $isLogin = false;
      }
  } else {
            $isLogin = false;
         }
  startblock('content'); ?>
       <h1 class="login_text">로그인</h1>
       <form action="login.php" method="post">
         <input class="input_id" type="text" name="id" value="" placeholder="id"/><br/>
         <input class="input_password" type="password" name="pw" value="" placeholder="pw"/>
         <input class="btn vtn-default login_button" type="submit" name="" value="login"/>
         <a href="register.php" class="join">회원가입</a>
       </form>
<?php
  endblock('content');
  startblock('head');
  //echo "<title> JUCY | ".$title."</title>";
  endblock('head');
  startblock('content-title');
  //echo $title;
  endblock('content-title');
?>