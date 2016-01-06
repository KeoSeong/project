<?php
  	include_once('base.php');
  	startblock('head'); ?>
	<link rel="stylesheet" type="text/css" href="css/ranking.css" />
<? endblock('head'); ?>
<? startblock('content'); ?>
	<div id = "entire">
 		<aside>
	 		<a href="ranking.php?case=1"><div>전체 랭킹 (맞은 갯수)</div></a>
	 		<a href="ranking.php?case=2"><div>유형별 랭킹 (맞은 갯수)</div></a>
	 		<a href="ranking.php?case=3"><div>전체 랭킹 (정답률)</div></a>
	 		<a href="ranking.php?case=4"><div>유형별 랭킹 (정답률)</div></a>
 		</aside>
 		<article>
 			<?php
	 			include("problemdata.php");
				$database = new Problem();
			?>
			<?php
 			if($_GET["case"] == '1') { ?>
 				<h1>전체 랭킹 (맞은 갯수)</h1>
				<?php
					$ranking = $database->GetAllRanking();
					$i = 1;
					foreach($ranking as $rank) { ?>
						<div class="rank">
							<div class="rank_no"><?= $i ?></div>
							<div class="rank_id"><?= $rank["id"]?></div>
							<div class="rank_name"><?= $rank["name"]?></div>
							<div class="rank_comment"><?= $rank["comment"]?></div>
							<div class="count"><p>맞은갯수</p><p><?= $rank["count(result)"]?></p></div>
						</div>
				<?php 	$i++;
					}
			}else if($_GET["case"] == '2' || isset($_GET["type"])) { ?>
		        <h1>유형별 랭킹 (맞은 갯수)</h1>
		        <form action="ranking.php?case=2" method="get">
		        	<select class='select' name='type'>
		        		<option>All</option>
			        	<?php 
			        	$types = $database->getType();
			        	foreach($types as $type) {
			        		?><option><?= $type["type"]?></option>
			        	<?php
			        	}?>
			        </select>
			        <input class="checkanswerbutton" type="submit" value="선택">
			    </form>
		    	<?php 
		    	if($_GET["type"] == "All") {
					$ranking = $database->GetAllRanking();
					$i = 1;
					foreach($ranking as $rank) { ?>
						<div class="rank">
							<div class="rank_no"><?= $i ?></div>
							<div class="rank_id"><?= $rank["id"]?></div>
							<div class="rank_name"><?= $rank["name"]?></div>
							<div class="rank_comment"><?= $rank["comment"]?></div>
							<div class="count"><p>맞은갯수</p><p><?= $rank["count(result)"]?></p></div>
						</div>
				<?php 	$i++;
					}
		    	}else if(isset($_GET["type"])) {
		    		$ranking = $database->GetTypeRanking($_GET["type"]);
					$i = 1;
					foreach($ranking as $rank) { ?>
						<div class="rank">
							<div class="rank_no"><?= $i ?></div>
							<div class="rank_id"><?= $rank["id"]?></div>
							<div class="rank_name"><?= $rank["name"]?></div>
							<div class="rank_comment"><?= $rank["comment"]?></div>
							<div class="count"><p>맞은갯수</p><p><?= $rank["count(result)"]?></p></div>
						</div>
				<?php 	$i++;
					}
		    	}else{
		    		?> 유형을 선택하십시오.<?php
		    	}
			}else if($_GET["case"] == '3') { ?>
 				<h1>전체 랭킹 (정답률)</h1>
 				<?php
					$ranking = $database->GetAllRanking();
					$count = 0;
					$members = array();
					foreach($ranking as $rank) {
						$total = $database->GetAllusercount($rank["id"]);
						$member = array();
						$member[0] = $rank["id"];
						$member[1] = $rank["name"];
						$member[2] = $rank["comment"];
						$member[3] = floor($rank["count(result)"] / $total * 100);
						$members[$count] = $member;
						$count++;
					}
					$count = 1;
					for($i = 100; $i >= 0; $i--) {
						for($j = 0; $j < count($members); $j++) {
							if($i == $members[$j][3]) { ?>
								<div class="rank">
									<div class="rank_no"><?= $count ?></div>
									<div class="rank_id"><?= $members[$j][0]?></div>
									<div class="rank_name"><?= $members[$j][1]?></div>
									<div class="rank_comment"><?= $members[$j][2]?></div>
									<div class="count"><p>정답률</p><p><?= $members[$j][3] ?>%</p></div>
								</div>
							<?php $count++ ;}
						}
					}
			}else if($_GET["case"] == '4' || isset($_GET["types"])) { ?>
		        <h1>유형별 랭킹 (정답률)</h1>
		        <form action="ranking.php?case=4" method="get">
		        	<select class='select' name='types'>
		        		<option>All</option>
			        	<?php 
			        	$types = $database->getType();
			        	foreach($types as $type) {
			        		?><option><?= $type["type"]?></option>
			        	<?php
			        	}?>
			        </select>
			        <input class="checkanswerbutton" type="submit" value="선택">
			    </form>
		    	<?php 
		    	if($_GET["types"] == "All") {
					$ranking = $database->GetAllRanking();
					$count = 0;
					$members = array();
					foreach($ranking as $rank) {
						$total = $database->GetAllusercount($rank["id"]);
						$member = array();
						$member[0] = $rank["id"];
						$member[1] = $rank["name"];
						$member[2] = $rank["comment"];
						$member[3] = floor($rank["count(result)"] / $total * 100);
						$members[$count] = $member;
						$count++;
					}
					$count = 1;
					for($i = 100; $i >= 0; $i--) {
						for($j = 0; $j < count($members); $j++) {
							if($i == $members[$j][3]) { ?>
								<div class="rank">
									<div class="rank_no"><?= $count ?></div>
									<div class="rank_id"><?= $members[$j][0]?></div>
									<div class="rank_name"><?= $members[$j][1]?></div>
									<div class="rank_comment"><?= $members[$j][2]?></div>
									<div class="count"><p>정답률</p><p><?= $members[$j][3] ?>%</p></div>
								</div>
							<?php $count++ ;}
						}
					}
		    	}else if(isset($_GET["types"])) {
					$ranking = $database->GetTypeRanking($_GET["types"]);
					$count = 0;
					$members = array();
					foreach($ranking as $rank) {
						$total = $database->GetTypeusercount($rank["id"], $_GET["types"]);
						$member = array();
						$member[0] = $rank["id"];
						$member[1] = $rank["name"];
						$member[2] = $rank["comment"];
						$member[3] = floor($rank["count(result)"] / $total * 100);
						$members[$count] = $member;
						$count++;
					}
					$count = 1;
					for($i = 100; $i >= 0; $i--) {
						for($j = 0; $j < count($members); $j++) {
							if($i == $members[$j][3]) { ?>
								<div class="rank">
									<div class="rank_no"><?= $count ?></div>
									<div class="rank_id"><?= $members[$j][0]?></div>
									<div class="rank_name"><?= $members[$j][1]?></div>
									<div class="rank_comment"><?= $members[$j][2]?></div>
									<div class="count"><p>정답률</p><p><?= $members[$j][3] ?>%</p></div>
								</div>
							<?php $count++ ;}
						}
					}
		    	}else{
		    		?> 유형을 선택하십시오.<?php
		    	}
			}
			?>
 		</article>
 	</div>
<? endblock('content'); ?>