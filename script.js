//angular code for logorg 

(function (angular) {
    'use strict';
    var app = angular.module("logorg", []);

    app.controller("logorg_data", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("logs_with_gates.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.mydata = response.data;


            });
        $scope.list1 = [1, 2, 3, 4];

//        $scope.selected = {};
//        $scope.edit = function (element) {
//            $scope.selected = angular.copy(element);
//        };
//
//        $scope.getTemplate = function (element) {
//            if (element.plp_id === $scope.selected.plp_id) {
//                return 'edit';
//            } else {
//                return 'display';
//            }
//        };
    }]);


    app.directive('whenScrolled', function () {
        return function (scope, elm, attr) {
            var raw = elm[0];
            elm.bind('scroll', function () {
                if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                    scope.$apply(attr.whenScrolled);
                }
            });
        };
    });
})(window.angular);



//angular code for consignee
(function (angular) {
    'use strict';
    var app = angular.module("consignee", []);

    app.controller("consignee_data", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("consignee.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.data = response.data;


            });
        $scope.quantity = 100;
        $scope.myVar = false;
        $scope.toggle = function () {
            $scope.myVar = !$scope.myVar;
        };
        $scope.orderToDisplay = 10;
        $scope.loadMore = function () {

            console.log("im caliing");
            if ($scope.orderToDisplay + 10 < $scope.data.length) {
                $scope.orderToDisplay += 10;
            } else {
                $scope.orderToDisplay = $scope.data.length;
            }
        };
    }]);

    app.directive('whenScrolled', function () {

        console.log("scrolling");
        return function (scope, elm, attr) {
            var raw = elm[0];
            elm.bind('scroll', function () {
                if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                    scope.$apply(attr.whenScrolled);
                }
            });
        };
    });

})(window.angular);



//angular code for vendor 
(function (angular) {
    'use strict';
    var app = angular.module("vendor", []);

    app.controller("vendor_data", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("vendor.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.mydata = response.data;


            });
        $scope.list1 = [1, 2, 3, 4];
    }]);
})(window.angular);




//code for edit the details

$(document).ready(function () {
    'use strict';
    $('body').on('click', '[data-editable]', function () {
        var $el = $(this);

        var $input = $('<input/>').val($el.text());
        $el.replaceWith($input);

        var save = function () {

            var $p = $('<p data-editable />').text($input.val());
            $input.replaceWith($p);
        };


        $input.one('blur', save).focus();

    });

});