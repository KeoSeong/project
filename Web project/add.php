<?php
    include 'timeline.php';
    require_once('base.php');
    $userid = $_SESSION['user_id'];

    $TL = new TimeLine();
    try {
        if(isset($_POST['author'])){
            $author = $_POST['author'];
        }
        if(isset($_POST['content'])){
            $content = $_POST['content'];
        }
        if(isset($_POST['reply'])){
            $reply = $_POST['reply'];
        }
        $content = htmlspecialchars($content);
        $tweet = array($author, $content);

        if((isset($userid))&&(strlen($content)>0)){
            if(isset($reply)){
                $TL->addReply($tweet,$reply);
                header("Location:contents.php?reply=$reply");
?> 
                <?="<script>location.replace(\"contents.php?reply=$reply\")</script>";?>
<?
            }
            else if(!isset($reply)){
                $TL->addReply($tweet,$reply);
?>
                <?="<script>location.replace(\"contents.php\")</script>";?>
 
<?
            }
        }else{
?>
            <?="<script>alert('로그인해주세요.'); location.replace(\"contents.php\")</script>";?>
<?
        }
    } catch(Exception $e) {
        header("Loaction:error.php");
    }
?>
