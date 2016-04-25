categoryEditCtrl = function ($scope, category, $state)
{
	$scope.category = category;

	$scope.saveCategory = function (category) {
		category.save().then(function () {
			$state.transitionTo('main.category', {}, {reload: true});
		});
	};

	$scope.deleteCategory = function (category) {
		category.remove().then(function(){
			for (var i = $scope.categories.length - 1; i >= 0; i--) {
				if ($scope.categories[i].id === category.id) {
					$scope.categories.splice(i, 1);
				}
			}
			$state.transitionTo('main.category', {}, {reload: true});
		});
	};
};

categoryEditCtrl.resolveEdit = {
	category : function (Restangular, $stateParams) {
		var categoryId      = $stateParams.categoryId,
				categoryRest    = Restangular.service('category'),
		    categoryPromice = categoryRest.one(categoryId).get();
		categoryPromice.then(function(category){
			category.fromServer = true;
		});
		return categoryPromice;
	}
};

categoryEditCtrl.resolveNew = {
	'category' : function(Restangular) {
		return Restangular.restangularizeElement(null, {}, 'category');
	}
};

angular.module('fastFood').controller('categoryEditCtrl', categoryEditCtrl);