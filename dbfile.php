<?php 


	Class DatabaseConnection
	{
	
		private $host ='localhost';
		private $user ='root';
		private $pwd ='';
		private $db ='shopcart';
		private $conn ='null';
			
		public function __construct(){
			
			$conn = new mysqli($this->host,$this->user,$this->pwd,$this->db);
			$this->conn =$conn;
			
			if ($conn->connect_error) {
    			die("Connection failed: " . $conn->connect_error);
			} 
		
		}
			public function dataconnection()
			{
				return $this->conn;
			}
	}
	

?>
