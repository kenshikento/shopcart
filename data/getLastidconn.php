<?php 

include('getProduct.php');
	$postdata = file_get_contents("php://input");
	$datarun = new dataProduct();
	$datarun->getlastproduct($postdata,1);
