var app = angular.module('TIA-WL-APP', ['ngAnimate', 'ngTouch']);

app.controller('gust_effect_Controller', function ($rootScope, $scope, $http, $window, $timeout) {
    var $parent = $window.parent.angular.element($window.frameElement).scope();

    var fromCalc = true;

    $scope.configAccess = document.getElementById('iframeId').getAttribute('debug');

    if($parent) {

        // Extends $scope
        $parent.$reference($scope, $rootScope, {
            static: {
                const: "ALL/code/TIA/222/CodeInfo-TIA-222.json",
                dbName: "tia_222_g_gust_effect"
            },
            files: {
                app: "gust_effect_files.php",
                path: "ALL/code/TIA/222/G/VP"
            },            
            document: document,
            calcApp: 'GE',
            calcAppName: 'TIA-222-G Gust Effect'
        });
        
        var frameID = parseFloat(window.frameElement.getAttribute('id'));

    } else {

        $scope.config = {
            static: {
                const: "./../CodeInfo-TIA-222.json",
                dbName: "tia_222_g_gust_effect"
            },
            files: {
                app: "gust_effect_files.php",
                path: "ALL/code/TIA/222/G/Gust"
            },              
            document: document,
            calcApp: 'GE',
            calcAppName: 'TIA-222-G Gust Effect'
        };

        fromCalc = false;

        $scope.calculation = {};

    }

    $scope.calculation.access = true;

    if($scope.configAccess != 'debug') {
        if(fromCalc) {
            $scope.calculation.access = true;
        } else {
            $scope.calculation.access = false;
        }
    }
    
    // Init
    $scope.calculation.inputData = {
        str_type: null,
        str_sptd_on_other_str: null,
        G_h: null,
        h: null
    };

    $scope.calculation.calcAppTable = 'tia_222_g_gust_effect';
    
    if(fromCalc) {
        var frameID = parseFloat(window.frameElement.getAttribute('id'));

        if(Number.isInteger(frameID)) {
            $scope.calculation.pageAppNo = $parent.tree.combSelectedFrames[frameID].id;
        } else {
            $scope.calculation.pageAppNo = $parent.tree.node.id;
        }

        // Get user and const data
        $parent.operation.getCalcData();
        $parent.operation.getConst();

        $scope.calculation.info = function (selector){
            var shared_selectors = [
                {
                    selector: '.shared',
                    position: 'bottom'  // bottom / top
                }
            ];
            $parent.info.open("ALL/code/TIA/222/G/Gust/gust_effect_knowledge.html", selector, shared_selectors);
        };

    } else {

        $scope.calculation.getConst = function () {
            $http({
                method: 'GET',
                url: $scope.config.static.const
            }).then(function successCallback(response) {
                
                $scope.calculation.inputData = $scope.inputDataDft = response.data['Default'];

                $scope.Notation = response.data['Notation'];
                $scope.Unit = response.data['Unit'];
                // alert($scope.Unit);
                $scope.Data = response.data;

                for (var attrname in $scope.calculation.remoteData) {
                    if ($scope.calculation.remoteData[attrname]) {
                        $scope.calculation.inputData[attrname] = $scope.calculation.remoteData[attrname];
                    }
                }

                if ($scope.calculation.change) {
                    $scope.calculation.change();
                }

                $scope.calculation.optionlist = response.data['Options'];
            }, function errorCallback() {
                $scope.inputDataDft = $scope.Notation = $scope.Unit = {};
            });
        };

        $scope.calculation.getConst();
    }
    

    // On change
    $scope.calculation.change = function () {
        var change_option = 'js';

        switch (change_option) {
            case 'js':
                var inputD = $scope.calculation.inputData;

                switch (inputD.str_type) {
                    case 'Latticed':
                    case 'latticed':
                        var h = inputD.h || 0;
                        inputD.G_h = Math.min(Math.max(0.85 + 0.15 * (h / 150 - 3.0), 0.85), 1.00);
                        break;
                    case 'guyed_mast':
                        inputD.G_h = 0.85;
                        break;
                    case 'tubular_pole':
                    case 'other_pole':
                        inputD.G_h = 1.10;
                        break;
                    case 'appurtenance':
                        inputD.G_h = 0.95;
                        break;
                    case 'str_sptd_on_other_str':

                        switch (inputD.str_sptd_on_other_str) {
                            case 'ballast_RT':
                                inputD.G_h = 1.0;
                                break;

                            case 'tubular_GT':
                            case 'spine_GT':
                            case 'pole_GT':
                            case 'tubular_SST':
                            case 'str_flexible_bldg':
                                inputD.G_h = 1.35;
                                break;
                            default:
                                inputD.G_h = NaN;
                                break;
                        }

                        break;
                    default:
                        break;
                }

                $scope.calculation.saveData = {
                    'RcdNo': inputD.RcdNo,
                    'h': inputD.h,
                    'G_h': inputD.G_h,
                    'str_type': inputD.str_type,
                    'str_sptd_on_other_str': inputD.str_sptd_on_other_str,
                    'pageAppNo': $scope.calculation.pageAppNo
                };

                if(fromCalc) {
                    $parent.$parent.calc.changed = true;
                    $parent.$parent.calc.innerCalcData = $scope.calculation.inputData;
                }

                $rootScope.$broadcast("loading:finish");
                break;

            case 'php':
                $http.post("./../../../../../api/request.php", {
                    // app: "gust_effect",
                    app: "ALL/code/TIA/222/G/Gust/gust_effect_f_change.php",
                    data: $scope.calculation.inputData,
                    method: "getAppCalculation"
                }).success(function (response) {
                    if(response.data) {
                        var inputD = $scope.calculation.inputData = response.data;

                        // Save export data
                        $scope.calculation.saveData = {
                            'RcdNo': inputD.RcdNo,
                            'h': inputD.h,
                            'G_h': inputD.G_h,
                            'str_sptd_on_other_str': inputD.str_sptd_on_other_str
                        };

                        console.log(response);
                    }

                });
                break;

            case 'python':
                break;

            default:
                break;
        }
    };
});
