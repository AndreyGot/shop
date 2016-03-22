contactsCtrl = function ($scope,$http,Restangular)
{
	$scope.contacts  = [];
	function uploadContacts () {
		var service = Restangular.service('contact');
		service.getList().then(function (response) {
			$scope.contacts = response;
		});
	}
	uploadContacts();

	$scope.currentContact = null;
	$scope.editAndShowContact = function (contact) {
		$scope.currentContact = contact;
	};

	$scope.back = function () {
		$scope.currentContact = null;
	};

	$scope.showContact = function (contact) {
		contact.show = true;
		$scope.contact = contact;
	};

	$scope.editContact = function (contact) {
		contact.edit = true;
	};

	$scope.addContact = function () {
		var contact = {
			id: null,
			name: '',
			edit: true
		};
		$scope.contacts.push(contact);
	};

	$scope.deleteContact = function (contact) {
		Restangular.restangularizeElement(null, contact, 'contact');
		contact.remove().then(function(){
			for (var i = $scope.contacts.length - 1; i >= 0; i--) {
				if ($scope.contacts[i].id === contact.id) {
					$scope.contacts.splice(i, 1);
				}
			}
		});
		$scope.back();
	};

	$scope.saveContact = function (contact) {

		// var previousContact = contact.previousContact;	
		
		// Restangular.restangularizeElement(null, previousContact, 'contact');
		Restangular.restangularizeElement(null, contact, 'contact');
		// console.log(contact);
		if (contact.id) {
			contact.fromServer = true;
		}
		contact.save().then(function (data) {
			contact.id   = data.id;
			for(var name in contact) {
			  if (contact.hasOwnProperty(name)) {
			  	contact[name] = contact[name];
			  }
			}
			$scope.back();
		});
	};
};
angular.module('fastFood').controller('contactsCtrl',contactsCtrl);