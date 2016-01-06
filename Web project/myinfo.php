<?php 
    require_once("base.php");
?>

<? startblock('head'); ?>
    <link rel="stylesheet" type="text/css" href="css/myinfo.css" />
<? endblock('head'); ?>

<?php
	class myInfo {
		private $db;
		function __construct() {
			$this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		function getInfo($id) {
			$id = $this->db->quote($id);
			$table = $this->db->query("SELECT * FROM user WHERE id =".$id);
			$table = $table->fetchAll();
			return $table[0];
		}
		function setInfo($id, $password, $comment, $school, $age, $name) {
			$id = $this->db->quote($id);
			if (trim($password) != "") {
				$password = $this->db->quote($password);
				$this->db->exec("UPDATE user SET password=$password WHERE id=$id");
			}
			if (trim($comment) != "") {
				$comment = $this->db->quote($comment);
				$this->db->exec("UPDATE user SET comment=$comment WHERE id=$id");
			}
			if (trim($school) != "") {
				$school = $this->db->quote($school);
				$this->db->exec("UPDATE user SET school=$school WHERE id=$id");
			}
			if (trim($age) != "") {
				$this->db->exec("UPDATE user SET age=$age WHERE id=$id");
			}
			if (trim($name) != "") {
				$name = $this->db->quote($name);
				$this->db->exec("UPDATE user SET name=$name WHERE id=$id");
			}
		}
		function getSolvedProblem($id) {
			$id = $this->db->quote($id);
			$table = $this->db->query("SELECT * FROM user NATURAL JOIN user_problem JOIN problem ON problem_no=no WHERE id=$id");
			return $table;
		}
	}
	$class = new myInfo();
	$info = $class->getInfo($_SESSION["user_id"]);
?>

<article>
	<div>
		<div>
			<!-- 아이디 (이름) -->
 			<h1><?= $info["id"] ?> (<?= $info["name"] ?>)</h1>
			<!-- 한마디 -->
			<p><?= $info["comment"] ?></p>
		</div>
		<div>
		<?php
			if ($_POST["mode"] == "complete") {
				$class->setInfo($info["id"], $_POST["m_password"], $_POST["m_comment"], $_POST["m_school"], $_POST["m_age"], $_POST["m_name"]);
				?><?="<script>alert('정보수정이 완료되었습니다.'); location.replace(\"myinfo.php\")</script>";?><?php
			}
			else if ($_POST["mode"] == "check") { ?>
				<h3>비밀번호 확인</h3>
				<div>
					<div>
						<form action="myinfo.php" method="POST">
							<input type="hidden" name="mode" value="modify">
							<div>확인을 위하여 비밀번호를 다시 한 번 입력하여 주세요.</div>
							<div>비밀번호 : <input type="text" placeholder="비밀번호를 입력하세요." name="check"> <input type="submit" value="확인"></div>
						</form>
					</div>
				</div>
			<?php	}
			else if ($_POST["mode"] == "modify" && $_POST["check"] != $info["password"]) {
				?><?="<script>alert('잘못 입력하셨습니다.'); location.replace(\"myinfo.php\")</script>";?><?php
			}
			else if ($_POST["mode"] == "modify" && $_POST["check"] == $info["password"]) { ?>
				<h3>정보 수정</h3>
				<div>	
					<div>
						<form action="myinfo.php" method="POST">
							<input type="hidden" name="mode" value="complete">
							<div>ID : <?= $info["id"] ?></div><br>
							<div>이름 : <input type="text" placeholder="이름을 입력하세요." value="<?= $info["name"] ?>" name="m_name"></div><br>
							<div>학교 : <input type="text" placeholder="학교를 입력하세요." value="<?= $info["school"] ?>" name="m_school"></div><br>
							<div>나이 : <input type="text" placeholder="나이를 입력하세요." value="<?= $info["age"] ?>" name="m_age"></div><br>
							<div>한마디 : <input type="text" placeholder="한마디를 입력하세요." value="<?= $info["comment"] ?>" name="m_comment"></div><br>
							<div>새 비밀번호 : <input type="text" name="m_password"></div><br>
							<div><input type="submit" value="정보수정완료"></div>
						</form>
					</div>
				</div>
			<?php } else { ?>
				<h3>내 정보</h3>
				<div>
					<div>
						<form action="myinfo.php" method="POST">
							<input type="hidden" name="mode" value="check">
							<div>ID : <?= $info["id"] ?></div><br>
							<div>이름 : <?= $info["name"] ?></div><br>
							<div>학교 : <?= $info["school"] ?></div><br>
							<div>나이 : <?= $info["age"] ?></div><br>
							<div><input type="submit" value="회원정보수정"></div>
						</form>
					</div>
				</div>
			<?php } ?>
		</div>
		<div>
			<h3>내가 풀었던 문제</h3>
			<div>
				<?php
					$solves = $class->getSolvedProblem($info["id"]);
					foreach ($solves as $prob) { 
						if ($prob["result"] == 1) {
							?><a href="problem.php?no=<?= $prob["problem_no"] ?>" id=correct><?= $prob["problem_no"] ?>(<?= $prob["type"] ?>)</a> <?php
						}
						else {
							?><a href="problem.php?no=<?= $prob["problem_no"] ?>" id=incorrect><?= $prob["problem_no"] ?>(<?= $prob["type"] ?>)</a> <?php
						}
					}
				?>
			</div>
		</div>
		<div>
			<h3>유형별 정답률</h3>
			<div id="graph">
				<div>
					<?php
						$total = array();
						$correct = array();
						$check = 0;
						$solves = $class->getSolvedProblem($info["id"]);
						foreach ($solves as $prob) {
							foreach($total as $key=>$value) {
								if ($key == $prob["type"]) {
									$check = 1;
								}
							}
							if ($check == 1) {
								$total[$prob["type"]]++;
								$check = 0;
							}
							else {
								$total[$prob["type"]] = 1;
								$correct[$prob["type"]] = 0;
							}
							if ($prob["result"] == 1) {
								$correct[$prob["type"]]++;
							}
						}
						$graph_array = array();
						foreach($total as $key=>$value) {
							$graph_array[$key] = $correct[$key]/$total[$key]*100;
						}
						foreach ($graph_array as $key=>$value) {
							$cpy = $value; ?> 
							<div><?= $key ?></div>
							<div>
								<div>  
									<?php 
										while ($value > 0) { ?> 
											<div></div> 
											<?php
												$value--;
										} ?> 
								</div>
								<div><?= (int)$cpy ?>%</div>
							</div><br>
							<?php
						} ?>
				</div>
			</div>
		</div>
	</div>
</article>