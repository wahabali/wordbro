App.controller('myWordsController', function ($scope, $http, $log) {


    $scope.genders = ['Der', 'Die', 'Das'];
    $scope.partOfSpeech = ['adj', 'adv', 'past-p', 'verb', 'pres-p', 'prep', 'conj', 'pron', 'prefix', 'suffix', 'noun'];




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
    $url = "http://localhost:8080/wordbro/php/services/wordService.php";
    // Simple GET request example :
    $http.get($url).
    success(function (data, status, headers, config) {
        // when the response is available
        $scope.message = "my words";
        $scope.words = data;
    }).
    error(function (data, status, headers, config) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        $scope.addAlert('danger', 'server did not respond painchod');
    });


    $scope.AddWord = function () {

        //            {new_word:$scope.new.word , meaning: $scope.new.meaning , gender:$scope.new.gender, 
        //                             partOfSpeech:$scope.new.partOfSpeech};

        // Simple POST request example (passing data) :

        var json = angular.toJson($scope.new);
        $log.log('sent' + json);

        $http.post($url, json).
        success(function (data, status, headers, config) {
            // this callback will be called asynchronously
            // when the response is available
            $scope.addAlert('success', 'added ' + $scope.new.word);

            $scope.words.push($scope.new);
            delete $scope.new;

        }).
        error(function (data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            $scope.addAlert('danger', 'server did not respond');
        });


        //            $url = "http://localhost:8080/wordbro/getWords.php";
        //            $url = $url + "?new_word=" + $scope.w.word;
        //            $url = $url +  "&meaning=" +  $scope.w.meaning ;
        //            $url = $url + "&partOfSpeech="+ $scope.w.partOfSpeech;
        //            $url = $url + "&gender="+ $scope.w.gender ;
        //            console.log($url);
        //            $http.get( $url)
        //             .success(function (response) {
        //               alert(response);
        //           });    
    }; //end of AddWord    

    //        $http({
    //            method: 'POST',
    //            url: "http://localhost:8080/wordbro/getWords.php",
    //            data: $.param({n_word:$scope.w.word , meaning = $scope.w.meaning, partOfSpeech = $scope.w.partOfSpeech , gender = $scope.w.gender }),
    //            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    //            }).success(function () {
    //            alert('sdfdf');
    //        });
    //                
    //        $post("http://localhost:8080/wordbro/getWords.php",{new_word: 'xss', meaning: 'mmm'},function(data){
    //            //Do something with data return from PHP file.
    //            alert('success');
    //        });



});
