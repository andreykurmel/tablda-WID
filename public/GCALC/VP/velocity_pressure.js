var app = angular.module('TIA-WL-APP', ['ngAnimate', 'ngSanitize', 'ngTouch']);

app.controller('vpController', function ($rootScope, $scope, $http, $window) {
    var $parent = $window.parent.angular.element($window.frameElement).scope();

    var fromCalc = true;

    $scope.configAccess = document.getElementById('iframeId').getAttribute('debug');

    if($parent) {

        // Extends $scope
        $parent.$reference($scope, $rootScope, {
            static: {
                const: "ALL/code/TIA/222/CodeInfo-TIA-222.json",
                dbName: "tia_222_g_vp"
            },
            files: {
                app: "velocity_pressure_files.php",
                path: "ALL/code/TIA/222/G/VP"
            },
            document: document,
            calcApp: 'VP',
            calcAppName: 'TIA-222-G Velocity Pressure'
        });
        
        var frameID = parseFloat(window.frameElement.getAttribute('id'));

    } else {

        $scope.config = {
            static: {
                const: "./../CodeInfo-TIA-222.json",
                dbName: "tia_222_g_vp"
            },
            files: {
                app: "velocity_pressure_files.php",
                path: ""
            },
            document: document,
            calcApp: 'VP',
            calcAppName: 'TIA-222-G Velocity Pressure'
        };

        fromCalc = false;

        $scope.calculation = {};

    }

    // Init
    $scope.calculation.inputData = {
        I: null,
        str_class: null,
        expCAT: null,
        z_g: null,
        alpha: null,
        K_zmin: null,
        K_e: null,
        topCAT: null,
        K_t: null,
        f: null,
        z: null,
        K_z: null,
        exp: null,
        H_crest: null,
        K_h: null,
        K_zt: null,
        str_type: null,
        str_cros_sec: null,
        K_d: null,
        V: null,
        q_z: null,

        str_sptd_on_other_str: null,
        G_h: null,
        h_str: null,
        t_i: null,
        K_iz: null,        
        t_iz: null         
    };

    $scope.calculation.access = true;

    if($scope.configAccess != 'debug') {
        if(fromCalc) {
            $scope.calculation.access = true;
        } else {
            $scope.calculation.access = false;
        }
    }
    
    $scope.calculation.calcAppTable = 'tia_222_g_vp';

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

        $scope.calculation.info = function (selector) {
            var shared_selectors = [
                {
                    selector: '.shared',
                    position: 'bottom'  // bottom / top
                }
            ];

            $parent.info.open("ALL/code/TIA/222/G/VP/velocity_pressure_knowledge.html", selector, shared_selectors);
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
                var tableValues = $scope.Data.tableValues;
                var inputD = $scope.calculation.inputData;

                inputD.I = tableValues.importance_factor[inputD.str_class][inputD.purpose_of_calculation];
                var I = inputD.I;

                var prmtr_based_on_expCAT = tableValues.prmtr_based_on_expCAT[inputD.expCAT];
                inputD.z_g = prmtr_based_on_expCAT.z_g;
                inputD.alpha = prmtr_based_on_expCAT.alpha;
                inputD.K_zmin = prmtr_based_on_expCAT.K_zmin;
                inputD.K_e = prmtr_based_on_expCAT.K_e;

                var z_g = inputD.z_g;
                var alpha = inputD.alpha;
                var K_zmin = inputD.K_zmin;
                var K_e = inputD.K_e;

                var prmtr_based_on_topCAT = tableValues.prmtr_based_on_topCAT[inputD.topCAT];
                inputD.K_t = prmtr_based_on_topCAT.K_t;
                inputD.f = prmtr_based_on_topCAT.f;

                var K_t = inputD.K_t;
                var f = inputD.f;

                var z = inputD.z;

                inputD.K_z = parseFloat(Math.min(Math.max(2.01 * (Math.pow((z / z_g), (2 / alpha))), K_zmin), 2.01)).toFixed(4);

                var K_z = inputD.K_z;
                var e = inputD.exp || 2.718;
                var H_crest = inputD.H_crest;
                var f = inputD.f;
                if (H_crest == 0) {
                    inputD.K_h = Infinity;
                } else {
                    inputD.K_h = parseFloat((Math.pow(e, f * z / H_crest))).toFixed(2);
                    // console.log('e=' + e + ', f=' + f + ', z=' + z + ', H_crest=' + H_crest);
                }

                var K_e = inputD.K_e;
                var K_h = inputD.K_h;
                var K_t = inputD.K_t;
                switch (inputD.topCAT) {
                    case '1':
                    case 1:
                        inputD.K_zt = 1.0;
                        break;

                    case '2':
                    case '3':
                    case '4':
                        inputD.K_zt = Math.pow(1 + K_e * K_t / K_h, 2).toFixed(4);
                        break;

                    case '5':
                        inputD.K_zt = inputD.K_zt5.toFixed(4);
                        break;
                    default:
                        break;
                }

                switch (inputD.str_type) {
                    case 'Latticed':
                    case 'latticed':
                    case 'guyed_mast':

                        switch (inputD.str_cros_sec) {
                            case 'triangular':
                            case 'square':
                            case 'rectangular':
                                inputD.K_d = 0.85;
                                break;
                            case 'others':
                                inputD.K_d = 0.95;
                                break;
                            default:
                                break;
                        }
                        break;

                    case 'tubular_pole':
                    case 'other_pole':
                    case 'appurtenance':
                        inputD.K_d = 0.95;
                        break;
                    default:
                        break;
                }

                var K_zt = inputD.K_zt || 1;
                var K_d = inputD.K_d;
                var V = inputD.V;

                if (isNumeric(I)) {
                } else {
                    I = 1.0
                }

                inputD.q_z = parseFloat((0.00256 * K_z * K_zt * K_d * (Math.pow(V, 2)) * I)).toFixed(4);


                switch (inputD.str_type) {
                    case 'Latticed':
                    case 'latticed':
                        var h_str = inputD.h_str || 0;
                        inputD.G_h = Math.min(Math.max(0.85 + 0.15 * (h_str / 150 - 3.0), 0.85), 1.00);
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

                var denominator = 33;

                var t_i = inputD.t_i;

                inputD.K_iz = parseFloat(Math.min( Math.pow( z/12 /denominator, 0.10), 1.4 )).toFixed(4);

                var K_iz = inputD.K_iz;

                inputD.t_iz = parseFloat(2.0*t_i*I*K_iz*Math.pow(K_zt, 0.35)).toFixed(4);

                // Save export data
                $scope.calculation.saveData = {
                    'pageAppNo': $scope.calculation.pageAppNo,
                    
                    'RcdNo': inputD.RcdNo,
                    'expCAT': inputD.expCAT,
                    'z_g': inputD.z_g,
                    'alpha': inputD.alpha,
                    'K_zmin': inputD.K_zmin,
                    'K_e': inputD.K_e,
                    'z': inputD.z,
                    'K_z': inputD.K_z,
                    'topCAT': inputD.topCAT,
                    'K_t': inputD.K_t,
                    'f': inputD.f,
                    'H_crest': inputD.H_crest,
                    'K_h': inputD.K_h,
                    'K_zt': inputD.K_zt,
                    'K_d': inputD.K_d,
                    'V': inputD.V,
                    'str_type': inputD.str_type,
                    'str_cros_sec': inputD.str_cros_sec,
                    'str_class': inputD.str_class,
                    'notes': inputD.notes,
                    'purpose_of_calculation': inputD.purpose_of_calculation,
                    'K_zt5': inputD.K_zt5,
                    'I': inputD.I,
                    'q_z': inputD.q_z,

                    'h_str': inputD.h_str,
                    'G_h': inputD.G_h,
                    'str_sptd_on_other_str': inputD.str_sptd_on_other_str,
                    't_i': inputD.t_i,
                    'K_iz': inputD.K_iz,                    
                    't_iz': inputD.t_iz               
                };

                if(fromCalc) {
                    $parent.$parent.calc.changed = true;
                    // $parent.$parent.calc.innerCalcData = $scope.calculation.inputData;

                    $parent.$parent.calc.innerCalcData.values = angular.copy($scope.calculation.inputData);
                    $parent.$parent.calc.innerCalcData.notations = $scope.Notation;
                    $parent.$parent.calc.innerCalcData.units = $scope.Unit;
                    
                    
                    if($parent.$parent.calc.innerCalcData && $scope.calculation.optionlist) {
                        $parent.$parent.calc.innerCalcData.values.purpose_of_calculation = $scope.calculation.optionlist.purpose_of_calculation[$parent.$parent.calc.innerCalcData.values.purpose_of_calculation];
                        $parent.$parent.calc.innerCalcData.values.str_type = $scope.calculation.optionlist.str_type[$parent.$parent.calc.innerCalcData.values.str_type];
                    }

                }
                

                $rootScope.$broadcast("loading:finish");
                break;

            case 'php':
                $http.post("./../../../../../api/request.php", {
                    app: "ALL/code/TIA/222/G/VP/velocity_pressure_f_change.php",
                    data: $scope.calculation.inputData,
                    extra: {
                        table: $scope.Data.tableValues
                    },
                    method: "getAppCalculation"
                }).success(function (responce) {
                    var inputD = $scope.calculation.inputData = responce.data;

                    $scope.calculation.saveData = {
                        'RcdNo': inputD.RcdNo,
                        'expCAT': inputD.expCAT,
                        'z_g': inputD.z_g,
                        'alpha': inputD.alpha,
                        'K_zmin': inputD.K_zmin,
                        'K_e': inputD.K_e,
                        'z': inputD.z,
                        'K_z': inputD.K_z,
                        'topCAT': inputD.topCAT,
                        'K_t': inputD.K_t,
                        'f': inputD.f,
                        'H_crest': inputD.H_crest,
                        'K_h': inputD.K_h,
                        'K_zt': inputD.K_zt,
                        'K_d': inputD.K_d,
                        'V': inputD.V,
                        'str_type': inputD.str_type,
                        'str_cros_sec': inputD.str_cros_sec,
                        'str_class': inputD.str_class,
                        'notes': inputD.notes,
                        'pageAppNo': $scope.calculation.pageAppNo,
                        'purpose_of_calculation': inputD.purpose_of_calculation,
                        'K_zt5': inputD.K_zt5,
                        'I': inputD.I,
                        'q_z': inputD.q_z,
                        'h_str': inputD.h_str,
                        'G_h': inputD.G_h,
                        'str_sptd_on_other_str': inputD.str_sptd_on_other_str,
                        't_i': inputD.t_i,
                        'K_iz': inputD.K_iz,                        
                        't_iz': inputD.t_iz

                    };
                });
                break;
            case 'python':
                break;

            case 'others':
                break;

            default:
                break;
        }

    };

    

    $scope.prmtrUpon = function (selectChange) {
        var inputD = $scope.calculation.inputData;
        switch (selectChange) {
            case 'expCAT':
                break;

            case 'str_type':

                document.getElementById("cros_sec_type").style.display = "none";

                switch (inputD.str_type) {
                    case 'Latticed':
                    case 'latticed':
                    case 'guyed_mast':
                        document.getElementById("cros_sec_type").style.display = "block";
                        break;
                    case 'tubular_pole':
                    case 'other_pole':
                    case 'appurtenance':
                        // inputD.K_d = 0.95;
                        break;
                    default:
                        break;
                }

                break;

            case 'str_cros_sec':
                break;
            case 'str_class':
                // console.log($scope.calculation);
                break;
            default:
                break;
        }
    };

    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
});
