angular.module('fastFood').config(function($stateProvider, $urlRouterProvider) {
  //
  // For any unmatched url, redirect to /state1
  $urlRouterProvider.otherwise('/main');
  //
  // Now set up the states
  $stateProvider
    .state('main', {
      url: '/main',
      templateUrl: '/main.html',
      controller: mainCtrl
    })
    .state('main.category', {
      url: '/category',
      templateUrl: '/category/index.html',
      controller: categoriesCtrl
    })
    .state('main.product', {
      url: '/product',
      templateUrl: '/product/index.html',
      controller: productsCtrl
    })
    .state('main.contact', {
      url: '/contact',
      templateUrl: '/contact/index.html',
      controller: contactsCtrl
    })
    .state('main.user', {
      url: '/user',
      templateUrl: '/user/index.html',
      controller: usersCtrl
    })
    .state('main.bill', {
      url: '/bill',
      templateUrl: '/bill/index.html',
      controller: billCtrl
    })
        .state('main.valueProduct', {
      url: '/value-product',
      templateUrl: '/valueProduct/index.html',
      controller: valueProductCtrl
    });
});