productEditCtrl = function ($scope, product, $state, categories, formValidator)
{
	$scope.product    = product;
	$scope.categories = categories;

	var submited = false;
	$scope.saveProduct = function (product, form) {
		if (formValidator(form) || submited) {
			return;
		}

		submited = true;
		product.save().then(function () {
			$state.transitionTo('main.product', {}, {reload: true}).then(function () {
				submited = false;
			});
		}, function () {
			submited = false;
		});
	};

	$scope.deleteProduct = function (product) {
		product.remove().then(function(){
			for (var i = $scope.products.length - 1; i >= 0; i--) {
				if ($scope.products[i].id === product.id) {
					$scope.products.splice(i, 1);
				}
			}
			$state.transitionTo('main.product', {}, {reload: true});
		});
	};
};

productEditCtrl.resolveEdit = {
	product : function (Restangular, $stateParams) {
		var productId      = $stateParams.productId,
				productRest    = Restangular.service('product'),
		    productPromice = productRest.one(productId).get();
		productPromice.then(function(product){
			product.fromServer = true;
		});
		return productPromice;
	},
	categories : function(Restangular) {
		return Restangular.service('category').getList();
	}
};

productEditCtrl.resolveNew = {
	product : function (Restangular) {
		return Restangular.restangularizeElement(null, {}, 'product');
	},
	categories : function(Restangular) {
		return Restangular.service('category').getList();
	}
};

angular.module('fastFood').controller('productEditCtrl',productEditCtrl);