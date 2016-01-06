<?
    require_once('base.php');
    include 'timeline.php';
    $TL = new TimeLine();
    $rows=$TL->loadTweets();

    if((!(empty($_GET['type'])))&&(!(empty($_GET['query'])))){
        $type = $_GET['type'];
        $query = $_GET['query'];
        $rows=$TL->searchTweets($type, $query);
    }

    else if((!(empty($_GET['reply'])))){
        $reply = $_GET['reply'];
        $rows=$TL->searchReply($reply);
    }
    $username =$_SESSION['user_id'];
?>

<? startblock('head'); ?>
        <link rel="stylesheet" href="css/contents.css">
<? endblock('head'); ?>

<? startblock('content'); ?>
        <div id="community">


            <div class="panel">
                <div class="panel-heading">
                    <form class="write-form" action="add.php" method="POST">
                        <input type = "hidden" value = <?=$username ?>>
                        <input type = "hidden" name="author" value = <?=$username ?>>
<?php
    if(isset($reply)){
        ?>
                        <input type = "hidden" name="reply" value = <?=$reply ?>>
<?
    }
?>
                        <div>
                            <input type="text" name="content" placeholder="글 내용을 작성해 주세요.">
                        </div>
                        <input type="submit" value="등록">
                    </form>
                </div>

				<div class="search">
                <form class="search-form" action="contents.php" method="GET">
                						                <?php
                 if(((empty($_GET['reply'])))){

                 }
                 	else {
                 		                 	?>
                 		   <a href="contents.php"><img src="img/back.png"/></a>
                 	<?php
                 	}
                ?>
                    <input type="submit" value="검색">
                    <input type="text" name="query" placeholder="검색어">
                    <select name = "type">
                        <option value = "Author">작성자</option>
                        <option value = "Contents">내용</option>
                    </select>
                </form>
            </div>
            
                <?foreach ($rows as $row) {
                    $numberOfReply=$TL->getNumberOfReply($row["no"]);
?>

<?php 
            if(((empty($_GET['reply'])))){
?>
				<div class="tweet">
                    <form class="delete-form" action="delete.php" method="POST">
                        <input type="submit" value = "삭제">
                        <input type="hidden" value = <?=$row["no"]?> name = "no">
                        <input type="hidden" value = <?=$row["author"]?> name = "author">
                    </form>
                    <div class="tweet-info">
                        <form action="contents.php" method="GET">
                            <input type = "submit" value = "댓글 (<?=$numberOfReply?>)">
                                                        <input type = "hidden" name = "reply" value = "<?=$row["no"]?>" >
							
                        </form>
                        <!-- <span><?= $row["no"] ?></span> -->
                        <span><?= $row["author"] ?></span>
                        <span><?= $row["time"] ?></span>
                    </div>
                    <div class="tweet-content">
                        <?=$row["contents"] ?>
                    </div>
                </div>
<?php
                            } else{
?>
				<div class="reply">
                    <form class="delete-form" action="delete.php" method="POST">
                        <input type="submit" value = "삭제">
                        <input type="hidden" value = <?=$row["no"]?> name = "no">
                        <input type="hidden" value = <?=$row["author"]?> name = "author">
                    </form>
                    <div class="reply-info">
                        <form action="contents.php" method="GET">   
							  <input type = "hidden" name = "reply" value = "<?=$row["no"]?>" >
                        </form>
                        <!-- <span><?= $row["no"] ?></span> -->
                        <span><?= $row["author"] ?></span>
                        <span><?= $row["time"] ?></span>
                    </div>
                    <div class="reply-content">
                        <?=$row["contents"] ?>
                    </div>
                </div>
<?php
                        }
                }
?>
            </div>
        </div>
<? endblock('content'); ?>