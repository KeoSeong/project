<?php

    
    class loadProblem {
        private $db;
        function __construct()
        {
            # You can change mysql username or password
            $this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function add($tweet) // This function inserts a tweet
        {
        	$this->db->exec("INSERT INTO tweets (contents, author,time) VALUES ('$tweet[1]', '$tweet[0]', now());");
            //Fill out here
        }
        public function feed_add($tweet) // This function inserts a tweet
        {
        	$this->db->exec("INSERT INTO tweets (contents, author,time) VALUES ('$tweet[1]', '$tweet[0]', now());");
            //Fill out here
        }
        public function delete($no) // This function deletes a tweet
        {
        	//$no = db->quote($no);
        	//db->query("DELETE FROM tweets WHERE no=$no");
        	
        	$this->db->exec("DELETE FROM tweets WHERE no='$no';");

            //Fill out here
        }
        # Ex 6: hash tag
        # Find has tag from the contents, add <a> tag using preg_replace() or preg_replace_callback()
        public function newproblem() // This function load all tweets
        {
        	$rows=$this->db->query("SELECT type, problem FROM problem WHERE conf=1 ORDER BY no DESC");
        	$tables = $rows->fetchAll();
        	$tables2 = array();
        	$i=0;
        	$count=0;
			for($i=0;$i < count($tables);$i++){
        		$tables2[$i]=$tables[$i];
        		$count++;
        		if($count >= 10)break;
			}
        	 
       		return $tables2;
        }
        
        public function hardproblem() // This function load all tweets
        {
        	$rows=$this->db->query("select type,problem,problem_no,count(result) from user_problem join  problem on no = problem_no where result=0 group by problem_no order by count(result) DESC");
        	
        	$tables = $rows->fetchAll();
        	$tables2 = array();
        	$i=0;
        	$count=0;
			for($i=0;$i < count($tables);$i++){
        		$tables2[$i]=$tables[$i];
        		$count++;
        		if($count >= 10)break;
			}
        	 
       		return $tables2;
        }
        
        public function myproblem() // This function load all tweets
        {
            require_once('base.php');
    		$userid = $_SESSION['user_id'];
        	$userid=$this->db->quote($userid);
        	$rows=$this->db->query("select problem,result from user_problem join problem on no=problem_no where id=$userid");
        	
        	$tables = $rows->fetchAll();
        	$tables2 = array();
        	$i=0;
        	$count=0;
			for($i=0;$i < count($tables);$i++){
        		$tables2[$i]=$tables[$i];
        		$count++;
        		if($count >= 10)break;
			}
        	 
       		return $tables2;
        }
       
    }
?>
