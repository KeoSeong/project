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
    		<div><</div><div>FEEDBACK</div><div>></div>
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
    </article>
    
  
    </body>
</html>
