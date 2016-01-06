<?php
    require_once('base.php');
	$id = $_SESSION['user_id'];
	if (strcmp($id, "admin")) {
		echo "<script>alert('관리자만 접근할 수 있습니다.'); history.back();</script>";
	}
?>
<? startblock('head'); ?>
    <link rel="stylesheet" href="css/admin.css" type="text/css" />
    <script src="jslibs/prototype.js" type="text/javascript"></script>
    <script src="jslibs/scriptaculous.js" type="text/javascript"></script>
    <script src="js/admin.js" type="text/javascript"></script>
<? endblock('head'); ?>

<? startblock('content'); ?>
<? if (!strcmp($id, "admin")){ ?>
    <h1>User Information</h1>
    <div>
        <table id="tg" style="undefined;table-layout: fixed; width: 1300px">
            <tr>
                <th class="tg-baqh" colspan="7">User Information</th>
            </tr>
            <tr>
                <td class="tg-dzk6">회원정보삭제</td>
                <td class="tg-dzk6">ID</td>
                <td class="tg-dzk6">E-mail</td>
                <td class="tg-dzk6">Comment</td>
                <td class="tg-dzk6">School</td>
                <td class="tg-dzk6">Age</td>
                <td class="tg-dzk6">Name</td>
            </tr>
            <?php
                include ("db.php");
                $dataBase = new LoginDatabase();
                $users = $dataBase->user_info();
                $i = 0;
                $num = 0;
                foreach ($users as $user) {
            ?>
            <tr id="<?= "tablerow".++$num ?>">
                <td class="tg-yw4l"><img src="img/paper.png" alt="<?= ++$i ?>" /></td>
                <td class="tg-yw4l"><?= $user[0] ?></td>
                <td class="tg-lqy6"><?= $user[1] ?></td>
                <td class="tg-lqy6"><?= $user[2] ?></td>
                <td class="tg-lqy6"><?= $user[3] ?></td>
                <td class="tg-lqy6"><?= $user[4] ?></td>
                <td class="tg-yw4l"><?= $user[5] ?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>

    <h2>Remove :</h2>
    <div id="trashcan">
        <img src="img/trashcan.png" />
    </div>

    <h1>Feedback</h1>
    <div>
        <ul id="ul">
            <?php
                $feeds = $dataBase->get_feedback();
                foreach ($feeds as $feed) {
            ?>
            <li>ID : <?= $feed[0] ?> | 건의사항 : <?= $feed[1] ?></li> <br />
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<? endblock('content'); ?>
