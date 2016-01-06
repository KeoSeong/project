<?php
	class LoginDatabase{
		private $db;
		function __construct()
        {
            $this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

		public function login($id, $pass)
		{
	        $isset_id = FALSE;
		    $resultset = $this->db->query("SELECT id, password FROM user WHERE id = '".$id."' and password = '".$pass."'");
		    foreach ($resultset as $row) {
		    	if($id == $row['id'] && $pass == $row['password']){
		    		$isset_id = TRUE;
		    	}
		    }
		    return $isset_id;
		}

		public function join($user_id, $user_pw, $user_comment, $user_school, $user_age, $user_name, $user_email){
			$user_id = $this->db->quote($user_id);
			$user_pw = $this->db->quote($user_pw);
			$user_comment = $this->db->quote($user_comment);
			$user_school = $this->db->quote($user_school);
			$user_name = $this->db->quote($user_name);
			$user_email = $this->db->quote($user_email);
			$this->db->exec("INSERT INTO user(id, password, comment, school, age, name, email) VALUES($user_id, $user_pw, $user_comment, $user_school, $user_age, $user_name, $user_email)");
		}

		public function find($user_email){
			$findset = $this->db->query("SELECT id, password FROM user WHERE email = '".$user_email."'");
			$temp = $findset->fetchAll();
			return $temp;
		}

		public function user_info(){
			$findset = $this->db->query("SELECT id, email, comment, school, age, name FROM user");
			$temp = $findset->fetchAll();
			return $temp;
		}

		public function remove_user($user_id){
			$user_id = $this->db->quote($user_id);
			$this->db->exec("DELETE FROM user WHERE id = $user_id");
		}

		public function get_feedback(){
			$findset = $this->db->query("SELECT id, feed FROM feedback");
			$temp = $findset->fetchAll();
			return $temp;
		}
	}
?>