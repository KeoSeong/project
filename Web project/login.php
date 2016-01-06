<?php
  include_once('base.php');
  startblock('head'); ?>
  
  <link rel="stylesheet" type="text/css" href="css/login.css" />

<? endblock('head'); ?>

<? startblock('content'); ?>

  <div>
    <section>
      <div>Login</div>
      <div>
        <form method="post" action="login_ok.php" class="login loginfix">
            <p>
                <input type="text" id="login" name="user_id" placeholder="Username">
                <input type="password" name="user_pw" id="password" placeholder="Password"> 
            </p>
            <button type="submit" name="submit">
              <span>Sign in</span>
            </button>     
        </form>
      </div>​​​​
      <div>
        <p>
          <a href="find_info.php">아이디/비밀번호 찾기</a>
          <a href="join.php">회원가입</a>
        </p>
      </div>
    </section>
  </div>

<? endblock('content'); ?>