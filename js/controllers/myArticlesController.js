App.controller('myArticlesController', function ($scope, $http, SharedData) {

    $scope.alerts = [];
    //alerts
    $scope.addAlert = function (mtype, message) {
        $scope.alerts.push({
            type: mtype,
            msg: message
        });
    };

    $scope.closeAlert = function (index) {
        $scope.alerts.splice(index, 1);
    };


    //Fetch Data
    $url = "http://localhost:8080/wordbro/php/articleService.php";
    // Simple GET request example :
    $http.get($url).
    success(function (data, status, headers, config) {
        // this callback will be called asynchronously
        // when the response is available
        $scope.message = "my articles";
        $scope.articles = data;

    }).
    error(function (data, status, headers, config) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        $scope.addAlert('danger', 'server did not respond :' + status);
    });



    //insert article
    function addArticle() {
        $http.post($url, $scope.article).
        success(function (data, status, headers, config) {
            // this callback will be called asynchronously
            // when the response is available
            $scope.addAlert('success', 'added ' + $scope.article.title);
            delete $scope.article;

        }).
        error(function (data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            $scope.addAlert('danger', 'server did not respond');
        });
    }

    $scope.ReadNow = function () {
        addArticle();
        SharedData.article = $scope.article;
    };

    $scope.Read = function (index) {
        SharedData.article = $scope.articles[index];
    }

    //insert article
    $scope.ReadLater = function () {
        addArticle();
    };

    $scope.Delete = function (index) {
        var article = $scope.articles[index];

        $http.delete($url, article.articleId).
        success(function (data, status, headers, config) {
            // this callback will be called asynchronously
            // when the response is available
            $scope.addAlert('success', 'deleted : ' + article.title);
            $scope.articles.splice(index, 1);

        }).
        error(function (data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            $scope.addAlert('danger', 'server did not respond');
        });

    };


});
