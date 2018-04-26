$scope.getCartPrice = function () {
			$scope.items =[];
			var i = 0;
			$scope.item =[];
			var total = 0;
			$scope.cart.forEach(function (product) {
				//console.log(product);
				total += product.price * product.quantity;
				//console.log(product.quantity);
				$scope.items.push = {product};	
				//console.log($scope.items);			
				i++;				
			});
		//	console.log($scope.items);
			//console.log(i);
			//console.log($scope.items);
			//$scope.item.push = ({"total":total,"items":$scope.items});

			$scope.item = [{"total":total,"items":$scope.items}];
			return $scope.item;
	};	











	$scope.getCartitems = function () {
			var total = 0;
			var items =[];
			var i = 0;
			$scope.item =[];
			var total = 0;
			$scope.cart.forEach(function (product) {
				total += product.price * product.quantity;	
				items.push = [{'key': i,'id':product.id,'price':product.price,'quantity':product.quantity}];		
				//console.log(items);
				console.log(product);
			i++;				
			});
			console.log(items);
			

			$scope.item = [{"total":total,"items":items}];
			//console.log($scope.item);
			//return $scope.item;
			return $scope.item;
			
	};	



	var values = {name: 'misko', gender: 'male'};
		var log = [];
		angular.forEach(values, function(value, key) {
  			this.push(key + ': ' + value);
		}, log);
		expect(log).toEqual(['name: misko', 'gender: male']);


			$scope.getCartitems = function () {
			var total = 0;
			var items =[];
			var i = 0;
			$scope.item =[];
			var total = 0;
			$scope.cart.forEach(product,function (value,key) {
				this.push(key + ': ' + value);
				//total += product.price * product.quantity;	
				//items.push = [{'key': i,'id':product.id,'price':product.price,'quantity':product.quantity}];		
				//console.log(items);
				//console.log(product);
							
			},log);

			console.log(log);
			

			$scope.item = [{"total":total,"items":items}];
			//console.log($scope.item);
			//return $scope.item;
			return $scope.item;
			
	};	