<?php
  include_once('base.php');
  startblock('head'); ?>
  
  <link rel="stylesheet" type="text/css" href="css/join.css" />

<? endblock('head'); ?>

<? startblock('content'); ?>

  <div>
    <section>
      <div>회원가입</div>
      <div>
        <form method="post" action="join_ok.php" >
            <div class="login loginfix">
              <h3>아이디</h3><input type="text" name="user_id" placeholder="아이디">
              <h3>이름</h3><input type="text" name="user_name" placeholder="이름">
              <h3>나이</h3><input type="text" name="user_age" placeholder="나이">
              <h3>이메일</h3><input type="email" name="user_email" placeholder="이메일">
              <h3>한마디</h3><input type="text" name="user_comment" placeholder="한마디">
              <h3>비밀번호</h3><input type="password" name="user_pw1" placeholder="비밀번호">
              <h3>비밀번호 확인</h3><input type="password" name="user_pw2" placeholder="비밀번호 확인">
              <h3>학교</h3><input type="text" name="user_school" placeholder="학교">  
            </div>
            <div>
              <button type="submit" name="submit">
                <span>가입하기</span>
              </button>
            </div>   
        </form>
      </div>​​​​
    </section>
  </div>

<? endblock('content'); ?>