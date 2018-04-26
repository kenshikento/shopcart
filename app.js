//'use strict';

 var app = angular.module('MyApp',['mm.foundation','ngMaterial', 'ngMessages','ngRoute','ui.router','ui.bootstrap','angular.filter']) 
 
app.config(['$locationProvider', '$stateProvider', function($locationProvider, $stateProvider) {
	
	$locationProvider.html5Mode(true);
	
	$stateProvider
		.state('products', {
      	url: "/products",
        templateUrl : "products.html",
        controller: 'products'
    })
		.state('history', {
      	url: "/history",
        templateUrl : "history.html",
        controller: 'history'
    })
}]);	


//--PRODUCT CONTROLLER--//     
app.controller("products", function ($scope,$http,$modal) {
	
	$scope.transaction =[];
	$scope.cart = [];
	$scope.userid = {};
	$scope.products=[];		

		$http({
			method:'GET',
			url: '/shopcart/data/getAllproductconn.php',
			
			headers : {'Content-Type': 'application/x-www-form-urlencoded'}   				
		}).then(function(response){
			$scope.response = response;
			$scope.products = $scope.response['data']['product'];
			
			
		}, function (response){	
			console.log("check again");
		});			


	
//-- Adds product in if there isn't a product then it will add one --/
	$scope.addToCart = function (product) {

		var found = false;
		
		$scope.cart.forEach(function (item) {
		if (item.id === product.id) {
				item.quantity++;
				found = true;		
		}

		});

		if (!found) {
				$scope.cart.push(angular.extend({quantity: 1}, product));
		}

	};	

//-- Totals up the product price * quantity and returns price --//
	$scope.getCartPrice = function () {
			var total = 0;
			$scope.cart.forEach(function (product) {
				total += product.price * product.quantity;										
			});

			return total;
	};	
// grabs the cart items and puts it into array which is sent into checkout controller//
	$scope.getCartitems = function () {

			var total = 0;			
			$scope.item =[];

			$scope.cart.forEach(function (product) {

				total += product.price * product.quantity;									
			});
		
			$scope.item = [{"total":total,"items":$scope.cart}];
			return $scope.item;

	};	

	var modalInstance;
	$scope.checkout = function () {
	 	modalInstance = $modal.open({
				templateUrl: 'checkout.html',
				controller: 'CheckoutCtrl',
				resolve: {
					totalitems: $scope.getCartitems
					
				}
			});
	};



});

//-- Check out Controller --//
app.controller('CheckoutCtrl', function ($scope, totalitems,$http,$modalInstance,$modal) {
	//-- Geting values out of array for cart items --//
	$scope.cartitems = totalitems[0]['items'];
	$scope.amountArray = totalitems[0]['items'].length;
	$scope.totalAmount= totalitems[0]['total'];
	$scope.data = JSON.stringify(totalitems[0]);
	$scope.postdata = $scope.data;
	$scope.product = totalitems[0]['items'];
	$scope.itemuser = [];	
	$scope.limit = 0;
	var totalcost = 0;	

	$scope.cartitems.forEach(function (cartitems) {
				totalcost += cartitems.price * cartitems.quantity;									
	});

	$http({
      method: 'GET',
      url: '/shopcart/data/getUser.php'
   	}).then(function (response){
   		$scope.list = response.data.customer;	
   	},function (response){
   		console.log(response);
   	});



	$scope.changeid = function(item){

		$scope.itemuser.push(item.name,item.id);
		$scope.limit = $scope.itemuser.length;
		if ($scope.limit > 2)
		{
			$scope.itemuser.splice(0,2);
		}
	}

	$scope.$cancel = function(){
		$modalInstance.close();
	}

	$scope.onSubmit = function () {
			
		$scope.datastring = {products:$scope.product,user:$scope.itemuser,totatamount:totalcost};
	
		$http({
			method:'post',
			url: '/shopcart/data/addData.php',
			data: $scope.datastring,
			headers : {'Content-Type': 'application/x-www-form-urlencoded'}   				
		}).then(function(response){
			$modalInstance.close();
			$scope.userid = [];
			$scope.sucessful = response;
			$scope.userid = $scope.sucessful.config.data;
				var modalaccept;
				modalaccept = $modal.open({
				templateUrl: 'approved.html',
				controller: 'approvedCtrl',
				resolve:{
							transactionID: $scope.user					
						}
				});

		}, function (response){		
			console.log("check again");
		});	
	};

	$scope.user = function () {
		return $scope.userid;
	};	


}); 	

//-- Last transaction //--
app.controller('approvedCtrl', function ($scope,transactionID,$http) {
	
	$scope.transaction = transactionID['user'];	
		$http({
			method:'post',
			url: '/shopcart/data/getLastidconn.php',
			data: $scope.transaction,
			headers : {'Content-Type': 'application/x-www-form-urlencoded'}   				
		}).then(function(response){				
		
		$scope.prev = response.data;
	
		}, function (response){
			
		console.log(response);

		});			

});	

//-- History transaction--//
app.controller("history", function ($scope,$http) {

	$scope.useritems = [];
    $scope.productlist=[]; 
    $scope.response    = [];
    // -- List of Users -- //
	$http({
      method: 'GET',
      url: '/shopcart/data/getUser.php'
   	}).then(function (response){
   		$scope.list  = response.data.customer;	
   		//console.log($scope.list);
   		//console.log(response);

   	},function (response){
   		console.log(response);
   	});
   
   		
	$scope.changeid = function(item){	

		getAllselected(item);	

	}

//-- Gets users history --//		
	var getAllselected = function($item){		
		$scope.useritems = [];			
	
		$scope.datastring = $item['id'];
		
		var response = $http({
			method:'GET',
			url: '/shopcart/data/getAlluserorder.php',
			params: {id:$scope.datastring},
			headers : {'Content-Type': 'application/x-www-form-urlencoded'}   				
			}).then(function(response){
								
				$scope.useritems = response.data;
				$scope.test =	arrProduct($scope.useritems);

			}, function (response){
				console.log(response);

			});
			
		}


});	
//-- This function pushes the data and restructures the array so that it can be displayed in reverse order --//
function arrProduct($arr){
	var test =[];
	angular.forEach($arr, function (val, key) {
        test.push({val: val});
    });
    return test;
}

function getPrice($scope,$totalprice) {
 		var total = 0;
 		total = $totalprice;

 		return total; 
 		
 } 






