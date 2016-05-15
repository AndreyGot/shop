productsCtrl = function ($scope, products, categories, CurrentUser, Restangular, formValidator)
{
	$scope.categories  = categories;
	$scope.products    = products;
	$scope.currentUser = CurrentUser;

	function ifProductSelected(valueProducts, productId) {
		for (var i = valueProducts.length - 1; i >= 0; i--) {
			if (valueProducts[i].product_id == productId) {
				return valueProducts[i];
			}
		}
	}

	var submited = false;
	$scope.addInShopCart = function(productValue, form){
		if (formValidator(form) || submited) {
			return;
		}

		var bill          = CurrentUser.getCurrentBill(),
		    valueProducts = bill.valueProducts || [];
		
		var selectedProduct = ifProductSelected(valueProducts, productValue.product_id);
		if (selectedProduct) {
			selectedProduct.value += productValue.value;
		} else {
			valueProducts.push(productValue);
		}

		for (var i = valueProducts.length - 1; i >= 0; i--) {
			valueProducts[i] = {
				product_id : valueProducts[i].product_id,
				value      : valueProducts[i].value
			};
		}

		bill.valueProducts = valueProducts;

		Restangular.restangularizeElement(null, bill, 'bill');
		if (bill.id) {
			bill.fromServer = true;
		}
		submited = true;
		bill.save().then(function (bill) {
			CurrentUser.setCurrentBill(bill);
			productValue.value = null;
			submited           = false;
			form.$setPristine();
		}, function () {
			submited = false;
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
angular.module('fastFood').controller('productsCtrl', productsCtrl);