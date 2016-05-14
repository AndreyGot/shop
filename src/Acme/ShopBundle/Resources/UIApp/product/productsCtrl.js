productsCtrl = function ($scope, $state, products, categories, CurrentUser)
{
	$scope.categories  = categories;
	$scope.products    = products;
	$scope.currentUser = CurrentUser;

	$scope.editProductOrBuyProduct = function (product) {
		if (CurrentUser.isAdmin()) {
			$state.transitionTo('main.product.edit', {productId : product.id});
		} else {
			// $state.transitionTo('main.product.buy', {productId : product.id});
		}
	};
	
	$scope.addInShopCart = function(){};
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