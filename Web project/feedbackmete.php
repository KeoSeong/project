<?php
    class Feedback {
        private $db;
        function __construct()
        {
            $this->db = new PDO("mysql:host=localhost;dbname=project", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function addFeedback($id,$content) // This function inserts a tweet
        {		
        	$id = $this->db->quote($id);
                $content = $this->db->quote($content);
                $statement=$this->db->prepare("INSERT INTO feedback (id,feed) VALUES ($id, $content);");       
                $statement->execute();
        }
    }
?>
