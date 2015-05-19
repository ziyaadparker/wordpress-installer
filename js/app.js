(function(){
    
    var app = angular.module('automate', ['ngSanitize', 'ngAnimate']);
    
    var types = [
        {
            label: 'Latest Version',
            id: 'http://wordpress.org/latest.zip'
        },
        {
            label: 'Nightly Build (Beta)',
            id: 'http://wordpress.org/nightly-builds/wordpress-latest.zip'
        }
    ];

    app.controller('FormController', ['$scope', '$http', function($scope, $http){
        this.options = types
        
        $scope.formData = {}
        $scope.formData.installation_type = 'http://wordpress.org/latest.zip'
        $scope.formData.create_database = false
        $scope.formData.database_host = 'localhost'
        $scope.formData.table_prefix = 'wp_'
        $scope.isInstalling = false

        $scope.processForm = function(){
            $http({
                method  : 'POST',
                url     : 'inc/process.php',
                data    : $.param($scope.formData),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .success(function(data){
                if (data.outcome == 'errors'){
                    $scope.setupProcess = ''
                    $scope.errorAlert = data.errors
                    $scope.DBerrorAlert = data.dberrors
                } else if (data.outcome == 'success'){
                    $scope.errorAlert = ''
                    $scope.DBerrorAlert = ''
                    $scope.setupProcess = data.setup_process
                    $scope.isInstalling = true
                    $scope.runInstaller()
                } else {
                    $scope.warningAlert = '<strong>Warning!</strong> Something is seriously wrong.';
                }
            });
        }

        $scope.runInstaller = function(){
            $http({
                method  : 'POST',
                url     : 'inc/installer.php',
                data    : $.param($scope.formData),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .success(function(data){
                $scope.isInstalling = false
                $scope.processResults = data.results
                $scope.projectUrl = data.projectUrl
            });
        }
    }]);
    
    app.directive('slugFriendly', function(){
        return {
            restrict: 'A',
            link: function(scope, elm, attr, crl){
                elm.keyup(function(){
                    var clean = angular.lowercase(elm.val());
                    if(angular.isUndefined(elm.val())){
                        return false;
                    }
                    elm.val(clean.replace(/[^a-z0-9-_]/g, ''));
                });
            }
        };
    });

    var visitedElementDirective = function(){
        return {
            restrict: 'E',
            require: '?ngModel',
            link: function (scope, elm, attr, ctrl){
                if (!ctrl) {
                    return;
                }

                elm.on('focus', function(){
                    elm.addClass('ng-focus');

                    scope.$apply(function(){
                        ctrl.hasFocus = true;
                    });
                });

                elm.on('blur', function(){
                    elm.removeClass('ng-focus');
                    elm.addClass('ng-visited');

                    scope.$apply(function(){
                        ctrl.hasFocus = false;
                        ctrl.hasVisited = true;
                    });
                });

                elm.closest('form').on('submit', function(){
                    elm.addClass('ng-visited');

                    scope.$apply(function(){
                        ctrl.hasFocus = false;
                        ctrl.hasVisited = true;
                    });
                });
            }
        };
    };
    
    app.directive('input', visitedElementDirective);

})();
