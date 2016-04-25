usersCtrl = function ($scope,$http,Restangular)
{
	$scope.users  = [];
	function uploadUsers () {
		var service = Restangular.service('user');
		service.getList().then(function (response) {
			$scope.users = response;
		});
	}
	uploadUsers();

	$scope.typeArr = [{value:'admin', title:'Admin'}, {value:'client', title:'Client'}];

	$scope.currentUser = null;
	$scope.editAndShowUser = function (user) {
		$scope.currentUser = user;
	};

	$scope.back = function () {
		$scope.currentUser = null;
	};

	$scope.showUser = function (user) {
		user.show = true;
		$scope.user = user;
	};

	$scope.editUser = function (user) {
		user.edit = true;
	};

	$scope.addUser = function () {
		var user = {
			id: null,
			name: '',
			edit: true
		};
		$scope.users.push(user);
	};

	$scope.deleteUser = function (user) {
		Restangular.restangularizeElement(null, user, 'user');
		user.remove().then(function(){
			for (var i = $scope.users.length - 1; i >= 0; i--) {
				if ($scope.users[i].id === user.id) {
					$scope.users.splice(i, 1);
				}
			}
		});
		$scope.back();
	};

	$scope.saveUser = function (user) {

		Restangular.restangularizeElement(null, user, 'user');
		// console.log(user);
		if (user.id) {
			user.fromServer = true;
		}
		user.save().then(function (data) {
			user.id   = data.id;
			for(var name in user) {
			  if (user.hasOwnProperty(name)) {
			  	user[name] = user[name];
			  }
			}
			$scope.back();
		});
	};
};
angular.module('fastFood').controller('usersCtrl',usersCtrl);