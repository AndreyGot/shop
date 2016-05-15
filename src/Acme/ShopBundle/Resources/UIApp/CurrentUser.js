angular.module('fastFood').factory('CurrentUser', function () {
	return {
		// anonim   : false,
		anonim   : true,
		userType : 'client',
		// userType : 'admin',
		isAnonim : function () {
			return this.anonim;
		},

		isAdmin : function () {
			if (this.isAnonim()) {
				return false;
			} 
			return this.userType === 'admin';
		},

		isClient : function () {
			if (this.isAnonim()) {
				return false;
			} 
			return this.userType === 'client';
		},
		setCurrentBill : function (bill) {
			if (this.isAdmin()) {
				return;
			}
			this.currentBill = bill;
		},
		getCurrentBill : function () {
			if (this.isAdmin()) {
				return;
			}
			return this.currentBill || {};
		},
	};
});