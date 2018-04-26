<?php 
	include('../dbfile.php');


	class dataProduct 
	{
		public function __construct()
		{
			$conn = new DatabaseConnection();
			$this->conn=$conn->dataconnection();		
		}
		// Main function that gets the order item ID based of customer ID input//
		public function getCustomerOrderID($data1,$limit){
			
			$conn = $this->conn;
			$resultdata =$data1;
	
			if ($limit ==='all')
			{

			$sql="SELECT a.id as orderID
			FROM 
				orderitem a
					inner join 
				transaction b 
					on a.id = b.orderuserid
				WHERE customerID = ?
				GROUP BY b.id
				ORDER BY a.id DESC";

			}else{

			$sql="SELECT a.id as orderID
			FROM 
				orderitem a
					inner join 
				transaction b 
					on a.id = b.orderuserid
				WHERE customerID = ?
				GROUP BY b.id
				ORDER BY a.id DESC
				LIMIT $limit";	

			}
			
			if($stmt = $conn->prepare($sql))
			{
			
			$stmt->bind_param("i",$resultdata);
			$stmt->execute();	
			$result = $stmt->get_result(); 
			$num_of_rows = $result->num_rows;


			while ($row = $result->fetch_assoc())
			{		

    			 $some_array[] = $row;
    	
			}	
			
			}
			else 
			{
				echo ('failed');
			}

			if($num_of_rows > 1){
			$max  = count($some_array);
			$resdata = array();
			$max = $max-1;
			
				for($x = 0; $x <=$max; $x++){

					$resdata['orderID'][] = $some_array[$x]['orderID'];
				}
	
			$result = array();
			$result = array_keys(array_flip($resdata['orderID']));	
			return $result;	

			} else if ($num_of_rows ==  1){
			
				return $some_array[0]['orderID'];	

			} else {
					
			}

		}

		//-- getallProducts Retrieve all products without pagination --// 
			public function getallProducts (){
			$conn = $this->conn;
			$sql = "SELECT * FROM product";
					
			if($stmt = $conn->prepare($sql))
			{

			$stmt->execute();			
			$result = $stmt->get_result(); 
			$num_of_rows = $result->num_rows;

			while ($row = $result->fetch_assoc())
			{		

    			 $some_array['product'][] = $row;

			}	

				echo json_encode($some_array);
			}
			else 
			{
				echo ('failed');
			}


		}
		//-- getUserproducts gets userID order item and then gathers all user products --//
		public function getUserproducts($data,$limit,$date){
				
			$orderitem=$this->getCustomerOrderID($data,$limit);
			if ($orderitem != null){

			$this->getAlluserproducts($date,$orderitem);

			} else {

			}	
		}

		public function getAlluserproducts($date,$orderitem){

			$test = false;
			$conn = $this->conn;
			$some_array = [];

			foreach ($orderitem as $key=>$val){
			$sql= "SELECT b.id as transactionID,b.date,d.totalamount,f.title,f.id as productID,f.description,f.image,SUM(d.quantity) as quantity,f.price as price
			FROM 
			customer a
				inner join 
			orderitem b
			on a.id = b.customerID
				inner join 
			transaction c
			on b.id = c.orderuserid
				inner join 
			quantityitems d 
			on c.quantityID = d.id 
				inner join
			product f 
			on d.productID = f.id 
			WHERE b.id = ? AND   YEAR(b.date) = ?
			GROUP BY productID";
			
			$stmt = $conn->prepare($sql);

			if($stmt = $conn->prepare($sql))
			{

			$stmt->bind_param("ii",$val,$date);
			$stmt->execute();	
			$result = $stmt->get_result(); 
			$num_of_rows = $result->num_rows;		

			if($num_of_rows!=0)
			{
			$test = true;	
			while ($row = $result->fetch_assoc())
			{		
		
				$some_array[$row['transactionID']][] = $row;
			}

			} else {

			echo "Sorry there are no products";

			}
 
			}
			else 
			{
				echo ('failed');
			}

		

			}	

			if ($test = true)
			{
				echo json_encode($some_array);

			}
			else {
				echo json_encode("No product");
			}
		
		}


		//-- gets the last product by limited record by 1 --//
		public function getlastproduct($data,$limit){
			$conn = $this->conn;	
			$resultdecoded = json_decode($data,true);	
			$data = $resultdecoded[1];		
			$orderitem=$this->getCustomerOrderID($data,$limit);
			
			if ($orderitem != null){
				
			$this->getlastid($data,$orderitem);	
			
			} else {

			}	
		}


		public function getlastid($data1,$orderitem){		
			
			$conn = $this->conn;		
			$sql="SELECT b.id as transactionID,b.date,d.totalamount,f.title,f.id as productID,f.description,f.image,SUM(d.quantity) as quantity,f.price as price
			FROM 
				customer a
					inner join 
				orderitem b
				on a.id = b.customerID
					inner join 
				transaction c
				on b.id = c.orderuserid
					inner join 
				quantityitems d 
				on c.quantityID = d.id 
				inner join
				product f 
				on d.productID = f.id 
				WHERE b.id = ?
				GROUP BY productID";



			if($stmt = $conn->prepare($sql))
			{
			
			$stmt->bind_param("i",$orderitem);
			$stmt->execute();	
			$result = $stmt->get_result(); 
			$num_of_rows = $result->num_rows;


			while ($row = $result->fetch_assoc())
			{		

    			 $some_array[$row['transactionID']][] = $row;

			}
	
			}
			else 
			{
				echo ('failed');
			}

			echo json_encode($some_array);


		}

				
	}


