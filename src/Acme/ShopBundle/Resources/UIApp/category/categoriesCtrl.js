categoriesCtrl = function ($scope, categories, CurrentUser, $state)
{
	$scope.categories = categories;
	$scope.editCategoryOrShowProducts = function (category) {
		if (CurrentUser.isAdmin()) {
			$state.transitionTo('main.category.edit', {categoryId : category.id});
		} else {
			$state.transitionTo('main.productCategory', {categoryId : category.id});
		}
	};
};

categoriesCtrl.resolve = {
	categories : function (Restangular) {
		return Restangular.service('category').getList();
	}
};
angular.module('fastFood').controller('categoriesCtrl',categoriesCtrl);