angular.module('fastFood').factory('CurrentUser', function () {
	return {
		anonim   : false,
		userType : 'admin',
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
		}
	};
});