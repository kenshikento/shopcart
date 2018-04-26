<?php 

	include('../data/dbfile.php');

	$postdata = file_get_contents("php://input");
	$datarun = new dataclass();
	$datarun->datagathering($postdata);	

	class dataclass 
	{
		public function __construct()
		{
			$conn = new DatabaseConnection();
			$this->conn=$conn->dataconnection();		
		}

		public function datagathering($data) 
		{	
			$conn = $this->conn;
			// data extracted
			$resultDecoded = json_decode($data,true);


			// User    [User name ] 

			$username = $resultDecoded['user'][0];	
			$username = $conn->real_escape_string($username);	
			$userid   = $resultDecoded['user'][1];	
			$userid   = $conn->real_escape_string($userid);

			// product [ total id price ]
			$totalamount = $resultDecoded['totatamount'];
			$max = sizeof($resultDecoded['products']);
			$totalquantity = 0;
			$quant = array();
			$quantity = array();
			$id = array();

			// Loop for each product
			for ($i = 0;  $i <$max; $i++)
			{	
				// using ID of product as array key for product quantity 
				$totalquantity += $resultDecoded['products'][$i]['quantity'];
				$id[] = $resultDecoded['products'][$i]['id'];
				$quantkey =$resultDecoded['products'][$i]['id'];
				$quant[$quantkey] = $resultDecoded['products'][$i]['quantity'];
			
			}
			

			// Cleaning data 

			// Sending information into addTransaction function
			$this->addTransaction($userid,$id,$quant,$totalamount);
		} 
		// Data sent   [userid / totalprice productID totalquantity  quantity-for-each-item ]	
		public function addTransaction($userid,$productid,$quantityitem,$totalamount)
		{	

			$conn = $this->conn;
			$stmt = $conn->prepare("INSERT INTO orderitem (customerID,date) VALUES (?,now())");
			$stmt->bind_param("i", $userid);
			if($stmt->execute())
			{
				$orderitemid = $conn->insert_id;

			} else {

				echo ("Order item did not successfully insert $userid");
			}
			
		

			// For this loop it inserts quantity item which then it finds the last inserted id which then inserts it into the transaction table --//
			$maxproduct = count($productid);
			for ($i = 0; $i < $maxproduct; $i++)
			{ 

			$quantityitems = $quantityitem[$productid[$i]];
			$quantity      = json_encode($quantityitems);
			$productsid    = $productid[$i];
			$stmt = $conn->prepare("INSERT INTO quantityitems(quantity,productID,totalamount) VALUES (?,?,?)");
			$stmt->bind_param("iii", $quantity,$productsid,$totalamount);

			if($stmt->execute())
			{
				$quantityitemsID = $conn->insert_id;

			} else {

				echo ("quantity items did not successfully insert $productsid");
			}
	

			$conn = $this->conn;
			$sql = "INSERT INTO transaction (quantityID,orderuserid) VALUES ($quantityitemsID,$orderitemid)";

			$stmt = $conn->prepare("INSERT INTO transaction (quantityID,orderuserid) VALUES (?,?)");
			$stmt->bind_param("ii", $quantityitemsID,$orderitemid);
			
			if($stmt->execute())
			{
				$user = $userid;

			} else {

				echo "Failed added transaction";
			}
						
			
			}
		


		}


}

