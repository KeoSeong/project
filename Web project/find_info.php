<?php
  include_once('base.php');
  startblock('head'); ?>

    <link rel="stylesheet" type="text/css" href="css/find_info.css" />

<? endblock('head'); ?>

<? startblock('content'); ?>

	<div>
    <section>
      <div>아이디 / 비밀번호 찾기</div>
      <div>
        <form method="post" action="find_info_ok.php" class="login loginfix">
            <p>
                <input type="text" id="login" name="user_email" placeholder="Email">
            </p>
            <button type="submit" name="submit">
              <span>Find</span>
            </button>     
        </form>
      </div>​​​​
    </section>
  </div>

<? endblock('content'); ?>