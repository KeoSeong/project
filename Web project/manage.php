<?php
    class Manage {
        private $db;
        function __construct()
        {
            $this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function loadUser()
        {   
            $rows = $this->db->query("SELECT * FROM user;");
            $tables = $rows->fetchall();
            return $tables;
        }

        public function addReply($tweet,$reply)
        {
            $tweet[0] = $this->db->quote($tweet[0]);
            $tweet[1] = $this->db->quote($tweet[1]);
            if(isset($reply)){
                $reply = $this->db->quote($reply);
                $statement=$this->db->prepare("INSERT INTO tweets (author, contents, time, reply) VALUES ($tweet[0], $tweet[1],now(), $reply);");
                $statement->execute();
            }
            else if(!isset($reply)){
                $statement=$this->db->prepare("INSERT INTO tweets (author, contents, time, reply) VALUES ($tweet[0], $tweet[1],now(), '0');");
                $statement->execute();
                $rows=$this->db->query("SELECT "."MAX(no) NUM"." FROM tweets");
                $tables = $rows->fetchall();
                $co = $tables[0]["NUM"];
                $co = $this->db->quote($co);
                $statement=$this->db->prepare("UPDATE tweets SET reply = $co where no = $co");        
                $statement->execute();
            }
        }

        public function deleteUser($author)
        {
            $author = $this->db->quote($author);
            $statement1=$this->db->prepare("DELETE FROM tweets where author = $author");        
            $statement1->execute();
            $statement2=$this->db->prepare("DELETE FROM use_problem where id = $author");        
            $statement2->execute();
            $statement3=$this->db->prepare("DELETE FROM user where id = $author");        
            $statement3->execute();
        }

        public function deleteProblem($problem_no)
        {
            $author = $this->db->quote($problem_no);
            $statement1=$this->db->prepare("DELETE FROM use_problem where problem_no = $problem_no");        
            $statement1->execute();
            $statement2=$this->db->prepare("DELETE FROM problem where no = $problem_no");        
            $statement2->execute();
        }
        public function loadProblem()
        {   
            $rows = $this->db->query("SELECT * FROM problem;");
            $tables = $rows->fetchall();
            $i=0;
            foreach ($tables as $row){
                $init = $tables[$i]["contents"];
                $init = preg_replace("/#([_]*[a-zA-Z0-9]+[\w]*)/", "<a href='contents.php?type=Contents&query=%23$1'>#$1</a>", $init);     
                $tables[$i]["contents"] = $init;         
                $time = preg_replace("/-/", "/", $tables[$i]["time"]);     
                $tables[$i]["time"]=substr($time,10).' '.substr($time,0,10);
                $i=$i+1;;
            }
            return $tables;
        }
        public function searchTweets($type, $query)
        {  
            if (!strcmp($type,"Author")){
                $query="%".$query."%";
                $query=$this->db->quote($query);
                $rows=$this->db->query("SELECT * from tweets where author like $query ORDER BY time desc;");
            }
            else if(!strcmp($type,"Contents")){
                $query="%".$query."%";
                $query=$this->db->quote($query);
                $rows=$this->db->query("SELECT * from tweets where contents like $query ORDER BY time desc;");
            }
            $tables = $rows->fetchall();
            $i=0;
            foreach ($tables as $row){
                $init = $tables[$i]["contents"];
                $init = preg_replace("/#([_]*[a-zA-Z0-9]+[\w]*)/", "<a href='contents.php?type=Contents&query=%23$1'>#$1</a>", $init);     
                $tables[$i]["contents"] = $init; 
                $time = preg_replace("/-/", "/", $tables[$i]["time"]);     
                $tables[$i]["time"]=substr($time,10).' '.substr($time,0,10);        
                $i=$i+1;;
            }
            return $tables;
        }
        public function searchReply($reply)
        {  
            $query=$this->db->quote($reply);
            $rows=$this->db->query("SELECT * from tweets where reply = $reply;");
            $tables = $rows->fetchall();
            $i=0;
            foreach ($tables as $row){
                $init = $tables[$i]["contents"];
                $init = preg_replace("/#([_]*[a-zA-Z0-9]+[\w]*)/", "<a href='contents.php?type=Contents&query=%23$1'>#$1</a>", $init);     
                $tables[$i]["contents"] = $init; 
                $time = preg_replace("/-/", "/", $tables[$i]["time"]);     
                $tables[$i]["time"]=substr($time,10).' '.substr($time,0,10);        
                $i=$i+1;;
            }
            return $tables;
        }
    }
?>
