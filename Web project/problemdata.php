<?php
	//problem 데이터베이스에서 problem테이블을 사용하는 함수.
	class Problem {
        private $db;
        function __construct() {
            # You can change mysql username or password
            $this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
		public function GetAllProblem() { //검증이 된 모든 문제 풀러오는 함수.
			$sql = "select * from problem where conf = 1";
			return $this->db->query($sql);
		}
		public function GetAllnotconfProblem() { //검증이 된 모든 문제 풀러오는 함수.
			$sql = "select * from problem where conf = 0";
			return $this->db->query($sql);
		}
		public function AllRandomProblem() { //전체 검증된 문제중 랜덤으로 문제출력해주는 함수.
			$sql = "select * from problem where conf = 1";
			$rows = $this->db->query($sql);
			$rows = $rows->fetchAll();
			$no = rand(0, count($rows)-1);
			return $rows[$no];
		}
		public function insertProblem($type, $problem, $answer) { //문제를 추가해주는 함수.
			$sql = "insert into problem(type, problem, answer, conf) values('".$type."','".$problem."','".$answer."', 0)";
			$this->db->exec($sql);
		}
		public function checkAnswer($no, $answer) { //답을 체크해주는 함수.
			$sql = "select * from problem where no =".$no;
			$rows = $this->db->query($sql);
			$result = "";
			foreach($rows as $row) $result = $row['answer'];
			if($result == $answer) $result = 'good';
			else $result = 'bad';
			return $result;
		}
		public function TypeRandomProblem($type) { //일정 타입에서 랜덤으로 문제를 출력해주는 함수.
			$sql = "select * from problem where type ='".$type."' and conf = 1";
			$rows = $this->db->query($sql);
			$rows = $rows->fetchAll();
			$no = rand(0, count($rows) - 1);
			return $rows[$no];
		}
		public function roadProblem($no) {  //일정 번호의 문제를 출력해주는 함수.
			$sql = "select * from problem where no =".$no;
			$rows = $this->db->query($sql);
			$rows = $rows->fetchAll();
			return $rows[0];
		}
		public function getType() { //데이터베이스에서 전체 타입을 불러오는 함수.
			$sql = "select distinct type from problem where conf = 1";
			$rows = $this->db->query($sql);
			return $rows;
		}
		public function insertAnswer($id, $problem_no, $user_ans, $result) { // 정답이나 오답을 저장.
			$sql = "insert into user_problem values('".$id."',".$problem_no.",'".$user_ans."',".$result.")";
			$this->db->exec($sql);
		}
		public function confProblem($no) {
			$sql = "update problem set conf = 1 where no = ".$no;
			$this->db->exec($sql);			
		}
		public function checkRepeatSolve($id, $problem_no) {
			$count = 0;
			$sql = "select * from user_problem where id = '".$id."'";
			$rows = $this->db->query($sql);
			foreach($rows as $row) {
				if($row['problem_no'] == $problem_no) $count++;
			}
			return $count;
		}
		public function GetAllusercount($id) {
			$count = 0;
			$sql = "select * from user_problem up join user u on u.id = up.id where u.id ='".$id."'";
			$rows = $this->db->query($sql);
			foreach($rows as $row) {
				$count++;
			}
			return $count;
		}
		public function GetTypeusercount($id, $type) {
			$count = 0;
			$sql = "select * from user_problem up join user u on u.id = up.id join problem p on p.no = up.problem_no where u.id ='".$id."'and p.type = '".$type."'";
			$rows = $this->db->query($sql);
			foreach($rows as $row) {
				$count++;
			}
			return $count;
		}
		public function GetAllRanking() {
			$sql = "select u.id, u.name, u.comment, count(result) from user_problem up join user u on u.id = up.id where result=1 group by u.id order by count(result) DESC";
			$rows = $this->db->query($sql);
			return $rows;
		}
		public function GetTypeRanking($type) {
			$sql = "select u.id, u.name, u.comment, count(result) from user_problem up join user u on u.id = up.id join problem p on p.no = up.problem_no where p.type ='".$type."' and result=1 group by u.id order by count(result) DESC";
			$rows = $this->db->query($sql);
			return $rows;
		}
	}
?>