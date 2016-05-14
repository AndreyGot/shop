angular.module('fastFood').factory('formValidator', function () {
    return function (form) {
        angular.forEach(form, function(field){
         if(angular.isObject(field) && '$viewValue' in field) {
             field.$setViewValue(field.$viewValue);
         }
        });
        form.$setDirty();
        return form.$invalid;
    };
});