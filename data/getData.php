<?php 
	include('../dbfile.php');
	
	$datarun = new dataProduct();
	$datarun->getProduct();	

	class dataProduct 
	{
		public function __construct()
		{
			$conn = new DatabaseConnection();
			$this->conn=$conn->dataconnection();		
		}
		public function getProduct() 
		{	
			
			$conn = $this->conn;
			
			$sql = "SELECT * FROM product";

			$query=mysqli_query($conn,$sql);
			//-- Runs only if output rows are more than 0 --//
			if($query->num_rows>0){


				while($row = $query ->fetch_assoc())
					{	

						$some_array['product'][] = $row;					
					}

			}else{
				echo "Error: Product cannot be found. <br>";
			}			

						header('Content-Type: application/json');
						echo json_encode($some_array);
		} 
		
		
	}



