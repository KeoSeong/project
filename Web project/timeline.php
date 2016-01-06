<?php
    class TimeLine {
        private $db;
        function __construct()
        {
            $this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function addReply($tweet,$reply) // This function inserts a tweet
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
                $co=$this->db->quote($co);
                $statement=$this->db->prepare("UPDATE tweets SET reply = $co where no = $co");        
                $statement->execute();
            }
        }
        public function delete($no)
        {
            $no=$this->db->quote($no);
            $statement=$this->db->prepare("DELETE FROM tweets where no = $no");        
            $statement->execute();
        }
       
        public function loadTweets()
        {   
            $rows = $this->db->query("SELECT * FROM tweets WHERE no = reply ORDER BY time desc ;");
            $tables = $rows->fetchall();
            $i=0;
            foreach ($tables as $row){
                $init = $tables[$i]["contents"];
                $init = preg_replace("/#([_]*[a-zA-Z0-9]+[\w]*)/", "<a href='contents.php?type=Contents&query=%23$1'>#$1</a>", $init);     
                $tables[$i]["contents"] = $init;         
                $time = preg_replace("/-/", "/", $tables[$i]["time"]);     
                $tables[$i]["time"]=substr($time,10).' '.substr($time,0,10);
                $i=$i+1;
            }
            return $tables;
        }
        public function searchTweets($type, $query)
        {  
            if (!strcmp($type,"Author")){
                $query="%".$query."%";
                $query=$this->db->quote($query);
                $rows=$this->db->query("SELECT * from tweets where no = reply and author like $query ORDER BY time desc;");
            }
            else if(!strcmp($type,"Contents")){
                $query="%".$query."%";
                $query=$this->db->quote($query);
                $rows=$this->db->query("SELECT * from tweets where no = reply and contents like $query ORDER BY time desc;");
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
        public function getNumberOfReply($no)
        {
            $query=$this->db->quote($no);
            $rows=$this->db->query("SELECT count($no) numberReply from tweets where reply = $no;");
            $tables = $rows->fetchall();
            $numberReply = $tables[0]["numberReply"];
            return ($numberReply-1);
        }
    }
?>