// create the module and name it scotchApp
var App = angular.module('wordbroApp', ['ngRoute', 'ui.bootstrap']);




// configure our routes
App.config(function ($routeProvider) {
    $routeProvider

    // route for the home page
        .when('/', {
        templateUrl: 'pages/home.html',
        controller: 'mainController'
    })

    // route for the newArticle page
    .when('/newArticle', {
        templateUrl: 'pages/newArticle.html',
        controller: 'myArticlesController'
    })

    // route for the newArticle page
    .when('/read', {
        templateUrl: 'pages/read.html',
        controller: 'readController'
    })

    // route for the words
    .when('/myWords', {
        templateUrl: 'pages/myWords.html',
        controller: 'myWordsController'
    })

    // route for the Articles page
    .when('/myArticles', {
        templateUrl: 'pages/myArticles.html',
        controller: 'myArticlesController'
    })

    // route for the about page
    .when('/about', {
        templateUrl: 'pages/about.html',
        controller: 'aboutController'
    })

    // route for the contact page
    .when('/contact', {
        templateUrl: 'pages/contact.html',
        controller: 'contactController'
    });
});


App.factory('SharedData', function () {
    return {
        article: ''
    };
});

// create the controller and inject Angular's $scope
App.controller('mainController', function ($scope) {

    // create a message to display in our view
    $scope.message = 'Everyone come and see how good I look!';
});




App.controller('contactController', function ($scope) {
    $scope.message = 'Contact us! JK. This is just a demo.';

});



App.controller('aboutController', function ($scope) {

    $scope.dynamicPopover = {
        content: 'Hello, World!',
        templateUrl: 'myPopoverTemplate.html',
        title: 'Title'
    };

    $scope.alerts = [
        {
            type: 'danger',
            msg: 'Oh snap! Change a few things up and try submitting again.'
        },
        {
            type: 'success',
            msg: 'Well done! You successfully read this important alert message.'
        }
      ];

    $scope.addAlert = function () {
        $scope.alerts.push({
            msg: 'Another alert!'
        });
        //    alert('it');
    };

    $scope.closeAlert = function (index) {
        $scope.alerts.splice(index, 1);
    };
});
