var app = angular.module('WindLoad4D', ['ngAnimate', 'ngSanitize', 'ngTouch', "ngAlertify"]);

app.factory("handler", function ($q) {
    return {
        success: function (response) {
            return response.data;
        },
        error: function (response) {
            if (!angular.isObject(response.data) || !response.data.message) {
                return $q.reject("An unknown error occurred.");
            }

            return $q.reject(response.data.message);
        }
    }
});

app.controller('wl_scController', function ($rootScope, $scope, $http, $window, $timeout, alertify) {
    var $parent = $window.parent.angular.element($window.frameElement).scope();

    let fromCalc = true;

    $scope.simplified = false;
    $scope.showPlot = false;
    $scope.infoPanel = false;

    $scope.parent = $parent;
    webgl.run("#webgl", "wid");
    webgl.changeViewSettingsWID({
        planeXY: false,
        planeYZ: false,
        planeZX: true,
        nodes: true,
        nodesName: true,
        wireframe: true,
        wireframeName: true,
        members: true,
        edges: false,
        // sky_box: 'skybox01',
        // terrain: 'grass/grass.jpg'
    });
    $scope.configAccess = document.getElementById('iframeId').getAttribute('debug');

    if($parent) {

        // Extends $scope
        $parent.$reference($scope, $rootScope, {
            static: {
                const: "ALL/code/TIA/222/G/WL/SC/wl_sc.json",
                dbName: "wl_sc"
            },
            files: {
                app: "wl_sc_files.php",
                path: "ALL/code/TIA/222/G/WL/SC"
            },
            document: document,
            calcApp: 'wl_sc',
            calcAppName: 'Wind Load on Structural Component'
        });
        var frameID = parseFloat(window.frameElement.getAttribute('id'));

        $scope.$watch("showPlot", function () {
            $parent.info.showAddBlock($scope.showPlot);
        });

    } else {

        $scope.config = {
            static: {
                const: "wl_sc.json",
                dbName: "wl_sc"
            },
            files: {
                app: "wl_sc_files.php",
                path: ""
            },
            document: document,
            calcApp: 'wl_sc',
            calcAppName: 'Wind Load on Structural Component'
        };

        fromCalc = false;

        $scope.calculation = {};

    }

    $scope.userData = {
        activeNotation: ''
    };


    $scope.showNotation = function(item) {
        if(item.notes) {
            $scope.userData.activeNotation = item.notes;
        } else {
            $scope.userData.activeNotation = '';
        }

    };


    $scope.infoToggle = function(state) {

        $scope.infoPanel = state;
        $scope.$applyAsync();

    };


    $scope.calculation.access = true;

    if($scope.configAccess != 'debug') {
        if (fromCalc) {
            $scope.calculation.access = true;
        } else {
            $scope.calculation.access = false;
        }
    }

    $scope.calculation.inputData = {};
    $scope.calculation.saveData = {};

    $scope.calculation.calcAppTable = 'wl_2d';

    $scope.calculation.input_src = 'web';

    $scope.newEquipment = {
        name: '',
        notes: ''
    };

    $scope.product = {};

    $scope.productList = [];
    $scope.newList = {};

    $scope.vpCalcList = [];

    //list of equipments for app without active calc like in table 'tia_222_g_wl_sc'
    $scope.calcEquipmentsList = [];

    //

    $scope.equipmentsList = [];
    $scope.equipmentsResetList = [];
    $scope.equipmentsActiveList = [];
    $scope.equipmentsVpCalcList = [];
    $scope.equipmentsIdaActiveList = [];

    $scope.loadingActiveVpCalc = '';
    $scope.design_ice_thk = 0;
    $scope.wind_dir = 0;

    $scope.loadingList = [];

    $scope.edited_equipment_row = 0;

    $scope.user_id = 0;

    if(fromCalc) {
        var frameID = parseFloat(window.frameElement.getAttribute('id'));

        if(Number.isInteger(frameID)) {
            $scope.calculation.pageAppNo = $parent.tree.combSelectedFrames[frameID].id;
        } else {
            $scope.calculation.pageAppNo = $parent.tree.node.id;
        }

        $scope.user_id = $parent.auth.data.id ? $parent.auth.data.id : 0;

        $parent.operation.getCalcData();
        $parent.operation.getConst();
    } else {

        $scope.calculation.getConst = function () {
            $http({
                method: 'GET',
                url: $scope.config.static.const
            }).then(function successCallback(response) {

                $scope.calculation.inputData = $scope.inputDataDft = response.data['Default'];

                $scope.Notation = response.data['Notation'];
                $scope.Unit = response.data['Unit'];
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

    $scope.getCodeInfoConsts = function() {
        $http({
            method: 'GET',
            url:  "./../../CodeInfo-TIA-222.json",
        }).then(function successCallback(response) {
            $scope.vp_units = response.data.Unit || {};
        });
    };

    $scope.getEquipmentInfo = function() {

        $scope.getVpCalcsList();

        $scope.getCodeInfoConsts();

        $http.get("request.php", {
            params: {
                method: "getProductsList"
            }
        }).success(function(response) {

            $scope.productList = response;

            $http.get("request.php", {
                params: {
                    user_id: $scope.user_id,
                    method: "getEquipment"
                }

            }).success(function (response_assoc) {

                $scope.equipmentsList      = angular.copy(response_assoc);
                $scope.equipmentsResetList = angular.copy(response_assoc);

                $scope.getEquipments();

                // $scope.models.geometry.reset.analysis = angular.copy(response);

            });

        });

    };

    $scope.changeAddEquipment = function (item, index, list) {

        var new_row = false;

        if(!list) {
            new_row = true;
        }

        if(list && list.id != $scope.edited_equipment_row) {
            new_row = true;
            $scope.edited_equipment_row = list.id;
        }

        if (item.select == null) {
            if (index) {
                $scope.equipmentsActiveList[index].association = angular.copy($scope.equipmentsResetList);
            } else {
                $scope.equipmentsList = angular.copy($scope.equipmentsResetList);
            }

            return false;
        }

        $scope.buildTabs(item, function (items, details) {
            if (index || index === 0) {
                $scope.equipmentsActiveList[index].association = items;
            } else {
                $scope.equipmentsList = items;
            }
        }, new_row);
    };

    $scope.updatewlda = function() {

        let calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        if(calcId) {
            $http.post("request.php", {
                method: "updatewlda",
                calcId: calcId,
                vp_calc:  $scope.loadingActiveVpCalc || 0,
                ice_thk:  $scope.design_ice_thk || 0,
                wind_dir: $scope.wind_dir || 0                
            }).success(function (response) {

            });
        }

    };

    $scope.addEquipment = function() {
        let selected = [];

        let calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        let unique = true;

        $scope.equipmentsActiveList.forEach(function(eq) {

            if(eq.name === $scope.newEquipment.name) {
                unique = false;
            }

        });

        if(!unique || $scope.newEquipment.name === '') {
            alertify.error('ID already in use');
            return false;
        }

        angular.forEach($scope.equipmentsList, function (association) {
            if(association.select) {
                selected.push({
                    id: association.select.id,
                    key: association.key,
                    value: association.select.value
                });
            }
        });

        $http.post("request.php", {
            method: "items",
            user_id: $scope.user_id,
            data: selected
        }).success(function (details) {

            if(details.data && details.data[0]) {

                let an_data =  {
                    calcPK: calcId,
                    db_pro_PK: details.data[0].id,
                    name: $scope.newEquipment.name,
                    notes: $scope.newEquipment.notes
                };

                let found = false;

                $scope.equipmentsActiveList.forEach(function(eqpt) {
                    if(eqpt.db_pro_PK == an_data.db_pro_PK) {
                        found = true;
                    }
                });

                if(!found) {
                    if(calcId) {
                        $http.post("request.php", {
                            method: "addEquipment",
                            data: an_data
                        }).success(function (response) {
                            if(response.error){
                                alertify.error(response.error);
                            }

                            $scope.getEquipments();
                            alertify.success("equipment successfully added");
                        });

                    } else {

                        an_data.id = ($scope.calcEquipmentsList.length + 1);

                        $scope.calcEquipmentsList.push(an_data);

                        $scope.generateEqActiveList($scope.calcEquipmentsList);

                    }
                } else {
                    alertify.error('DA already added!');
                }

            }

        });

    };

    $scope.updateList = function(list){

        let eqID = 0;

        $scope.equipmentsActiveList.forEach(function(item) {
            if(list.tia_222_g_wl_sc_lib_PK === item.eqpt_id) {
                eqID = item.db_pro_PK;
            }
        });

        let listData = {
            db_pro_PK: eqID,
            frt_azm  : list.frt_azm,
            ctr_elev : list.ctr_elev,
            ice_thk  : list.ice_thk,

            q_z: list.q_z,
            g_h: list.g_h,
            k_a: list.k_a,
            epa_a: list.epa_a,
            dwf: list.dwf,

            quantity : list.quantity,
            units: $scope.Unit,
            vp: {calc_id: $scope.loadingActiveVpCalc || '', units: $scope.vp_units},
            design_ice_thk: $scope.design_ice_thk || '',
            wind_dir: $scope.wind_dir || 0
        };

        $http.post("request.php", {
            method: "getListForEquipment",
            data: listData
        }).success(function (response) {

            if(response.error){
                alertify.error(response.error);
            } else {

                list.frt_azm =  response.frt_azm ? response.frt_azm : 0;
                list.ctr_elev = response.ctr_elev ? response.ctr_elev : 0;
                list.ice_thk =  response.ice_thk ? response.ice_thk : 0;
                list.q_z =      response.q_z ? response.q_z : null;
                list.g_h =      response.g_h ? response.g_h : 0;
                list.k_a =      response.k_a ? response.k_a : 0;
                list.epa_a =    response.epa_a ? response.epa_a : 0;
                list.dwf =      response.dwf ? response.dwf : 0;
                list.quantity = response.quantity ? response.quantity : 1;

                $http.post("request.php", {
                    method: "updateList",
                    data: list
                }).success(function (response) {
                    if(response.error){
                        alertify.error(response.error)
                    } else {
                        alertify.success('list updated');
                        list.change = false;
                    }
                })

            }

        });


    };

    $scope.removeList = function(list){
        $http.post("request.php", {
            method: "removeList",
            data: list
        }).success(function (response) {

            if(response.error){
                alertify.error(response.error)
            } else {
                alertify.success('List successfully removed')
            }
            list.change = false;

        })
    };

    $scope.prepareDefaultNewList = function(){
        $scope.newList = {
            tia_222_g_wl_sc_PK: equipment.tia_222_g_wl_sc_PK,
            tia_222_g_wl_sc_lib_PK: equipment.tia_222_g_wl_sc_lib_PK,
            selectedEq: '',
            frt_azm: 0,
            ctr_elev: 0,
            ice_thk: '',
            q_z: '',
            name: '',
            epa_a: '',
            dwf: '',
            g_h: 0.95,
            k_a: 1,
            quantity: 1,
            faces: []
        }
    };

    $scope.prepareDefaultNewList();

    $scope.prepareListForEquipment = function(equipment, newList){
        console.log('equipment: '); console.log(equipment);

        // get the Units in CodeInfo-TIA-222.json if neither 'vp_calc_id' nor 'design_ice_thk' is empty. 
        // $scope.vp_units <-- 

        // if($scope.loadingActiveVpCalc && $scope.design_ice_thk) {
        //     $scope.vp_units = $scope.codeUnits;
        // }else{
        //     $scope.vp_units
        // }

        let unique = true;

        $scope.equipmentsIdaActiveList.forEach(function(loading) {

            if(loading.name === newList.name) {
                unique = false;
            }

        });

        if(!unique || newList.name === '') {
            alertify.error('Name already in use');
            return false;
        }

        if(!newList.q_z && !$scope.loadingActiveVpCalc) {
            alertify.error('Valid value for q_z is required if no q_z calc is selected.');
            return false;
        }

        let listData = {
            db_pro_PK: equipment.db_pro_PK,
            frt_azm  : newList.frt_azm,
            ctr_elev : newList.ctr_elev,
            ice_thk  : newList.ice_thk,

            q_z: newList.q_z,
            g_h: newList.g_h,
            k_a: newList.k_a,
            epa_a: newList.epa_a,
            dwf: newList.dwf,

            quantity : newList.quantity,
            units: $scope.Unit,
            vp: {calc_id: $scope.loadingActiveVpCalc || '', units: $scope.vp_units},
            design_ice_thk: $scope.design_ice_thk || '',
            wind_dir: $scope.wind_dir || 0
        };

        $http.post("request.php", {
            method: "getListForEquipment",
            data: listData
        }).success(function (response) {
            if(response.error){
                alertify.error(response.error);
                $scope.newList.tia_222_g_wl_sc_PK     = equipment.tia_222_g_wl_sc_PK;
                $scope.newList.tia_222_g_wl_sc_lib_PK = equipment.tia_222_g_wl_sc_lib_PK;
            } else {
                console.log('response: ');
                console.log(response);
                $scope.newList = {
                    tia_222_g_wl_sc_PK:     equipment.tia_222_g_wl_sc_PK,
                    tia_222_g_wl_sc_lib_PK: equipment.tia_222_g_wl_sc_lib_PK,

                    // name:     equipment.name,
                    selectedEq: equipment.name,

                    name:     newList.name ? newList.name : '',

                    status:   newList.status ? newList.status : '',

                    frt_azm:  response.frt_azm ? response.frt_azm : 0,
                    ctr_elev: response.ctr_elev ? response.ctr_elev : 0,
                    ice_thk:  response.ice_thk ? response.ice_thk : 0,
                    q_z:      response.q_z ? response.q_z : null,
                    g_h:      response.g_h ? response.g_h : 0,
                    k_a:      response.k_a ? response.k_a : 0,
                    epa_a:    response.epa_a ? response.epa_a : 0,
                    dwf:      response.dwf ? response.dwf : 0,
                    quantity: response.quantity ? response.quantity : 1
                };

                $scope.newList.faces = [];

                if(response.faces){
                    response.faces.forEach(function(face){
                        $scope.newList.faces.push({
                            face_shape:   face.shape,
                            inclusion:    '',
                            face_name:    face.name,
                            face_azm:     face.azimuth.value,
                            exposed:      face.exposure,
                            p_a:          face.P_A_A_A.value,
                            aspect_ratio: face.ar,
                            c_a:          face.C_a,
                            epa_a:        face.EPA_A.value
                        })
                    });
                }

                $scope.insertList($scope.newList);
            }
        })
    };

    $scope.changeListRow = function(list, value) {

        list.change = true;

        switch(value) {
            case 'frt_azm':
                list.q_z = null;
                list.epa_a = null;
                list.dwf = null;
                break;
            case 'ctr_elev':
                list.ice_thk = null;
                list.q_z = null;
                list.epa_a = null;
                list.dwf = null;
                break;
            case 'ice_thk':
                list.q_z = null;
                list.epa_a = null;
                list.dwf = null;
                break;
            case 'q_z':
                list.epa_a = null;
                list.dwf = null;
                break;
            case 'g_h':
                list.epa_a = null;
                list.dwf = null;
                break;
            case 'k_a':
                list.epa_a = null;
                list.dwf = null;
                break;
            case 'epa_a':
                list.dwf = null;
                break;
            case 'dwf':
                list.frt_azm = '-';
                list.ctr_elev = '-';
                list.ice_thk = '-';
                list.q_z = '-';
                list.g_h = '-';
                list.k_a = '-';
                list.epa_a = '-';
                break;
        }

    };

    $scope.recalcListRow = function(list){

        list.vp_calc_id     = $scope.loadingActiveVpCalc || '';
        list.design_ice_thk = $scope.design_ice_thk || 0;
        list.wind_dir       = $scope.wind_dir || 0;

        $http.post("request.php", {
            method: "recalcListRow",
            list: list
        }).success(function (response) {
            if(response.error){
                alertify.error(response.error);
            } else {
                if(response){
                    list.frt_azm = response.frt_azm || list.frt_azm;
                    list.ctr_elev = response.ctr_elev || list.ctr_elev;
                    list.ice_thk  = response.ice_thk || list.ice_thk;
                    list.q_z = response.q_z || list.q_z;
                    list.g_h = response.g_h || list.g_h;
                    list.k_a = response.k_a || list.k_a;                    
                    list.epa_a = response.epa_a.value || list.epa_a;
                    list.dwf = response.dwf.value || list.dwf;
                }
            }
        })
    };

    $scope.insertList = function(newList){
        console.log(newList);

        var calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        if(calcId) {
            $http.post("request.php", {
                method: "insertList",
                data: newList
            }).success(function (response) {

            if(response.status){
                newList.id = response.id;
                newList.createdOn = response.createdOn;

                $scope.equipmentsIdaActiveList.push(angular.copy(newList));
                alertify.success('Loading added');

                $scope.prepareDefaultNewList();

            } else {
                alertify.error(response.error);
            }

            })
        } else {

            newList.id = $scope.equipmentsIdaActiveList.length + 1;

            $scope.equipmentsIdaActiveList.push(angular.copy(newList));
            alertify.success('Loading added');

            $scope.prepareDefaultNewList();

        }

    };

    $scope.removeList = function(list){
        $http.post("request.php", {
            method: "removeList",
            listId: list.id
        }).success(function (response) {

            let index = $scope.equipmentsIdaActiveList.indexOf(list);
            $scope.equipmentsIdaActiveList.splice(index, 1);

            if(response.status){
                alertify.success('list successfully removed');
            } else {
                alertify.error(response.error);
            }

        })
    };

    $scope.selectList = function(list){

        var calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        if(calcId) {
            $scope.activeList = false;
            $http.post("request.php", {
                method: "getFacesForList",
                listId: list.id
            }).success(function (response) {
                list.faces = response.faces;

                if(response.faces.length){
                    $scope.activeList = {
                        'name': list.name,
                        'faces': response.faces
                    }
                } else {
                    // if there is no saved faces, add code to call DA_faces_array.php
                    // to generate the faces.


                    alertify.error('no saved faces for this list');
                }
            });
        } else {
            if(list.faces.length) {
                $scope.activeList = {
                    'name': list.name,
                    'faces': list.faces
                }
            }
        }

    };

    $scope.changeIceThickness = function () {
        if($scope.design_ice_thk) {
            $scope.equipmentsIdaActiveList.forEach(function(ida){
                ida.ice_thk = $scope.design_ice_thk;
            });
        }
    };

    $scope.updateEquipment = function(equipment){
        console.log(equipment);
        let tempEquipment = {
            id: equipment.eqpt_id,
            name: equipment.name,
            db_pro_PK: equipment.db_pro_PK,
            notes: equipment.notes
        };
        $http.post("request.php", {
            method: "updateEquipment",
            equipment: tempEquipment
        }).success(function (response) {
            if(response.status){
                alertify.success('equipment successfully updated');
            } else {
                alertify.error(response.error);
            }
            equipment.change = false;
        });
    };

    $scope.removeEquipment = function (index, id) {

        $http.post('request.php', {
            method: "removeEquipment",
            id: id
        }).success(function(response) {
            if(response.error){
                alertify.error(response.error)
            } else {
                $scope.calcEquipmentsList.forEach(function(eq, key) {
                    if(eq.id == id) {
                        $scope.calcEquipmentsList.splice(key, 1);
                    }
                });

                $scope.equipmentsActiveList.splice(index, 1);
                alertify.success('equipment successfully removed')
            }
        });

    };

    $scope.getEquipments = function() {

        var calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        $scope.getLoading();

        if(calcId) {

            $http.get("request.php", {
                params: {
                    method: "getCalcEquipment",
                    calcPK: calcId
                }
            }).success(function (response_data) {

                console.log(response_data);

                $scope.loadingActiveVpCalc = response_data.tia_222_g_wl_sc_PK[0].vp_calc;
                $scope.design_ice_thk = response_data.tia_222_g_wl_sc_PK[0].ice_thk;

                $scope.generateEqActiveList(response_data.tia_222_g_wl_sc_lib_PK);

                $scope.generateVpCalcList(response_data.tia_222_g_wl_sc_PK);

                $scope.generateIdaActiveList(response_data.tia_222_g_wl_ida);

                    // $scope.generateProdList(response_data.db_product);
                    // $scope.generateProdList(response_data.da);

                    // $scope.generateAsctnList(response_data.db_pro_asctn);
                    //
                    // $scope.generateWaList(response_data.db_pro_wa);
                });
        }
    };

    $scope.generateVpCalcList = function (response_data) {
        var products_VpCalc = [];

        response_data.forEach(function (product) {
            var tmp = {};

            tmp.vp_calc = product.vp_calc;
            tmp.ice_thk = product.ice_thk;
            products_VpCalc.push(tmp);
        });

        $scope.equipmentsVpCalcList = products_VpCalc;
    };

    $scope.generateEqActiveList = function(response_data) {
        var products_analys = [];

        $scope.productList.forEach(function (item) {
            if(response_data){
                response_data.forEach(function (product) {

                    if (item.id == product.db_pro_PK) {
                        var tmp = angular.copy(item);
                        tmp.name = product.name;
                        tmp.notes = product.notes;
                        tmp.eqpt_id = tmp.tia_222_g_wl_sc_lib_PK = product.id;
                        tmp.db_pro_PK = product.db_pro_PK;
                        tmp.tia_222_g_wl_sc_PK = product.tia_222_g_wl_sc_PK;
                        tmp.createdOn = product.createdOn;

                        products_analys.push(tmp);
                    }
                })
            }
        });

        $scope.equipmentsActiveList = products_analys;

        $scope.equipmentsActiveList.sort(function(a,b){
            return new Date(a.createdOn) - new Date(b.createdOn);
        });


        angular.forEach($scope.equipmentsActiveList, function (list) {
            list.association = angular.copy($scope.equipmentsResetList);

            angular.forEach(list.association, function (association) {
                if (list[association.key] != undefined) {
                    angular.forEach(association.data, function (data) {
                        if (data.value == list[association.key]) {
                            association.select = data;
                        }
                    });
                }
            });
        });
    };

    $scope.generateIdaActiveList = function (response_data) {
        var products_IdaActiveList = [];

        if(response_data){
            response_data.forEach(function (product) {
                var tmp = {};
                tmp.id = product.id;
                tmp.name = product.name;
                tmp.status = product.status;
                tmp.ctr_elev = product.ctr_elev;
                tmp.dwf = product.dwf;
                tmp.epa_a = product.epa_a;
                tmp.frt_azm = product.frt_azm;
                tmp.g_h = product.g_h;
                tmp.ice_thk = product.ice_thk;
                tmp.k_a = product.k_a;
                tmp.q_z = product.q_z;
                tmp.quantity = product.quantity;
                tmp.createdOn = product.createdOn;

                $scope.equipmentsActiveList.forEach(function(eqpt) {
                    if(eqpt.eqpt_id == product.tia_222_g_wl_sc_lib_PK) {
                        tmp.tia_222_g_wl_sc_lib_PK = product.tia_222_g_wl_sc_lib_PK;
                        tmp.db_pro_PK = eqpt.db_pro_PK;
                    }
                });

                products_IdaActiveList.push(tmp);
                // console.log('idaActiveList: ', product);
            });
        }

        $scope.equipmentsIdaActiveList = products_IdaActiveList;
    };

    // $scope.generateProdList = function (response_data) {
    //     console.log(response_data);
    // }
    // $scope.generateAsctnList = function (response_data) {
    //     console.log(response_data);
    // }
    // $scope.generateWaList = function (response_data) {
    //     console.log(response_data);
    // }
    $scope.generateProdList = function (response_data) {
        // console.log(response_data);
    };

    $scope.getLoading = function () {

        var calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        if(calcId) {

            $http.get("request.php", {
                params: {
                    method: "getLoading",
                    calcPK: calcId
                }
            }).success(function (response) {
                $scope.loadingList = [];

                response.forEach(function(item) {
                    var found = false;

                    $scope.loadingList.forEach(function(list_item) {
                        if(list_item.eq_id == item.tia_222_g_wl_ida_PK) {
                            found = true;

                            list_item.loadings.push(item);
                        }
                    });

                    if(!found) {
                        $scope.loadingList.push({
                            eq_id: item.tia_222_g_wl_ida_PK,
                            name: item.name,
                            loadings: [item]
                        });
                    }
                });

            })

        }

    };

    $scope.updateLoadingFace = function (facerow) {
        // facerow.inclusion = +item.inclusion;
        $http.post("request.php", {
            method: "updateLoadingFace",
            data: facerow
        }).success(function (response) {

            facerow.change = false;

        })
        
    };

    $scope.buildTabs = function (current, callback, new_row) {
        if (angular.isFunction(callback)) {
            var selected = {
                key: current.key,
                value: current.select ? current.select.value : null,
                last: true
            };

            if(new_row) {
                $scope.product.selected = [];
                $scope.product.selected.push(selected);
            } else {
                var found = false;

                angular.forEach($scope.product.selected, function (item, index) {
                    if (item.key != current.key || item.lastCustom == false) {
                        item.last = false;
                    } else {
                        $scope.product.selected.splice(index+1, 5);
                        item.last = true;
                        item.value = current.select.value;
                        found = true
                    }
                });

                if(!found && selected.value) $scope.product.selected.push(selected);
            }


            $http.post('request.php', {
                method: "sortEq",
                user_id: $scope.user_id,
                data: $scope.product.selected
            }).success(function(items) {

                angular.forEach(items, function (item) {
                    item.data.forEach(function (data) {
                        var exit = false;
                        $scope.product.selected.forEach(function(selected){
                            if (data.value == selected.value && data.id != 'new') {
                                item.select = data;
                                exit = true;
                                return false;
                            }
                        });
                        if(exit) return false;
                    });

                    if (item.data.length == 1) {
                        item.select = item.data[0];
                    }

                });

                $http.post('request.php', {
                    method: "items",
                    user_id: $scope.user_id,
                    data: $scope.product.selected
                }).success(function(details) {
                    callback.call({}, items, details);
                });
            });

}
};

    $scope.getVpCalcsList = function() {

        let calcId = ($parent.calc.current && $parent.calc.current.RcdNo) ? $parent.calc.current.RcdNo : 0;

        $scope.vpCalcList = [];
        $scope.loadingActiveVpCalc = '';

        if(calcId) {

            $http.post("request.php", {
                method: "getVPcalcsList",
                calcId: calcId
            }).success(function(response) {
                if(response.error) {
                    alertify.error(response.error);
                } else {
                    $scope.vpCalcList = response.data;
                }
            });

        }
    };

    $scope.getEquipmentInfo();

    if(fromCalc) {

        $parent.$watch("calc.current.RcdNo", function () {
            $scope.getEquipmentInfo();
        });

        $parent.$watch("auth.data.id", function () {
            $scope.user_id = $parent.auth.data.id ? $parent.auth.data.id : 0;

            $scope.getEquipmentInfo();
        });

    }


    $scope.saveForNewCalc = function (newCalcPK, callback) {
        if(newCalcPK) {

            $http.post("request.php", {
                newCalcPK: newCalcPK,
                equipments: $scope.equipmentsActiveList,
                loadings: $scope.equipmentsIdaActiveList,
                method: "saveAllForNewCalc"
            }).success(function (response) {

                console.log('saveAllForNewCalc: ', response);

                if(callback) {
                    callback();
                }

            });
        }

    };

    $scope.calculation.customCall = function (newCalcPK, callback) {
        $scope.saveForNewCalc(newCalcPK, callback);
    };

    $scope.calculation.change = function (whatschanged) {
        var change_option = 'php';

        if($parent) {
            $parent.info.showAddBlock($scope.showPlot);
        }

        switch (change_option) {
            case 'js':
            break;

            case 'php':

            $http.get("request.php", {
                params: {
                    app: "ALL/code/TIA/222/G/WL/DA/calculations/wl_sc_change.php",
                    data: $scope.calculation.inputData,
                    unit: $scope.Unit,
                    extra: {
                        table: $scope.Data.tableValues
                    },
                    whatschanged: whatschanged
                }

            }).success(function (response) {

                    // $.each(response.web, function(key, value) {
                    //     if(typeof value === 'object'){
                    //         if($scope.formatOfParameters.object.fixed4.indexOf(key) != -1){
                    //             $scope.calculation.inputData[key] = isNumeric(value['value']) ? parseFloat(value['value']).toFixed(4) : value['value'];
                    //
                    //         }else{
                    //             $scope.calculation.inputData[key] = isNumeric(value['value']) ? parseFloat(value['value']).toFixed(2) : value['value'];
                    //         }
                    //     }else{
                    //         if($scope.formatOfParameters.wholeValue.indexOf(key) != -1){
                    //             $scope.calculation.inputData[key] = value;
                    //         }else{
                    //             $scope.calculation.inputData[key] = isNumeric(value) ? parseFloat(value).toFixed(2) : value;
                    //         }
                    //     }
                    // });
                    //
                    // $scope.calculation.saveData = $scope.calculation.inputData;
                    // $scope.calculation.saveData.pageAppNo = $scope.calculation.pageAppNo;
                    //
                    // var inputD = response;
                    //
                    // $scope.drawPlot(response.plot);
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

    $scope.calculation.info = function (selector) {
        $parent.info.open("ALL/code/TIA/222/G/WL/DA/wl_sc_knowledge.html", selector);
    };

    $scope.infoToggle = function() {

};

});
