valueProductCtrl = function ($scope, $http, Restangular)
{
	$scope.valueProducts  = [];
	function uploadValueProducts () {
		var service = Restangular.service('value-product');
		service.getList().then(function (response) {
			$scope.valueProducts = response;
		});
	}
	uploadValueProducts();

	$scope.currentValueProduct = null;
	$scope.editAndShowValueProduct = function (valueProduct) {
		$scope.currentValueProduct = valueProduct;
	};

	$scope.back = function () {
		$scope.currentValueProduct = null;
	};

	$scope.showValueProduct = function (valueProduct) {
		valueProduct.show = true;
		$scope.valueProduct = valueProduct;
	};

	$scope.editValueProduct = function (valueProduct) {
		valueProduct.edit = true;
	};

	$scope.addValueProduct = function () {
		var valueProduct = {
			id: null,
			// name: '',
			edit: true
		};
		$scope.valueProducts.push(valueProduct);
	};

	$scope.deleteValueProduct = function (valueProduct) {
		Restangular.restangularizeElement(null, valueProduct, 'value-product');
		valueProduct.remove().then(function(){
			for (var i = $scope.valueProducts.length - 1; i >= 0; i--) {
				if ($scope.valueProducts[i].id === valueProduct.id) {
					$scope.valueProducts.splice(i, 1);
				}
			}
		});
		$scope.back();
	};

	$scope.saveValueProduct = function (valueProduct) {
		Restangular.restangularizeElement(null, valueProduct, 'value-product');
		if (valueProduct.id) {
			valueProduct.fromServer = true;
		}
		valueProduct.save().then(function (data) {
			valueProduct.edit         = false;
			valueProduct.id           = data.id;
			valueProduct.product_name = data.product_name;
			$scope.back();
		});
	};
};
angular.module('fastFood').controller('valueProductCtrl',valueProductCtrl);