<?php 
	include('../dbfile.php');
	$datarun = new dataUser();
	$datarun->getUser();	

	class dataUser 
	{
		public function __construct()
		{
			$conn = new DatabaseConnection();
			$this->conn=$conn->dataconnection();		
		}
		public function getUser() 
		{	
			
			$conn = $this->conn;									
			$sql = "SELECT name,id FROM customer";
			$query=mysqli_query($conn,$sql);

			if($query->num_rows>0){

				while($row = $query ->fetch_assoc())
					{	

						$some_array['customer'][] = $row;					
					}

			}else{
				echo "Error: User cannot be found. <br>";
			}			

						header('Content-Type: application/json');
						echo json_encode($some_array);
		} 
		
		
	}



?>