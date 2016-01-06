<?php
  	include_once('base.php');
  	startblock('head'); ?>
	<link rel="stylesheet" type="text/css" href="css/problem.css" />
<? endblock('head'); ?>
<? startblock('content'); ?>
	<div id = "entire">
 		<aside>
	 		<a href="problem.php?case=1"><div>랜덤 문제 풀기</div></a>
	 		<a href="problem.php?case=2"><div>유형별 랜덤 문제 풀기</div></a>
	        <a href="problem.php?case=3"><div>전체 문제 중 선택하기</div></a>
	        <a href="problem.php?case=4"><div>문제 추가</div></a>
	        <a href="problem.php?case=5"><div>문제 심사</div></a>
 		</aside>
 		<article>
 			<?php
	 			include("problemdata.php");
				$database = new Problem();
			?>
			<?php
 			if($_GET["case"] == '1') { ?>
 				<h1>랜덤 문제 풀기</h1>
			<?php 
				$problem = $database->AllRandomProblem();
			?>
					<p class="solve"><strong><?= $problem["no"] * 1 ?>.  </strong><?= $problem["type"] ?>
					<p class="solveproblem"><?= $problem["problem"] ?></p></p>
					<form action="check_answer.php" method="post">
						<p class="solve"><input class="solvetext" type="text" name='answer' placeholder="답안"></p>
						<?php
							if(!isset($_SESSION['user_id'])) {
								?><input type="hidden" name="user_id" value=null><?php
							}else{
								?><input type="hidden" name="user_id" value=<?=$_SESSION['user_id']?>><?php
							}
						?>
						<input type="hidden" name="problem_no" value=<?=$problem["no"]?>>
						<input type="hidden" name="case" value='1'>
		           		<input class="checkanswerbutton" type="submit" value="정답확인">
		           	</form>
		    <?php
			}else if($_GET["case"] == '2' || isset($_GET["type"])) { ?>
		        <h1>유형별 랜덤 문제 풀기</h1>
		        <form action="problem.php?case=2" method="get">
		        	<select class='select' name='type'>
		        		<option>All</option>
			        	<?php 
			        	$types = $database->getType();
			        	foreach($types as $type) {
			        		?><option><?= $type["type"]?></option>
			        	<?php
			        	}?>
			        </select>
			        <input class="checkanswerbutton2" type="submit" value="선택">
			    </form>
		    	<?php 
		    	if($_GET["type"] == "All") {
		    		$Tproblem = $database->AllRandomProblem();
				?>
					<p class="solve"><strong><?= $Tproblem["no"] * 1 ?>.  </strong><?= $Tproblem["type"] ?>
					<p class="solveproblem"><?= $Tproblem["problem"] ?></p></p>
					<form action="check_answer.php" method="post">
						<p class="solve"><input class="solvetext" type="text" name='answer' placeholder="답안"></p>
						<?php
							if(!isset($_SESSION['user_id'])) {
								?><input type="hidden" name="user_id" value=null><?php
							}else{
								?><input type="hidden" name="user_id" value=<?=$_SESSION['user_id']?>><?php
							}
						?>
						<input type="hidden" name="problem_no" value=<?=$Tproblem["no"]?>>
						<input type="hidden" name="case" value='2'>
	           			<input class="checkanswerbutton" type="submit" value="정답확인">
	           		</form>
	           		<form action="problem.php">
	           			<input type="hidden" name="case" value='2'>
			           	<input class="checkanswerbutton" type="submit" value='뒤로'>
	           		</form>
	           	<?php
		    	}
				else if(isset($_GET["type"])) {
		    		$Tproblem = $database->TypeRandomProblem($_GET["type"]);
				?>
					<p class="solve"><strong><?= $Tproblem["no"] * 1 ?>.  </strong><?= $Tproblem["type"] ?>
					<p class="solveproblem"><?= $Tproblem["problem"] ?></p></p>
					<form action="check_answer.php" method="post">
						<p class="solve"><input class="solvetext" type="text" name='answer' placeholder="답안"></p>
						<input type="hidden" name="problem_no" value=<?=$Tproblem["no"]?>>
						<?php
							if(!isset($_SESSION['user_id'])) {
								?><input type="hidden" name="user_id" value=null><?php
							}else{
								?><input type="hidden" name="user_id" value=<?=$_SESSION['user_id']?>><?php
							}
						?>
						<input type="hidden" name="case" value='2'>
	           			<input class="checkanswerbutton" type="submit" value="정답확인">
	           		</form>
	           		<form action="problem.php">
	           			<input type="hidden" name="case" value='2'>
			           	<input class="checkanswerbutton" type="submit" value='뒤로'>
	           		</form>
	           	<?php
		    	}else{
		    		?><p class="center">유형을 선택하십시오.</p><?php
		    	}
			}else if($_GET["case"] == '3' || isset($_GET["no"])) { ?>
				<h1>전체 문제 중 선택하기</h1>
			    	<?php 
		    		if(isset($_GET["no"])) {
		    			$Nproblem = $database->roadProblem($_GET["no"] * 1);
					?>
		    			<p class="solve"><strong><?= $Nproblem["no"] * 1 ?>.  </strong><?= $Nproblem["type"] ?>
						<p class="solveproblem"><?= $Nproblem["problem"] ?></p></p>
						<form action="check_answer.php" method="post">
							<p class="solve"><input class="solvetext" type="text" name='answer' placeholder="답안"></p>
							<input type="hidden" name="case" value='3'>
							<?php
								if(!isset($_SESSION['user_id'])) {
									?><input type="hidden" name="user_id" value=null><?php
								}else{
									?><input type="hidden" name="user_id" value=<?=$_SESSION['user_id']?>><?php
								}
							?>
							<input type="hidden" name="problem_no" value=<?=$Nproblem["no"]?>>
		           			<input class="checkanswerbutton" type="submit" value="정답확인">
			           	</form>
			           	<form action="problem.php">
			           		<input type="hidden" name="case" value='3'>
			           		<input class="checkanswerbutton" type="submit" value='뒤로'>
			           	</form>
			        <?php
				    }else{
						$problems = $database->GetAllProblem();
						foreach($problems as $problem) {?>
							<a class="allproblemlist" href="problem.php?no=<?= $problem["no"]?>">
								<div>
									<div class="problemno"><?= $problem["no"]?></div>
									<div class="problemtype"><?= $problem["type"]?></div>
									<div class="problem"><?= $problem["problem"] ?></div>
								</div>
							</a>
						<?php
					}
					?></br><?php
				}
			}else if($_GET["case"] == '4') { ?>
				<h1>문제 추가</h1>
				<form action="add_problem.php" method="post">
					<p class="solve"><strong>0. </strong><input class="solvetext" type="text" name='type' placeholder="유형"></br>
					<textarea class="solvetextarea" name='problem' placeholder="문제"></textarea></br>
					<input class="solvetext" type="text" name='answer' placeholder="답안"></br></p>
			        <input class="checkanswerbutton" type="submit" value="추가">
			    </form>
			<?php
			}else if($_GET["case"] == '5') { 
				if($_SESSION['user_id'] == "admin") {
					?><h1>문제 심사</h1><?php
					$problems = $database->GetAllnotconfProblem();
					foreach($problems as $problem) {?>
						<a class="allproblemlist">
							<div>
								<div class="problemno"><?= $problem["no"]?></div>
								<div class="problemtype"><?= $problem["type"]?></div>
								<div class="problem"><?= $problem["problem"] ?></div>
								<form action="conf_problem.php" method="post">
									<input type="hidden" name="problem_no" value=<?=$problem["no"]?>>
								 	<input class="confbutton" type="submit" value="추가">
								</form>
							</div>
						</a>
					<?php }
				}else{
					?><script> alert("운영자만 이용가능합니다.");location.replace("problem.php")</script><?php
				}
			}
			?>
	    </article>
	</div>
<? endblock('content'); ?>