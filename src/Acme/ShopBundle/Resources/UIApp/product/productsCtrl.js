productsCtrl = function ($scope, $http, Restangular, products, categories)
{
	$scope.categories = categories;
	$scope.products   = products;
	$scope.currentProduct = null;
	$scope.editAndShowProduct = function (product) {
		$scope.currentProduct = product;
	};

	$scope.back = function () {
		$scope.currentProduct = null;
	};

	$scope.showProduct = function (product) {
		product.show = true;
		$scope.product = product;
	};

	$scope.editProduct = function (product) {
		product.edit = true;
	};

	$scope.addProduct = function () {
		var product = {
			id: null,
			name: '',
			edit: true
		};
		$scope.products.push(product);
	};

	$scope.deleteProduct = function (product) {
		Restangular.restangularizeElement(null, product, 'product');
		product.remove().then(function(){
			for (var i = $scope.products.length - 1; i >= 0; i--) {
				if ($scope.products[i].id === product.id) {
					$scope.products.splice(i, 1);
				}
			}
		});
		$scope.back();
	};

	$scope.saveProduct = function (product) {
		Restangular.restangularizeElement(null, product, 'product');
		if (product.id) {
			product.fromServer = true;
		}
		product.save().then(function (data) {
			product.edit         = false;
			product.id           = data.id;
			product.category_name = data.category_name;
			$scope.back();
		});
	};
};

productsCtrl.resolve = {
	products : function (Restangular, $stateParams) {
		return Restangular.service('product').getList($stateParams);
	},
	categories : function (Restangular) {
		return Restangular.service('category').getList();
	}
};
angular.module('fastFood').controller('productsCtrl',productsCtrl);