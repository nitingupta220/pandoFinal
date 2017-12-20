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
        $scope.selected = {};
        // gets the template to ng-include for a table row / item
        $scope.getTemplate = function (data) {
            if (data.plp_id === $scope.selected.plp_id) return 'edit';
            else return 'display';
        };

        $scope.editLogorg = function (data) {
            $scope.selected = angular.copy(data);
        };

        $scope.saveLogorg = function (idx) {
            $scope.mydata[idx] = angular.copy($scope.selected);
            $scope.reset();
        };

        $scope.reset = function () {
            $scope.selected = {};
        };



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

        $scope.selected = {};
        $scope.getTemplate = function (data) {
            if (data.consignee_id === $scope.selected.consignee_id) return 'edit';
            else return 'display';
        };

        $scope.editConsignee = function (data) {
            $scope.selected = angular.copy(data);
        };

        $scope.saveConsignee = function (idx) {
            $scope.mydata[idx] = angular.copy($scope.selected);
            $scope.reset();
        };

        $scope.reset = function () {
            $scope.selected = {};
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
        $scope.selected = {};
        // gets the template to ng-include for a table row / item
        $scope.getTemplate = function (data) {
            if (data.vendor_id === $scope.selected.vendor_id) return 'edit';
            else return 'display';
        };

        $scope.editVendor = function (data) {
            $scope.selected = angular.copy(data);
        };

        $scope.saveVendor = function (idx) {
            $scope.mydata[idx] = angular.copy($scope.selected);
            $scope.reset();
        };

        $scope.reset = function () {
            $scope.selected = {};
        };

    }]);
})(window.angular);

//angular code for rate_matrix
(function (angular) {
    'use strict';
    var app = angular.module("ratematrix", []);

    app.controller("rateMatrix", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("rate_matrix.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.mydata = response.data;


            });

    }]);
    app.controller("detentionMatrix", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("detention.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.mydata = response.data;


            });

    }]);
})(window.angular);








//angular code for Master Material
(function (angular) {
    'use strict';
    var app = angular.module("MasterMaterial", []);

    app.controller("Material", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("materials.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.mydata = response.data;


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
        $scope.selected = {};
        // gets the template to ng-include for a table row / item
        $scope.getTemplate = function (data) {
            if (data._id === $scope.selected._id) return 'edit';
            else return 'display';
        };

        $scope.editMaterial = function (data) {
            $scope.selected = angular.copy(data);
        };

        $scope.saveMaterial = function (idx) {
            $scope.mydata[idx] = angular.copy($scope.selected);
            $scope.reset();
        };

        $scope.reset = function () {
            $scope.selected = {};
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



//angular code for users
(function (angular) {
    'use strict';
    var app = angular.module("user", []);

    app.controller("user_data", ["$scope", "$http", function ($scope, $http) {
        //    here $http get a information from "logs_with_gates.json"     

        $http.get("user.json")
            //        then we will call then mathod to call function in which response argument gives all data contain in records as an Array 
            .then(function (response) {

                $scope.mydata = response.data;
            });


    }]);
})(window.angular);


//code for edit the details

//$(document).ready(function () {
//    'use strict';
//    $('body').on('click', '[data-editable]', function () {
//        var $el = $(this);
//
//        var $input = $('<input/>').val($el.text());
//        $el.replaceWith($input);
//
//        var save = function () {
//
//            var $p = $('<p data-editable />').text($input.val());
//            $input.replaceWith($p);
//        };
//
//
//        $input.one('blur', save).focus();
//
//    });
//
//});

$(document).ready(function () {
    'use strict';
    $('.sidebar ul li').on('click', function () {
        $(this).addClass('.sidebar .active');
    });
});



//File Upload Path

$(document).ready(function () {
    $('#upload').on('click', function () {
        $('#file').trigger('click');
    });
});

$(document).ready(function () {
    $('#upload1').on('click', function () {
        $('#file1').trigger('click');
    });
});

jQuery(function ($) {
    $('input[type="file"]').change(function () {
        console.log(123);
        if ($(this).val()) {
            var filename = $(this).val();
            $(this).closest('.second').find('.upload-path').text(filename);
        }
    });
});
