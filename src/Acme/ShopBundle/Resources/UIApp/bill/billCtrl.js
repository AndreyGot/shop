billCtrl = function ($scope,$http,Restangular)
{
	$scope.bills  = [];
	function uploadBills () {
		var service = Restangular.service('bill');
		service.getList().then(function (response) {
			$scope.bills = response;
		});
	}
	uploadBills();

	$scope.users  = [];
	function uploadUsers () {
		var service = Restangular.service('user');
		service.getList().then(function (response) {
			$scope.users = response;
		});
	}
	uploadUsers();

	$scope.currentBill = null;
	$scope.editAndShowBill = function (bill) {
		$scope.currentBill = bill;
	};

	$scope.back = function () {
		$scope.currentBill = null;
	};

	$scope.showBill = function (bill) {
		bill.show = true;
		$scope.bill = bill;
	};

	$scope.editBill = function (bill) {
		bill.edit = true;
	};

	$scope.addBill = function () {
		var bill = {
			id: null,
			// name: '',
			edit: true
		};
		$scope.bills.push(bill);
	};

	$scope.deleteBill = function (bill) {
		Restangular.restangularizeElement(null, bill, 'bill');
		bill.remove().then(function(){
			for (var i = $scope.bills.length - 1; i >= 0; i--) {
				if ($scope.bills[i].id === bill.id) {
					$scope.bills.splice(i, 1);
				}
			}
		});
		$scope.back();
	};

	$scope.userChanged = function (user, bill) {
		bill.user_name = user.name;
	};

	$scope.saveBill = function (bill) {
		Restangular.restangularizeElement(null, bill, 'bill');
		if (bill.id) {
			bill.fromServer = true;
		}
		bill.save().then(function (data) {
			bill.edit         = false;
			bill.id           = data.id;
			bill.created      = data.created;
			$scope.back();
		});
	};
};
angular.module('fastFood').controller('billCtrl',billCtrl);