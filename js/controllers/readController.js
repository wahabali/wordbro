App.controller('readController', function ($scope, SharedData, $http, $log) {

    $log.log('Read Controller here.');

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



    $scope.message = SharedData.article.title;

    $url = "http://localhost:8080/wordbro/php/readService.php";


    var json = angular.toJson(SharedData.article); //'{"title":"title" , "body":"body"  }';
    $log.log('sent' + json);
    //$http.post($url, SharedData.article).
    $http.post($url, json).
    success(function (data, status, headers, config) {
        $scope.addAlert('success', '');
        $log.log('returned : ' + JSON.stringify(data));
        $scope.words = data;
        /*angular.forEach(data.words, function (wordRow) {
            $log.log(wordRow.word);
            $scope.words.push(wordRow.word);
        });*/
        // this callback will be called asynchronously
        // when the response is available
        //$scope.text = data.dict;
        // $scope.message = data;
        //console.log("data " + JSON.stringify(data));
        // console.log("data " + angular.fromJson(data));


    }).error(function (data, status, headers, config) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        $scope.addAlert('danger', 'server error');
        $log.log(status);
    });




    /*    $scope.words = ["one", "two", "three"];
        $scope.text = ["one", "two", "three"];
        $scope.meaning = ["1", "2", "teen, 3 , drei"];
        $scope.toggled = [false, false, false];*/

    $scope.popMeaning = function ($index) {

        $scope.dynamicPopover = {
            content: 'Here go more meanings',
            templateUrl: 'myPopoverTemplate.html',
            title: 'title' //$scope.words[$index]
        };

    }

    $scope.toggleWord = function ($index) {

        if ($scope.toggled[$index] == false) {
            $scope.text[$index] = $scope.meaning[$index];
            $scope.toggled[$index] = true;
        } else {
            $scope.text[$index] = $scope.words[$index];
            $scope.toggled[$index] = false;
        }


    };


});
