<?php 
    require_once("base.php");
    include 'feedbackmete.php';
    $FB = new Feedback();
    
?>

<? startblock('head'); ?>
    <link rel="stylesheet" type="text/css" href="css/feedback.css" />
<? endblock('head'); ?>
    <article>
    	<div>
    		<div>FEEDBACK</div>
    		</p>
    		<form class="write-form" action="feedadd.php" method="POST">     
                        <textarea class = "feed" name="content" placeholder ="Content"/></textarea></p>
                        <?php
                        if (isset($_GET['feedbackbutton'])){ 
                        ?>
                        <div class="success">소중한 한마디 감사합니다 ^^</div>
                    
                        <?php
                        }else{
                        ?>
                        <input class="bt" type="submit" name="feedbackbutton" value="SEND">
            			<?php }?>
            </form>
    	</div>

    
         <p/>
    <footer><div id=develop>Developers</div>
        <div>
            <div><h1>개발자</h1><img src="img/3.jpeg"><p>김태성</p><p id=yong></p> </div>
            <div><h1>개발자</h1><img src="img/1.jpeg"><p>김민규</p><p id=yong></p></div>
            <div><h1>개발자</h1><img src="img/2.jpeg"><p>박거성</p><p id=yong></p></div>
            <div><h1>개발자</h1><img src="img/5.jpeg"><p>안정기</p><p id=yong>1991년 10월 18일생<br/>010-2771-7702<br/>한양대학교 ERICA 컴퓨터공학과<br/>Facebook / Instagram<br/>/*영화감독이 꿈입니다.*/</p></div>

            <div><h1>개발자</h1><img src="img/4.jpeg"><p>최준태</p><p id=yong></p></div>
        </div>
    </footer>
    </div>
</html>