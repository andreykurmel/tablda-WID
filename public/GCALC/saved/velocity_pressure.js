var app = angular.module('TIA-WL-APP', ['ngAnimate', 'ngTouch']);

app.controller('vpController', function ($scope, $http, $window, $timeout) {
    $scope.gridOptions = {
        columnDefs: [
            {field: 'Sym'},
            {field: 'Value'},
            {field: 'Description'}
        ],
        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: {fontSize: 9},
        exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
        exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
        exporterPdfHeader: {text: "Calculation", style: 'headerStyle'},
        exporterPdfFooter: function (currentPage, pageCount) {
            return {text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle'};
        },
        exporterPdfCustomFormatter: function (docDefinition) {
            docDefinition.styles.headerStyle = {fontSize: 22, bold: true};
            docDefinition.styles.footerStyle = {fontSize: 10, bold: true};
            return docDefinition;
        },
        exporterPdfOrientation: 'portrait',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 500,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function (gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    var $parent = $window.parent.angular.element($window.frameElement).scope();
    $parent.calc.input.calcAppName = 'vp';
    var $auth = $parent.auth.data;
    var $project = $parent.project;
    var $calc = $parent.calc;
    var $tree = $parent.tree;

    $parent.$watch("calc.current", function () {
        if ($parent.project.current && $parent.project.current != '') {
            $scope.calculation.getCalcData();
        }
    });

    $parent.$watch("ref.save", function () {
        if (this.last == true) {
            $parent.ref.save = false;
            $scope.calculation.saveCalcData();
        }
    });

    $parent.$watch("ref.saveAs", function () {
        if (this.last == true) {
            $parent.ref.saveAs = false;
            $scope.calculation.saveCalcData($parent.ref.userscalcPK);
        }
    });

    $parent.$watch("ref.delete", function () {
        if (this.last == true) {
            $parent.ref.delete = false;
            $scope.calculation.dropCalcData();
        }
    });

    $parent.$watch("ref.download", function () {
        if (this.last == true) {
            $parent.ref.download = false;
            $scope.calculation.downLoad();
        }
    });
    $parent.$watch("ref.pdf", function () {
        if (this.last == true) {
            $parent.ref.pdf = false;
            $scope.calculation.toPDF();
        }
    });

    $scope.operation = {
        saveCalcData: function () {},
        dropCalcData: function () {},
        downLoad: function () {},
        toPDF: function () {}
    };

    $scope.calculation = {
        optionlist: false,
        expCAT: [],
        topCAT: [],
        remoteData: [],
        inputData: {},

        isPdf: 'isPdf',

        getCalcData: function () {
            //console.log($calc.current);
            $http.post(dbFileUrl, {
                method: 'getCalcData',
                calcId: $calc.current
            }).then(function successCallback(response) {
                if (response.data['error']) {
                    console.log(response.data['error']);
                }else{
                    $scope.tableCalc = response.data.shift();
                    $parent.calc.input.calcAppName = $scope.tableCalc.calcAppName;
                    $scope.calculation.remoteData = response.data ? response.data[0] : [];
                    console.log($scope.calculation.remoteData);
                    $scope.calculation.getConst();
                }
            }, function errorCallback(response) {
                console.log(response);
            });
        },

        getConst: function () {
            $http({
                method: 'GET',
                url: constFile
            }).then(function successCallback(response) {
                $scope.calculation.inputData = $scope.inputDataDft = response.data['Default'];

                $scope.Notation = response.data['Notation'];
                $scope.Unit = response.data['Unit'];
                $scope.Data = response.data;

                for (var attrname in $scope.calculation.remoteData) { $scope.calculation.inputData[attrname] = $scope.calculation.remoteData[attrname]; }
                $scope.calculation.change();
                $scope.calculation.optionlist = response.data['Options'];
            }, function errorCallback(response) {
                $scope.inputDataDft = $scope.Notation = $scope.Unit = {};
            });
        },

        saveCalcData: function (userscalsPK) {
            var sendData = {};
            angular.copy($scope.calculation.inputData, sendData);
            if (!sendData.expCAT) {
                alert('you forgot to  select value!!!');
                return;
            } else if (!$project.current) {
                alert('you forgot to  select project!!!');
                return;
            } else if (!$calc.current) {
                alert('you forgot to  select calcID!!!');
                return;
            } else if (!$scope.tableCalc) {
                alert('you can\'t save data!!!');
                return;
            }
            delete sendData.$$hashKey;
            delete sendData.exp;
            delete sendData.q_z;
            console.log(sendData);

            sendData.projectID = $project.current;
            sendData.calcID = $calc.current;

            $http.post(dbFileUrl, {
                method: 'saveCalcData',
                val: JSON.stringify(sendData),
                userId: $auth.userid,
                table: $scope.tableCalc.calcAppName,
                userscalcPK: userscalsPK ? userscalsPK : null
            }).then(function (resp) {
                if (resp.data['error']) {
                    alert(resp.data['error']);
                } else {
                    alert(resp.data['succsess']);

                }
            }, function (resp) {
                console.log('error', resp);
            })
        },

        dropCalcData: function () {
            var expC = $scope.calculation.inputData.expCAT;
            if (!expC || !$project.current || !$calc.current) {
                alert('nothing to delete!!!');
                return;
            } else if (!$scope.tableCalc) {
                alert('you can\'t delete data!!!');
                return;
            }

            $http.post(dbFileUrl, {
                method: 'dropCalcData',
                expCat: expC,
                projectId: $project.current,
                calcId: $calc.current,
                table: $scope.tableCalc.calcAppName
            }).then(function successCallback(resp) {
                if (resp.data['error']) {
                    alert(resp.data['error']);
                } else {
                    alert(resp.data['succsess']);
                    //$scope.remoteData.splice(drop.id, 1);
                    //$scope.inputData = $scope.inputDataDft;
                }
            }, function errorCallback(response) {
                console.log(response);
            });
        },

        downLoad: function () {
            if (!$scope.exposureCat || !$project.current || !$calc.current) {
                alert('nothing to download!!!');
                return;
            }
        },

        toPDF: function () {
            //$parent.ref.header +=document.getElementsByTagName('body')[0].innerHTML;
            //var el = document.getElementsByClassName('isPdf');
            //for(var i =0;i<el.length;i++){
            //    el[i].className  ='';
            //    //el[i].removeAttribute( "class" )
            //}
            //$scope.calculation.isPdf ='';
            var newData = [];
            for (var key in $scope.calculation.inputData) {
                newData.push({
                    Sym: key,
                    Value: $scope.calculation.inputData[key],
                    Description: $scope.Notation[key]
                });
            }
            $scope.gridOptions.data = newData;
            //console.log($( ".grid" ).children( 'button'));
            //$scope.calculation.isPdf  ='';
            //var doc = new jsPDF({
            //    unit:'px',
            //    format:'a4'
            //});
            //var specialElementHandlers = {
            //};
            //doc.fromHTML($parent.ref.header, 5, 5, {
            //    'width': 600,
            //    'margin': 1,
            //    'pagesplit': true,
            //    'elementHandlers': specialElementHandlers
            //},function(){
            //        doc.output('dataurlnewwindow');
            //    }
            //);
            //document.getElementsByClassName('ui-grid-contents-wrapper')[0].innerHTML +='<button id="bton" ng-click="itemAction($event,title)">ds</button>';
            //document.getElementById('bton').click();
            document.getElementsByClassName('ui-grid-icon-container')[0].click();
            document.getElementsByTagName('button')[5].click();
            //var pdf =xepOnline.Formatter.Format('iframeId',
            //    {pageWidth:'216mm', pageHeight:'279mm',namespaces:['xmlns:ng=&quot;http://www.foo.net&quot;']});

            //for(var i =0;i<el.length;i++){
            //    el[i].className  +='isPdf';
            //    el[i].setAttribute( "class", 'isPdf' );;
            //}
            //$scope.calculation.isPdf ='isPdf';
        },

        change: function () {

            var tableValues = $scope.Data.tableValues;

            var inputD = $scope.calculation.inputData;

            // var importance_factor = tableValues.importance_factor[inputD.str_class][];
            // inputD.wl_woIce = importance_factor.wl_woIce;
            // inputD.wl_wIce = importance_factor.wl_wIce;
            // inputD.iceThk = importance_factor.iceThk;
            // inputD.earthquake = importance_factor.earthquake;

            inputD.I = tableValues.importance_factor[inputD.str_class][inputD.purpose_of_calculation];
            var I = inputD.I;
            // console.log(inputD.I, inputD, inputD.purpose_of_calculation);

            var prmtr_based_on_expCAT = tableValues.prmtr_based_on_expCAT[inputD.expCAT];
            inputD.z_g = prmtr_based_on_expCAT.z_g;
            inputD.alpha = prmtr_based_on_expCAT.alpha;
            inputD.K_zmin = prmtr_based_on_expCAT.K_zmin;
            inputD.K_e = prmtr_based_on_expCAT.K_e;

            var z_g   = inputD.z_g;
            var alpha = inputD.alpha;
            var K_zmin = inputD.K_zmin;
            var K_e    = inputD.K_e;

            var prmtr_based_on_topCAT = tableValues.prmtr_based_on_topCAT[inputD.topCAT];
            inputD.K_t = prmtr_based_on_topCAT.K_t;
            inputD.f = prmtr_based_on_topCAT.f;

            var K_t = inputD.K_t;
            var f = inputD.f;

            var z   = inputD.z;

            inputD.K_z = parseFloat(Math.min(Math.max(2.01 * (Math.pow((z / z_g), (2 / alpha))), K_zmin), 2.01));

            var K_z = inputD.K_z;
            var e = inputD.exp;
            var H = inputD.H;
            var f = inputD.f;
            if (H == 0) {
                inputD.K_h = Infinity;
            } else {
                inputD.K_h = parseFloat((Math.pow(e, f * z / H)));
                // alert('e=' + e + ', f=' + f + ', z=' + z + ', H=' + H);
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
                    inputD.K_zt = Math.pow(1 + K_e * K_t / K_h, 2);
                    break;

                case '5':
                    inputD.K_zt = '';
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

            var K_zt = inputD.K_zt;
            var K_d = inputD.K_d;
            var V = inputD.V;

            inputD.q_z = parseFloat((0.00256 * K_z * K_zt * K_d * (Math.pow(V, 2)) * I));
        }

    };

    if ($tree.node.link) {
        $scope.calculation.getConst();
    } else {
        $scope.calculation.getCalcData();
    }

    $scope.calculation.getCalcData();

    $scope.prmtrUpon = function (selectChange) {
        var inputD = $scope.calculation.inputData;
        switch (selectChange) {
            case 'expCAT':
                break;
            /*case 'expCAT':
                var curD = $scope.calculation.expCAT;
                for (var i = 0; i < curD.length; i++) {
                    if (curD[i].expCAT == inputD.expCAT) {
                        updateInputValue(curD[i], inputD);
                        break;
                    }
                }
                document.getElementById("table2-4").style.display = "inline";
                switch (inputD.expCAT) {
                    case 'B':
                        break;
                    case 'C':
                        break;
                    case 'D':
                        break;
                    default:
                        document.getElementById("table2-4").style.display = "none";
                        break;
                }
                break;*/

            case 'topCAT':

                // var curD = $scope.calculation.topCAT;
                // for (var i = 0; i < curD.length; i++) {
                //     if (curD[i].topCAT == inputD.topCAT) {
                //         document.getElementById("table2-5").style.display = "inline";
                //         inputD.K_t = (curD[i]['K_t'] == null || curD[i]['K_t'] == undefined) ? 0 : parseFloat(curD[i]['K_t']);
                //         inputD.f = (curD[i]['f'] == null || curD[i]['f'] == undefined) ? 0 : parseFloat(curD[i]['f']);
                //         break;
                //     }else{
                //         inputD.K_t = inputD.f = 0;
                //     }
                // }

                // document.getElementById("table2-5-tc1").style.display = "none";
                // document.getElementById("table2-5").style.display = "none";
                // document.getElementById("tf").style.display = "none";
                // document.getElementById("table2-5-tc5").style.display = "none";

                // alert(inputD.topCAT);
                // switch (inputD.topCAT) {
                //     case '1':
                //     document.getElementById("table2-5-tc1").style.display = "inline";
                //         // document.getElementById("tf").style.display = "inline";
                //         break;

                //         case '2':
                //         case '3':
                //         case '4':
                //         document.getElementById("table2-5").style.display = "inline";
                //         document.getElementById("tf").style.display = "inline";
                //         break;

                //         case '5':
                //         document.getElementById("table2-5-tc5").style.display = "inline";
                //         // document.getElementById("tf").style.display = "inline";
                //         break;

                //         default:
                //         break;
                //     }

                // $scope.calculation.change('K_h');
                break;

            case 'str_type':

                document.getElementById("cros_sec_type").style.display = "none";

                switch (inputD.str_type) {
                    case 'Latticed':
                    case 'latticed':
                    case 'guyed_mast':
                        document.getElementById("cros_sec_type").style.display = "inline";
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
                console.log($scope.calculation);
                //var loadCase = $scope.calculation.loadCase,
                //    I_mptc = 0;
                break;
            default:
                break;
        }
    }

    function updateValue(curObj, inputD) {
        for (var filed in curObj) {
            curObj[filed] = inputD[filed] ? inputD[filed] : curObj[filed];
        }
        return curObj;
    }

    function updateInputValue(curObj, inputD) {
        var floatNum = new RegExp('^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$');
        for (var filed in curObj) {
            if (curObj[filed] == null || curObj[filed] == undefined) {
                inputD[filed] = 0;
            } else if (floatNum.test(curObj[filed])) {
                inputD[filed] = parseFloat(curObj[filed])
            }
        }
    }
});
var dbFileUrl = './../../../api/request.php', constFile = '../CodeInfo-TIA-222.json';
