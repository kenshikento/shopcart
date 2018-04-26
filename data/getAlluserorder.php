<?php 

include('getProduct.php');

	$postdata = $_GET['id'];
	$datarun = new dataProduct();
	$datarun->getUserproducts($postdata,'all',2018);