mainCtrl = function ($scope, CurrentUser)
{
	$scope.currentUser = CurrentUser;
};
angular.module('fastFood').controller('mainCtrl',mainCtrl);