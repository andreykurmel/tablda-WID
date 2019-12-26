app.controller("Base", function ($scope, $rootScope, $timeout, $window, $http, Auth) {
    // TODO: Base

    $scope.auth = Auth;
    $scope.auth.state = '';
    $scope.auth.loginShow = true;
    $scope.auth.doorHide = true;

    $scope.base = {};
    $scope.base.loader = true;
    $scope.base.toggleSettingsMenu = false;

    $scope.base.showNodeInfo = false;
    $scope.base.nodeInfo = {
        x: 0,
        y: 0,
        z: 0
    };

    $scope.base.selectedMember = null;
    $scope.base.selectedMemberMesh = null;
    $scope.base.showAddEqPanel = false;
    $scope.base.showMemberInfo = false;
    $scope.base.showAssocInfo = false;

    $scope.base.memberInfo = {};
    $scope.base.assocInfo = '';
    $scope.base.selectedEqId = '';
    $scope.base.selectedLcId = '';
    $scope.base.selectedLc = null;

    $scope.base.lcInfo = {
        azm: '',
        rad: ''
    };
    $scope.base.statusInfo = '';
    $scope.base.nodeStartInfo = '';
    $scope.base.nodeFinishInfo = '';

    $scope.base.showNodeDistanceInfo = false;
    $scope.base.nodeDistanceInfo = [
        {
            name: 'n1',
            distance: 15.0
        },
        {
            name: 'n2',
            distance: 5.0
        }
    ];

    $scope.selectedProduct = '';
    $scope.selectedGeometry = '';

    // TODO: Root event
    $rootScope.$on("loading:progress", function () {
        if ($scope.base.loader) {
            $scope.base.loader = true;
        }
    });

    $rootScope.$on("loading:finish", function () {
        var timer = $timeout(function () {
            $scope.base.loader = false;
            $timeout.cancel(timer);
        }, 250);
    });

    // TODO: Run webgl
    webgl.run("#webgl", "wid");
});

app.controller("Models", function ($scope, $window, request, $compile, $timeout, Head, Foot, $http, handler) {
    $scope.userLoadInfo = {
        userIds: [],
        privateId: '',
        shared: true,
        private: false
    };

    $scope.cameraSettings = {};

    $scope.cameraSettings.position = {
        x: -5,
        y: 8,
        z: 6
    };

    $scope.cameraSettings.changePosition = function () {
        webgl.changeCameraPosition($scope.cameraSettings.position);
    };

    $scope.viewSettings = {
        planeXY: false,
        planeYZ: false,
        planeZX: true,
        nodes: true,
        nodesName: true,
        wireframe: true,
        wireframeName: true,
        members: true,
        objects: true,
        edges: false,
        skyboxColor: '#ffffff',
        terrainColor: '#ffffff',
        defaultAngle: false,
        showLabelsEqpt: false,
        fontSize: 20,
        frameScale: 1
    };

    $scope.skyBoxOptions = [
        {
            name: 'sunny',
            value: 'skybox01'
        },
        {
            name: 'dawn',
            value: 'skybox02'
        }
    ];

    $scope.terrainOptions = [
        {
            name: 'grass',
            src: 'grass/grass.jpg'
        },
        {
            name: 'gravel',
            src: 'gravel/gravel.jpg'
        }
    ];

    $scope.singleObjectsConfig = {

        'FlatPanel': {
            'd1': {
                show: true,
                exp: 'Height',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Width',
                units: 'd'
            },
            'd3': {
                show: true,
                exp: 'Depth',
                units: 'd'
            },
            'd4': {
                show: true,
                exp: 'CSCH',
                units: 'd'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'Cuboid': {
            'd1': {
                show: true,
                exp: 'Height',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Width',
                units: 'd'
            },
            'd3': {
                show: true,
                exp: 'Depth',
                units: 'd'
            },
            'd4': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'Cylinder': {
            'd1': {
                show: true,
                exp: 'Height',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Diameter',
                units: 'd'
            },
            'd3': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd4': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'Sphere': {
            'd1': {
                show: true,
                exp: 'Diameter',
                units: 'd'
            },
            'd2': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd3': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd4': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'CylinderDishShroud': {
            'd1': {
                show: true,
                exp: 'Diameter',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Thickness',
                units: 'd'
            },
            'd3': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd4': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'ConicalDishShroud': {
            'd1': {
                show: true,
                exp: 'Diameter',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Thickness',
                units: 'd'
            },
            'd3': {
                show: true,
                exp: 'Conical Height',
                units: 'd'
            },
            'd4': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'DishRadom': {
            'd1': {
                show: true,
                exp: 'Diameter',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Radom Height',
                units: 'd'
            },
            'd3': {
                show: true,
                exp: 'Thickness',
                units: 'd'
            },
            'd4': {
                show: true,
                exp: 'Conical Height',
                units: 'd'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        },
        'ParabolicGridDish': {
            'd1': {
                show: true,
                exp: 'Width',
                units: 'd'
            },
            'd2': {
                show: true,
                exp: 'Height',
                units: 'd'
            },
            'd3': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd4': {
                show: false,
                exp: '-',
                units: '-'
            },
            'd5': {
                show: false,
                exp: '-',
                units: '-'
            },
            'w': {
                show: true,
                exp: 'w/',
                units: 'weight'
            },
            'wo': {
                show: true,
                exp: 'w/o',
                units: 'weight'
            }
        }

    };

    $scope.gridViewSettings = {
        size: '1ft',
        shrink: 0
    };

    $scope.shrinkChange = function () {
        $scope.models.geometry.drawWholeGeometry();
    };

    $scope.fontSizeChange = function () {

        console.log('fontSizeChange');

        // $scope.models.geometry.drawWholeGeometry();

    };

    $scope.sortDirections = {
        'status': 'asc'
    };

    $scope.sortArrayByField = function (array, field, sortDirection) {
        let reverse = true;

        if ($scope.sortDirections[field]) {
            reverse = $scope.sortDirections[field] !== 'asc';
            $scope.sortDirections[field] = $scope.sortDirections[field] === 'asc' ? 'desc' : 'asc';
        }

        if (array && array.length > 1) {

            if (!reverse) {
                array.sort(function (a, b) {
                    if (a[field] > b[field]) {
                        return 1;
                    }
                    if (a[field] < b[field]) {
                        return -1;
                    }

                    return 0;
                });
            }
            else {
                array.sort(function (a, b) {
                    if (a[field] < b[field]) {
                        return 1;
                    }
                    if (a[field] > b[field]) {
                        return -1;
                    }

                    return 0;
                });
            }
        }
    };

    $scope.publicUsersID = [];

    $scope.infoPanel = false;
    $scope.infoPanelDetailsPanel = false;

    $scope.detailsFilter = {};
    $scope.viewByStatusPanel = {};
    $scope.viewByStatusColor = {};

    $scope.detailsFilter.enabled = false;
    $scope.detailsFilter.filters = {
        "Existing": true,
        "Proposed": true,
        "Rlctd": true,
        "Reserved": true,
        "Future": true,
        "TbRlctd": true,
        "TbRmvd": true
    };

    $scope.detailsFilter.viewAll = true;

    $scope.detailsFilter.changeViewAll = function () {
        if ($scope.detailsFilter.viewAll) {
            $scope.models.geometry.lc_analysis_active_details_list = $scope.models.geometry.lc_analysis_active_details_reset_list;
            for (let key in $scope.detailsFilter.filters) {
                $scope.detailsFilter.filters[key] = true;
            }
        }
        else {
            for (let key in $scope.detailsFilter.filters) {
                $scope.detailsFilter.filters[key] = false;
            }
            $scope.models.geometry.lc_analysis_active_details_list = [];
        }
    };

    $scope.detailsFilter.getReadyDetailsFilter = function (lcs) {
        $scope.detailsFilter.filters = {};

        lcs.forEach(function (lc) {
            if ($scope.detailsFilter.filters[lc.status] === undefined) {
                $scope.detailsFilter.filters[lc.status] = true;
            }
        });
    };

    $scope.$watch("detailsFilter.enabled", function () {
        if (!$scope.detailsFilter.enabled) {
            $scope.models.geometry.lc_analysis_active_details_list = $scope.models.geometry.lc_analysis_active_details_reset_list;
        }
        else {
            let newLCArray = [];
            angular.forEach($scope.models.geometry.lc_analysis_active_details_reset_list, function (lc) {
                for (let keyFilter in $scope.detailsFilter.filters) {
                    if ($scope.detailsFilter.filters[keyFilter] && keyFilter === lc.status) {
                        newLCArray.push(lc);
                    }
                }
            });
            $scope.models.geometry.lc_analysis_active_details_list = newLCArray;
        }
    });

    $scope.detailsFilter.changeFilter = function (key) {
        if (!$scope.detailsFilter.filters[key]) {
            $scope.detailsFilter.viewAll = false;
        }
        else {
            for (let keyFilter in $scope.detailsFilter.filters) {
                if ($scope.detailsFilter.filters[keyFilter] === false) {
                    $scope.detailsFilter.viewAll = false;
                    break;
                } else $scope.detailsFilter.viewAll = true;
            }

            $scope.models.geometry.lc_analysis_active_details_list = $scope.models.geometry.lc_analysis_active_details_reset_list;
        }

        let newLCArray = [];
        angular.forEach($scope.models.geometry.lc_analysis_active_details_reset_list, function (lc) {
            for (let keyFilter in $scope.detailsFilter.filters) {
                if ($scope.detailsFilter.filters[keyFilter] && keyFilter === lc.status) {
                    newLCArray.push(lc);
                }
            }
        });
        $scope.models.geometry.lc_analysis_active_details_list = newLCArray;
    };

    $scope.viewByStatusPanel.changeFilter = function () {
        $scope.models.geometry.drawWholeGeometry();
    };

    $scope.viewByStatusPanel.getReadyViewByStatusPanelFilter = function (lcs) {
        $scope.viewByStatusPanel.filters = {};

        lcs.forEach(function (lc) {
            if (lc.lc) {
                if ($scope.viewByStatusPanel.filters[lc.lc.status] === undefined) {
                    $scope.viewByStatusPanel.filters[lc.lc.status] = true;
                }
            } else {
                if ($scope.viewByStatusPanel.filters[lc.status] === undefined) {
                    $scope.viewByStatusPanel.filters[lc.status] = true;
                }
            }
        });
    };

    $scope.viewByStatusPanel.showPanel = false;
    $scope.viewByStatusPanel.filters = {};

    $scope.viewByStatusColor.enabled = false;
    $scope.viewByStatusColor.colors = {
        "Existing": '#e8a05f',
        "Proposed": '#80ff7f',
        "Rlctd": '#cccccc',
        "Reserved": '#ff4dab',
        "Future": '#424448',
        "TbRlctd": '#cc6dff',
        "TbRmvd": '#a5acff'
    };

    $scope.viewByStatusColor.switch = function () {
        $scope.viewByStatusColor.enabled = !$scope.viewByStatusColor.enabled;
        $scope.models.geometry.drawWholeGeometry();
    };

    $scope.viewByStatusColor.changeColorForEquipment = function (status) {
        return $scope.viewByStatusColor.colors[status];
    };

    $scope.infoResolve = '';
    $scope.infoResolveDetailsPanel = '';

    $scope.infoBlocksForGeoTabs = {
        materials: '#materials',
        sections: '#sections',
        nodes: '#nodes',
        members: '#members',
        connections: '#connections',
        documents: '#geo_doc',
        association: '#geo_association',
        analysis: '#analysis'
    };

    $scope.usersList = [];

    $scope.publicAccess = function () {

        $scope.publicUsersID = [];

        $scope.usersList.forEach(function (user) {

            if (user.check) {
                $scope.publicUsersID.push('' + user.id);
            }

        });

        if ($scope.models.product.settings.shared) {

            $scope.userLoadInfo.userIds = [];

            $scope.publicUsersID.forEach(function (item) {
                $scope.userLoadInfo.userIds.push(item);
            });

            $scope.models.product.formSearchList();
            $scope.models.geometry.formSearchList();
            // $scope.models.site.formSearchList();

            $scope.query.resetProduct();
            $scope.query.resetGeometry();
            $scope.query.resetSite();

        }


    };

    $scope.showInfo = function (selector, where) {

        var app = "wid_knowledge.html";

        var shared_selectors = [
            {
                selector: '.shared',
                position: 'bottom'  // bottom / top
            }
        ];

        if (where == 'geometry_tabs') {
            selector = [$scope.infoBlocksForGeoTabs[$scope.models.geometry_tabs]];
        }

        // if(where == 'geometry_tabs') {
        //     selector = [$scope.infoBlocksForGeoTabs[$scope.models.geometry_tabs]];
        // }

        $http.get(app).success(function (html) {

            var temp_html = '';

            var container = document.createElement("div");
            var element = angular.element(container).html(html);


            if (shared_selectors) {
                shared_selectors.forEach(function (share) {
                    if (share.position == 'top') {
                        temp_html += element.find(share.selector).html();
                    }
                });
            }

            if (Array.isArray(selector)) {
                selector.forEach(function (item) {
                    temp_html += element.find(item).html();
                })
            } else {
                temp_html += element.find(selector).html();
            }

            if (shared_selectors) {
                shared_selectors.forEach(function (share) {
                    if (share.position == 'bottom') {
                        temp_html += element.find(share.selector).html();
                    }
                });
            }

            $scope.currBlock = {
                selector: selector,
                where: where
            };

            if (where == 'details_panel') {
                $scope.infoPanelDetailsPanel = !$scope.infoPanelDetailsPanel;
                $scope.infoResolveDetailsPanel = temp_html;
            } else if ($scope.infoPanel && (JSON.stringify($scope.currBlock) == JSON.stringify($scope.prevBlock))) {
                $scope.infoPanel = false;
            } else {
                $scope.infoPanel = true;
                $scope.infoResolve = temp_html;
            }

            $scope.prevBlock = {
                selector: selector,
                where: where
            }
        });
    };

    $scope.head = Head;

    $scope.foot = Foot;

    $scope.showGlobalNavigationPanel = false;
    $scope.showPublicAccessPanel = false;


    // TODO: Webgl
    $scope.webgl = {};

    $scope.webgl.selected = {
        node: false,
        member: false
    };

    $scope.model = {
        calcs: {},
        footer_calc: {},
        companyInfo: {},
        head_style: 0,
        foot_style: 0
    };

    // TODO: Header
    $scope.header = {};

    $scope.header.data = {};

    $scope.header.newLogo = '';

    $scope.header.change = function () {
        $scope.models.geometry.report_changed = true;
    };

    $scope.header.changeLogo = function (company) {

        $scope.model.header_calcs.companyPK = company.id;

        $scope.auth.allCompanies.forEach(function (item) {
            if (item.id == $scope.model.header_calcs.companyPK) {
                $scope.model.companyInfo = item;
            }
        });

        $scope.models.geometry.report_changed = true;

        $scope.head.modalLogo = false;

    };

    $scope.header.addHeader = function (callback) {
        $scope.head.addHeader(function (response) {
            if (!response.error) {
                callback(response.data.id);
            }
        });
    };

    $scope.header.save = function () {

        $scope.head.data = $scope.model.header_calcs;
        // if($scope.head.companyInfo) {
        //     $scope.head.data.companyPK = $scope.auth.companyInfo.id;
        // }

        $scope.head.save(function (response) {
            if (response.newhead) {
                // $scope.calc.current.headerPK = response.result.id;

                $scope.calc.editCurCalc($scope.calc.current, function () {
                    $scope.header.update();
                });
            }
            $scope.models.geometry.report_changed = false;
        });

    };

    $scope.header.update = function () {

        $scope.head.current.headID = $scope.models.geometry.lc_analysis_active.headerPK;

        $scope.head.update(function () {

            $scope.head.activeHeadLayout = $scope.head.data.stylePK;

            $scope.model.header_calcs = $scope.head.data;


            $scope.auth.allCompanies.forEach(function (item) {
                if (item.id == $scope.model.header_calcs.companyPK) {
                    $scope.model.companyInfo = item;
                    $scope.model.header_calcs.logo = $scope.model.companyInfo.logo;
                }
            });

        });
    };

    $scope.header.updateStyles = function (data) {
        // var header_id = data.headerPK,
        //     new_style_id = data.headerStylePK;
        // if(new_style_id && header_id) {
        //     $scope.head.updateStyles(header_id, new_style_id);
        // }
    };

    $scope.model.header_calcs = {};

    $scope.footer = {};

    $scope.footer.data = {};

    $scope.footer.addFooter = function (callback) {
        $scope.foot.addFooter(function (response) {
            if (!response.error) {
                callback(response.data.id);
            }
        });
    };

    $scope.footer.save = function () {

        $scope.foot.data = $scope.model.footer_calcs;

        // if($scope.auth.companyInfo) {
        //     $scope.foot.data.companyPK = $scope.auth.companyInfo.id;
        // }

        $scope.foot.save(function (response) {
            // if(response.newfoot) {
            //     $scope.calc.current.footerPK = response.result.id;
            //
            //     $scope.calc.editCurCalc($scope.calc.current, function() {
            //         $scope.footer.update();
            //     });
            // }
            $scope.models.geometry.report_changed = false;
        });

    };

    $scope.footer.update = function () {
        $scope.foot.current.footID = $scope.models.geometry.lc_analysis_active.footerPK;

        $scope.foot.update(function () {

            $scope.foot.activeFooterLayout = $scope.foot.data.stylePK;

            $scope.model.footer_calcs = $scope.foot.data;

        });
    };

    $scope.footer.updateStyles = function (data) {
        // var footer_id = data.footerPK,
        //     new_style_id = data.footerStylePK;
        // if(new_style_id && footer_id) {
        //     $scope.foot.updateStyles(footer_id, new_style_id);
        // }
    };

    $scope.footer.change = function (index) {
        var temp_input = angular.element('#footer_input_' + index);

        var tmp = document.createElement("span");
        tmp.className = "input-element tmp-element";
        tmp.innerHTML = temp_input.val().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        document.body.appendChild(tmp);
        var theWidth = tmp.getBoundingClientRect().width;
        document.body.removeChild(tmp);

        temp_input.width(theWidth * 1.15);
    };

    $scope.model.footer_calcs = {};

    $scope.geoSectionsDimensions = {};

    $scope.sectionDimensions = [
        'A', 'A_m', 'B_upr', 'B_upr_m', 'C', 'C_m', 'C_w', 'C_w_m', 'D_t', 'D_t_m', 'H_upr', 'H_upr_m',
        'Ht', 'Ht_m', 'ID', 'ID_m', 'I_w', 'I_w_m', 'I_x', 'I_x_m', 'I_y', 'I_y_m', 'I_z', 'I_z_m', 'J',
        'J_m', 'OD', 'OD_m', 'P_a', 'P_a_m', 'P_b', 'P_b_m', 'Q_f', 'Q_f_m', 'Q_s', 'Q_s_m', 'Q_w',
        'Q_w_m', 'S_w1', 'S_w1_m', 'S_w2', 'S_w2_m', 'S_w3', 'S_w3_m', 'S_wA', 'S_wA_m', 'S_wB', 'S_wB_m',
        'S_wC', 'S_wC_m', 'S_x', 'S_x_m', 'S_y', 'S_y_m', 'S_z', 'S_zA', 'S_zA_m', 'S_zB', 'S_zB_m', 'S_zC',
        'S_zC_m', 'S_z_m', 'W', 'W_m', 'W_no', 'W_no_m', 'Z_x', 'Z_x_m', 'Z_y', 'Z_y_m', 'b', 'b_f', 'b_f_2t_f',
        'b_f_2t_f_m', 'b_f_m', 'b_fdet', 'b_fdet_m', 'b_m', 'b_t', 'b_t_des', 'b_t_des_m', 'b_t_m', 'd', 'd_det',
        'd_det_m', 'd_m', 'e_o', 'e_o_m', 'h', 'h_m', 'h_o', 'h_o_m', 'h_t_des', 'h_t_des_m', 'h_t_w', 'h_t_w_m',
        'id_no', 'k_1', 'k_1_m', 'k_des', 'k_des_m', 'k_det', 'k_det_m', 'r_o', 'r_o_m', 'r_ts', 'r_ts_m', 'r_x',
        'r_x_m', 'r_y', 'r_y_m', 'r_z', 'r_z_m', 't', 't_des', 't_des_m', 't_f', 't_f_m', 't_fdet', 't_fdet_m',
        't_m', 't_nom', 't_nom_m', 't_w', 't_w_m', 't_wdet', 't_wdet_2', 't_wdet_2_m', 't_wdet_m', 'tan_a',
        'tan_a_m', 'w_A', 'w_A_m', 'w_B', 'w_B_m', 'w_C', 'w_C_m', 'x', 'x_m', 'x_p', 'x_p_m', 'y', 'y_m', 'y_p',
        'y_p_m', 'z_A', 'z_A_m', 'z_B', 'z_B_m', 'z_C', 'z_C_m'
    ];

    $scope.sectionDimensionsx = {
        "2L_E": ['D_t'],
        "2L_LLBB": [],
        "2L_SLBB": [],
        "C": [],
        "HP": [],
        "HSS(Rect)": [],
        "HSS(Rnd)": ['OD'],
        "HSS(Sqr)": ['Ht'],
        "L_E": ['d', 'b'],
        "L_uE": [],
        "M": [],
        "MC": [],
        "MT": [],
        "Pipe": ['OD'],
        "S": [],
        "ST": [],
        "W": ['d', 'b_f'],
        "WT": [],
        "SR": [],
        "Plate": [],
    };

    $scope.draggedName = '';

    $scope.onMouseUp = function () {

        $timeout(function () {

            $('#draggable_clone').css({
                left: -500,
                top: 0
            });

            $scope.draggedName = '';

            $(document).unbind('mousemove');

            $scope.models.product.draggingOn = false;
            $scope.models.product.draggingProduct = {};

            $scope.models.geometry.draggingOn = false;
            $scope.models.geometry.draggingProduct = {};

        }, 50);

    };

    // TODO: Models
    $scope.models = {
        add: {},
        nodes: {
            add: {}
        },
        nodes_p: {
            add: {}
        },
        secs: {
            add: {}
        },
        tabs: "geometry",
        right_tabs: "search",
        geometry_tabs: "materials",
        nodes_tabs: "listing",
        product_tabs: "associations",
        analysis_tabs: 'lc',
        copyPanel: false,
        copyFoldersDdl: [],
        copyFolder: '',
        copyObj: {},
        privacyUpdate: false
    };

    $scope.actions = {
        transferDataPopUp: {show: false}
    };

    $scope.models.product = {
        selected: [],
        items: [],
        details: [],
        pdf: [],
        files_list: [],
        photo_list: [],
        ascnt_obj: {},
        association: [],
        associationDetails: [],
        associationSections: [],
        associationNodes: [],
        ice_thk: 0,
        wind_areas: [],
        deleted_wa: [],
        add: true,
        settings: {
            shared: true,
            private: false
        },
        reset: {
            association: []
        },
        list: [],
        searchList: [],
        panel: false,
        changed: false,
        textureUpdate: false,
        pdfUrl: '',
        image: null,
        imageFileName: '',
        uploadMode: 'browse',
        uploadModePhotos: 'browse',
        photoBrowseFile: {},
        photoBrowseFileName: '',
        photoUploadURL: '',
        photoDragFile: {},
        photoDragName: '',
        dataLoaded: false,
        file_notes: '',
        file_show: 'false',
        chart_labels: ["0", "45", "90", "135", "180", "225", "270", "315", "360"],
        chart_data: [],
        chart_series: ['EPA'],
        slider_min: 0,
        slider_max: 360,
        slider_step: 5,
        slider_value: 0,
        epa_slider_value: 0,
        plot_height: 100,
        plot_width: 100,
        calculate: 0,
        new_wa: {},
        custom_ice: 0,
        weight_wo_mkit: 0,
        weight_w_mkit: 0,
        epa_slider_values: [],
        sliderShow: true,
        piValue: Math.PI.toFixed(4),
        slider_width: '247px',
        slider_left: '56px',
        draggingOn: false,
        draggingProduct: {}
    };
    $scope.sectionsInfo = [];
    $scope.models.geometry = {
        selected: [],
        items: [],
        details: [],
        models: [],
        shapes: [],
        members: [],
        materials: [],
        newMaterial: {},
        materialsLists: {
            orgList: [],
            standardList: [],
            gradeList: []
        },
        shapesList: {
            shapeList: [],
            size1List: [],
            size2List: []
        },
        pdf: [],
        list: [],
        association: [],
        list_analysis_eq: [],
        list_analys_lc: [],
        list_analys_lc_details: [],
        new_analys_lc: {},
        new_analys_dc: {},
        nodes: [],
        nodes_p: [],
        settings: {
            shared: true,
            private: false
        },
        reset: {
            association: []
        },
        searchList: [],
        image: null,
        imageFileName: '',
        uploadMode: 'browse',

        uploadModePhotos: 'browse',
        photoBrowseFile: {},
        photoBrowseFileName: '',
        photoUploadURL: '',
        photoDragFile: {},
        photoDragName: '',
        photo_list: [],

        dataLoaded: false,
        analysis_panel: false,
        activeGeometryDcList: [],
        activeGeometryLcParentList: [],
        activeGeometryLcList: [],
        analysisCombinations: [],
        lc_analysis_active: {},
        lc_analysis_active_details_list: [],
        lc_analysis_active_details_reset_list: [],
        active_dc: {},
        new_analys_lc_details: {
            dx: 0,
            dy: 0,
            dz: 0,
            rotx: 0,
            roty: 0,
            rotz: 0
        },
        new_connection: {},
        edited_analysis_row: 0,
        edited_associate_row: 0,
        edited_connector_row: 0,
        newObject: {
            rad: 0,
            azm: 0
        },
        TR: {
            dx: 0,
            dy: 0,
            dz: 0,
            rotx: 0,
            roty: 0,
            rotz: 0
        },
        report_changed: false,
        aiscSelected: {
            shape: {
                first: false,
                second: false
            },
            size_1: {
                first: false,
                second: false
            },
            size_2: {
                first: false,
                second: false
            }
        },
        draggingOn: false,
        draggingProduct: {},
        newConnector: {},
        insertNodeModal: false,
        insertedNodeData: '',
        insertMemberModal: false,
        insertedMemberData: '',
    };

    //PRODUCT
    $scope.models.product.clearInput = function () {
        $scope.models.product.association = angular.copy($scope.models.product.reset.association);
    };

    $scope.models.product.changeItem = function (item) {
        $scope.models.product.new = false;

        if (item.select == null) {
            $scope.models.product.selected.forEach(function (selected, index) {
                if (item.key == selected.key) {
                    $scope.models.product.selected.splice(index, 5);
                    if (index == 0) {
                        $scope.query.resetProduct();
                        $scope.models.product.dataLoaded = false;
                    } else {
                        $scope.models.product.changeItem(item);
                    }
                    return false;
                }
            });
        } else {
            $scope.models.buildTabs(item, $scope.models.tabs, function (items, details) {

                $scope.models.product.dataLoaded = true;

                $scope.models.product.items = items;

                var temp_details = {};

                if (details.data && details.data.length === 1) {
                    temp_details = details.data[0];
                }

                // $scope.models.product.details =

                request.getProductAssociation(temp_details.id).then(function (response) {

                    if (response && response[0]) {

                        $scope.models.product.ascnt_obj = response[0];

                        angular.forEach(response[0], function (value, key) {

                            if (key != 'id') {
                                temp_details[key] = value;
                            }

                        });

                    }

                    $scope.models.product.details = temp_details;

                    $scope.query.pdfProduct();
                    $scope.models.product.getPhotoList();
                    $scope.query.getProductFiles3d();
                    $scope.models.product.getWA();
                    $scope.models.product.association = angular.copy($scope.models.product.reset.association);

                    var selected = [];

                    if ($scope.models.product.details.db_geo_PK) {
                        angular.forEach($scope.models.product.association, function (association) {

                            angular.forEach(association.data, function (data) {
                                if (data.id == $scope.models.product.details.db_geo_PK) {
                                    association.select = data;
                                    selected.push({
                                        id: association.select.id,
                                        key: association.key,
                                        value: association.select.value,
                                        last: true
                                    });
                                }
                            });

                        });
                    }

                    if (selected.length) {
                        $scope.models.product.add = false;
                        request.items(selected, "geometry", $scope.userLoadInfo).then(function (details) {
                            $scope.models.product.associationDetails = details.data;
                            $scope.models.product.associationMembers = details.members;
                            $scope.models.product.associationSections = details.secs;
                            $scope.models.product.associationNodes = details.nodes;

                            $scope.render.redraw('product')
                        });
                    } else {
                        $scope.render.redraw('product')
                    }

                });
            });
        }
    };

    $scope.models.product.changeAssociation = function (item) {
        if (item.select == null) {
            $scope.models.product.association = angular.copy($scope.models.product.reset.association);
            return false;
        }

        $scope.models.buildTabs(item, "geometry", function (items, details) {
            $scope.models.product.association = items;
            $scope.models.product.detailsAstn = details.data[0] || [];

            // TODO: Render association models - too slow
            $scope.models.product.associationDetails = details.data;
            $scope.models.product.associationSections = details.secs;
            $scope.models.product.associationNodes = details.nodes;

            // $scope.render.redraw('product');
        });
    };

    $scope.models.product.saveItem = function () {

        $scope.models.product.saveAllWA();

        $scope.models.product.deleted_wa.forEach(function (id) {
            $scope.models.product.removeWA(id);
        });

        $scope.models.product.deleted_wa = [];

        if ($scope.models.product.association[0].select) {
            $scope.models.product.details.db_geo_PK = $scope.models.product.association[0].select.id;
        }

        $scope.models.product.ascnt_obj['d1'] = $scope.models.product.details['d1'];
        $scope.models.product.ascnt_obj['d2'] = $scope.models.product.details['d2'];
        $scope.models.product.ascnt_obj['d3'] = $scope.models.product.details['d3'];
        $scope.models.product.ascnt_obj['d4'] = $scope.models.product.details['d4'];
        $scope.models.product.ascnt_obj['d5'] = $scope.models.product.details['d5'];
        $scope.models.product.ascnt_obj['weight_wo_mkit'] = $scope.models.product.details['weight_wo_mkit'];
        $scope.models.product.ascnt_obj['weight_w_mkit'] = $scope.models.product.details['weight_w_mkit'];


        $scope.models.product.ascnt_obj['db_geo_PK'] = $scope.models.product.details['db_geo_PK'];
        $scope.models.product.ascnt_obj['geometryType'] = $scope.models.product.details['geometryType'];
        $scope.models.product.ascnt_obj['db_pro_PK'] = $scope.models.product.details['id'];
        $scope.models.product.ascnt_obj['geometryShapeType'] = $scope.models.product.details['geometryShapeType'];
        $scope.models.product.ascnt_obj['texture_type'] = $scope.models.product.details['texture_type'];
        $scope.models.product.ascnt_obj['has_azm'] = $scope.models.product.details['has_azm'];
        $scope.models.product.ascnt_obj['color'] = $scope.models.product.details['color'];
        $scope.models.product.ascnt_obj['texture'] = $scope.models.product.details['texture'];


        var texture = $scope.soTexture;

        var reader = new FileReader();

        reader.onloadend = function () {

            var textureBase = reader.result;

            $scope.models.product.details.texture = texture.name;
            $scope.models.product.details.textureFile = textureBase;
            $scope.models.product.details.textureUpdate = true;

            request.updateProductAssociation($scope.models.product.ascnt_obj).then(function (result) {

                // request.update($scope.models.product.details, "all", state).then(function (response) {
                $scope.models.product.add = false;
                $scope.models.product.changed = false;
                $scope.models.product.textureUpdate = false;
                $scope.render.redraw('product');
                // });
            });

        };

        if (texture) {
            reader.readAsDataURL(texture);
        } else {
            $scope.models.product.details.textureUpdate = false;
            $scope.models.product.details.textureFile = false;

            request.updateProductAssociation($scope.models.product.ascnt_obj).then(function (result) {

                // request.update($scope.models.product.details, "all", state).then(function (response) {
                $scope.models.product.add = false;
                $scope.models.product.changed = false;
                $scope.models.product.textureUpdate = false;

                $scope.render.redraw('product');
                // });

            });

        }
    };

    $scope.models.product.removeItem = function (flag) {
        request.remove($scope.models.product.details['id'], "all", flag).then(function (response) {
            var str = '';

            if (flag) {
                $scope.models.product.add = true;
                $scope.models.product.association = angular.copy($scope.models.product.reset.association);
                str += "remove assotiation ";
            } else {
                $scope.query.resetProduct();
                str += "remove product "
            }
        });
    };

    $scope.models.product.changeNew = function (event) {
        if (event.keyCode == 27) {
            $scope.query.resetProduct();
        }
    };

    $scope.models.product.formSearchList = function () {
        $scope.models.product.searchList = [];
        $scope.models.product.list.forEach(function (item) {
            if ($scope.userLoadInfo.userIds.indexOf(item.userID) !== -1) {

                let value = item.type + ' | ' + item.shape + ' | ' + item.mftr + ' | ' + item.model;

                $scope.models.product.searchList.push({
                    value: value,
                    id: item.id,
                    item: item
                });

            }
        });
    };

    $scope.models.product.addingNewEntryFromSearch = function (item) {
        $scope.selectedProduct = '';

        angular.forEach($scope.models.geometry.analysis, (analysis) => {
            analysis.select = {}
        });
        angular.forEach($scope.models.geometry.analysis[0].data, function (type) {
            if (type.value === item.item.type) $scope.models.geometry.analysis[0].select = type;
        });
        angular.forEach($scope.models.geometry.analysis[1].data, (sub_type) => {
            if (sub_type.value === item.item.sub_type) $scope.models.geometry.analysis[1].select = sub_type;
        });
        angular.forEach($scope.models.geometry.analysis[2].data, (shape) => {
            if (shape.value === item.item.shape) $scope.models.geometry.analysis[2].select = shape;
        });
        angular.forEach($scope.models.geometry.analysis[3].data, (mftr) => {
            if (mftr.value === item.item.mftr) $scope.models.geometry.analysis[3].select = mftr;
        });
        angular.forEach($scope.models.geometry.analysis[4].data, (model) => {
            if (model.value === item.item.model) $scope.models.geometry.analysis[4].select = model;
        });
    };

    $scope.models.product.searchInputChange = function (item) {
        $scope.selectedProduct = '';

        if (item.item.userID != 0) {
            if (!$scope.models.product.settings.private) {
                alert('You must include private data!');

                return
            }
        }

        angular.element('#panelTabs a:first').tab('show');
        $scope.models.tabs = 'all';

        var node = {};
        node.key = 'type';
        node.name = 'Type';
        node.select = {};
        node.select.id = item.item.id;
        node.select.value = item.item.type;

        $scope.models.product.selected = [];

        if (item.item.model) {
            $scope.models.product.selected.push({
                last: false,
                key: 'model',
                value: item.item.model
            });
        }

        if (item.item.shape) {
            $scope.models.product.selected.push({
                last: false,
                key: 'shape',
                value: item.item.shape
            });
        }

        if (item.item.sub_type) {
            $scope.models.product.selected.push({
                last: false,
                key: 'sub_type',
                value: item.item.sub_type
            });
        }

        if (item.item.mftr) {
            $scope.models.product.selected.push({
                last: false,
                key: 'mftr',
                value: item.item.mftr
            });
        }

        $scope.models.buildTabs(node, 'all', function (items, details) {

            $scope.models.product.dataLoaded = true;

            $scope.models.product.items = items;
            $scope.models.product.details = details.data ? details.data[0] : {};

            request.getProductAssociation($scope.models.product.details.id).then(function (response) {

                if (response && response[0]) {

                    $scope.models.product.ascnt_obj = response[0];

                    angular.forEach(response[0], function (value, key) {

                        if (key != 'id') {
                            $scope.models.product.details[key] = value;
                        }

                    });

                }

                $scope.query.pdfProduct();
                $scope.models.product.getPhotoList();
                $scope.query.getProductFiles3d();
                $scope.models.product.getWA();
                $scope.models.product.association = angular.copy($scope.models.product.reset.association);

                var selected = [];

                angular.forEach($scope.models.product.association, function (association) {
                    if ($scope.models.product.details[association.key] != undefined) {
                        angular.forEach(association.data, function (data) {
                            if (data.value == $scope.models.product.details[association.key]) {
                                association.select = data;
                                selected.push({
                                    id: association.select.id,
                                    key: association.key,
                                    value: association.select.value,
                                    last: true
                                });
                            }
                        });
                    }
                });

                if (selected.length) {
                    $scope.models.product.add = false;
                    request.items(selected, "geometry", $scope.userLoadInfo).then(function (details) {
                        $scope.models.product.associationDetails = details.data;
                        $scope.models.product.associationMembers = details.members;
                        $scope.models.product.associationSections = details.secs;
                        $scope.models.product.associationNodes = details.nodes;

                        $scope.render.redraw('product')
                    });
                } else {
                    $scope.render.redraw('product')
                }
            });

        })
    };

    $scope.models.product.tree = {
        data: [],
        expanded: [],
        newProduct: {},
        options: {
            nodeChildren: "productsTreeList",
            multiSelection: false,
            dirSelectable: true,
            isAccess: function (node) {
                var state = "show";

                if (node.status == "inactive") {
                    state = "hide";

                    if ($scope.auth.isAdmin()) {
                        state = "disable";
                    }
                }

                return state;
            },
            isPremier: function (node) {
                return node.accessLevel == "premier";
            },
            isLeaf: function (node) {
                return false;
            }
        },
        node: {},
        contextSelectedNode: {},
        selectedNodes: [],
        foldersTree: [],
        selectedNodeType: '',
        linksShow: false,
        showSelected: function(node, type) {

            $('.panel-product-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            $('.panel-geometry-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            $('.panel-site-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            if (!$scope.models.containsObject($scope.models.product.tree.expanded, node)) {
                $scope.models.product.tree.expanded.push(node);
            }

            $scope.models.geometry.tree.node = {};
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.tree.selectedNodeType = type;

            $scope.models.product.tree.linksShow = false;

            if (node.linksFolder) {
                $scope.models.product.tree.linksShow = true;
            }

            if (node.category) {
                $scope.models.product.tree.formNodesList(node);
            } else {
                $scope.models.product.tree.selectedNodes.push(node);
            }

        },
        formNodesList: function (node) {
            if (node.productsList) {
                node.productsList.forEach(function (item) {
                    if (!item.category) {
                        $scope.models.product.tree.selectedNodes.push(item);
                    } else if (node.id !== 0) {
                        $scope.models.product.tree.formNodesList(item);
                    }
                })
            } else {
                node.productsList = [];
                node.productsTreeList = [];
            }
        },
        context: function (node) {

            console.log(node);

            var context = [];

            var customHtmlFolder = '<div style="padding: 5px;">Folder name</div>' +
                '<div style="padding: 5px;"><input id="input_folder_context" type="text"></div>';

            var customItemFolder = {
                html: customHtmlFolder,
                enabled: function () {
                    return false
                }
            };

            var customHtmlCreateButton = '<button class="btn btn-default" style="margin-left: 5px;">Create</button>';

            var customHtmlChangeButton = '<button class="btn btn-default" style="margin-left: 5px;">Change</button>';

            var customHtmlFolderRemove = '<div style="padding: 5px;">Remove selected folder?</div>';

            var customHtmlRemoveButton = '<button class="btn btn-default" style="margin-left: 5px;">Remove</button>';

            var customItemFolderButton = {
                html: customHtmlCreateButton,
                enabled: function () {
                    return true
                },
                click: function () {
                    $scope.models.createFolder(node, {name: document.getElementById('input_folder_context').value});
                }
            };

            var customItemFolderButtonChange = {
                html: customHtmlChangeButton,
                enabled: function () {
                    return true
                },
                click: function () {
                    node.name = document.getElementById('input_folder_name_context').value;
                    $scope.models.updateFolder(node);
                }
            };

            var customItemFolderRemove = {
                html: customHtmlFolderRemove,
                enabled: function () {
                    return false
                }
            };

            var customItemFolderButtonRemove = {
                html: customHtmlRemoveButton,
                enabled: function () {
                    return true
                },
                click: function () {
                    $scope.models.removeFolder(node);
                }
            };

            var customHtmlRename = '<div style="padding: 5px;">Folder name</div>' +
                '<div style="padding: 5px;"><input id="input_folder_name_context" value="' + node.name + '" type="text"></div>';

            var customItemRename = {
                html: customHtmlRename,
                enabled: function () {
                    return false
                }
            };

            $scope.models.product.tree.foldersTree = [];


            if (node.category == 'product') {
                $scope.models.product.tree.data.forEach(function (product) {
                    var path = product.name + '/';
                    $scope.models.product.tree.foldersTree.push({
                        name: product.name,
                        id: product.id,
                        path: path + 'root'
                    });

                    $scope.models.product.generateFoldersTree(product.productsTreeList, $scope.models.product.tree.foldersTree, path);
                });
            } else if (node.category == 'geometry') {
                $scope.models.geometry.tree.data.forEach(function (geometry) {
                    var path = geometry.name + '/';
                    $scope.models.product.tree.foldersTree.push({
                        name: geometry.name,
                        id: geometry.id,
                        path: path + 'root'
                    });

                    $scope.models.product.generateFoldersTree(geometry.geometriesTreeList, $scope.models.product.tree.foldersTree, path);
                });
            }


            var customHtmlMove = $compile('<div style="padding-left: 5px; padding-right: 5px; padditg-top: 5px;">Select destination</div>' +
                '<div style="padding: 13px 5px 5px 5px;">' +
                '   <select class="form-control" id="select_move_project_context">' +
                '       <option ng-repeat="project in models.product.tree.foldersTree" value="{{project}}">{{project.path}}</option>' +
                '   </select>' +
                '</div>')($scope);

            var customItemMove = {
                html: customHtmlMove,
                enabled: function () {
                    return false
                }
            };

            var customHtmlMoveButton = '<button class="btn btn-default" style="margin-left: 5px;">Move</button>';

            var customItemMoveButton = {
                html: customHtmlMoveButton,
                enabled: function () {
                    return true
                },
                click: function () {
                    var e = document.getElementById('select_move_project_context');
                    var moveToNode = JSON.parse(e.value);

                    node.parentID = moveToNode.id;

                    $scope.models.updateFolder(node, function () {
                        $scope.query.getProductsList();
                        $scope.query.getGeometriesList();
                    });

                }
            };

            if (!$scope.auth.isAuth()) {
                return [];
            }

            if (node.category == 'product' || node.category == 'geometry' || node.category == 'site') {
                $scope.models.product.tree.contextSelectedNode = node;
                context.push(
                    ['Add Folder', function (item) {

                    }, [
                        customItemFolder,
                        customItemFolderButton

                    ]
                    ]
                );

                if (node.parentID) {
                    context.push(
                        ['Rename', function (item) {

                        }, [
                            customItemRename,
                            customItemFolderButtonChange
                        ]],
                        ['Remove', function (item) {

                        }, [
                            customItemFolderRemove,
                            customItemFolderButtonRemove
                        ]],
                        ['Move to', function (item) {

                        }, [
                            customItemMove,
                            customItemMoveButton
                        ]
                        ]
                    );
                }

            }

            return context;
        }
    };

    $scope.models.product.panelInputSelect = function (id) {

        $('.panel-product-tree-element').each(function () {
            $(this).parent().removeClass('panel-selected-node');

            let nodeid = $(this).data().folderid;

            if (nodeid == id) {

                $(this).parent().addClass('panel-selected-node');
            }
        })

    };

    $scope.models.product.generateFoldersTree = function (list, tree, path) {
        list.forEach(function (item) {
            tree.push({name: item.name, id: item.id, path: path + item.name});
            if (item.productsTreeList && item.productsTreeList.length > 0) {
                var newPath = path + item.name + '/';
                $scope.models.product.generateFoldersTree(item.productsTreeList, tree, newPath);
            } else if (item.geometriesTreeList && item.geometriesTreeList.length > 0) {
                var newPath = path + item.name + '/';
                $scope.models.product.generateFoldersTree(item.geometriesTreeList, tree, newPath);
            }
        });
    };

    $scope.models.product.panelDrag = function (product, index) {

        $scope.draggedName = index + 1;

        $(document).bind('mousemove', function (e) {
            $('#draggable_clone').css({
                left: e.pageX + 20,
                top: e.pageY
            });
        });

        $scope.models.product.draggingOn = true;
        $scope.models.product.draggingProduct = product;

    };

    $scope.models.product.panelDragEnd = function (node) {

        if ($scope.models.product.draggingOn) {
            let product = angular.copy($scope.models.product.draggingProduct);
            let oldParent = product.parentID;
            product.parentID = node.id;

            $scope.models.product.draggingOn = false;
            $scope.models.product.draggingProduct = {};

            request.update(product, "all", "save").then(function (response) {

                if (oldParent != 0) {
                    for (let i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                        if ($scope.models.product.tree.selectedNodes[i].id == product.id) {
                            $scope.models.product.tree.selectedNodes.splice(i, 1);
                        }
                    }

                    for (let k = 0; k < $scope.models.product.tree.node.productsList.length; k++) {
                        if ($scope.models.product.tree.node.productsList[k].id == product.id) {
                            $scope.models.product.tree.node.productsList.splice(k, 1);
                        }
                    }
                }

                node.productsList.push(product);

                $scope.query.resetProduct();
            });
        }

    };

    $scope.models.product.getPhotoList = function () {

        let id = $scope.models.product.details ? $scope.models.product.details.id : 0;

        request.getPhotoList('product', id).then(function (response) {

            $scope.models.product.photo_list = response;

        });

    };

    $scope.models.product.uploadPhotoFile = function () {
        let file = $scope.models.product.photoBrowseFile;

        let id = $scope.models.product.details ? $scope.models.product.details.id : 0;

        if (id) {
            file.forEach(function (item) {

                let fd = new FormData();
                fd.append('file', item);

                return $.ajax({
                    url: "request.php?method=uploadProductPhoto&db_pro_PK=" + id,
                    type: "POST",
                    data: fd,
                    enctype: "multipart/form-data",
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        if (response.files) {
                            response.files.forEach(function (item) {
                                $scope.models.product.photo_list.push(item);
                            });

                            $scope.$applyAsync();
                        }
                    }
                }).then(
                    handler.success,
                    handler.error
                );

            });
        }
    };

    $scope.models.product.uploadPhotoFromUrl = function () {

        let id = $scope.models.product.details ? $scope.models.product.details.id : 0;

        if (id && $scope.models.product.photoUploadURL) {
            let urls = $scope.models.product.photoUploadURL.split(',');

            urls.forEach(function (item) {

                request.uploadPhotoFromUrl({
                    tab: 'product',
                    url: item,
                    pk: id
                }).then(function (response) {

                    if (response.file) {
                        $scope.models.product.photo_list.push(response.file);
                    }


                });

            })
        }

    };

    $scope.models.product.uploadPhotoFromDnd = function () {

        let id = $scope.models.product.details ? $scope.models.product.details.id : 0;
        let data = {
            pk: id,
            table: 'db_pro_photo'
        };

        data.file = $scope.models.product.photoDragFile;
        data.name = $scope.models.product.photoDragName;

        if (data.name) {

            request.uploadPhotoFromDnd(data).then(function (response) {


                if (response.file) {
                    $scope.models.product.photo_list.push(response.file);
                }

            });

        }

    };

    $scope.models.product.updatePhotoFile = function (photo) {

        request.updatePhotoFile({
            table: 'db_pro_photo',
            notes: photo.notes,
            id: photo.id
        }).then(function (response) {

            if (response.status) {
                photo.change = false;
            }

        });

    };

    $scope.models.product.removePhotoFile = function (photo, index) {

        request.removePhotoFile({
            table: 'db_pro_photo',
            id: photo.id
        }).then(function (response) {

            if (response.status) {
                $scope.models.product.photo_list.splice(index, 1);
            }

        });

    };

    $scope.models.product.updateProduct = function (product) {
        if ($scope.models.product.checkForSameProduct(product, $scope.models.product.list)) {
            alert("There are existing data record having same master-field combination. Change the value of at least one of the master fields.");
            return;
        }

        request.update(product, "all", "save").then(function (response) {
            product.change = false;
        });
    };

    $scope.models.product.deleteProduct = function (index) {
        request.remove(index, "all").then(function (response) {
            if (response.success) {
                for (var i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                    if ($scope.models.product.tree.selectedNodes[i].id == index) {
                        $scope.models.product.tree.selectedNodes.splice(i, 1);
                    }
                }

                for (var k = 0; k < $scope.models.product.tree.node.productsList.length; k++) {
                    if ($scope.models.product.tree.node.productsList[k].id == index) {
                        $scope.models.product.tree.node.productsList.splice(k, 1);
                    }
                }

                $scope.query.resetProduct();
            }
        });
    };

    $scope.models.product.deleteProductLink = function (index) {
        let userId = $scope.auth.data.id || -1;

        request.removeLink(index, userId, 'db_product').then(function (response) {

            for (let i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                if ($scope.models.product.tree.selectedNodes[i].id === index) {
                    $scope.models.product.tree.selectedNodes.splice(i, 1);
                }
            }

            for (let k = 0; k < $scope.models.product.tree.node.productsList.length; k++) {
                if ($scope.models.product.tree.node.productsList[k].id === index) {
                    $scope.models.product.tree.node.productsList.splice(k, 1);
                }
            }

            $scope.query.resetProduct();

        });
    };

    $scope.models.product.addNewProduct = function (new_product, copy, callback) {

        if (!new_product.type && !new_product.sub_type && !new_product.shape && !new_product.mftr && !new_product.model) {
            alert('At least one master field should not be empty!');
            return;
        }

        if ($scope.models.product.checkForSameProduct(new_product, $scope.models.product.list)) {
            alert("There are existing data record having same master-field combination. Change the value of at least one of the master fields.");
            return;
        }

        var new_node = angular.copy(new_product);
        var type = 'all';

        new_node.userID = $scope.auth.data.id;

        if (!copy) {
            new_node.parentID = $scope.models.product.tree.node.id;
        }

        request.update(new_node, type, "new").then(function (response) {
            if (response.success) {
                if (!copy) {
                    $scope.models.product.tree.selectedNodes.push(response.data);
                    $scope.models.product.tree.node.productsList.push(response.data);
                    $scope.models.product.list.push(response.data);
                    $scope.query.resetProduct();
                } else {
                    $scope.query.getProductsList();
                    $scope.models.copyPanel = false;
                    if (callback) {
                        callback(response);
                    }
                }
            }
        })

    };

    $scope.models.product.checkForSameProduct = function (product, list) {
        var check = false;

        list.forEach(function (item) {
            var same = true;

            if (product.id && item.id == product.id) {
                same = false;
            }

            if (product.type) {
                if (item.type != product.type) {
                    same = false;
                }
            }

            if (product.sub_type) {
                if (item.sub_type != product.sub_type) {
                    same = false;
                }
            }

            if (product.shape) {
                if (item.shape != product.shape) {
                    same = false;
                }
            }

            if (product.mftr) {
                if (item.mftr != product.mftr) {
                    same = false;
                }
            }

            if (product.model) {
                if (item.model != product.model) {
                    same = false;
                }
            }

            if (same) {
                check = true;
            }
        });

        return check;
    };

    $scope.models.product.formProductTreeList = function () {
        if ($scope.auth.isAuth()) {
            request.getFolders($scope.auth.data.id).then(function (folders) {

                request.getLinks($scope.auth.data.id, 'db_product').then(function (links) {

                    let treeList = [];
                    let ProductMain = {
                        name: 'Product',
                        productsList: [],
                        productsTreeList: [],
                        category: 'product',
                        id: 0
                    };

                    $scope.models.product.list.forEach(function (product) {
                        if (product.userID == $scope.auth.data.id && product.mode !== 'link') {
                            if (product.parentID != 0) {
                                folders.forEach(function (folderItem) {
                                    if (folderItem.id == product.parentID) {
                                        if (!folderItem.productsList) {
                                            folderItem.productsList = [];
                                            folderItem.productsTreeList = [];
                                        }

                                        folderItem.productsList.push(product);
                                    }
                                })
                            }

                            ProductMain.productsList.push(product);

                        }
                    });

                    folders.forEach(function (item) {
                        if (item.parentID != 0) {
                            folders.forEach(function (folder) {
                                if (!folder.productsList) {
                                    folder.productsList = [];
                                    folder.productsTreeList = [];
                                }
                                if (folder.id == item.parentID) {
                                    folder.productsList.push(item);
                                    folder.productsTreeList.push(item);
                                }
                            });
                        } else {
                            if (item.category === 'product') {
                                ProductMain.productsList.push(item);
                                ProductMain.productsTreeList.push(item);
                            }
                        }
                    });

                    //links
                    let linkFolder = {
                        name: 'links',
                        linksFolder: true,
                        category: 'product',
                        parentID: 0,
                        productsList: [],
                        productsTreeList: []
                    };

                    links.forEach(function (l) {
                        let user = '';

                        $scope.usersList.forEach(function (u) {

                            if (u.id == l.userID) {
                                user = u.firstName;
                                user = user + ' ' + u.lastName;
                            }

                        });

                        l.userInfo = user;
                        l.link = true;
                        linkFolder.productsList.push(l);
                    });

                    ProductMain.productsList.push(linkFolder);
                    ProductMain.productsTreeList.push(linkFolder);
                    //

                    treeList.push(ProductMain);
                    $scope.models.product.tree.data = treeList;

                });


            });
        } else {
            $scope.models.product.tree.data = [];
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.panel = false;
        }

    };

    $scope.models.product.checkDataLoaded = function () {
        if (!$scope.models.product.dataLoaded) {
            alert('Load a data record first!');
        }
    };

    $scope.models.product.drawCustomObject = function (file) {
        webgl.draw({file: file.file, id: $scope.models.product.details.id}, "draw", "custom_object");
    };

    $scope.models.product.file3dUpdate = function (file) {
        if (!file.notes) {
            file.notes = '';
        }
        request.file3dUpdate(file).then(function (response) {
            file.change = false;
            $scope.render.redraw('product');
        });
    };

    $scope.models.product.file3dRemove = function (file, index) {
        request.file3dRemove(file.id, file.file, $scope.models.product.details.id).then(function (response) {
            if (response.success) {
                $scope.models.product.files_list.splice(index, 1);
                $scope.render.redraw('product');
            }
        });
    };

    $scope.models.product.formEpaChart = function (object) {
        var angles = [0, 45, 90, 135, 180, 225, 270, 315, 360];
        // var angles = [0, 15, 30, 45, 60, 75, 90, 105, 120, 135, 150, 165, 180, 195, 210, 225, 240, 255, 270, 285, 300, 315, 330, 345, 360];
        var epas = [];

        if (object.geometryShapeType == 'Cuboid') {

            var height = object.d1;
            var width = object.d2;
            var depth = object.d3;

            for (var i = 0; i < angles.length; i++) {
                var epa = height * width * Math.cos(angles[i]) + height * depth * Math.sin(angles[i]);

                epas.push(epa.toFixed(2));
            }

        } else if (object.geometryShapeType == 'Cylinder') {

            var height = object.d1;
            var width = object.d2;
            var depth = object.d1; //!

            for (var i = 0; i < angles.length; i++) {
                var epa = height * width * Math.cos(angles[i]) + height * depth * Math.sin(angles[i]);

                epas.push(epa.toFixed(2));
            }

        } else if (object.geometryShapeType == 'Sphere') {

            var height = object.d1;
            var width = object.d1; //!
            var depth = object.d1; //!

            for (var i = 0; i < angles.length; i++) {
                var epa = height * width * Math.cos(angles[i]) + height * depth * Math.sin(angles[i]);

                epas.push(epa.toFixed(2));
            }

        }

        $scope.models.product.chart_data = [epas];
    };

    $scope.models.product.epaSlider = function () {
        if ($scope.models.product.epa_slider_values[$scope.models.product.slider_value]) {
            $scope.models.product.epa_slider_value = $scope.models.product.epa_slider_values[$scope.models.product.slider_value].toFixed(2);
        }
    };

    $scope.models.product.plotResize = function (d2, d3) {
        var res = d2 / d3;
        var base_heigth = 60;

        var height;
        var width;

        height = base_heigth;
        width = base_heigth * res;

        if (width > 60) {
            height = height * (60 / width);
            width = 60;
        }

        if (height < 1) height = 1;
        if (width < 1) width = 1;

        $scope.models.product.plot_height = height;
        $scope.models.product.plot_width = width;
    };

    $scope.models.product.calc_wind_faces = function () {

        var data = {};

        data.windAreas = $scope.models.product.wind_areas;

        data.custom_ice = $scope.models.product.custom_ice;
        data.d1 = $scope.models.product.details['d1'];
        data.d2 = $scope.models.product.details['d2'] || 1;
        data.d3 = $scope.models.product.details['d3'] || 1;

        data.weight1 = $scope.models.product.details['weight1'] || 1;

        data.geometryShapeType = $scope.models.product.details['geometryShapeType'] || "Cuboid";

        data.weight_wo_mkit = $scope.models.product.details.weight_wo_mkit || 0;

        request.calc_wind_faces(data).then(function (response) {

            $scope.models.product.changed = true;

            if (!$scope.models.product.wind_areas) {
                $scope.models.product.wind_areas = [];
            }

            if (response.da && response.da.faces) {
                response.da.faces.forEach(function (face) {


                    let wa_face = {
                        db_pro_PK: $scope.models.product.details.id,

                        face_name: face.name || '',
                        shape: face.shape || '',
                        px: face.position[0] || 0,
                        py: face.position[1] || 0,
                        pz: face.position[2] || 0,
                        width: face.wth.value || 0,
                        height: face.lth.value || 0,
                        p_a_a: face.P_A_A_A.value || 0,
                        ndx: face.n_dir_vec[0] || 0,
                        ndy: face.n_dir_vec[1] || 0,
                        ndz: face.n_dir_vec[2] || 0,
                        azimuth: face.azimuth.value || 0,
                        creation: 'auto'
                    };

                    let found = false;

                    for (let k = $scope.models.product.wind_areas.length - 1; k >= 0; k--) {

                        if ($scope.models.product.wind_areas[k].creation === 'auto' && $scope.models.product.wind_areas[k].face_name === wa_face.face_name) {

                            wa_face.id = $scope.models.product.wind_areas[k].id;
                            $scope.models.product.wind_areas[k] = wa_face;

                            found = true;

                        }

                    }

                    if (!found) {
                        $scope.models.product.wind_areas.push(wa_face);
                    }

                });
            }

            let epa_plot = [];

            response.EPA_A_plot.forEach(function (face) {
                epa_plot.push(face.epa_a.value);
            });

            // $scope.models.product.epa_slider_values = response.EPA_A_slider;

            // $scope.models.product.calculate = response.calculate;

            // for(var i = 0; i < $scope.models.product.wa_loading.length; i++) {
            //     var item = $scope.models.product.wa_loading[i];
            //
            //     for(var l = 0; l < response.windAreas.length; l++) {
            //         var res_item = response.windAreas[l];
            //
            //         if(res_item.id == item.id) {
            //             item.Aa_0 = parseFloat(res_item.Aa_0).toFixed(2);
            //             item.Aa_05 = parseFloat(res_item.Aa_05).toFixed(2);
            //             item.Aa_1 = parseFloat(res_item.Aa_1).toFixed(2);
            //             item.Aa_2 = parseFloat(res_item.Aa_2).toFixed(2);
            //             item.Aa_4 = parseFloat(res_item.Aa_4).toFixed(2);
            //             item.Aa_x = parseFloat(res_item.Aa_x).toFixed(2);
            //         }
            //     }
            // }
            //
            // $scope.models.product.details.weight0 = parseFloat(response.weight0).toFixed(2);
            // $scope.models.product.details.weight05 = parseFloat(response.weight05).toFixed(2);
            // $scope.models.product.details.weight1 = parseFloat(response.weight1).toFixed(2);
            // $scope.models.product.details.weight2 = parseFloat(response.weight2).toFixed(2);
            // $scope.models.product.details.weight4 = parseFloat(response.weight4).toFixed(2);
            // $scope.models.product.details.weightx = parseFloat(response.weightx).toFixed(2);

            // var minE = 0,
            //     maxE = 0;
            //
            // response.EPA_A_plot.forEach(function (item) {
            //     if(item > maxE) {
            //         maxE = item;
            //     }
            //     if(item < minE) {
            //         minE = item;
            //     }
            // });
            //
            // if(minE < 0) {
            //     if(minE < -9999) {
            //         $scope.models.product.slider_width = '227px';
            //         $scope.models.product.slider_left = '84px';
            //     } else if(minE < -999){
            //         $scope.models.product.slider_width = '226px';
            //         $scope.models.product.slider_left = '77px';
            //     } else if(minE < -99){
            //         $scope.models.product.slider_width = '233px';
            //         $scope.models.product.slider_left = '70px';
            //     } else if(minE < -9){
            //         $scope.models.product.slider_width = '240px';
            //         $scope.models.product.slider_left = '63px';
            //     }
            // } else {
            //     if(maxE > 9999) {
            //         $scope.models.product.slider_width = '231px';
            //         $scope.models.product.slider_left = '80px';
            //     } else if(maxE > 999){
            //         $scope.models.product.slider_width = '230px';
            //         $scope.models.product.slider_left = '73px';
            //     } else if(maxE > 99){
            //         $scope.models.product.slider_width = '237px';
            //         $scope.models.product.slider_left = '66px';
            //     } else if(maxE > 9){
            //         $scope.models.product.slider_width = '244px';
            //         $scope.models.product.slider_left = '59px';
            //     }
            // }

            $scope.models.product.chart_data = [epa_plot];
            $scope.models.product.epa_slider_values = epa_plot;

            // $scope.models.product.formEpaChart($scope.models.product.details);
        });

    };

    $scope.models.product.getWA = function () {

        request.getWA($scope.models.product.details.id).then(function (response) {
            $scope.models.product.deleted_wa = [];
            $scope.models.product.wind_areas = response;
        });

    };

    $scope.models.product.addWA = function (new_wa) {
        let data = new_wa ? angular.copy(new_wa) : angular.copy($scope.models.product.new_wa);

        data.db_pro_PK = $scope.models.product.details.id;
        data.creation = 'manual';

        $scope.models.product.changed = true;

        // request.addWA(data).then(function (response) {

        $scope.models.product.wind_areas.push(data);

        $scope.models.product.new_wa = {};

        // });
    };

    $scope.models.product.saveWA = function (item) {
        if ($scope.auth.isAuth()) {
            item.changed = false;

            var saved = angular.copy(item);
            delete saved.changed;

            request.saveWA(saved).then(function (response) {
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.product.saveAllWA = function () {

        if ($scope.models.product.wind_areas) {
            $scope.models.product.wind_areas.forEach(function (wa) {

                if (wa.id) {
                    $scope.models.product.saveWA(wa);
                } else {

                    let data = angular.copy(wa);

                    data.db_pro_PK = $scope.models.product.details.id;

                    request.addWA(data).then(function (response) {
                        wa.id = response.id;
                    });

                }

            });


        }

    };

    $scope.models.product.deleteWA = function (id, index) {


        if ($scope.auth.isAuth()) {

            $scope.models.product.changed = true;
            $scope.models.product.deleted_wa.push(id);
            $scope.models.product.wind_areas.splice(index, 1);

        } else {
            alert("Function(s) available to registered user only");
        }

    };

    $scope.models.product.removeWA = function (id, index) {

        request.removeWA(id).then(function (response) {

        });

    };

    $scope.models.product.changeWAsize = function (item) {
        if (item.d1 && item.d2 && item.shape) {
            if (item.shape == 'Rectangular') {
                item.size = item.d1 * item.d2;
            } else if (item.shape == 'Circular') {
                item.size = (item.d1 * item.d1 * Math.PI / 4).toFixed(2);
            } else if (item.shape == 'Sphere') {
                item.size = (item.d1 * item.d1 * Math.PI / 4).toFixed(2);
            }
        }
    };

    $scope.unitConversionProcess = function (item) {

        if (item.shape === 'SR' || item.shape === 'Plate') {
            item.size1 = parseFloat(item.size1);
        }

        if (item.shape === 'Plate') {
            item.size2 = parseFloat(item.size2);
        }

        $http({
            method: 'GET',
            url: './../general/calcs/ALL/code/AISC/SCM/CodeInfo-AISC-SCM.json',
        }).then(function successCallback(response) {
            $scope.unitsData = response.data.Unit || {};

            if (item.A) {
                var crtValue = parseFloat(item.A);
                if (!isNaN(crtValue)) {
                    var crtUnit = $scope.unitsData.US_Customary.A;
                    var unit2be = $scope.units.find('db_geo_sec', 'A');
                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                    item.A = value2be;
                } else item.A = '';
            }

            if (item.Izz) {
                var crtValue = parseFloat(item.Izz);
                if (!isNaN(crtValue)) {
                    var crtUnit = $scope.unitsData.US_Customary.I_x;
                    var unit2be = $scope.units.find('db_geo_sec', 'Izz');
                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                    item.Izz = value2be;
                } else item.Izz = '';
            }

            if (item.Iyy) {
                var crtValue = parseFloat(item.Iyy);
                if (!isNaN(crtValue)) {
                    var crtUnit = $scope.unitsData.US_Customary.I_y;
                    var unit2be = $scope.units.find('db_geo_sec', 'Iyy');
                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                    item.Iyy = value2be;
                } else item.Iyy = '';
            }

            if (item.I_z) {
                var crtValue = parseFloat(item.I_z);
                if (!isNaN(crtValue)) {
                    var crtUnit = $scope.unitsData.US_Customary.I_x;
                    var unit2be = $scope.units.find('db_geo_sec', 'Izz');
                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                    item.I_z = value2be;
                } else item.I_z = '';
            }

            if (item.I_y) {
                var crtValue = parseFloat(item.I_y);
                if (!isNaN(crtValue)) {
                    var crtUnit = $scope.unitsData.US_Customary.I_y;
                    var unit2be = $scope.units.find('db_geo_sec', 'Iyy');
                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                    item.I_y = value2be;
                } else item.I_y = '';
            }

            if (item.J) {
                var crtValue = parseFloat(item.J);
                if (!isNaN(crtValue)) {
                    var crtUnit = $scope.unitsData.US_Customary.J;
                    var unit2be = $scope.units.find('db_geo_sec', 'J');
                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                    item.J = value2be;
                } else item.J = '';
            }
        });

        if (item.E) {
            var crtValue = parseFloat(item.E);
            if (!isNaN(crtValue)) {
                var crtUnit = $scope.shared_units.find('db_material', 'e');
                var unit2be = $scope.units.find('db_geo_mat', 'e');
                var value2be = unitConversion(crtValue, crtUnit, unit2be);
                item.E = value2be;
            } else item.E = '';
        }

        if (item.Rho) {
            var crtValue = parseFloat(item.Rho);
            if (!isNaN(crtValue)) {
                var crtUnit = $scope.shared_units.find('db_material', 'density');
                var unit2be = $scope.units.find('db_geo_mat', 'rho');
                var value2be = unitConversion(crtValue, crtUnit, unit2be);
                item.Rho = value2be;
            } else item.Rho = '';
        }

        if (item.G) {
            var crtValue = parseFloat(item.G);
            if (!isNaN(crtValue)) {
                var crtUnit = $scope.shared_units.find('db_material', 'g');
                var unit2be = $scope.units.find('db_geo_mat', 'g');
                var value2be = unitConversion(crtValue, crtUnit, unit2be);
                item.G = value2be;
            } else item.G = '';
        }

        if (item.Nu) {
            var crtValue = parseFloat(item.Nu);
            if (!isNaN(crtValue)) {
                var crtUnit = $scope.shared_units.find('db_material', 'nu');
                var unit2be = $scope.units.find('db_geo_mat', 'nu');
                var value2be = unitConversion(crtValue, crtUnit, unit2be);
                item.Nu = value2be;
            } else item.Nu = '';

        }

        if (item.fy) {
            var crtValue = parseFloat(item.fy);
            if (!isNaN(crtValue)) {
                var crtUnit = $scope.shared_units.find('db_material', 'fy');
                var unit2be = $scope.units.find('db_geo_mat', 'fy');
                var value2be = unitConversion(crtValue, crtUnit, unit2be);
                item.fy = value2be;
            } else item.fy = '';
        }

        if (item.fu) {
            var crtValue = parseFloat(item.fu);
            if (!isNaN(crtValue)) {
                var crtUnit = $scope.shared_units.find('db_material', 'fu');
                var unit2be = $scope.units.find('db_geo_mat', 'fu');
                var value2be = unitConversion(crtValue, crtUnit, unit2be);
                item.fu = value2be;
            } else item.fu = '';
        }
    }

    $scope.sortByIntId = function (a, b) {
        var aId = parseInt(a.no || a.id || a.RcdId);
        var bId = parseInt(b.no || b.id || b.RcdId);
        return aId - bId;
    };

    $scope.sortByCreatedDate = function (a, b) {
        let dateObjA = new Date(a.createdOn || 0);
        let dateObjB = new Date(b.createdOn || 0);

        if (dateObjA < dateObjB) {
            return -1;
        }
        if (dateObjB < dateObjA) {
            return 1;
        }
    };

    //GEOMETRY
    $scope.models.geometry.changeItem = function (item) {
        if (item.select == null) {
            $scope.models.geometry.selected.forEach(function (selected, index) {
                if (item.key == selected.key) {
                    $scope.models.geometry.selected.splice(index, 5);
                    if (index == 0) {
                        $scope.query.resetGeometry();
                        $scope.models.geometry.dataLoaded = false;
                    } else {
                        $scope.models.geometry.changeItem(item);
                    }
                    return false;
                }
            });
        } else {
            $scope.models.buildTabs(item, $scope.models.tabs, function (items, details) {

                $scope.models.geometry.items = items;

                if (details.data && details.data.length === 1) {

                    $scope.models.geometry.dataLoaded = true;

                    $scope.models.nodes.add.db_geo_PK = details.data[0].id;
                    $scope.models.secs.add.db_geo_PK = details.data[0].id;
                    $scope.models.geometry.newMaterial.db_geo_PK = details.data[0].id;
                    //$scope.models.geometry.newMaterial.org = $scope.models.geometry.materialsLists.orgList[0].value || '';
                    $scope.models.geometry.db_geo_PK = details.data[0].id;
                    $scope.models.geometry.details = details.data || [];
                    $scope.models.geometry.members = details.members;
                    if ($scope.models.geometry.members) $scope.models.geometry.members.sort($scope.sortByIntId);
                    $scope.models.geometry.nodes = details.nodes;
                    if ($scope.models.geometry.nodes) $scope.models.geometry.nodes.sort($scope.sortByIntId);
                    $scope.models.geometry.nodes_p = details.nodes_p || [];
                    $scope.models.geometry.secs = details.secs;
                    if ($scope.models.geometry.secs) $scope.models.geometry.secs.sort($scope.sortByIntId);
                    $scope.models.geometry.connectors = details.connectors || [];
                    if ($scope.models.geometry.connectors) $scope.models.geometry.connectors.sort($scope.sortByIntId);
                    $scope.models.geometry.connections = details.connections || [];
                    if ($scope.models.geometry.connections) $scope.models.geometry.connections.sort($scope.sortByIntId);

                    $scope.models.geometry.list_assoc = [];
                    $scope.models.geometry.list_analysis_eq = [];
                    $scope.models.geometry.list_analysis_lc = [];
                    $scope.models.geometry.list_analysis_dc = [];

                    $scope.models.geometry.getSectionsInfo(function (response) {
                        if (response.data) {
                            $scope.sectionsInfo = response.data;
                            $scope.sectionsInfo.forEach(function (item) {
                                $scope.unitConversionProcess(item);
                            });
                        }
                        $scope.models.geometry.nodes_p.forEach(function (parameter) {
                            $scope.models.geometry.changeSection(parameter);
                        });

                        angular.forEach($scope.models.geometry.secs, function (item) {
                            item.shapeList = angular.copy($scope.models.geometry.shapesList.shapeList);
                            item.size1List = angular.copy($scope.models.geometry.shapesList.size1List);
                            item.size2List = angular.copy($scope.models.geometry.shapesList.size2List);
                        });

                        $scope.models.geometry.materials = details.materials;
                        if ($scope.models.geometry.materials) $scope.models.geometry.materials.sort($scope.sortByIntId);

                        angular.forEach($scope.models.geometry.materials, function (item) {
                            item.orgList = angular.copy($scope.models.geometry.materialsLists.orgList);
                            item.standardList = angular.copy($scope.models.geometry.materialsLists.standardList);
                            item.gradeList = angular.copy($scope.models.geometry.materialsLists.gradeList);
                        });

                        $scope.models.geometry.association = angular.copy($scope.models.geometry.reset.association);
                        $scope.models.geometry.analysis = angular.copy($scope.models.geometry.reset.analysis);

                        $scope.query.pdfGeometry();
                        $scope.models.geometry.getPhotoList();

                        var product = {};

                        angular.forEach($scope.models.geometry.items, function (item) {
                            if (item.select) {
                                product[item.key] = item.select.value;
                            }
                        });

                        $scope.models.geometry.getGeometryAssociationsList(function (assoc_list) {

                            request.getGeometryAssociationNew(assoc_list).then(function (response) {

                                $scope.models.geometry.list_assoc = response;

                                angular.forEach($scope.models.geometry.list_assoc, function (list) {
                                    list.association = angular.copy($scope.models.geometry.reset.association);

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

                            });

                        });
                        $scope.models.geometry.getAnalysisCombinations();

                        $scope.models.geometry.getAnalysis(function (analysis_ids) {

                            request.getAnalysisEqpt(analysis_ids).then(function (response_data) {

                                if (response_data) {

                                    var products_analys = [];

                                    $scope.models.product.list.forEach(function (item) {

                                        response_data.forEach(function (product) {

                                            if (item.id == product.db_pro_PK) {
                                                var tmp = angular.copy(item);
                                                tmp.analysis_name = product.name;
                                                tmp.analysis_notes = product.notes;
                                                tmp.eqpt_id = product.id;
                                                tmp.createdOn = product.createdOn;
                                                products_analys.push(tmp);
                                            }
                                        })
                                    });

                                    $scope.models.geometry.list_analysis_eq = products_analys;
                                    if ($scope.models.geometry.list_analysis_eq) $scope.models.geometry.list_analysis_eq.sort($scope.sortByCreatedDate);

                                    angular.forEach($scope.models.geometry.list_analysis_eq, function (list) {
                                        list.association = angular.copy($scope.models.geometry.reset.association);

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

                                }

                                $scope.models.geometry.drawWholeGeometry();

                            });

                        });

                    });


                }
            });
        }
    };

    // $scope.models.geometry.saveItem = function () {
    //     if (!$scope.models.geometry.details.length) {
    //         $scope.models.geometry.items.forEach(function(item) {
    //             if(item.select.id == "new"){
    //                 var current = {
    //                     key: item.key,
    //                     select: {
    //                         value: item.select.value
    //                     }
    //                 };
    //
    //                 $scope.models.geometry.addDetail();
    //                 $scope.models.geometry.changeItem(current);
    //                 return false;
    //             }
    //         });
    //     }
    //
    //     angular.forEach($scope.models.geometry.secs, function (secs) {
    //         $scope.models.geometry.saveSec(secs);
    //     });
    //
    //     angular.forEach($scope.models.geometry.nodes, function (nodes) {
    //         $scope.models.geometry.saveNode(nodes);
    //     });
    //
    //     angular.forEach($scope.models.geometry.details, function (details) {
    //         $scope.models.geometry.saveDetail(details);
    //     });
    // };

    $scope.models.geometry.removeItem = function (flag) {
        if ($scope.auth.isAuth()) {
            request.remove($scope.models.geometry.details[0].id, "geometry", flag).then(function (response) {
                $scope.query.resetGeometry();
            });
        } else {
            alert("Function(s) available to registered user only");
        }

    };

    $scope.models.geometry.addMember = function () {
        if ($scope.auth.isAuth()) {

            var found = false;

            $scope.models.add.db_geo_PK = $scope.models.geometry.db_geo_PK;

            if (!$scope.models.geometry.members) {
                $scope.models.geometry.members = [];
            }

            if ($scope.models.add.Mbr_Name) {

                $scope.models.geometry.members.forEach(function (item) {
                    if (item.Mbr_Name == 'M' + $scope.models.add.Mbr_Name) {
                        found = true;
                    }
                });

                if (found) {
                    alert('Name should be unique');
                    return;
                }

                $scope.models.add.Mbr_Name = 'M' + $scope.models.add.Mbr_Name;
            } else {
                $scope.models.add.Mbr_Name = 'M' + ($scope.models.geometry.members.length + 1);
            }

            request.saveMember($scope.models.add, "new").then(function (response) {

                $scope.models.geometry.insertMemberModal = false;

                $scope.models.add = {};

                $scope.models.geometry.members.push(response);

                $scope.models.geometry.drawWholeGeometry();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveMember = function (item) {
        if ($scope.auth.isAuth()) {
            item.changed = false;

            var saved = angular.copy(item);
            delete saved.changed;
            delete saved.selected;

            saved.db_geo_PK = $scope.models.geometry.db_geo_PK;

            request.saveMember(saved, "save").then(function (response) {
                $scope.models.geometry.drawWholeGeometry();
            });

        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeMember = function (id, index) {
        if ($scope.auth.isAuth()) {
            request.removeMember(id).then(function (response) {
                $scope.models.geometry.members.splice(index, 1);
                $scope.models.geometry.drawWholeGeometry();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.insertNewMember = function () {

        let data = $scope.models.geometry.insertedMemberData.split(' ') || [];

        if (data && data[0]) {

            $scope.models.add = {};

            $scope.models.add.Mbr_Name = data[0] || '';

            $scope.models.add.sec_name = data[1] || '';

            $scope.models.add.ROT = data[5] || '';

            let ns = data[2];
            let ne = data[3];
            let no = data[4];
            let nsid = 0;
            let neid = 0;
            let noid = 0;

            $scope.models.geometry.nodes.forEach(function (node) {

                if (node.node_name === ns) {
                    nsid = node.no;
                }

                if (node.node_name === ne) {
                    neid = node.no;
                }

                if (node.node_name === no) {
                    noid = node.no;
                }

            });

            $scope.models.add.NodeS = nsid;
            $scope.models.add.NodeE = neid;
            $scope.models.add.NodeO = noid;

            $scope.models.geometry.addMember();


        }

    };

    $scope.models.geometry.addDetail = function () {
        if ($scope.auth.isAuth()) {
            angular.forEach($scope.models.geometry.items, function (items) {
                $scope.models.add[items.key] = items.select ? items.select.value : '';
            });

            $scope.models.add.db_geo_PK = $scope.models.geometry.db_geo_PK;

            if ($scope.models.add.Mbr_Name) {
                $scope.models.add.Mbr_Name = 'M' + $scope.models.add.Mbr_Name;
            } else {
                $scope.models.add.Mbr_Name = 'M';
            }

            request.update($scope.models.add, "geometry", "new").then(function (response) {
                $scope.models.add = {};
                $scope.models.geometry.details.push(response.data);
                $scope.models.geometry.drawWholeGeometry();
            });

        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveDetail = function (item) {
        if ($scope.auth.isAuth()) {
            item.changed = false;

            var saved = angular.copy(item);
            delete saved.changed;
            delete saved.selected;

            saved.db_geo_PK = $scope.models.geometry.db_geo_PK;

            request.update(saved, "geometry", "save").then(function (response) {
                $scope.models.geometry.drawWholeGeometry();
            });

        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeDetail = function (id, index) {
        if ($scope.auth.isAuth()) {
            request.remove(id, "geometry", null, 'id').then(function (response) {
                $scope.models.geometry.details.splice(index, 1);
                $scope.models.geometry.drawWholeGeometry();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.getGeometryAssociationsList = function (callback) {

        request.getGeometryAssociationsList($scope.models.geometry.details[0].id).then(function (response) {

            if (callback) {
                callback(response);
            }
        });
    };

    $scope.models.geometry.addAssociation = function () {
        let data = {};

        $scope.models.geometry.getGeometryAssociationsList();

        data.db_geo_PK = $scope.models.geometry.details[0].id;
        data.db_pro_PK = $scope.models.geometry.association[0].select.id;


        $scope.models.geometry.getGeometryAssociationsList(function (assoc_list) {
            var found = false;

            assoc_list.forEach(function (item) {
                if (item == data.db_pro_PK) {
                    found = true;
                }
            });

            if (!found) {
                request.addGeometryAssociation(data).then(function (response) {

                    assoc_list.push(data.db_pro_PK);

                    request.getGeometryAssociationNew(assoc_list).then(function (response) {

                        $scope.models.geometry.list_assoc = response;

                        angular.forEach($scope.models.geometry.list_assoc, function (list) {
                            list.association = angular.copy($scope.models.geometry.reset.association);

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

                    });

                });
            }

        });
    };

    $scope.models.geometry.saveAssociation = function (item) {
        var temp = angular.copy(item);

        angular.forEach(temp.association, function (association) {
            if (association.select) {
                temp[association.key] = association.select.value
            } else {
                temp[association.key] = "";
            }
        });

        if (temp.association) {
            delete temp.association;
        }

        request.update(temp, "all", "save").then(function (response) {
        });
    };

    $scope.models.geometry.saveAssociationNew = function (item) {

        var old_product_id = item.no;
        var new_product_id = item.association[0].select.id;
        var db_geo_PK = $scope.models.geometry.details[0].id;

        request.updateGeometryAssociation(db_geo_PK, old_product_id, new_product_id).then(function (response) {

        });

    };

    $scope.models.geometry.removeAssociation = function (index, id) {
        if ($scope.auth.isAuth()) {
            request.remove(id, "all").then(function (response) {
                $scope.models.geometry.list_assoc.splice(index, 1);
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeAssociationNew = function (index, id) {
        request.removeGeometryAssociation($scope.models.geometry.details[0].id, id).then(function (response) {
            $scope.models.geometry.list_assoc.splice(index, 1);
        });
    };

    $scope.models.geometry.changeAssociation = function (item, index, list) {
        var new_row = false;

        if (!list) {
            new_row = true;
        }

        if (list && list.no != $scope.models.geometry.edited_associate_row) {
            new_row = true;
            $scope.models.geometry.edited_associate_row = list.no;
        }

        if (item.select == null) {
            if (index) {
                $scope.models.geometry.list_assoc[index].association = angular.copy($scope.models.geometry.reset.association);
            } else {
                $scope.models.geometry.association = angular.copy($scope.models.geometry.reset.association);
            }

            return false;
        }

        $scope.models.buildTabs(item, "all", function (items, details) {
            if (index || index === 0) {
                $scope.models.geometry.list_assoc[index].association = items;
            } else {
                $scope.models.geometry.association = items;
            }
        }, new_row);
    };

    $scope.models.geometry.addAnalysisEqpt = function () {

        let selected = [];
        let name = '';

        angular.forEach($scope.models.geometry.analysis, function (association) {
            if (association.key === 'model' && association.select) {
                name = association.select.value || '';
            }

            if (association.select) {
                selected.push({
                    id: association.select.id,
                    key: association.key,
                    value: association.select.value
                });
            }
        });

        if (!$scope.models.geometry.analysis_name) {
            if (name) {
                $scope.models.geometry.analysis_name = name;
            } else {
                alert('You must enter a name for the new entry.');
                return;
            }
        }

        request.items(selected, 'all', $scope.userLoadInfo).then(function (details) {
            if (details.data && details.data[0]) {

                var an_data = {
                    analysis_id: $scope.models.geometry.lc_analysis_active.id,
                    db_pro_PK: details.data[0].id,
                    name: $scope.models.geometry.analysis_name,
                    notes: $scope.models.geometry.analysis_notes
                };

                request.addAnalysisEqpt(an_data).then(function (response) {

                    var lc_ids = [];

                    $scope.models.geometry.list_analysis_lc.forEach(function (lc) {
                        lc_ids.push(lc.id);
                    });

                    request.getAnalysisEqpt(lc_ids).then(function (response_data) {

                        if (response_data && response_data.length > 0) {

                            var products_analys = [];

                            $scope.models.product.list.forEach(function (item) {
                                response_data.forEach(function (product) {
                                    if (item.id == product.db_pro_PK) {
                                        var tmp = angular.copy(item);
                                        tmp.analysis_name = product.name;
                                        tmp.analysis_notes = product.notes;
                                        tmp.eqpt_id = product.id;
                                        tmp.createdOn = product.createdOn;
                                        products_analys.push(tmp);
                                    }
                                })

                            });

                            $scope.models.geometry.list_analysis_eq = products_analys;
                            if ($scope.models.geometry.list_analysis_eq) $scope.models.geometry.list_analysis_eq.sort($scope.sortByCreatedDate);

                            angular.forEach($scope.models.geometry.list_analysis_eq, function (list) {
                                list.association = angular.copy($scope.models.geometry.reset.association);

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
                            angular.forEach($scope.models.geometry.analysis, function (item) {
                                if (item.select) item.select = {};
                            });
                            $scope.models.geometry.analysis_name = '';
                        }
                    });
                });
            }
        });
    };

    $scope.models.geometry.saveAnalysisEqpt = function (list) {
        var old_id = list.db_pro_PK;
        var selected = [];

        angular.forEach(list.association, function (association) {
            if (association.select) {
                selected.push({
                    id: association.select.id,
                    key: association.key,
                    value: association.select.value
                });
            }
        });

        request.items(selected, 'all', $scope.userLoadInfo).then(function (details) {
            if (details.data && details.data[0]) {

                list.db_geo_PK = details.data[0].id;
                list.Type_G = details.data[0].Type_G;
                list.Shape_G = details.data[0].Shape_G;
                list.Model_G = details.data[0].Model_G;
                list.Sub_type_G = details.data[0].Sub_type_G;
                list.Mftr_G = details.data[0].Mftr_G;
                list.type = details.data[0].type;
                list.shape = details.data[0].shape;
                list.model = details.data[0].model;
                list.sub_type = details.data[0].sub_type;
                list.mftr = details.data[0].mftr;
                list.geometryType = details.data[0].geometryType;
                list.geometryShapeType = details.data[0].geometryShapeType;
                list.d1 = details.data[0].d1;
                list.d2 = details.data[0].d2;
                list.d3 = details.data[0].d3;

                var data = {
                    geom_id: $scope.models.geometry.details[0].id,
                    new_product_id: details.data[0].id,
                    old_id: old_id,
                    eqpt_id: list.eqpt_id,
                    name: list.analysis_name,
                    notes: list.analysis_notes
                };

                request.updateAnalysisEqpt(data).then(function (response) {
                    list.change = false;
                    $scope.models.geometry.drawWholeGeometry();
                })
            }
        });
    };

    $scope.models.geometry.removeAnalysisEqpt = function (index, list) {
        if ($scope.auth.isAuth()) {
            request.removeAnalysisEqpt(list.id, list.analysis_name).then(function (response) {
                $scope.models.geometry.list_analysis_eq.splice(index, 1);
                $scope.models.geometry.drawWholeGeometry();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.changeAnalysis = function (item, index, list) {

        var new_row = false;

        if (!list) {
            new_row = true;
        }

        if (list && list.no != $scope.models.geometry.edited_analysis_row) {
            new_row = true;
            $scope.models.geometry.edited_analysis_row = list.no;
        }

        if (item.select == null) {
            if (index) {
                $scope.models.geometry.list_analysis_eq[index].association = angular.copy($scope.models.geometry.reset.analysis);
            } else {
                $scope.models.geometry.analysis = angular.copy($scope.models.geometry.reset.analysis);
            }

            return false;
        }

        $scope.models.buildTabs(item, "all", function (items, details) {
            if (index || index === 0) {
                $scope.models.geometry.list_analysis_eq[index].association = items;

                if (details.data && details.data[0]) {
                    $scope.models.geometry.list_analysis_eq[index].id = details.data[0].id;
                }

            } else {
                $scope.models.geometry.analysis = items;
            }
        }, new_row);
    };

    $scope.models.geometry.formAnalysisFile = function (lc) {
        // console.log('AFile', lc);
        request.formAnalysisFile($scope.models.geometry.details[0].id, lc.id).then(function (response) {
            lc.run = true;
            // console.log('response', lc);
            // $scope.models.geometry.openAnalysisFile(lc);
        });
    };

    $scope.models.geometry.openAnalysisFile = function (lc) {
        // console.log('here', lc)
        $window.open('documents/analysis/' + $scope.models.geometry.details[0].id + '/Analysis.json', '_blank');
    };

    $scope.models.geometry.formAnalysisPDF = function (lc) {
        if ($scope.models.geometry.details[0].id) {
            // var path = window.btoa('{"appName":"WID", "dataCategory":"geometry", "geometryPK":"' + $scope.models.geometry.details[0].id + '", "db_geo_PK":"' + $scope.models.geometry.details[0].id + '"}');
            var path = window.btoa('{"appName":"WID", "dataCategory":"geometry", "db_geo_PK":"' + $scope.models.geometry.details[0].id + '"}');
            // geometryPK is repeating db_geo_PK
            $window.open('./../../pdf.php?prts=' + path, '_blank');
        }
    };

    $scope.models.geometry.getLcDcLists = function (db_geo_PK, callback) {
        request.getLcDcLists(db_geo_PK).then((res) => {
            $scope.models.geometry.lcs = res.lcs;
            $scope.models.geometry.dcs = res.dcs;

            if (callback) callback();
        });
    };

    $scope.models.geometry.addAnalysisCombination = function (new_combination) {
        let equals_combinations = false;
        let foundLC = false;
        let foundDC = false;

        $scope.models.geometry.analysisCombinations.forEach(function (comb) {
            if (new_combination.lc_id == comb.lc_id && new_combination.dc_id == comb.dc_id) {
                equals_combinations = true;
            }
        });

        if (equals_combinations) {
            alert("You already have this combination");
            return;
        }

        $scope.models.geometry.activeGeometryLcParentList.forEach(function (item) {
            if (item.lc_name === new_combination.new_lc) foundLC = true;
        });

        $scope.models.geometry.activeGeometryDcList.forEach(function (item) {
            if (item.dc_name === new_combination.new_dc) foundDC = true;
        });

        if (foundLC || foundDC) {
            alert('LC and DC name should be unique');
            return;
        }

        let data = angular.copy(new_combination);
        data["db_geo_PK"] = $scope.models.geometry.details[0].id;
        data["notes"] = new_combination.notes;

        delete data.new_dc;
        delete data.new_lc;

        if (new_combination.new_dc) {
            request.createDC($scope.models.geometry.details[0].id, new_combination.new_dc).then(res => {
                data["dc_id"] = "" + res.new_dc_id;
                $scope.models.geometry.activeGeometryDcList.push(res.new_dc);
                $scope.$applyAsync();
            });
        } else {
            data["dc_id"] = new_combination.dc_id;
        }
        ;

        if (new_combination.new_lc) {
            request.createLC($scope.models.geometry.details[0].id, new_combination.new_lc).then(res => {
                data["lc_id"] = "" + res.new_lc_id;
                $scope.models.geometry.activeGeometryLcParentList.push(res.new_lc_parent);
                $scope.$applyAsync();
            });
        } else {
            data["lc_id"] = new_combination.lc_id;
        }
        ;

        $scope.header.addHeader(function (new_id) {
            data.headerPK = new_id;

            $scope.footer.addFooter(function (new_f_id) {
                data.footerPK = new_f_id;
                request.addAnalysisCombination(data).then(function (res) {
                    if (res.status) {
                        data.id = res.new_id;
                        $scope.models.geometry.analysisCombinations.push(data);
                        $scope.models.geometry.new_combination = {};
                    }
                    ;
                });
            });
        });
    };

    $scope.models.geometry.getAnalysisCombinations = function (callback) {
        let db_geo_PK = $scope.models.geometry.details[0].id;
        request.getAnalysisCombinations(db_geo_PK).then((res) => {
            $scope.models.geometry.activeGeometryDcList = res.dcs || [];
            $scope.models.geometry.activeGeometryLcParentList = res.lcs_parents || [];
            $scope.models.geometry.activeGeometryLcList = res.lcs || [];
            $scope.models.geometry.analysisCombinations = res.analysisCombinations || [];

            $scope.models.geometry.generateAnalysisMountName();

            $scope.viewByStatusPanel.getReadyViewByStatusPanelFilter($scope.models.geometry.activeGeometryLcList);

            if (callback) callback();
        });

    };


    $scope.models.geometry.generateAnalysisMountName = function () {

        $scope.models.geometry.analysisCombinations.forEach((comb) => {

            let name = 'documents/';
            let dcname = '';
            let lcname = '';

            name += $scope.models.geometry.details[0].Model_G + "/" + $scope.models.geometry.details[0].Model_G;

            $scope.models.geometry.activeGeometryDcList.forEach((dc) => {

                if (dc.id == comb.dc_id) {
                    dcname = dc.dc_name;
                }

            });

            $scope.models.geometry.activeGeometryLcParentList.forEach((lc) => {

                if (lc.id == comb.lc_id) {
                    lcname = lc.lc_name;
                }

            });

            name += '_' + lcname + '_' + dcname + '.r3d';

            comb.mountName = name;

        });

    };

    $scope.models.geometry.saveAllAnalysis = function () {
        if ($scope.models.geometry.analysisCombinations.length) {
            $scope.models.geometry.analysisCombinations.forEach((lc) => {
                request.updateAnalysis(lc);
            });
        }
    }


    $scope.models.geometry.getAnalysis = function (callback) {

        var db_geo_PK = $scope.models.geometry.details[0].id;

        //user data
        $scope.head.user = $scope.auth.data;
        $scope.foot.user = $scope.auth.data;

        $scope.head.getHeaderComb();
        $scope.foot.getFooterComb();

        request.getAnalysis(db_geo_PK).then(function (response) {
            $scope.models.geometry.list_analysis_lc = response;

            if (response && response.length > 0) {

                var lc_ids = [];

                response.forEach(function (lc) {
                    lc_ids.push(lc.id);
                });

                // request.getAnalysisLcDetails(lc_ids).then(function(response_details) {
                //
                //     $scope.models.geometry.list_analys_lc_details = response_details;
                //     $scope.viewByStatusPanel.getReadyViewByStatusPanelFilter($scope.models.geometry.list_analys_lc_details);

                request.getAnalysisDc(lc_ids).then(function (response_dc) {

                    $scope.models.geometry.list_analysis_dc = response_dc;

                    $scope.models.geometry.getWholeSceneChanges(function () {
                        if (callback) {
                            callback(lc_ids);
                        }
                    });
                });
                // });

            } else {
                if (callback) {
                    callback([]);
                }
            }

        });
    };

    $scope.models.geometry.saveAnalysis = function (lc) {
        request.updateAnalysis(lc).then(function (response) {
            lc.change = false;
            $scope.models.geometry.getWholeSceneChanges(function () {
                $scope.models.geometry.drawWholeGeometry();
            });
        });
    };

    $scope.models.geometry.updateCombination = function (comb) {
        let check = false;
        let equals_combinations = false;

        if ($scope.models.geometry.new_lc) {
            $scope.models.geometry.activeGeometryLcParentList.forEach(lc => {
                if (lc.lc_name === $scope.models.geometry.new_lc) {
                    check = true;
                }
            });

            if (check) {
                alert('You already have LC with this name. For continue, please rename new LC.');
                return;
            }

            request.createLC($scope.models.geometry.details[0].id, $scope.models.geometry.new_lc).then(res => {
                comb.lc_id = "" + res.new_lc_id;
                $scope.models.geometry.activeGeometryLcParentList.push(res.new_lc_parent);
                $scope.$applyAsync();
            });
        }

        if ($scope.models.geometry.new_dc && $scope.models.geometry.activeGeometryDcList) {
            $scope.models.geometry.activeGeometryDcList.forEach(dc => {
                if (dc.dc_name === $scope.models.geometry.new_dc) {
                    check = true;
                }
            });

            if (check) {
                alert('You already have DC with this name. For continue, please rename new DC.');
                return;
            }
            request.createDC($scope.models.geometry.details[0].id, $scope.models.geometry.new_dc).then((res) => {
                comb.dc_id = "" + res.new_dc_id;
                $scope.models.geometry.activeGeometryDcList.push(res.new_dc);
                $scope.$applyAsync();
            });
        }

        $scope.models.geometry.analysisCombinations.forEach(function (item) {
            if ((comb.id != item.id) && (comb.lc_id == item.lc_id && comb.dc_id == item.dc_id)) {
                equals_combinations = true;
            }
        });

        if (equals_combinations) {
            alert("You already have this combination");
            return;
        }

        request.updateAnalysis(comb).then(function (response) {
            comb.change = false;
            $scope.models.geometry.getWholeSceneChanges(function () {
                $scope.models.geometry.drawWholeGeometry();
            });
        });
    };

    $scope.models.geometry.removeAnalysis = function (index, id) {
        if ($scope.auth.isAuth()) {

            $scope.models.geometry.analysisCombinations.forEach(item => {
                if (item.id == id) deleted_comb = item;
                return;
            });

            request.removeAnalysis(id).then(function (response) {
                if (response.success) {
                    $scope.models.geometry.list_analysis_lc.splice(index, 1);
                    $scope.models.geometry.analysisCombinations.splice(index, 1);
                    $scope.models.geometry.getWholeSceneChanges(function () {
                        $scope.models.geometry.drawWholeGeometry();
                    });
                }
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.addAnalysisLc = function () {
        var data = angular.copy($scope.models.geometry.new_analys_lc);

        data.db_geo_PK = $scope.models.geometry.details[0].id;

        var foundLC = false;
        var foundDC = false;

        $scope.models.geometry.list_analysis_lc.forEach(function (item) {
            if (item.lc_name == data.lc_name) {
                foundLC = true;
            }
            if (item.dc_name == data.dc_name) {
                foundDC = true;
            }
        });

        if (foundLC || foundDC) {
            alert('LC and DC name should be unique');
            return;
        }

        $scope.header.addHeader(function (new_id) {
            data.headerPK = new_id;

            $scope.footer.addFooter(function (new_f_id) {
                data.footerPK = new_f_id;

                request.addAnalysisLc(data).then(function (response) {
                    if (response.success) {

                        data.id = response.new_id;

                        $scope.models.geometry.list_analysis_lc.push(data);

                        $scope.models.geometry.new_analys_lc = {};

                        $scope.models.geometry.addAnalysisDc(response.new_id);
                    }
                });
            })
        })

    };

    $scope.models.geometry.editDetails = function (comb, tab) {

        $scope.models.geometry.activeGeometryDcList.forEach(dc => {
            if (comb.dc_id == dc.id) {
                $scope.models.geometry.active_dc = dc;
            }
        });

        $scope.models.geometry.activeGeometryLcParentList.forEach(lc_parent => {
            if (comb.lc_id == lc_parent.id) {
                $scope.models.geometry.active_lc = lc_parent;
            }
        });

        $scope.models.geometry.lc_analysis_active = comb;

        $scope.header.update();
        $scope.footer.update();

        $scope.models.geometry.lc_analysis_active_details_list = [];
        $scope.models.geometry.lc_analysis_active_details_reset_list = [];

        if (tab == 'DC') {
            if ($scope.models.geometry.active_dc && !$scope.models.geometry.active_dc.dc_name) {
                return
            }
            angular.element('#analysisTabs a:eq(0)').tab('show');
            angular.element('#analysisTabs a').removeClass('selected_tab');
            angular.element('#analysisTabs a:eq(0)').addClass('selected_tab');
        } else {
            if ($scope.models.geometry.active_lc && !$scope.models.geometry.active_lc.lc_name) {
                return
            }
            angular.element('#analysisTabs a:eq(2)').tab('show');
            angular.element('#analysisTabs a').removeClass('selected_tab');
            angular.element('#analysisTabs a:eq(2)').addClass('selected_tab');
        }

        $scope.models.geometry.activeGeometryLcList.forEach(lc => {
            if (lc.lc_parent_id == $scope.models.geometry.active_lc.id) {

                $scope.models.geometry.lc_analysis_active_details_list.push(lc);
                $scope.models.geometry.lc_analysis_active_details_reset_list.push(lc);

            }
        });

        $scope.detailsFilter.getReadyDetailsFilter($scope.models.geometry.lc_analysis_active_details_reset_list);

        $scope.models.geometry.analysis_panel = true;
    };

    $scope.models.geometry.saveAnalysisLcDetails = function (lc) {
        let data = angular.copy(lc);
        delete data.has_azm;
        delete data.selected;

        request.updateAnalysisLcDetails(data).then(function (response) {
            lc.change = false;
            $scope.detailsFilter.getReadyDetailsFilter($scope.models.geometry.lc_analysis_active_details_reset_list);
            $scope.viewByStatusPanel.getReadyViewByStatusPanelFilter($scope.models.geometry.activeGeometryLcList);
            $scope.models.geometry.drawWholeGeometry();
        });
    };

    $scope.models.geometry.copyAnalysisLcDetails = function (lc_id_copy) {

        request.copyAnalysisLcDetails(lc_id_copy, $scope.models.geometry.active_lc.id).then(function (res) {

            if (res.success) {
                $scope.models.geometry.getAnalysisCombinations(function () {
                    $scope.models.geometry.lc_analysis_active_details_list = [];
                    $scope.models.geometry.lc_analysis_active_details_reset_list = [];

                    $scope.models.geometry.activeGeometryLcList.forEach(function (item) {
                        if (item.lc_parent_id == $scope.models.geometry.active_lc.id) {
                            $scope.models.geometry.lc_analysis_active_details_list.push(item);
                            $scope.models.geometry.lc_analysis_active_details_reset_list.push(item);
                        }
                    });

                    $scope.models.geometry.drawWholeGeometry();
                });
            }
        });
    };

    $scope.models.geometry.removeAnalysisLcDetails = function (index, id) {
        if ($scope.auth.isAuth()) {
            request.removeAnalysisLcDetails(id).then(function (response) {
                if (response.success) {

                    $scope.models.geometry.lc_analysis_active_details_list.forEach(function (item, key) {
                        if (item.id == id) {
                            $scope.models.geometry.lc_analysis_active_details_list.splice(key, 1);
                            $scope.models.geometry.lc_analysis_active_details_reset_list.splice(key, 1);
                        }
                    });

                    $scope.models.geometry.list_analys_lc_details.forEach(function (item, key) {
                        if (item.id == id) {
                            $scope.models.geometry.list_analys_lc_details.splice(key, 1);
                        }
                    });

                    $scope.models.geometry.activeGeometryLcList.forEach(function (item, key) {
                        if (item.id == id) {
                            $scope.models.geometry.activeGeometryLcList.splice(key, 1);
                        }
                    });

                    $scope.detailsFilter.getReadyDetailsFilter($scope.models.geometry.lc_analysis_active_details_reset_list);
                    $scope.viewByStatusPanel.getReadyViewByStatusPanelFilter($scope.models.geometry.activeGeometryLcList);

                    $scope.models.geometry.drawWholeGeometry();
                }
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.addAnalysisLcDetails = function (mode) {
        let data = null;

        if (mode === 'standard') {
            data = angular.copy($scope.models.geometry.new_analys_lc_details);
            data.lc_parent_id = $scope.models.geometry.lc_analysis_active.lc_id;
        } else if (mode === 'onMember') {
            data = angular.copy($scope.models.geometry.newObject);

            let parent = 0;

            $scope.models.geometry.analysisCombinations.forEach((comb) => {

                if (comb.draw === 'true' && comb.lc_id) {
                    parent = comb.lc_id;
                }

            });

            data.lc_parent_id = parent;

        }

        data.status = data.status || 'Existing';


        request.addAnalysisLcDetails(data).then(function (response) {
            if (response.success) {

                data.id = response.new_id;

                $scope.models.geometry.activeGeometryLcList.push(data);
                $scope.models.geometry.list_analys_lc_details.push(data);
                $scope.models.geometry.lc_analysis_active_details_list.push(data);
                $scope.models.geometry.lc_analysis_active_details_reset_list.push(data);

                $scope.models.geometry.new_analys_lc_details = {
                    dx: 0,
                    dy: 0,
                    dz: 0,
                    rotx: 0,
                    roty: 0,
                    rotz: 0
                };

                $scope.detailsFilter.getReadyDetailsFilter($scope.models.geometry.lc_analysis_active_details_reset_list);
                $scope.viewByStatusPanel.getReadyViewByStatusPanelFilter($scope.models.geometry.activeGeometryLcList);

                $scope.models.geometry.drawWholeGeometry();
            }
        });
    };

    $scope.models.geometry.updateAnalysisLcParent = function () {

        let check = false;

        let id = $scope.models.geometry.active_lc.id;
        let name = $scope.models.geometry.active_lc.lc_name;

        $scope.models.geometry.activeGeometryLcParentList.forEach(lc => {
            if (lc.id != id && lc.lc_name === name) {
                check = true;
            }
        });

        if (check) {
            alert('You already have LC with this name. For continue, please rename LC.');
            return;
        }

        request.updateLC(id, name).then(function (response) {

            $scope.models.geometry.active_lc.change = false;

        });

    };

    $scope.models.geometry.removeAnalysisLcParent = function () {

        request.deleteLC($scope.models.geometry.active_lc.id).then(function (response) {

            $scope.models.geometry.activeGeometryLcParentList.forEach((lc, key) => {
                if (lc.id == $scope.models.geometry.active_lc.id) {
                    $scope.models.geometry.activeGeometryLcParentList.splice(key, 1);
                    $scope.models.geometry.active_lc = null;
                    $scope.models.geometry.lc_analysis_active_details_list = [];
                    $scope.models.geometry.analysis_panel = false;
                }
            });

        });

    };

    $scope.models.geometry.removeAnalysisDC = function () {

        request.deleteDC($scope.models.geometry.active_dc.id).then(function (response) {

            $scope.models.geometry.activeGeometryDcList.forEach((dc, key) => {
                if (dc.id == $scope.models.geometry.active_dc.id) {
                    $scope.models.geometry.activeGeometryDcList.splice(key, 1);
                    $scope.models.geometry.active_dc = null;
                    $scope.models.geometry.analysis_panel = false;
                }
            });

        });

    };

    $scope.models.geometry.toggleOffset = function (dc) {
        var oldValues = {};
        if (dc.dx_chk === 'false') {
            oldValues.dx = dc.dx;
            dc.dx = "0.00";
        }
        if (dc.dy_chk === 'false') {
            oldValues.dy = dc.dy;
            dc.dy = "0.00";
        }
        if (dc.dz_chk === 'false') {
            oldValues.dz = dc.dz;
            dc.dz = "0.00";
        }

        $scope.models.geometry.getWholeSceneChanges(function () {
            $scope.models.geometry.drawWholeGeometry();
            if (dc.dx_chk === 'false') {
                dc.dx = oldValues.dx;
                oldValues.dx = '';
            }
            if (dc.dy_chk === 'false') {
                dc.dy = oldValues.dy;
                oldValues.dy = '';
            }
            if (dc.dz_chk === 'false') {
                dc.dz = oldValues.dz;
                oldValues.dz = '';
            }
        });
    };

    $scope.models.geometry.updateAnalysisDc = function (dc) {
        let check = false;

        let id = $scope.models.geometry.active_dc.id;
        let name = $scope.models.geometry.active_dc.dc_name;

        $scope.models.geometry.activeGeometryDcList.forEach((dc) => {
            if (dc.id != id && dc.dc_name === name) {
                check = true;
            }
        });

        if (check) {
            alert('You already have DC with this name. For continue, please rename DC.');
            return;
        }


        request.updateAnalysisDc(dc).then(function (response) {
            dc.change = false;
            $scope.models.geometry.toggleOffset(dc);
        });
    };

    $scope.models.geometry.addAnalysisDc = function (analysis_PK) {
        var data = angular.copy($scope.models.geometry.new_analys_dc);

        data.analysis_PK = analysis_PK;

        request.addAnalysisDc(data).then(function (response) {
            if (response.success) {

                data.id = response.new_id;

                $scope.models.geometry.list_analysis_dc.push(data);

                $scope.models.geometry.new_analys_dc = {};
            }
        });
    };

    $scope.models.geometry.updateAnalysisReport = function () {

        var active_lc = $scope.models.geometry.lc_analysis_active;

        $scope.model.header_calcs.stylePK = $scope.head.activeHeadLayout;
        $scope.model.footer_calcs.stylePK = $scope.foot.activeFooterLayout;

        var data_head = $scope.model.header_calcs;
        var data_foot = $scope.model.footer_calcs;

        $scope.header.save();
        $scope.footer.save();

    };

    $scope.models.geometry.addConnector = function () {
        if ($scope.auth.isAuth()) {

            let found = false;

            let newConnector = angular.copy($scope.models.geometry.newConnector);

            $scope.models.geometry.connectors.forEach(function (item) {
                if (item.name === newConnector.name) {
                    found = true;
                }
            });

            if (!found) {

                newConnector.geom_id = $scope.models.geometry.details[0].id;

                request.addConnector(newConnector).then(function (response) {

                    if (response.success) {
                        newConnector.id = response.newId;

                        $scope.models.geometry.connectors.push(newConnector);

                        $scope.models.geometry.newConnector = {};
                    }

                });

            } else {
                alert('Name should be unique');
            }

        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveConnector = function (list) {
        if ($scope.auth.isAuth()) {


            request.updateConnector(list).then(function (response) {
                list.change = false;
            });


        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeConnector = function (index, id) {
        if ($scope.auth.isAuth()) {
            request.removeConnector(id).then(function (response) {
                $scope.models.geometry.connectors.splice(index, 1);
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.changeConnector = function (item, index, list) {


    };

    $scope.models.geometry.getConnections = function () {

        var db_geo_PK = $scope.models.geometry.details[0].id;

        request.getConnections(db_geo_PK).then(function (response) {
            $scope.models.geometry.connections = response;

        });
    };

    $scope.models.geometry.updateConnection = function (con) {
        if ($scope.auth.isAuth()) {
            request.updateConnection(con).then(function (response) {
                con.change = false;
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeConnection = function (index, id) {
        if ($scope.auth.isAuth()) {
            request.removeConnection(id).then(function (response) {
                if (response.success) {
                    $scope.models.geometry.connections.splice(index, 1);
                }
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.addConnection = function () {
        if ($scope.auth.isAuth()) {
            var data = angular.copy($scope.models.geometry.new_connection);

            var found = false;

            $scope.models.geometry.connections.forEach(function (item) {
                if (item.name === data.name) {
                    found = true;
                }
            });

            if (!found) {
                data.db_geo_PK = $scope.models.geometry.details[0].id;

                request.addConnection(data).then(function (response) {

                    if (response.success) {

                        data.id = response.new_id;

                        $scope.models.geometry.connections.push(data);

                        $scope.models.geometry.new_connection = {};
                    }
                });
            } else {
                alert('Name should be unique');
            }
        } else {
            alert("Function(s) available to registered user only");
        }

    };

    $scope.models.geometry.addNode = function () {
        if ($scope.auth.isAuth()) {

            var found = false;

            if (!$scope.models.geometry.nodes) {
                $scope.models.geometry.nodes = [];
            }

            if ($scope.models.nodes.add.node_name) {

                $scope.models.geometry.nodes.forEach(function (item) {
                    if (item.node_name == 'N' + $scope.models.nodes.add.node_name) {
                        found = true;
                    }
                });

                if (found) {
                    alert('Name should be unique');
                    return;
                }

                $scope.models.nodes.add.node_name = 'N' + $scope.models.nodes.add.node_name;

            } else {
                $scope.models.nodes.add.node_name = 'N' + ($scope.models.geometry.nodes.length + 1);
            }

            $scope.models.nodes.add.db_geo_PK = $scope.models.geometry.db_geo_PK;

            $scope.models.geometry.calculateNode($scope.models.nodes.add, function (saved) {
                request.saveNode(saved, "new").then(function (response) {
                    $scope.models.geometry.insertNodeModal = false;

                    $scope.models.nodes.add = {};

                    $scope.models.geometry.nodes.push(response);

                    $scope.models.geometry.drawWholeGeometry();
                });
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveNode = function (item) {
        if ($scope.auth.isAuth()) {

            $scope.models.geometry.calculateNode(item, function (saved) {
                request.saveNode(saved, "save").then(function (response) {
                    item.changed = false;
                    $scope.models.geometry.reevaluateNodes();
                });
            });

        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeNode = function (id, index) {
        if ($scope.auth.isAuth()) {
            request.removeNode(id).then(function (response) {
                $scope.models.geometry.nodes.splice(index, 1);
                $scope.models.geometry.drawWholeGeometry();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.addNodeP = function () {
        if ($scope.auth.isAuth()) {

            $scope.models.nodes_p.add.db_geo_PK = $scope.models.geometry.db_geo_PK;

            $scope.models.nodes_p.add.value = $scope.models.geometry.nodesPCalculation($scope.models.nodes_p.add);

            delete $scope.models.nodes_p.add.sec_dim_list;

            request.saveNodeP($scope.models.nodes_p.add, "new").then(function (response) {

                if (!$scope.models.geometry.nodes_p) {
                    $scope.models.geometry.nodes_p = [];
                }

                $scope.models.nodes_p.add = {};

                $scope.models.geometry.changeSection(response);

                $scope.models.geometry.nodes_p.push(response);

            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveNodeP = function (item) {
        if ($scope.auth.isAuth()) {
            item.changed = false;

            item.value = $scope.models.geometry.nodesPCalculation(item);

            var saved = angular.copy(item);
            delete saved.changed;
            delete saved.selected;
            delete saved.sec_dim_list;

            request.saveNodeP(saved, "save").then(function (response) {
                $scope.models.geometry.reevaluateNodes();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.insertNewNode = function () {

        let insert = $scope.models.geometry.insertedNodeData.split('\n') || [];

        insert.forEach(function (row) {

            let data = row.split(' ') || [];

            if (data && data[0]) {
                $scope.models.nodes.add = {};

                $scope.models.nodes.add.node_name = data[0] || '';
                $scope.models.nodes.add.x_f = data[1] || 0;
                $scope.models.nodes.add.y_f = data[2] || 0;
                $scope.models.nodes.add.z_f = data[3] || 0;

                $scope.models.geometry.addNode();

            }

        });

    };

    $scope.models.geometry.changeSection = function (item) {

        $scope.models.geometry.secs.forEach(function (section) {
            if (section.sec_name === item.sec_name) {

                if ($scope.geoSectionsDimensions[section.sec_name]) {
                    item.sec_dim_list = $scope.geoSectionsDimensions[section.sec_name];
                } else {
                    item.sec_dim_list = [];
                }

            }
        })
    };

    $scope.models.geometry.changeDim = function (item) {

        item.sec_dim_list.forEach(function (dim) {

            if (dim.name == item.sec_dim) {
                item.sec_dim_val = dim.value;
            }

        });

    };

    $scope.models.geometry.calculateNode = function (item, callback) {

        var base_node = {
            x: 0,
            y: 0,
            z: 0
        };

        if (item.base_node) {
            $scope.models.geometry.nodes.forEach(function (node) {
                if (item.base_node == node.no) {
                    if (node.x) {
                        base_node.x = parseFloat(node.x);
                    }
                    if (node.y) {
                        base_node.y = parseFloat(node.y);
                    }
                    if (node.z) {
                        base_node.z = parseFloat(node.z);
                    }
                }
            });
        }

        if (!item.rot_y_n) {
            item.rot_y_n = 0;
        }
        if (!item.x_f) {
            item.x_f = 0;
        }
        if (!item.y_f) {
            item.y_f = 0;
        }
        if (!item.z_f) {
            item.z_f = 0;
        }
        if (!item.rot_y_f) {
            item.rot_y_f = 0;
        }

        var rot_y_n_v = item.rot_y_n * Math.PI / 180;
        var x_f_v = $scope.models.geometry.nodesCalculation(item.x_f);
        var y_f_v = $scope.models.geometry.nodesCalculation(item.y_f);
        var z_f_v = $scope.models.geometry.nodesCalculation(item.z_f);
        var rot_y_f_v = item.rot_y_f * Math.PI / 180;

        // var n_x = ( x_f_v + base_node.x ) * Math.cos(rot_y_f_v);
        // n_x = n_x - ( z_f_v + base_node.z ) * Math.sin(rot_y_f_v);
        var n_x = base_node.x * Math.cos(rot_y_n_v) - base_node.z * Math.sin(rot_y_n_v);
        n_x = n_x + x_f_v * Math.cos(rot_y_f_v) - z_f_v * Math.sin(rot_y_f_v);

        y_f_v = parseFloat(y_f_v);
        var n_y = base_node.y + y_f_v;
        n_y = parseFloat(n_y);

        // var n_z = ( z_f_v + base_node.z) * Math.cos(rot_y_f_v);
        // n_z = n_z + ( x_f_v + base_node.x) * Math.sin(rot_y_f_v) ;
        var n_z = base_node.x * Math.sin(rot_y_n_v) + base_node.z * Math.cos(rot_y_n_v);
        n_z = n_z + x_f_v * Math.sin(rot_y_f_v) + z_f_v * Math.cos(rot_y_f_v);


        var saved = angular.copy(item);
        delete saved.changed;
        delete saved.selected;

        item.x = (n_x).toFixed(4);
        saved.x = (n_x).toFixed(4);

        item.y = (n_y).toFixed(4);
        saved.y = (n_y).toFixed(4);

        item.z = (n_z).toFixed(4);
        saved.z = (n_z).toFixed(4);

        if (callback) {
            callback(saved);
        }
    };

    $scope.models.geometry.reevaluateNodes = function () {

        var counter = 0;

        $scope.models.geometry.nodes.forEach(function (item) {

            $scope.models.geometry.calculateNode(item, function (saved) {
                counter++;

                request.saveNode(saved, "save").then(function (response) {
                    counter--;
                    if (counter == 0) {
                        $scope.models.geometry.drawWholeGeometry();
                    }
                });
            });

        });
    };

    $scope.models.geometry.removeNodeP = function (id, index) {
        if ($scope.auth.isAuth()) {
            request.removeNodeP(id).then(function (response) {
                $scope.models.geometry.nodes_p.splice(index, 1);
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveSec = function (item) {
        if ($scope.auth.isAuth()) {
            item.changed = false;

            var saved = angular.copy(item);
            delete saved.changed;
            delete saved.selected;

            request.saveSec(saved, "save").then(function (response) {
                $scope.models.geometry.getSectionsInfo(function (response) {
                    $scope.sectionsInfo = response.data;
                    $scope.sectionsInfo.forEach(function (item) {
                        $scope.unitConversionProcess(item);
                    });
                    $scope.models.geometry.drawWholeGeometry();
                });

            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeSec = function (id, index) {
        if ($scope.auth.isAuth()) {
            request.removeSec(id).then(function (response) {
                $scope.models.geometry.secs.splice(index, 1);
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.addSec = function () {
        if ($scope.auth.isAuth()) {

            let found = false;

            if (!$scope.models.geometry.secs) {
                $scope.models.geometry.secs = [];
            }

            if ($scope.models.secs.add.sec_name) {

                $scope.models.geometry.secs.forEach(function (item) {
                    if (item.sec_name == 'S' + $scope.models.secs.add.sec_name) {
                        found = true;
                    }
                });

                if (found) {
                    alert('Name should be unique');
                    return;
                }

                $scope.models.secs.add.sec_name = 'S' + $scope.models.secs.add.sec_name;
            } else {
                $scope.models.secs.add.sec_name = 'S' + ($scope.models.geometry.secs.length + 1);
            }

            $scope.models.secs.add.db_geo_PK = $scope.models.geometry.db_geo_PK;

            request.saveSec($scope.models.secs.add, "new").then(function (response) {
                $scope.models.secs.add = {};

                response.shapeList = angular.copy($scope.models.geometry.shapesList.shapeList);
                response.size1List = angular.copy($scope.models.geometry.shapesList.size1List);
                response.size2List = angular.copy($scope.models.geometry.shapesList.size2List);

                $scope.models.geometry.secs.push(response);

                $scope.models.geometry.getSectionsInfo(function (response) {
                    $scope.sectionsInfo = response.data;
                    $scope.sectionsInfo.forEach(function (item) {
                        $scope.unitConversionProcess(item);
                    });
                });

                $scope.query.loadSizesList();
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.getSectionsInfo = function (callback) {

        $scope.sectionsInfo = [];

        let list = angular.copy($scope.models.geometry.secs || []);

        list.forEach(function (item) {
            delete item.shapeList;
            delete item.size1List;
            delete item.size2List;
        });

        $scope.geoSectionsDimensions = {};

        request.getSectionsInfo(list).then(function (response) {

            if (response.result) {
                let data = response.data;


                data.forEach((item) => {

                    list.forEach((sec) => {

                        if ((sec.shape === item.Type) && (sec.size1 === item.AISC_Size1) && (sec.size2 === item.AISC_Size2)) {

                            $scope.geoSectionsDimensions[sec.sec_name] = [];

                            $scope.sectionDimensionsx[sec.shape].forEach((dim) => {
                                $scope.geoSectionsDimensions[sec.sec_name].push({
                                    name: dim,
                                    value: item[dim]
                                });
                            });

                        }

                    });

                });

            }

            if (callback) {
                callback(response);
            }

        });

    };

    $scope.models.geometry.changeShapes = function (shape) {
        // $scope.query.loadModels(shape);
    };

    $scope.models.geometry.changeNew = function (event) {
        if (event.keyCode == 27) {
            $scope.query.resetGeometry();
        }
    };

    $scope.models.geometry.addMaterial = function () {
        if ($scope.auth.isAuth()) {

            var data = $scope.models.geometry.newMaterial;

            if (typeof data.E === 'string') data.E = String(data.E).replace(/,/g, '');
            if (typeof data.Rho === 'string') data.Rho = String(data.Rho).replace(/,/g, '');
            if (typeof data.G === 'string') data.G = String(data.G).replace(/,/g, '');
            if (typeof data.Nu === 'string') data.Nu = String(data.Nu).replace(/,/g, '');
            if (typeof data.fy === 'string') data.fy = String(data.fy).replace(/,/g, '');
            if (typeof data.fu === 'string') data.fu = String(data.fu).replace(/,/g, '');

            data.db_geo_PK = $scope.models.geometry.db_geo_PK;

            request.addMaterial(data).then(function (response) {
                if (response.status == true) {
                    if (!$scope.models.geometry.materials) {
                        $scope.models.geometry.materials = [];
                    }

                    response.data.orgList = angular.copy($scope.models.geometry.materialsLists.orgList);
                    response.data.standardList = angular.copy($scope.models.geometry.materialsLists.standardList);
                    response.data.gradeList = angular.copy($scope.models.geometry.materialsLists.gradeList);

                    $scope.models.geometry.materials.push(response.data);

                    $scope.models.geometry.newMaterial.grade = '';
                    $scope.models.geometry.newMaterial.org = $scope.models.geometry.materialsLists.orgList[0].value || '';
                    $scope.models.geometry.newMaterial.standard = '';
                    $scope.models.geometry.newMaterial.name = '';
                    $scope.models.geometry.newMaterial.E = '';
                    $scope.models.geometry.newMaterial.Rho = '';
                    $scope.models.geometry.newMaterial.G = '';
                    $scope.models.geometry.newMaterial.Nu = '';
                    $scope.models.geometry.newMaterial.fy = '';
                    $scope.models.geometry.newMaterial.fu = '';

                    $scope.query.loadMaterials();
                }
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.saveMaterial = function (item) {
        if ($scope.auth.isAuth()) {

            var data = item;

            request.saveMaterial(data).then(function (response) {
                if (response.status) {
                    item.changed = false;
                }
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.removeMaterial = function (id, index) {
        if ($scope.auth.isAuth()) {
            request.removeMaterial(id).then(function (response) {
                if (response.status == true) {
                    $scope.models.geometry.materials.splice(index, 1);
                }
            });
        } else {
            alert("Function(s) available to registered user only");
        }
    };

    $scope.models.geometry.formSearchList = function () {
        $scope.models.geometry.searchList = [];
        $scope.models.geometry.list.forEach(function (item) {
            if ($scope.userLoadInfo.userIds.indexOf(item.userID) !== -1) {
                let value = item.Type_G + ' | ' + item.Mftr_G + ' | ' + item.Model_G;

                $scope.models.geometry.searchList.push({
                    value: value,
                    id: item.id,
                    item: item
                });
            }
        });
    };

    $scope.models.geometry.searchInputChange = function (item) {
        $scope.selectedGeometry = '';

        if (item.item.userID != 0) {
            if (!$scope.models.product.settings.private) {
                alert('You must include private data!');

                return
            }
        }

        angular.element('#panelTabs a:last').tab('show');

        var node = {};
        node.key = 'Type_G';
        node.name = 'Type';
        node.select = {};
        node.select.id = item.item.id;
        node.select.value = item.item.Type_G;

        $scope.models.geometry.selected = [];

        if (item.item.Model_G) {
            $scope.models.geometry.selected.push({
                last: false,
                key: 'Model_G',
                value: item.item.Model_G
            });
        }

        if (item.item.Shape_G) {
            $scope.models.geometry.selected.push({
                last: false,
                key: 'Shape_G',
                value: item.item.Shape_G
            });
        }

        if (item.item.Sub_type_G) {
            $scope.models.geometry.selected.push({
                last: false,
                key: 'Sub_type_G',
                value: item.item.Sub_type_G
            });
        }

        if (item.item.Mftr_G) {
            $scope.models.geometry.selected.push({
                last: false,
                key: 'Mftr_G',
                value: item.item.Mftr_G
            });
        }


        $scope.models.buildTabs(node, 'geometry', function (items, details) {
            if (details.data) {

                $scope.models.geometry.dataLoaded = true;

                $scope.models.geometry.items = items;

                $scope.models.nodes.add.db_geo_PK = details.data[0].id;
                $scope.models.secs.add.db_geo_PK = details.data[0].id;
                $scope.models.geometry.newMaterial.db_geo_PK = details.data[0].id;
                $scope.models.geometry.db_geo_PK = details.data[0].id;
                $scope.models.geometry.details = details.data || [];
                $scope.models.geometry.members = details.members || [];
                if ($scope.models.geometry.members) $scope.models.geometry.members.sort($scope.sortByIntId);
                $scope.models.geometry.nodes = details.nodes;
                if ($scope.models.geometry.nodes) $scope.models.geometry.nodes.sort($scope.sortByIntId);
                $scope.models.geometry.nodes_p = details.nodes_p || [];
                $scope.models.geometry.secs = details.secs;
                if ($scope.models.geometry.secs) $scope.models.geometry.secs.sort($scope.sortByIntId);
                $scope.models.geometry.materials = details.materials;
                if ($scope.models.geometry.materials) $scope.models.geometry.materials.sort($scope.sortByIntId);
                $scope.models.geometry.connectors = details.connectors || [];
                if ($scope.models.geometry.connectors) $scope.models.geometry.connectors.sort($scope.sortByIntId);
                $scope.models.geometry.connections = details.connections || [];
                if ($scope.models.geometry.connections) $scope.models.geometry.connections.sort($scope.sortByIntId);


                $scope.models.geometry.nodes_p.forEach(function (parameter) {
                    $scope.models.geometry.changeSection(parameter);
                });

                $scope.models.geometry.list_assoc = [];
                $scope.models.geometry.list_analysis_eq = [];
                $scope.models.geometry.list_analysis_lc = [];
                $scope.models.geometry.list_analysis_dc = [];

                angular.forEach($scope.models.geometry.secs, function (item) {
                    item.shapeList = angular.copy($scope.models.geometry.shapesList.shapeList);
                    item.size1List = angular.copy($scope.models.geometry.shapesList.size1List);
                    item.size2List = angular.copy($scope.models.geometry.shapesList.size2List);
                });

                angular.forEach($scope.models.geometry.materials, function (item) {
                    item.orgList = angular.copy($scope.models.geometry.materialsLists.orgList);
                    item.standardList = angular.copy($scope.models.geometry.materialsLists.standardList);
                    item.gradeList = angular.copy($scope.models.geometry.materialsLists.gradeList);

                    if (item.E) {
                        var crtValue = parseFloat(item.E);
                        var crtUnit = $scope.shared_units.find('db_material', 'e');
                        var unit2be = $scope.units.find('db_geo_mat', 'e');
                        var value2be = unitConversion(crtValue, crtUnit, unit2be);
                        item.E = value2be;
                    }

                    if (item.Rho) {
                        var crtValue = parseFloat(item.Rho);
                        var crtUnit = $scope.shared_units.find('db_material', 'density');
                        var unit2be = $scope.units.find('db_geo_mat', 'rho');
                        var value2be = unitConversion(crtValue, crtUnit, unit2be);
                        item.Rho = value2be;

                    }

                    if (item.G) {
                        var crtValue = parseFloat(item.G);
                        var crtUnit = $scope.shared_units.find('db_material', 'g');
                        var unit2be = $scope.units.find('db_geo_mat', 'g');
                        var value2be = unitConversion(crtValue, crtUnit, unit2be);
                        item.G = value2be;
                    }

                    if (item.Nu) {
                        var crtValue = parseFloat(item.Nu);
                        var crtUnit = $scope.shared_units.find('db_material', 'nu');
                        var unit2be = $scope.units.find('db_geo_mat', 'nu');
                        var value2be = unitConversion(crtValue, crtUnit, unit2be);
                        item.Nu = value2be;
                    }
                });

                $scope.query.pdfGeometry();
                $scope.models.geometry.getPhotoList();

                var product = {};

                angular.forEach($scope.models.geometry.items, function (item) {
                    if (item.select) {
                        product[item.key] = item.select.value;
                    }
                });

                $scope.models.geometry.getGeometryAssociationsList(function (assoc_list) {

                    request.getGeometryAssociationNew(assoc_list).then(function (response) {

                        $scope.models.geometry.list_assoc = response;

                        angular.forEach($scope.models.geometry.list_assoc, function (list) {
                            list.association = angular.copy($scope.models.geometry.reset.association);

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

                    });

                });
                $scope.models.geometry.getAnalysisCombinations();

                $scope.models.geometry.getAnalysis(function (lc_ids) {

                    request.getAnalysisEqpt(lc_ids).then(function (response_data) {

                        if (response_data) {

                            var products_analys = [];

                            $scope.models.product.list.forEach(function (item) {

                                response_data.forEach(function (product) {

                                    if (item.id == product.db_pro_PK) {
                                        var tmp = angular.copy(item);
                                        tmp.analysis_name = product.name;
                                        tmp.analysis_notes = product.notes;
                                        tmp.eqpt_id = product.id;
                                        tmp.createdOn = product.createdOn;
                                        products_analys.push(tmp);
                                    }
                                })
                            });

                            $scope.models.geometry.list_analysis_eq = products_analys;
                            if ($scope.models.geometry.list_analysis_eq) $scope.models.geometry.list_analysis_eq.sort($scope.sortByCreatedDate);

                            angular.forEach($scope.models.geometry.list_analysis_eq, function (list) {
                                list.association = angular.copy($scope.models.geometry.reset.association);

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

                        }

                        $scope.models.geometry.drawWholeGeometry();

                    })
                });


            }
        });
    };

    $scope.models.geometry.tree = {
        data: [],
        expanded: [],
        newProduct: {},
        options: {
            nodeChildren: "geometriesTreeList",
            multiSelection: false,
            dirSelectable: true,
            isAccess: function (node) {
                var state = "show";

                if (node.status == "inactive") {
                    state = "hide";

                    if ($scope.auth.isAdmin()) {
                        state = "disable";
                    }
                }

                return state;
            },
            isPremier: function (node) {
                return node.accessLevel == "premier";
            },
            isLeaf: function (node) {
                return false;
            }
        },
        node: {},
        selectedNodes: [],
        showSelected: function (node, type) {

            $('.panel-geometry-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            $('.panel-product-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });
            
            $('.panel-site-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            if (!$scope.models.containsObject($scope.models.geometry.tree.expanded, node)) {
                $scope.models.geometry.tree.expanded.push(node);
            }

            $scope.models.product.tree.node = {};
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.tree.selectedNodeType = type;

            $scope.models.product.tree.linksShow = false;

            if (node.linksFolder) {
                $scope.models.product.tree.linksShow = true;
            }

            if (node.category) {
                $scope.models.geometry.tree.formNodesList(node);
            } else {
                $scope.models.product.tree.selectedNodes.push(node);
            }

        },
        formNodesList: function (node) {
            if (node.geometriesList) {
                node.geometriesList.forEach(function (item) {
                    if (!item.category) {
                        $scope.models.product.tree.selectedNodes.push(item);
                    } else if (node.id !== 0) {
                        $scope.models.geometry.tree.formNodesList(item);
                    }
                })
            } else {
                node.geometriesList = [];
                node.geometriesTreeList = [];
            }
        },
    };

    $scope.models.geometry.panelInputSelect = function (id) {

        $('.panel-geometry-tree-element').each(function () {
            $(this).parent().removeClass('panel-selected-node');

            let nodeid = $(this).data().folderid;

            if (nodeid == id) {
                $(this).parent().addClass('panel-selected-node');
            }

        })

    };

    $scope.models.geometry.deleteGeometry = function (index) {
        request.remove(index, "geometry", null, 'id').then(function (response) {
            if (response.$successGeo) {

                $scope.models.geometry.removeGeometryAssets(index, function () {
                    for (var i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                        if ($scope.models.product.tree.selectedNodes[i].id == index) {
                            $scope.models.product.tree.selectedNodes.splice(i, 1);
                        }
                    }

                    for (var k = 0; k < $scope.models.geometry.tree.node.geometriesList.length; k++) {
                        if ($scope.models.geometry.tree.node.geometriesList[k].id == index) {
                            $scope.models.geometry.tree.node.geometriesList.splice(k, 1);
                        }
                    }

                    $scope.query.resetGeometry();
                });

            }
        });
    };

    $scope.models.geometry.deleteGeometryLink = function (index) {
        let userId = $scope.auth.data.id || -1;
        request.removeLink(index, userId, 'db_geometry').then(function (response) {

            for (let i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                if ($scope.models.product.tree.selectedNodes[i].id === index) {
                    $scope.models.product.tree.selectedNodes.splice(i, 1);
                }
            }

            for (let k = 0; k < $scope.models.geometry.tree.node.geometriesList.length; k++) {
                if ($scope.models.geometry.tree.node.geometriesList[k].id === index) {
                    $scope.models.geometry.tree.node.geometriesList.splice(k, 1);
                }
            }

        });
    };

    $scope.models.geometry.removeGeometryAssets = function (geo_id, callback) {

        request.removeGeometryAssets(geo_id).then(function (response) {

            if (callback) {
                callback();
            }

        });

    };

    $scope.models.geometry.addNewGeometry = function (new_geometry, copy, callback) {

        if (!new_geometry.Type_G && !new_geometry.Sub_type_G && !new_geometry.Shape_G && !new_geometry.Mftr_G && !new_geometry.Model_G) {
            alert('At least one master field should not be empty!');
            return;
        }

        if ($scope.models.geometry.checkForSameGeometry(new_geometry, $scope.models.geometry.list)) {
            alert("There are existing data record having same master-field combination. Change the value of at least one of the master fields.");
            return;
        }

        var new_node = angular.copy(new_geometry);
        var type = 'geometry';

        new_node.userID = $scope.auth.data.id;

        request.update(new_node, type, "new").then(function (response) {
            if (response.success) {

                $scope.models.geometry.copyGeometryAssets(new_geometry.id, response.data.id, function () {
                    if (!copy) {
                        $scope.models.product.tree.selectedNodes.push(response.data);
                        $scope.models.geometry.tree.node.geometriesList.push(response.data);
                        $scope.models.geometry.list.push(response.data);
                        $scope.query.resetGeometry();
                    } else {
                        $scope.models.geometry.list.push(response.data);
                        $scope.query.getGeometriesList();
                        $scope.models.copyPanel = false;
                        if (callback) {
                            callback(response);
                        }
                    }
                });

            }
        });

    };

    $scope.models.geometry.copyGeometryAssets = function (old_geometry, new_geometry, callback) {

        request.copyGeometryAssets(old_geometry, new_geometry).then(function (response) {

            if (callback) {
                callback();
            }

        });

    };

    $scope.models.geometry.checkForSameGeometry = function (geometry, list) {
        var check = false;

        list.forEach(function (item) {
            var same = true;

            if (geometry.id && item.id == geometry.id) {
                same = false;
            }

            if (geometry.Type_G) {
                if (item.Type_G != geometry.Type_G) {
                    same = false;
                }
            }

            if (geometry.Sub_type_G) {
                if (item.Sub_type_G != geometry.Sub_type_G) {
                    same = false;
                }
            }

            if (geometry.Shape_G) {
                if (item.Shape_G != geometry.Shape_G) {
                    same = false;
                }
            }

            if (geometry.Mftr_G) {
                if (item.Mftr_G != geometry.Mftr_G) {
                    same = false;
                }
            }

            if (geometry.Model_G) {
                if (item.Model_G != geometry.Model_G) {
                    same = false;
                }
            }

            if (same) {
                check = true;
            }
        });

        return check;
    };

    $scope.models.geometry.updateGeometry = function (product) {
        if ($scope.models.geometry.checkForSameGeometry(product, $scope.models.geometry.list)) {
            alert("There are existing data record having same master-field combination. Change the value of at least one of the master fields.");
            return;
        }

        request.update(product, "geometry", "save").then(function (response) {
            product.change = false;
        });
    };

    $scope.models.geometry.panelDrag = function (geometry, index) {

        $scope.draggedName = index + 1;

        $(document).bind('mousemove', function (e) {
            $('#draggable_clone').css({
                left: e.pageX + 20,
                top: e.pageY
            });
        });

        $scope.models.geometry.draggingOn = true;
        $scope.models.geometry.draggingProduct = geometry;

    };

    $scope.models.geometry.panelDragEnd = function (node) {

        if ($scope.models.geometry.draggingOn) {
            let geometry = angular.copy($scope.models.geometry.draggingProduct);
            let oldParent = geometry.parentID;
            geometry.parentID = node.id;

            $scope.models.geometry.draggingOn = false;
            $scope.models.geometry.draggingProduct = {};

            request.update(geometry, "geometry", "save").then(function (response) {

                if (oldParent != 0) {
                    for (let i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {

                        if ($scope.models.product.tree.selectedNodes[i].id == geometry.id) {
                            $scope.models.product.tree.selectedNodes.splice(i, 1);
                        }
                    }

                    for (let k = 0; k < $scope.models.geometry.tree.node.geometriesList.length; k++) {
                        if ($scope.models.geometry.tree.node.geometriesList[k].id == geometry.id) {
                            $scope.models.geometry.tree.node.geometriesList.splice(k, 1);
                        }
                    }
                }

                node.geometriesList.push(geometry);

                $scope.query.resetGeometry();
            });
        }

    };

    $scope.models.geometry.formGeometriesTreeList = function () {
        if ($scope.auth.isAuth()) {
            request.getFolders($scope.auth.data.id).then(function (folders) {

                request.getLinks($scope.auth.data.id, 'db_geometry').then(function (links) {

                    var treeList = [];
                    var GeometryMain = {
                        name: 'Geometry',
                        geometriesList: [],
                        geometriesTreeList: [],
                        category: 'geometry',
                        id: 0
                    };

                    var geoIds = [];

                    $scope.models.geometry.list.forEach(function (geometry) {
                        if (geometry.userID == $scope.auth.data.id && geometry.mode !== 'link') {

                            let geo = {
                                id: geometry.id,
                                model: geometry.Model_G
                            };

                            geoIds.push(geo);

                            if (geometry.parentID != 0) {
                                folders.forEach(function (folderItem) {
                                    if (folderItem.id == geometry.parentID) {
                                        if (!folderItem.geometriesList) {
                                            folderItem.geometriesList = [];
                                            folderItem.geometriesTreeList = [];
                                        }

                                        folderItem.geometriesList.push(geometry);
                                    }
                                })
                            }
                            if (!$scope.models.geometry.checkForSameGeometry(geometry, GeometryMain.geometriesList)) {
                                GeometryMain.geometriesList.push(geometry);
                            }
                        }
                    });

                    $scope.models.site.geometries_ids = geoIds;

                    folders.forEach(function (item) {
                        if (item.parentID != 0) {
                            folders.forEach(function (folder) {
                                if (!folder.geometriesList) {
                                    folder.geometriesList = [];
                                    folder.geometriesTreeList = [];
                                }
                                if (folder.id == item.parentID) {
                                    folder.geometriesList.push(item);
                                    folder.geometriesTreeList.push(item);
                                }
                            });
                        } else {
                            if (item.category == 'geometry') {
                                GeometryMain.geometriesList.push(item);
                                GeometryMain.geometriesTreeList.push(item);
                            }
                        }
                    });

                    //links
                    let linkFolder = {
                        name: 'links',
                        linksFolder: true,
                        category: 'geometry',
                        parentID: 0,
                        geometriesList: [],
                        geometriesTreeList: []
                    };

                    links.forEach(function (l) {
                        let user = '';

                        $scope.usersList.forEach(function (u) {

                            if (u.id == l.userID) {
                                user = u.firstName;
                                user = user + ' ' + u.lastName;
                            }

                        });

                        l.userInfo = user;

                        l.link = true;
                        linkFolder.geometriesList.push(l);
                    });

                    GeometryMain.geometriesList.push(linkFolder);
                    GeometryMain.geometriesTreeList.push(linkFolder);
                    //

                    treeList.push(GeometryMain);

                    $scope.models.geometry.tree.data = treeList;

                });
            });
        } else {
            $scope.models.geometry.tree.data = [];
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.panel = false;
        }
    };

    $scope.models.geometry.materialChange = function (item, target, value, key) {
        let newData = [];

        newData.push({
            changedField: key,
            changedFieldValue: value,
            orgValue: $scope.models.geometry.newMaterial.org,
            stdValue: $scope.models.geometry.newMaterial.standard,
            grdValue: $scope.models.geometry.newMaterial.grade
        });

        request.sortMaterialsLists(newData).then(function (material) {
            target.orgList = material[0] ? material[0].data : [];
            target.standardList = material[1] ? material[1].data : [];
            target.gradeList = material[2] ? material[2].data : [];

            if (target.orgList.length == 1) {
                item.org = target.orgList[0].value;
            }

            if (target.standardList.length == 1) {
                item.standard = target.standardList[0].value;
            }

            if (target.gradeList.length == 1) {
                item.grade = target.gradeList[0].value;
            }

            if (item.org && item.standard && item.standard) {
                let item_data = [
                    {
                        key: 'org',
                        value: item.org
                    },
                    {
                        key: 'standard',
                        value: item.standard
                    },
                    {
                        key: 'grade',
                        value: item.grade
                    }
                ];

                request.getMaterialItem(item_data).then(function (response) {
                    if (response.data) {
                        item.name = response.data[0].name;
                        item.E = response.data[0].e;
                        item.Rho = response.data[0].density;
                        item.G = response.data[0].g;
                        item.Nu = response.data[0].Nu;
                        item.fy = response.data[0].fy;
                        item.fu = response.data[0].fu;
                        $scope.unitConversionProcess(item);
                    } else {
                        item.name = '';
                        item.E = '';
                        item.Rho = '';
                        item.G = '';
                        item.Nu = '';
                        item.fy = '';
                        item.fu = '';
                    }
                });
            }
        });
    };

    $scope.models.geometry.sectionChange = function (item, target, value, key) {

        if (item.shape === 'SR' || item.shape === 'Plate') {

            if (key === 'shape') {
                item.size1 = '';
                item.size2 = '';
            }

            let size1 = +item.size1;
            let size2 = +item.size2;

            if (item.shape === 'SR' && !isNaN(size1)) {
                item.A = +(Math.PI * Math.pow(item.size1, 2) / 4).toFixed(4);
                item.Iyy = +(Math.PI * Math.pow(item.size1, 4) / 64).toFixed(4);
                item.Izz = +(Math.PI * Math.pow(item.size1, 4) / 64).toFixed(4);
                item.J = +(Math.PI * Math.pow(item.size1, 4) / 32).toFixed(4);
            }

            if (item.shape === 'Plate' && !isNaN(size1) && !isNaN(size2)) {
                item.A = +(item.size1 * item.size2).toFixed(4);
                item.Iyy = +(item.size1 * Math.pow(item.size2, 3) / 12).toFixed(4);
                item.Izz = +(Math.pow(item.size1, 3) * item.size2 / 12).toFixed(4);
                item.J = +(item.size1 * item.size2 * (Math.pow(item.size1, 2) * Math.pow(item.size2, 2)) / 12).toFixed(4);
            }

        } else {

            if (!value && ($scope.models.geometry.aiscSelected[key].first || $scope.models.geometry.aiscSelected[key].second)) {

                request.loadSizesList().then(function (aisc) {

                    target.shapeList = aisc[0] ? aisc[0].data : [];
                    target.shapeList.push({value: "SR"});
                    target.shapeList.push({value: "Plate"});
                    target.size1List = aisc[1] ? aisc[1].data : [];
                    target.size2List = aisc[2] ? aisc[2].data : [];

                    $scope.models.geometry.aiscSelected.shape.first = false;
                    $scope.models.geometry.aiscSelected.size_1.first = false;
                    $scope.models.geometry.aiscSelected.size_2.first = false;
                    $scope.models.geometry.aiscSelected.shape.second = false;
                    $scope.models.geometry.aiscSelected.size_1.second = false;
                    $scope.models.geometry.aiscSelected.size_2.second = false;

                    item.shape = '';
                    item.size1 = '';
                    item.size2 = '';
                });

                return false;
            }

            if (($scope.models.geometry.aiscSelected.shape.first || $scope.models.geometry.aiscSelected.size_1.first || $scope.models.geometry.aiscSelected.size_2.first) && (!$scope.models.geometry.aiscSelected.shape.second && !$scope.models.geometry.aiscSelected.size_1.second && !$scope.models.geometry.aiscSelected.size_2.second)) {

                if (!$scope.models.geometry.aiscSelected[key].first) {
                    $scope.models.geometry.aiscSelected[key].second = true;
                }

            }

            if (!$scope.models.geometry.aiscSelected.shape.first && !$scope.models.geometry.aiscSelected.size_1.first && !$scope.models.geometry.aiscSelected.size_2.first) {

                $scope.models.geometry.aiscSelected[key].first = true;

            }


            if (value) {

                let ddl_key = 'Type';

                if (key === 'size_1') {
                    ddl_key = 'AISC_Size1';
                } else if (key === 'size_2') {
                    ddl_key = 'AISC_Size2';
                }

                let data = [
                    {
                        key: ddl_key,
                        value: value,
                        last: true
                    }
                ];

                request.sortSectionsLists(data).then(function (aisc) {

                    if (!$scope.models.geometry.aiscSelected.shape.first && !$scope.models.geometry.aiscSelected.shape.second && key != 'shape') {
                        target.shapeList = aisc[0] ? aisc[0].data : [];

                        target.shapeList.push({value: "SR"});
                        target.shapeList.push({value: "Plate"});
                    }

                    if (!$scope.models.geometry.aiscSelected.size_1.first && !$scope.models.geometry.aiscSelected.size_1.second && key != 'size_1') {
                        target.size1List = aisc[1] ? aisc[1].data : [];
                    }

                    if (!$scope.models.geometry.aiscSelected.size_2.first && !$scope.models.geometry.aiscSelected.size_2.second && key != 'size_2') {
                        target.size2List = aisc[2] ? aisc[2].data : [];
                    }

                    if ($scope.models.geometry.aiscSelected[key].first) {
                        target.shapeList = aisc[0] ? aisc[0].data : [];

                        target.shapeList.push({value: "SR"});
                        target.shapeList.push({value: "Plate"});

                        target.size1List = aisc[1] ? aisc[1].data : [];
                        target.size2List = aisc[2] ? aisc[2].data : [];

                        $scope.models.geometry.aiscSelected.shape.second = false;
                        $scope.models.geometry.aiscSelected.size_1.second = false;
                        $scope.models.geometry.aiscSelected.size_2.second = false;
                    }


                    if (target.shapeList.length === 1) {
                        item.shape = target.shapeList[0].value;
                    }

                    if (target.size1List.length === 1) {
                        item.size1 = target.size1List[0].value;
                    }

                    if (target.size2List.length === 1) {
                        item.size2 = target.size2List[0].value;
                    }

                    if (item.shape && item.size1 && item.size2) {

                        let temp = angular.copy(item);

                        delete temp.shapeList;
                        delete temp.size1List;
                        delete temp.size2List;

                        request.getSectionsInfo([temp]).then(function (response) {
                            $scope.sectionsInfo = response.data;
                            $scope.sectionsInfo.forEach(function (item) {
                                $scope.unitConversionProcess(item);
                            });

                            if (response.data && response.data[0]) {
                                let sec = response.data[0];
                                item.A = sec.A;
                                item.J = sec.J;
                                item.Iyy = sec.I_x;
                                item.Izz = sec.I_y;
                                $scope.unitConversionProcess(item);
                            }

                        })
                    }

                });
            }

        }


    };

    $scope.models.geometry.memberNodesChange = function (item, attr) {
        if (item.NodeS == item.NodeE && item.NodeS != '') {
            item[attr] = '';
            alert("NodeS and NodeE can't be the same!");
        }
    };

    $scope.models.geometry.changeGeoTabs = function (tab) {
        $scope.models.geometry.checkDataLoaded();
        $scope.models.geometry_tabs = tab;

        if ($scope.infoPanel) {
            $scope.showInfo([], 'geometry_tabs');
        }

    };

    $scope.models.geometry.checkDataLoaded = function () {
        if (!$scope.models.geometry.dataLoaded) {
            alert('Load a data record first!');
        }
    };

    $scope.models.geometry.getWholeSceneChanges = function (callback) {
        let TR = {
            dx: 0,
            dy: 0,
            dz: 0,
            rotx: 0,
            roty: 0,
            rotz: 0
        };
        $scope.models.geometry.analysisCombinations.forEach(function (comb) {
            if (comb.draw === 'true' && comb.dc_id) {
                $scope.models.geometry.activeGeometryDcList.forEach(function (dc) {
                    if (dc.id == comb.dc_id) {
                        if (dc.dx && dc.dx_chk === 'true') {
                            TR.dx = TR.dx + parseFloat(dc.dx);
                        }
                        if (dc.dy && dc.dy_chk === 'true') {
                            TR.dy = TR.dy + parseFloat(dc.dy);
                        }
                        if (dc.dz && dc.dz_chk === 'true') {
                            TR.dz = TR.dz + parseFloat(dc.dz);
                        }
                        if (dc.rotx) {
                            TR.rotx = TR.rotx + parseFloat(dc.rotx);
                        }
                        if (dc.roty) {
                            TR.roty = TR.roty + parseFloat(dc.roty);
                        }
                        if (dc.rotz) {
                            TR.rotz = TR.rotz + parseFloat(dc.rotz);
                        }
                    }
                })
            }
        });
        $scope.models.geometry.TR = TR;
        if (callback) {
            callback();
        }
    };

    $scope.models.geometry.changeLcDraw = function (lc) {
        $scope.models.geometry.analysisCombinations.forEach(item => {
            if (item.id !== lc.id) {
                item.draw = 'false';
            }
        });

        $scope.models.geometry.getWholeSceneChanges($scope.models.geometry.drawWholeGeometry)
    };

    $scope.models.geometry.drawWholeGeometry = function () {
        var equipments = $scope.models.geometry.drawLCs();

        if (equipments.length > 0) {
            $scope.models.geometry.drawAddEquipment(equipments, function () {

                var equipment_details = [];

                if (equipments) {
                    equipments.forEach(function (eqpt) {
                        if (eqpt.eq.geometryType === 'structure') {
                            eqpt.eq.associationNodes = $scope.models.geometry.rotateAndDeposeNodes(eqpt.eq.associationNodes, eqpt.lc);
                            // eqpt.eq.associationNodes = $scope.models.geometry.rotateAndDeposeNodes(eqpt.eq.associationNodes, $scope.models.geometry.TR);

                            var details = $scope.models.geometry.formGeometryDetails(eqpt.eq.associationMembers, eqpt.eq.associationNodes, eqpt.eq.associationSections);
                            eqpt.details = details;
                        }
                    });
                }

                $scope.render.redraw('equipment', equipments);
            });
        } else {
            $scope.render.redraw('geometry');
        }

    };

    $scope.models.geometry.drawLCs = function () {
        var lcs = [];

        if ($scope.models.geometry.analysisCombinations) $scope.models.geometry.analysisCombinations.forEach(function (comb) {
            if (comb.draw == 'true') {

                // var lc_details = [];

                $scope.models.geometry.activeGeometryLcList.forEach(function (item) {
                    if (item.lc_parent_id == comb.lc_id) {
                        var equipments = [];

                        $scope.models.geometry.list_analysis_eq.forEach(function (equipment) {
                            if (equipment.analysis_name == item.eqpt_name) {
                                equipments = angular.copy(equipment);
                            }
                        });

                        lcs.push({lc: item, eq: equipments});

                    }
                });
                // if(lc_details[0]){
                //     lcs.push(lc_details);
                // }
                // $scope.models.geometry.drawAddEquipment(lc_details);
            }
        });

        if ($scope.viewByStatusPanel.showPanel) {
            let filteredLCs = [];
            lcs.forEach(function (lc) {
                for (let keyFilter in $scope.viewByStatusPanel.filters) {
                    if ($scope.viewByStatusPanel.filters[keyFilter] && keyFilter == lc.lc.status) {
                        filteredLCs.push(lc);
                    }
                }
            });
            return filteredLCs;
        }
        return lcs;
    };

    $scope.models.geometry.drawAddEquipment = function (active_lc, callback) {
        var counter = 0;

        active_lc.forEach(function (lc) {
            if (lc.eq) {
                request.getProductAssociation(lc.eq.id).then(function (response) {

                    angular.forEach(response[0], function (value, key) {

                        if (key !== 'id') {
                            lc.eq[key] = value;
                        }

                    });

                    if (lc.eq.has_azm) {
                        lc.lc.has_azm = lc.eq.has_azm;
                    }

                    if (lc.eq.geometryType === 'structure') {
                        var selected = [];

                        if (lc.eq.Type_G) {
                            selected.push({
                                key: 'Type_G',
                                value: lc.eq.Type_G
                            });
                        }

                        if (lc.eq.Model_G) {
                            selected.push({
                                key: 'Model_G',
                                value: lc.eq.Model_G
                            });
                        }

                        if (lc.eq.Shape_G) {
                            selected.push({
                                key: 'Shape_G',
                                value: lc.eq.Shape_G
                            });
                        }

                        if (lc.eq.Sub_type_G) {
                            selected.push({
                                key: 'Sub_type_G',
                                value: lc.eq.Sub_type_G
                            });
                        }

                        if (lc.eq.Mftr_G) {
                            selected.push({
                                key: 'Mftr_G',
                                value: lc.eq.Mftr_G
                            });
                        }

                        if (lc.eq.db_geo_PK) {
                            angular.forEach($scope.models.product.association, function (association) {

                                angular.forEach(association.data, function (data) {
                                    if (data.id == lc.eq.db_geo_PK) {

                                        association.select = data;
                                        selected.push({
                                            id: association.select.id,
                                            key: association.key,
                                            value: association.select.value,
                                            last: true
                                        });
                                    }
                                });

                            });
                        }

                        if (selected.length) {
                            lc.eq.add = false;

                            request.items(selected, "geometry", $scope.userLoadInfo).then(function (details) {
                                lc.eq.associationDetails = details.data;
                                lc.eq.associationMembers = details.members;
                                lc.eq.associationSections = details.secs;
                                lc.eq.associationNodes = details.nodes;
                                counter++;

                                if (counter == active_lc.length) {
                                    if (callback) {
                                        callback();
                                    }
                                }
                            });
                        } else {
                            counter++;

                            if (counter == active_lc.length) {
                                if (callback) {
                                    callback();
                                }
                            }
                        }
                    } else {
                        counter++;

                        if (counter == active_lc.length) {
                            if (callback) {
                                callback();
                            }
                        }
                    }
                });
            }
        });
    };

    $scope.models.geometry.formGeometryDetails = function (details, nodes, sections) {
        var objects = [];

        if (details != false) {
            angular.forEach(details, function (data) {
                var x = 0;
                var y = 0;
                var z = 0;

                var shape = false;
                var size1 = false;
                var size2 = false;

                var NodeS = null;
                var NodeE = null;

                var Nodes = {
                    s: null,
                    e: null
                };

                angular.forEach(nodes, function (nodes) {
                    if (data.NodeS == nodes.no) {
                        x = nodes.x;
                        y = nodes.y;
                        z = nodes.z;

                        NodeS = nodes.no;
                        Nodes.s = [nodes.x, nodes.y, nodes.z];
                    }

                    if (data.NodeE == nodes.no) {
                        NodeE = nodes.no;
                        Nodes.e = [nodes.x, nodes.y, nodes.z];
                    }
                });

                if (Nodes.s && Nodes.e) {
                    data.Mbr_Lth = Math.pow(Math.pow(Nodes.e[0] - Nodes.s[0], 2) +
                        Math.pow(Nodes.e[1] - Nodes.s[1], 2) +
                        Math.pow(Nodes.e[2] - Nodes.s[2], 2),
                        1 / 2);

                    if (data.Mbr_Lth) {
                        data.Mbr_Lth = data.Mbr_Lth.toFixed(4);
                    }
                } else {
                    data.Mbr_Lth = data.Mbr_Lth || 5;
                }

                angular.forEach(sections, function (secs) {
                    if (data.sec_name == secs.sec_name) {
                        shape = secs.shape;
                        size1 = secs.size1;
                        size2 = secs.size2;
                    }
                });

                objects.push({
                    id: data['no'],
                    name: data['Mbr_Name'] || "",
                    shape: shape || false,
                    length: data['Mbr_Lth'] || 5,
                    size1: size1 || false,
                    size2: size2 || false,
                    other: {
                        x1: x || 0,
                        y1: y || 0,
                        z1: z || 0,
                        x2: 0,
                        y2: data['ROT'] || 0,
                        z2: 0,
                        node: Nodes
                    },
                    nodes: {
                        NodeS: NodeS || null,
                        NodeE: NodeE || null
                    }
                });
            });
        }

        return {nodes: nodes, objects: objects};
    };

    $scope.models.geometry.rotateAndDeposeNodes = function (nodes, lc) {
        var newNodes = angular.copy(nodes);

        if (newNodes) {
            newNodes.forEach(function (node) {
                if (lc.rotz) {
                    var oldX = node.x,
                        oldY = node.y,
                        rotZ = lc.rotz * (Math.PI / 180);

                    node.x = oldX * Math.cos(rotZ) - oldY * Math.sin(rotZ);
                    node.y = oldX * Math.sin(rotZ) + oldY * Math.cos(rotZ);
                }

                if (lc.roty) {
                    var oldX = node.x,
                        oldZ = node.z,
                        rotY = lc.roty * (Math.PI / 180);

                    node.x = oldX * Math.cos(rotY) - oldZ * Math.sin(rotY);
                    node.z = oldX * Math.sin(rotY) + oldZ * Math.cos(rotY);
                }

                if (lc.rotx) {
                    var oldY = node.y,
                        oldZ = node.z,
                        rotX = lc.rotx * (Math.PI / 180);

                    node.y = oldY * Math.cos(rotX) - oldZ * Math.sin(rotX);
                    node.z = oldY * Math.sin(rotX) + oldZ * Math.cos(rotX);
                }

                node.x = parseFloat(node.x) + parseFloat(lc.dx);
                node.y = parseFloat(node.y) + parseFloat(lc.dy);
                node.z = parseFloat(node.z) + parseFloat(lc.dz);
            });
        }

        return newNodes;
    };

    $scope.models.geometry.calculateRotation = function (member) {
        if (!member.NodeO) {
            return
        }

        var nodeS = null;
        var nodeE = null;
        var nodeO = null;

        // var newNodes = $scope.models.geometry.rotateAndDeposeNodes($scope.models.geometry.nodes, $scope.models.geometry.TR);
        var newNodes = $scope.models.geometry.nodes;

        newNodes.forEach(function (node) {
            if (member.NodeS == node.no) {
                nodeS = [parseFloat(node.x), parseFloat(node.y), parseFloat(node.z)];
            }

            if (member.NodeE == node.no) {
                nodeE = [parseFloat(node.x), parseFloat(node.y), parseFloat(node.z)];
            }

            if (member.NodeO == node.no) {
                nodeO = [parseFloat(node.x), parseFloat(node.y), parseFloat(node.z)];
            }
        });

        var AB = [nodeE[0] - nodeS[0], nodeE[1] - nodeS[1], nodeE[2] - nodeS[2]];
        var AC = [nodeO[0] - nodeS[0], nodeO[1] - nodeS[1], nodeO[2] - nodeS[2]];
        var AD = [0, -nodeS[1], 0];

        if (nodeS[1] == 0) {
            AD = [0, -1, 0];
        }

        if (AB[0] == 0 && AB[2] == 0) {
            AD = [1, -nodeS[1], 0]
        }

        var normalVecABC = [(AB[1] * AC[2]) - (AB[2] * AC[1]), (AB[2] * AC[0]) - (AB[0] * AC[2]), (AB[0] * AC[1]) - (AB[1] * AC[0])];
        var normalVecABD = [(AB[1] * AD[2]) - (AB[2] * AD[1]), (AB[2] * AD[0]) - (AB[0] * AD[2]), (AB[0] * AD[1]) - (AB[1] * AD[0])];

        var angleCos1 = Math.abs(normalVecABD[0] * normalVecABC[0] + normalVecABD[1] * normalVecABC[1] + normalVecABD[2] * normalVecABC[2]);
        var angleCos2 = (Math.sqrt(normalVecABC[0] * normalVecABC[0] + normalVecABC[1] * normalVecABC[1] + normalVecABC[2] * normalVecABC[2]) * Math.sqrt(normalVecABD[0] * normalVecABD[0] + normalVecABD[1] * normalVecABD[1] + normalVecABD[2] * normalVecABD[2]));

        if (angleCos1 == 0 || angleCos2 == 0) {
            var angleCos = 0;
        } else {
            var angleCos = angleCos1 / angleCos2;
        }

        if (angleCos > 1) {
            angleCos = 1;
        }
        if (angleCos < -1) {
            angleCos = -1;
        }

        var angle = Math.acos(angleCos) * (180 / Math.PI);

        var relPosLR = (normalVecABD[0] * nodeO[0] + normalVecABD[1] * nodeO[1] + normalVecABD[2] * nodeO[2]) - normalVecABD[1] * AD[1];

        var relPosUD = nodeO[1] - nodeS[1];


        if (relPosLR > 0) {
            if (relPosUD > 0) {
                angle = 180 - angle;
            }
        } else if (relPosLR < 0) {
            if (relPosUD < 0) {
                angle = 180 - angle;
            }
        }

        member.ROT = angle.toFixed(2);
    };

    $scope.models.geometry.nodesCalculation = function (str) {

        if ($scope.models.geometry.nodes_p) {
            $scope.models.geometry.nodes_p.forEach(function (par) {
                this[par.name] = +par.value;
            });
        }

        var result;

        var sqrt = Math.sqrt;
        var sin = Math.sin;
        var cos = Math.cos;
        var tan = Math.tan;

        $scope.models.geometry.nodes.forEach(function (node) {

            this[node.node_name] = {
                x: +node.x || 0,
                y: +node.y || 0,
                z: +node.z || 0
            }

        });

        try {
            result = eval(str)
        }
        catch (e) {
            result = 'error';
        }

        return result;
    };

    $scope.models.geometry.nodesPCalculation = function (nodeP) {

        var result;

        if (nodeP.value_formula && parseFloat(nodeP.value_formula) != 0) {
            var X = nodeP.sec_dim_val;

            var sqrt = Math.sqrt;
            var sin = Math.sin;
            var cos = Math.cos;
            var tan = Math.tan;

            var test = function () {
                return 10;
            };

            try {
                result = eval(nodeP.value_formula)
            }
            catch (e) {
                result = 'error';
            }
        } else {
            result = nodeP.value;
        }


        return result;
    };

    $scope.models.geometry.copyTab = function () {

        if ($scope.models.geometry.dataLoaded && $scope.models.geometry_tabs) {

            let tab = $scope.models.geometry_tabs;
            let data = [];

            let order = [];

            switch (tab) {
                case 'materials': {
                    data = angular.copy($scope.models.geometry.materials);

                    order = ['name', 'E', 'Rho', 'G', 'Nu', 'Ry', 'Rt'];

                    data.forEach((mat) => {
                        delete mat.orgList;
                        delete mat.standardList;
                        delete mat.gradeList;
                        delete mat.RcdId;
                        delete mat.db_geo_PK;
                        delete mat.standard;
                        delete mat.org;
                        delete mat.grade;
                        delete mat.notes;
                        delete mat.createdBy;
                        delete mat.createdOn;
                        delete mat.modifiedBy;
                        delete mat.modifiedOn;
                        delete mat.$$hashKey;

                        mat.Ry = '';
                        mat.Rt = '';
                    });

                    break;
                }
                case 'sections': {
                    data = angular.copy($scope.models.geometry.secs);

                    order = ['sec_name', 'size2', 'mat', 'A', 'Iyy', 'Izz', 'J', 'Type', 'Dlist', 'Ru'];

                    data.forEach((sec) => {
                        delete sec.shapeList;
                        delete sec.size1List;
                        delete sec.size2List;

                        delete sec.no;
                        delete sec.sec_id;
                        delete sec.db_geo_PK;
                        delete sec.shape;
                        delete sec.size1;
                        delete sec.notes;
                        delete sec.createdBy;
                        delete sec.createdOn;
                        delete sec.modifiedBy;
                        delete sec.modifiedOn;
                        delete sec.$$hashKey;

                        sec.Type = '';
                        sec.Dlist = '';
                        sec.Ru = '';

                    });

                    break;
                }
                case 'nodes': {
                    let temp = angular.copy($scope.models.geometry.nodes);

                    order = ['name', 'x', 'y', 'z'];

                    temp.forEach((node) => {
                        let tnode = {
                            x: node.x,
                            y: node.y,
                            z: node.z,
                            name: node.node_name
                        };

                        data.push(tnode);
                    });

                    break;
                }
                case 'members': {
                    data = angular.copy($scope.models.geometry.members);

                    order = ['Mbr_Name', 'sec_name', 'NodeSname', 'NodeEname', 'NodeOname', 'ROT', 'Type', 'Dlist'];

                    data.forEach((mem) => {
                        delete mem.no;
                        delete mem.db_geo_PK;
                        delete mem.Face;
                        delete mem.Mat;
                        delete mem.notes;
                        delete mem.Mbr_Lth;
                        delete mem.Note_G;
                        delete mem.createdBy;
                        delete mem.createdOn;
                        delete mem.modifiedBy;
                        delete mem.modifiedOn;
                        delete mem.$$hashKey;

                        mem.Type = '0';
                        mem.Dlist = '0';

                        $scope.models.geometry.nodes.forEach(function (node) {

                            if (node.no == mem.NodeS) {
                                mem.NodeSname = node.node_name;
                            }

                            if (node.no == mem.NodeE) {
                                mem.NodeEname = node.node_name;
                            }

                            if (node.no == mem.NodeO) {
                                mem.NodeOname = node.node_name;
                            }

                        });
                    });

                    break;
                }
                case 'connections': {

                    order = ['name', 'mbrA', 'mbrA_loc', 'mbrB', 'mbrB_loc', 'cntr'];

                    data = angular.copy($scope.models.geometry.connections);
                    //connectors????
                    break;
                }
                case 'association': {
                    data = angular.copy($scope.models.geometry.association);
                    break;
                }
                case 'analysis': {
                    order = ['lc_name', 'dc_name'];

                    data = angular.copy($scope.models.geometry.list_analysis_lc);
                    break;
                }
                default: {
                    data = angular.copy($scope.models.geometry[tab]);
                    break;
                }
            }

            let copy = '';
            // let copy = JSON.stringify(data, null, 2);

            data.forEach((item) => {
                let t = '';

                order.forEach((attr) => {
                    if (item[attr]) {
                        t = t + '' + item[attr] + ' ';
                    } else {
                        t = t + '0 ';
                    }
                });

                t = t.slice(0, -1);

                copy = copy + t + '\n';
            });

            let textArea = document.createElement("textarea");


            // Place in top-left corner of screen regardless of scroll position.
            textArea.style.position = 'fixed';
            textArea.style.top = 0;
            textArea.style.left = '-300px';
            textArea.style['z-index'] = -1;

            // Ensure it has a small width and height. Setting to 1px / 1em
            // doesn't work as this gives a negative w/h on some browsers.
            textArea.style.width = '2em';
            textArea.style.height = '2em';

            // We don't need padding, reducing the size if it does flash render.
            textArea.style.padding = 0;

            // Clean up any borders.
            textArea.style.border = 'none';
            textArea.style.outline = 'none';
            textArea.style.boxShadow = 'none';

            // Avoid flash of white box if rendered for any reason.
            textArea.style.background = 'transparent';


            textArea.value = copy;

            document.body.appendChild(textArea);

            textArea.select();

            try {
                let successful = document.execCommand('copy');
                let msg = successful ? 'successful' : 'unsuccessful';
            } catch (err) {
                console.log('Oops, unable to copy');
            }

            document.body.removeChild(textArea);

        }

    };

    $scope.models.geometry.changeAssocOptions = function (item, index) {

        // item, index, list

        if (item.select == null) {

            if (index) {
                $scope.models.geometry.list_analysis_eq[index].association = angular.copy($scope.models.geometry.reset.analysis);
            }

            return false;

        }

        $scope.models.buildTabs(item, "all", function (items, details) {

            angular.forEach($scope.models.geometry.list_analysis_eq, function (eqpt) {

                if ($scope.base.selectedEqId == eqpt.id) {

                    if (details.data && details.data[0]) {
                        eqpt.id = details.data[0].id;
                    }

                    eqpt.association = items;

                    $scope.models.geometry.saveAnalysisEqpt(eqpt);

                }

            });


        });


    };

    $scope.models.geometry.changeLcInfoOptions = function () {
        $scope.models.geometry.saveAnalysisLcDetails($scope.base.selectedLc);
    };

    $scope.models.geometry.calcRad = function () {

        let rad = 0;

        if ($scope.models.geometry.newObject.dy) {

            rad += parseFloat($scope.models.geometry.newObject.dy);

        }

        let dcy = 0;

        $scope.models.geometry.analysisCombinations.forEach(function (comb) {
            if (comb.draw === 'true' && comb.dc_id) {
                $scope.models.geometry.activeGeometryDcList.forEach(function (dc) {
                    if (dc.id == comb.dc_id) {

                        if (dc.dy && dc.dy_chk === 'true') {
                            dcy = parseFloat(dc.dy);
                        }

                    }
                })
            }
        });

        rad += dcy;

        $scope.models.geometry.newObject.rad = rad;

    };

    $scope.models.geometry.calcAzm = function () {

        let azm = 0;

        if ($scope.models.geometry.newObject.roty) {

            azm += parseFloat($scope.models.geometry.newObject.roty);

        }

        let dcroty = 0;

        $scope.models.geometry.analysisCombinations.forEach(function (comb) {
            if (comb.draw === 'true' && comb.dc_id) {
                $scope.models.geometry.activeGeometryDcList.forEach(function (dc) {
                    if (dc.id == comb.dc_id) {

                        if (dc.roty) {
                            dcroty = parseFloat(dc.roty);
                        }

                    }
                })
            }
        });

        azm += dcroty;

        $scope.models.geometry.newObject.azm = azm;

    };

    $scope.models.geometry.addNewObject = function () {

        $scope.base.showAddEqPanel = false;

        $scope.models.geometry.addAnalysisLcDetails('onMember');

    };

    //geo photos
    $scope.models.geometry.getPhotoList = function () {

        let id = $scope.models.geometry.details ? $scope.models.geometry.details[0].id : 0;

        request.getPhotoList('geometry', id).then(function (response) {

            $scope.models.geometry.photo_list = response;

        });

    };

    $scope.models.geometry.uploadPhotoFile = function () {
        let file = $scope.models.geometry.photoBrowseFile;

        let id = $scope.models.geometry.details ? $scope.models.geometry.details[0].id : 0;

        if (id) {
            file.forEach(function (item) {

                let fd = new FormData();
                fd.append('file', item);

                return $.ajax({
                    url: "request.php?method=uploadGeometryPhoto&db_geo_PK=" + id,
                    type: "POST",
                    data: fd,
                    enctype: "multipart/form-data",
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        if (response.files) {
                            response.files.forEach(function (item) {
                                $scope.models.geometry.photo_list.push(item);
                            });

                            $scope.$applyAsync();
                        }
                    }
                }).then(
                    handler.success,
                    handler.error
                );

            });
        }
    };

    $scope.models.geometry.uploadPhotoFromUrl = function () {

        let id = $scope.models.geometry.details ? $scope.models.geometry.details[0].id : 0;

        if (id && $scope.models.geometry.photoUploadURL) {
            let urls = $scope.models.geometry.photoUploadURL.split(',');

            urls.forEach(function (item) {

                request.uploadPhotoFromUrl({
                    tab: 'geometry',
                    url: item,
                    pk: id
                }).then(function (response) {

                    if (response.file) {
                        $scope.models.geometry.photo_list.push(response.file);
                    }


                });

            })
        }

    };

    $scope.models.geometry.uploadPhotoFromDnd = function () {

        let id = $scope.models.geometry.details ? $scope.models.geometry.details[0].id : 0;
        let data = {
            pk: id,
            table: 'db_geo_photo'
        };

        data.file = $scope.models.geometry.photoDragFile;
        data.name = $scope.models.geometry.photoDragName;

        if (data.name) {

            request.uploadPhotoFromDnd(data).then(function (response) {

                if (response.file) {
                    $scope.models.geometry.photo_list.push(response.file);
                }

            });

        }

    };

    $scope.models.geometry.updatePhotoFile = function (photo) {

        request.updatePhotoFile({
            table: 'db_geo_photo',
            notes: photo.notes,
            id: photo.id
        }).then(function (response) {

            if (response.status) {
                photo.change = false;
            }

        });

    };

    $scope.models.geometry.removePhotoFile = function (photo, index) {

        request.removePhotoFile({
            table: 'db_geo_photo',
            id: photo.id
        }).then(function (response) {

            if (response.status) {
                $scope.models.geometry.photo_list.splice(index, 1);
            }

        });

    };
    //

    //SITES
    $scope.models.site = {
        selected: [],
        pattern: [],
        details: [],
        list_assoc: [],
        list_analysis_eq: [],
        list_analysis_lc: [],
        list_analysis_dc: [],
        connectors: [],
        connections: [],
        pdf: [],
        members: [],
        secs: [],
        nodes: [],
        nodes_p: [],
        materials: [],
        geometries_ids: []

    };

    $scope.models.site.tree = {
        data: [],
        expanded: [],
        newProduct: {},
        options: {
            nodeChildren: "sitesTreeList",
            multiSelection: false,
            dirSelectable: true,
            isAccess: function (node) {
                var state = "show";

                if (node.status == "inactive") {
                    state = "hide";

                    if ($scope.auth.isAdmin()) {
                        state = "disable";
                    }
                }

                return state;
            },
            isPremier: function (node) {
                return node.accessLevel == "premier";
            },
            isLeaf: function (node) {
                return false;
            }
        },
        node: {},
        selectedNodes: [],
        showSelected: function (node, type) {

            $('.panel-geometry-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            $('.panel-product-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            $('.panel-site-tree-element').each(function () {
                $(this).parent().removeClass('panel-selected-node');
            });

            if (!$scope.models.containsObject($scope.models.site.tree.expanded, node)) {
                $scope.models.site.tree.expanded.push(node);
            }

            $scope.models.product.tree.node = {};
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.tree.selectedNodeType = type;


            if (node.category) {
                $scope.models.site.tree.formNodesList(node);
            } else {
                $scope.models.product.tree.selectedNodes.push(node);
            }

            // console.log('sites show selected', $scope.models.product.tree.selectedNodes, node);

        },
        formNodesList: function (node) {
            if (node.sitesList) {
                node.sitesList.forEach(function (item) {
                    if (!item.category) {
                        $scope.models.product.tree.selectedNodes.push(item);
                    } else if (node.id !== 0) {
                        $scope.models.site.tree.formNodesList(item);
                    }
                })
            } else {
                node.sitesList = [];
                node.sitesTreeList = [];
            }
        },
    };

    $scope.models.site.changeItem = function (item) {

        if (item.select == null) {

            $scope.query.resetSite();

        } else {

            if($scope.models.site.pattern.length === 0) {

                $scope.models.site.pattern.push({
                    id: item.select.id,
                    value: item.select.value,
                    key: item.key
                })

            } else {
                let found = false;
                let index = 0;

                $scope.models.site.pattern.forEach((pattern, i) => {

                    if(pattern.key === item.key) {
                        found = true;
                        index = i;
                    }

                })

                if(found) {
                    $scope.models.site.pattern.splice(index);
                }

                $scope.models.site.pattern.push({
                    id: item.select.id,
                    value: item.select.value,
                    key: item.key
                })


            }

        }

        request.getSitesItemList($scope.userLoadInfo, $scope.models.site.pattern).then(function (response) {

            response.ddls.forEach((ddl) => {

                let found = false;

                $scope.models.site.pattern.forEach((pattern) => {

                    if(pattern.key === ddl.key) {
                        found = true;
                    }

                })

                if(!found) {

                    $scope.models.site.items.forEach((select) => {

                        if(select.key === ddl.key) {
                            select.data = ddl.data;

                            if(select.data.length === 1) {
                               select.select = select.data[0];
                            }

                        }

                    })

                }

            });

            if (response.data && response.data.length === 1) {

                $scope.models.site.selectSite(response.data[0]);

            }

        });

    }

    $scope.models.site.selectSite = function (site) {

        let selected = [{
            key: 'Model_G',
            value: site.geo_id
        }]


        request.items(selected, 'site', $scope.userLoadInfo).then(function (details) {

            $scope.models['geometry'].allowEdit = details.data[0].userID == $scope.auth.data.id;

            $scope.models.geometry.dataLoaded = true;

            $scope.models.nodes.add.db_geo_PK = details.data[0].id;
            $scope.models.secs.add.db_geo_PK = details.data[0].id;
            $scope.models.geometry.newMaterial.db_geo_PK = details.data[0].id;
            $scope.models.geometry.newMaterial.org = $scope.models.geometry.materialsLists.orgList[0].value || '';
            $scope.models.geometry.db_geo_PK = details.data[0].id;
            $scope.models.geometry.details = details.data || [];
            $scope.models.geometry.members = details.members;
            if ($scope.models.geometry.members) $scope.models.geometry.members.sort($scope.sortByIntId);
            $scope.models.geometry.nodes = details.nodes;
            if ($scope.models.geometry.nodes) $scope.models.geometry.nodes.sort($scope.sortByIntId);
            $scope.models.geometry.nodes_p = details.nodes_p || [];
            $scope.models.geometry.secs = details.secs;
            if ($scope.models.geometry.secs) $scope.models.geometry.secs.sort($scope.sortByIntId);
            $scope.models.geometry.connectors = details.connectors || [];
            if ($scope.models.geometry.connectors) $scope.models.geometry.connectors.sort($scope.sortByIntId);
            $scope.models.geometry.connections = details.connections || [];
            if ($scope.models.geometry.connections) $scope.models.geometry.connections.sort($scope.sortByIntId);

            $scope.models.geometry.list_assoc = [];
            $scope.models.geometry.list_analysis_eq = [];
            $scope.models.geometry.list_analysis_lc = [];
            $scope.models.geometry.list_analysis_dc = [];

            $scope.models.geometry.getSectionsInfo(function (response) {
                if (response.data) {
                    $scope.sectionsInfo = response.data;
                    $scope.sectionsInfo.forEach(function (item) {
                        $scope.unitConversionProcess(item);
                    });
                }
                $scope.models.geometry.nodes_p.forEach(function (parameter) {
                    $scope.models.geometry.changeSection(parameter);
                });

                angular.forEach($scope.models.geometry.secs, function (item) {
                    item.shapeList = angular.copy($scope.models.geometry.shapesList.shapeList);
                    item.size1List = angular.copy($scope.models.geometry.shapesList.size1List);
                    item.size2List = angular.copy($scope.models.geometry.shapesList.size2List);
                });

                $scope.models.geometry.materials = details.materials;
                if ($scope.models.geometry.materials) $scope.models.geometry.materials.sort($scope.sortByIntId);

                angular.forEach($scope.models.geometry.materials, function (item) {
                    item.orgList = angular.copy($scope.models.geometry.materialsLists.orgList);
                    item.standardList = angular.copy($scope.models.geometry.materialsLists.standardList);
                    item.gradeList = angular.copy($scope.models.geometry.materialsLists.gradeList);
                });

                $scope.models.geometry.association = angular.copy($scope.models.geometry.reset.association);
                $scope.models.geometry.analysis = angular.copy($scope.models.geometry.reset.analysis);

                $scope.query.pdfGeometry();
                $scope.models.geometry.getPhotoList();

                var product = {};

                angular.forEach($scope.models.geometry.items, function (item) {
                    if (item.select) {
                        product[item.key] = item.select.value;
                    }
                });

                $scope.models.geometry.getGeometryAssociationsList(function (assoc_list) {

                    request.getGeometryAssociationNew(assoc_list).then(function (response) {

                        $scope.models.geometry.list_assoc = response;

                        angular.forEach($scope.models.geometry.list_assoc, function (list) {
                            list.association = angular.copy($scope.models.geometry.reset.association);

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

                    });

                });
                $scope.models.geometry.getAnalysisCombinations();

                $scope.models.geometry.getAnalysis(function (analysis_ids) {

                    request.getAnalysisEqpt(analysis_ids).then(function (response_data) {

                        if (response_data) {

                            var products_analys = [];

                            $scope.models.product.list.forEach(function (item) {

                                response_data.forEach(function (product) {

                                    if (item.id == product.db_pro_PK) {
                                        var tmp = angular.copy(item);
                                        tmp.analysis_name = product.name;
                                        tmp.analysis_notes = product.notes;
                                        tmp.eqpt_id = product.id;
                                        tmp.createdOn = product.createdOn;
                                        products_analys.push(tmp);
                                    }
                                })
                            });

                            $scope.models.geometry.list_analysis_eq = products_analys;
                            if ($scope.models.geometry.list_analysis_eq) $scope.models.geometry.list_analysis_eq.sort($scope.sortByCreatedDate);

                            angular.forEach($scope.models.geometry.list_analysis_eq, function (list) {
                                list.association = angular.copy($scope.models.geometry.reset.association);

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

                        }

                        $scope.models.geometry.drawWholeGeometry();

                    });

                });

            });


        });


        $('#product, #geometry, #panelTabs li').removeClass('active');
        $('#site, #site-tab').addClass('active');
        $scope.models.changeTabs('site')

        //todo change searchInputChange functions like here

    };

    $scope.models.site.formSitesTreeList = function () {
        if ($scope.auth.isAuth()) {
            request.getFolders($scope.auth.data.id).then(function (folders) {

                var treeList = [];
                var SiteMain = {
                    name: 'Site',
                    sitesList: [],
                    sitesTreeList: [],
                    category: 'site',
                    id: 0
                };

                $scope.models.site.list.forEach(function (site) {
                    if (site.userID == $scope.auth.data.id) {
                        if (site.parentID != 0) {
                            folders.forEach(function (folderItem) {
                                if (folderItem.id == site.parentID) {
                                    if (!folderItem.sitesList) {
                                        folderItem.sitesList = [];
                                        folderItem.sitesTreeList = [];
                                    }

                                    folderItem.sitesList.push(site);
                                }
                            })
                        }

                        SiteMain.sitesList.push(site);

                    }
                });

                folders.forEach(function (item) {
                    if (item.parentID != 0) {
                        folders.forEach(function (folder) {
                            if (!folder.sitesList) {
                                folder.sitesList = [];
                                folder.sitesTreeList = [];
                            }
                            if (folder.id == item.parentID) {
                                folder.sitesList.push(item);
                                folder.sitesTreeList.push(item);
                            }
                        });
                    } else {
                        if (item.category == 'site') {
                            SiteMain.sitesList.push(item);
                            SiteMain.sitesTreeList.push(item);
                        }
                    }
                });



                treeList.push(SiteMain);

                $scope.models.site.tree.data = treeList;


            });
        } else {
            $scope.models.site.tree.data = [];
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.panel = false;
        }
    };

    $scope.models.site.addNewSite = function (new_site) {

        let new_node = angular.copy(new_site);

        if ($scope.models.site.checkForSameSite(new_node, $scope.models.site.list)) {
            alert("There are existing data record having same master-field combination. Change the value of at least one of the master fields.");
            return;
        }

        new_node.userID = $scope.auth.data.id;

        // console.log(new_node);

        request.addSite(new_node).then(function (response) {

            console.log(response);

            if (response.result) {

                $scope.models.product.tree.selectedNodes.push(response.data);
                $scope.models.site.tree.node.sitesList.push(response.data);
                $scope.models.site.list.push(response.data);

                request.getSitesItemList($scope.userLoadInfo, $scope.models.site.pattern).then(function (response) {

                    response.ddls.forEach((ddl) => {

                        let found = false;

                        $scope.models.site.pattern.forEach((pattern) => {

                            if (pattern.key === ddl.key) {
                                found = true;
                            }

                        })

                        if (!found) {

                            $scope.models.site.items.forEach((select) => {

                                if (select.key === ddl.key) {
                                    select.data = ddl.data;
                                }

                            })

                        }

                    });

                });

            }
        });

    };

    $scope.models.site.checkForSameSite = function (site, list) {
        var check = false;

        list.forEach(function (item) {
            let same = true;


            if (site.fa) {
                if (item.fa != site.fa) {
                    same = false;
                }
            }

            if (site.site_name) {
                if (item.site_name != site.site_name) {
                    same = false;
                }
            }

            if (site.elev) {
                if (item.elev != site.elev) {
                    same = false;
                }
            }

            if (site.sectors) {
                if (item.sectors != site.sectors) {
                    same = false;
                }
            }

            if (site.geo_id) {
                if (item.geo_id != site.geo_id) {
                    same = false;
                }
            }

            if (same) {
                check = true;
            }
        });

        return check;
    };

    $scope.models.site.updateSite = function (site) {

        request.updateSite(site).then(function (response) {
            site.change = false;
        });

    };

    $scope.models.site.deleteSite = function (id) {

        request.remove(id, "site", null, 'id').then(function (response) {

            if (response) {

                for (var i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                    if ($scope.models.product.tree.selectedNodes[i].id == id) {
                        $scope.models.product.tree.selectedNodes.splice(i, 1);
                    }
                }

                for (var k = 0; k < $scope.models.site.tree.node.sitesList.length; k++) {
                    if ($scope.models.site.tree.node.sitesList[k].id == id) {
                        $scope.models.site.tree.node.sitesList.splice(k, 1);
                    }
                }

                $scope.query.resetSite();

            }

        });

    };

    $scope.models.site.generateSiteItems = function(list) {
        let sites = [];

        let fa = {
            data: [],
            key: 'fa',
            name: 'FA',
        };

        let elev = {
            data: [],
            key: 'elev',
            name: 'Elev',
        };

        let name = {
            data: [],
            key: 'site_name',
            name: 'Name',
        };

        let sectors = {
            data: [],
            key: 'sectors',
            name: 'Sectors',
        };

        let g_model = {
            data: [],
            key: 'geo_id',
            name: 'Geo Model',
        };

        list.forEach(function(site) {

            if(site.fa) {

                let found = false;

                fa.data.forEach((item)=>{
                    if(item.value === site.fa) {
                        found = true;
                    }
                })

                if(!found) {
                    fa.data.push({
                        id: site.id,
                        value: site.fa
                    });
                }

            }

            if(site.elev) {

                let found = false;

                elev.data.forEach((item)=>{
                    if(item.value === site.elev) {
                        found = true;
                    }
                })

                if(!found) {
                    elev.data.push({
                        id: site.id,
                        value: site.elev
                    });
                }
            }

            if(site.site_name) {

                let found = false;

                name.data.forEach((item)=>{
                    if(item.value === site.name) {
                        found = true;
                    }
                })

                if(!found) {
                    name.data.push({
                        id: site.id,
                        value: site.site_name
                    });
                }
            }

            if(site.sectors) {

                let found = false;

                sectors.data.forEach((item)=>{
                    if(item.value === site.sectors) {
                        found = true;
                    }
                })

                if(!found) {
                    sectors.data.push({
                        id: site.id,
                        value: site.sectors
                    });
                }
            }

            if(site.geo_id) {

                let found = false;

                g_model.data.forEach((item)=>{
                    if(item.value === site.geo_id) {
                        found = true;
                    }
                })

                if(!found) {
                    g_model.data.push({
                        id: site.id,
                        value: site.geo_id
                    });
                }
            }

        });

        sites.push(fa, elev, name, sectors, g_model);

        return sites;
    }

    //



    $scope.models.selectChange = function () {
        if (!$scope.models.product.settings.private && !$scope.models.product.settings.shared) {
            alert('No database is checked for operation.');
        }
    };

    $scope.models.createFolder = function (node, new_folder) {

        new_folder.category = node.category;
        new_folder.parentID = node.id;
        new_folder.userID = $scope.auth.data.id;

        request.createFolder(new_folder).then(function (response) {
            if (node.category == 'product') {
                node.productsList.push(response.data);
                node.productsTreeList.push(response.data);
            } else if(node.category == 'geometry') {
                node.geometriesList.push(response.data);
                node.geometriesTreeList.push(response.data);
            } else if(node.category == 'site') {
                node.sitesList.push(response.data);
                node.sitesTreeList.push(response.data);
            }

        });
    };

    $scope.models.updateFolder = function (folder, callback) {

        var new_folder = angular.copy(folder);

        if (new_folder.category == 'product') {
            delete new_folder.productsList;
            delete new_folder.productsTreeList;
        } else {
            delete new_folder.geometriesList;
            delete new_folder.geometriesTreeList;
        }

        request.updateFolder(new_folder).then(function (response) {
            if (callback) {
                callback();
            }
        });
    };

    $scope.models.removeFolder = function (folder) {

        request.removeFolder(folder.id).then(function (response) {
            if (response.success) {
                if (folder.category == 'product') {
                    $scope.models.updateTreeView($scope.models.product.tree.data[0], folder.id, 'product');
                } else {
                    $scope.models.updateTreeView($scope.models.geometry.tree.data[0], folder.id, 'geometry');
                }
            }
        });
    };

    $scope.models.updateTreeView = function (list, id, type) {
        if (type == 'product') {
            list.productsTreeList.forEach(function (item, index) {
                if (item.id == id) {
                    list.productsTreeList.splice(index, 1);
                } else {
                    if (item.productsTreeList) {
                        $scope.models.updateTreeView(item, id, type);
                    }
                }
            })
        } else {
            list.geometriesTreeList.forEach(function (item, index) {
                if (item.id == id) {
                    list.geometriesTreeList.splice(index, 1);
                } else {
                    if (item.geometriesTreeList) {
                        $scope.models.updateTreeView(item, id, type);
                    }
                }
            })
        }
    };

    $scope.models.changeTabs = function (tabs) {
        $scope.models.tabs = tabs;

        $scope.base.showNodeInfo = false;
        $scope.base.showMemberInfo = false;
        $scope.base.showAddEqPanel = false;
        $scope.base.showAssocInfo = false;
        $scope.base.showAxesHelperForMesh = false;

        $scope.viewByStatusPanel.showPanel = false;

        $scope.viewByStatusColor.enabled = false;


        if (tabs === 'geometry') {

            if($scope.models.geometry.selected.length) {

                let key = null;

                $scope.models.geometry.selected.forEach((select) => {
                    if(select.last) {
                        key = select.key;
                    }
                });

                $scope.models.geometry.items.forEach((item) => {
                    if(item.key === key) {
                        $scope.models.geometry.changeItem(item);
                    }
                });

            } else {
                $scope.models.geometry.drawWholeGeometry();
            }

        } else if(tabs === 'site') {

            if($scope.models.site.selected.length) {

                let key = null;

                $scope.models.site.selected.forEach((select) => {
                    if(select.last) {
                        key = select.key;
                    }
                });

                $scope.models.site.items.forEach((item) => {
                    if(item.key === key) {
                        $scope.models.site.changeItem(item);
                    }
                });

            }

            console.log($scope.models.site.selected, $scope.models.site.items);
        } else {
            $scope.render.redraw('product');
        }

    };

    $scope.models.buildTabs = function (current, type, callback, new_row) {
        var itemType = type;

        if(itemType === 'all') {
            itemType = 'product';
        }


        if (angular.isFunction(callback)) {
            var selected = {
                key: current.key,
                value: current.select ? current.select.value : null,
                last: true
            };

            if (new_row) {
                $scope.models[itemType].selected = [];
                $scope.models[itemType].selected.push(selected);
            } else {
                var found = false;

                angular.forEach($scope.models[itemType].selected, function (item, index) {
                    if (item.key != current.key || item.lastCustom == false) {
                        item.last = false;
                    } else {
                        $scope.models[itemType].selected.splice(index + 1, 5);
                        item.last = true;
                        item.value = current.select.value;
                        found = true
                    }
                });

                if (!found && selected.value) $scope.models[itemType].selected.push(selected);
            }

            request.sort($scope.models[itemType].selected, type, $scope.userLoadInfo).then(function (items) {
                angular.forEach(items, function (item) {
                    item.data.forEach(function (data) {
                        var exit = false;
                        $scope.models[itemType].selected.forEach(function (selected) {
                            if (data.value == selected.value) {
                                item.select = data;
                                exit = true;
                                return false;
                            }
                        });
                        if (exit) return false;
                    });

                    if (item.data.length == 1) {
                        item.select = item.data[0];
                        var found = false;
                        angular.forEach($scope.models[itemType].selected, function (selected) {
                            if (selected.key == item.key) {
                                found = true;
                            }
                        });
                        if (!found) {
                            // item.lastCustom = false;
                            // $scope.models[itemType].changeItem(item);
                        }
                    }
                });

                request.items($scope.models[itemType].selected, type, $scope.userLoadInfo).then(function (details) {

                    callback.call({}, items, details);
                    if (details.data && $scope.auth.isAuth()) {

                        $scope.models[itemType].allowEdit = details.data[0].userID == $scope.auth.data.id;

                        if(itemType === 'site') {
                            $scope.models['geometry'].allowEdit = details.data[0].userID == $scope.auth.data.id;
                        }

                        // $scope.models[itemType].allowEdit = true;
                    } else {
                        $scope.models[itemType].allowEdit = false;

                        if(itemType === 'site') {
                            $scope.models[itemType].allowEdit = false;
                        }
                    }
                });
            });
        }
    };

    $scope.models.pdfSave = function (pdf, type) {
        request.savePdf(pdf.id, pdf, type).then(function (response) {
            pdf.change = false;
        });
    };

    $scope.models.pdfRemove = function (id, type) {

        request.removePdf(id, type).then(function (response) {
            $scope.query.pdf();
        });
    };

    $scope.models.copyProductPopUp = function () {

        if (!$scope.auth.isAuth()) {
            return;
        }

        $scope.models.copyObj = {};

        $scope.models.copyFoldersDdl = [];

        let not_empty = false;

        if ($scope.models.tabs === 'geometry') {
            if ($scope.models.geometry.details) {
                if (Array.isArray($scope.models.geometry.details)) {
                    $scope.models.copyObj = $scope.models.geometry.details[0];
                } else {
                    $scope.models.copyObj = $scope.models.geometry.details;
                }

                if ($scope.models.copyObj) {
                    if ($scope.models.copyObj.Type_G) {
                        $scope.models.copyObj.Type_G = $scope.models.copyObj.Type_G + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.Sub_type_G) {
                        $scope.models.copyObj.Sub_type_G = $scope.models.copyObj.Sub_type_G + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.Shape_G) {
                        $scope.models.copyObj.Shape_G = $scope.models.copyObj.Shape_G + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.Mftr_G) {
                        $scope.models.copyObj.Mftr_G = $scope.models.copyObj.Mftr_G + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.Model_G) {
                        $scope.models.copyObj.Model_G = $scope.models.copyObj.Model_G + '-copy-' + moment().format('ms') + $scope.auth.data.id;
                        not_empty = true;
                    }

                    $scope.models.geometry.tree.data.forEach(function (geometry) {
                        var path = geometry.name + '/';
                        $scope.models.copyFoldersDdl.push({name: geometry.name, id: geometry.id, path: path + 'root'});

                        $scope.models.product.generateFoldersTree(geometry.geometriesTreeList, $scope.models.copyFoldersDdl, path);
                    });
                }

            }
        } else {
            if ($scope.models.product.details) {
                if (Array.isArray($scope.models.product.details)) {
                    $scope.models.copyObj = $scope.models.product.details[0];
                } else {
                    $scope.models.copyObj = $scope.models.product.details;
                }

                if ($scope.models.copyObj) {
                    if ($scope.models.copyObj.type) {
                        $scope.models.copyObj.type = $scope.models.copyObj.type + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.sub_type) {
                        $scope.models.copyObj.sub_type = $scope.models.copyObj.sub_type + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.shape) {
                        $scope.models.copyObj.shape = $scope.models.copyObj.shape + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.mftr) {
                        $scope.models.copyObj.mftr = $scope.models.copyObj.mftr + '-copy';
                        not_empty = true;
                    }

                    if ($scope.models.copyObj.model) {
                        $scope.models.copyObj.model = $scope.models.copyObj.model + '-copy-' + moment().format('ms') + $scope.auth.data.id;
                        not_empty = true;
                    }

                    $scope.models.product.tree.data.forEach(function (product) {
                        var path = product.name + '/';
                        $scope.models.copyFoldersDdl.push({name: product.name, id: product.id, path: path + 'root'});

                        $scope.models.product.generateFoldersTree(product.productsTreeList, $scope.models.copyFoldersDdl, path);
                    });
                }

            }
        }

        if (not_empty) {
            $scope.models.copyPanel = true;
        }
    };

    $scope.models.createLink = function () {

        let copyObject = {};

        let link = {};

        if ($scope.models.tabs === 'geometry') {
            if ($scope.models.geometry.details) {
                if (Array.isArray($scope.models.geometry.details)) {
                    copyObject = $scope.models.geometry.details[0];
                } else {
                    copyObject = $scope.models.geometry.details;
                }

                if (copyObject && copyObject.id) {

                    link = {
                        mode: 'link',
                        linkID: copyObject.id,
                        userID: $scope.auth.data.id,
                        table: 'geometry'
                    };

                }

            }
        } else {
            if ($scope.models.product.details) {
                if (Array.isArray($scope.models.product.details)) {
                    copyObject = $scope.models.product.details[0];
                } else {
                    copyObject = $scope.models.product.details;
                }

                if (copyObject && copyObject.id) {

                    link = {
                        mode: 'link',
                        linkID: copyObject.id,
                        userID: $scope.auth.data.id,
                        table: 'product'
                    };

                }

            }
        }

        request.createLink(link).then(function (response) {

            if (response.status) {

                if ($scope.models.tabs === 'geometry') {
                    $scope.models.geometry.formGeometriesTreeList();
                } else {
                    $scope.models.product.formProductTreeList();
                }

                alert('Link created successfully');
            }

        });


    };

    $scope.models.copyProduct = function () {

        $scope.models.copyObj.parentID = $scope.models.copyFolder;

        if ($scope.models.tabs === 'all') {
            $scope.models.product.addNewProduct($scope.models.copyObj, true, function (response) {
                $scope.models.product.searchInputChange({item: response.data});
            });
        } else if ($scope.models.tabs === 'geometry') {
            $scope.models.geometry.addNewGeometry($scope.models.copyObj, true, function (response) {
                $scope.models.geometry.searchInputChange({item: response.data});
            });
        }
    };

    $scope.models.openPanelPopUp = function () {
        if ($scope.auth.isAuth()) {
            $scope.models.product.tree.selectedNodes = [];
            $scope.models.product.tree.selectedNodeType = '';
            $scope.models.product.panel = !$scope.models.product.panel;
        }
    };


    // transferDataPopUp

    $scope.actions.transferDataPopUp.transferSelected = function (item, transferObjType) {
        if ($scope.auth.isAuth()) {
            $scope.actions.transferDataPopUp.show = true;
            $scope.actions.transferDataPopUp.object = item;
            $scope.actions.transferDataPopUp.transferObjType = transferObjType;
        }
    };

    $scope.actions.transferDataPopUp.transferMode = '';

    $scope.actions.transferDataPopUp.permissions = [
        {value: 'edit', description: 'Edit'},
        {value: 'view', description: 'View'},
        {value: 'transfer', description: 'Transfer'}
    ];

    $scope.actions.transferDataPopUp.acceptPermission = function () {

        let mailPattern = /\w+@\w+\.+\w+/;

        if (mailPattern.test($scope.actions.transferDataPopUp.selectedUser)) {
            $scope.actions.transferDataPopUp.typeCredentialField = 'Email';
        } else {
            $scope.actions.transferDataPopUp.typeCredentialField = 'Username'
        }

        $scope.actions.transferDataPopUp.show = false;

        if ($scope.actions.transferDataPopUp.transferMode === 'view' || $scope.actions.transferDataPopUp.transferMode === 'edit') {
            $scope.actions.transferDataPopUp.givePermissionToAnotherUser($scope.actions.transferDataPopUp.transferObjType, $scope.actions.transferDataPopUp.object.id, $scope.actions.transferDataPopUp.typeCredentialField, $scope.actions.transferDataPopUp.selectedUser, $scope.actions.transferDataPopUp.transferMode);
            $scope.actions.transferDataPopUp.resetTransferDataPopUpFields();

        }

        if ($scope.actions.transferDataPopUp.transferMode === 'transfer') {
            $scope.actions.transferDataPopUp.transferDataToAnotherUser($scope.actions.transferDataPopUp.transferObjType, $scope.actions.transferDataPopUp.object.id, $scope.actions.transferDataPopUp.typeCredentialField, $scope.actions.transferDataPopUp.selectedUser);
        }
    };

    $scope.actions.transferDataPopUp.transferDataToAnotherUser = function (transferObjType, objId, typeCredentialField, selectedUser) {

        request.transferDataToAnotherUser(transferObjType, objId, typeCredentialField, selectedUser).then(function (res) {

            if (res.status && transferObjType == 'geometry') {
                for (let i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                    if ($scope.models.product.tree.selectedNodes[i].id == objId) {
                        $scope.models.product.tree.selectedNodes.splice(i, 1);
                    }
                }

                for (let i = 0; i < $scope.models.geometry.tree.node.geometriesList.length; i++) {
                    if ($scope.models.geometry.tree.node.geometriesList[i].id == objId) {
                        $scope.models.geometry.tree.node.geometriesList.splice(i, 1);
                    }
                }

                $scope.query.resetGeometry();
                $scope.actions.transferDataPopUp.resetTransferDataPopUpFields();
            }
            else if (res.status && transferObjType == 'product') {
                for (var i = 0; i < $scope.models.product.tree.selectedNodes.length; i++) {
                    if ($scope.models.product.tree.selectedNodes[i].id == objId) {
                        $scope.models.product.tree.selectedNodes.splice(i, 1);
                    }
                }

                for (var k = 0; k < $scope.models.product.tree.node.productsList.length; k++) {
                    if ($scope.models.product.tree.node.productsList[k].id == objId) {
                        $scope.models.product.tree.node.productsList.splice(k, 1);
                    }
                }

                $scope.query.resetProduct();
                $scope.actions.transferDataPopUp.resetTransferDataPopUpFields();
            }
        }); // callback's end
    };

    $scope.actions.transferDataPopUp.givePermissionToAnotherUser = function (transferObjType, objId, typeCredentialField, selectedUser, permission) {
        request.givePermissionToAnotherUser(transferObjType, objId, typeCredentialField, selectedUser, permission).then(function (res) {
            if (res.status) {
                alert('User with ' + typeCredentialField + ' "' + selectedUser + '" received the rights to ' + permission);
            }
            else {
                alert('User ' + selectedUser + ' already received this rights.');
            }
        });
    };

    $scope.actions.transferDataPopUp.resetTransferDataPopUpFields = function () {
        $scope.actions.transferDataPopUp.transferObjType = '';
        $scope.actions.transferDataPopUp.object = {};
        $scope.actions.transferDataPopUp.typeCredentialField = '';
        $scope.actions.transferDataPopUp.transferMode = '';
        $scope.actions.transferDataPopUp.selectedUser = '';
    };

    $scope.models.containsObject = function (list, obj) {
        var i;
        for (i = 0; i < list.length; i++) {
            if (list[i] === obj) {
                return true;
            }
        }

        return false;
    };

    // TODO: Query
    $scope.query = {};

    $scope.query.getProductFiles3d = function () {
        if ($scope.models.product.details['id']) {
            request.getProductFiles3d($scope.models.product.details['id']).then(function (response) {
                $scope.models.product.files_list = response;
                $scope.render.redraw('product');
            });
        }
    };

    $scope.query.pdfProduct = function () {
        if ($scope.models.product.details['id']) {
            request.getPdf($scope.models.product.details['id'], "all").then(function (response) {
                $scope.models.product.pdf = response;
            });
        }
    };

    $scope.query.pdfGeometry = function () {
        if ($scope.models.geometry.details[0] && $scope.models.geometry.details[0]['id']) {
            request.getPdf($scope.models.geometry.details[0]['id'], "geometry").then(function (response) {
                $scope.models.geometry.pdf = response;
            });
        }
    };

    $scope.query.pdf = function () {
        $scope.query.pdfProduct();
        $scope.query.pdfGeometry();
    };

    $scope.query.pdfFromUrl = function (type) {
        var id = 0;
        if (type == 'geometry') {
            id = $scope.models.geometry.details[0].id;
        } else if (type == 'all') {
            id = $scope.models.product.details.id;
        }

        if ($scope.models.product.pdfUrl) {
            var urls = $scope.models.product.pdfUrl.split(',');

            urls.forEach(function (item) {
                if (item) {
                    request.getFileFromUrl(item, type, id).then(function (response) {
                        if (type == 'geometry') {
                            $scope.query.pdfGeometry();
                        } else {
                            $scope.query.pdfProduct();
                        }
                    });
                }
            });
        }
    };

    $scope.query.fileDragNDrop = function (type) {
        var data = {};
        var id = 0;
        if (type == 'geometry') {
            data.file = $scope.models.geometry.image;
            data.name = $scope.models.geometry.imageFileName;
            id = $scope.models.geometry.details[0].id;
        } else if (type == 'all') {
            data.file = $scope.models.product.image;
            data.name = $scope.models.product.imageFileName;
            id = $scope.models.product.details.id;
        }
        if (data.name) {
            request.getFileDnd(data, type, id).then(function (response) {
                if (type == 'geometry') {
                    $scope.query.pdfGeometry();
                    $scope.models.geometry.image = null;
                    $scope.models.geometry.imageFileName = '';
                } else {
                    $scope.query.pdfProduct();
                    $scope.models.product.image = null;
                    $scope.models.product.imageFileName = '';
                }
            });
        }
    };

    $scope.query.resetProduct = function () {
        var temp_selected = $scope.models.product.selected;

        request.get("all", $scope.userLoadInfo).then(function (response) {

            if (temp_selected[0]) {
                var node = {};
                node.key = temp_selected[0].key;
                node.select = {};
                node.select.value = temp_selected[0].value;

                var sel_id = '';

                if (Array.isArray($scope.models.product.details)) {
                    sel_id = $scope.models.product.details[0].id;
                } else {
                    sel_id = $scope.models.product.details.id;
                }

                $scope.models.product.searchList.forEach(function (item) {
                    if (item.id == sel_id) {
                        $scope.models.privacyUpdate = true;
                    }
                });
            }

            $scope.models.geometry.association = angular.copy(response);
            $scope.models.geometry.analysis = angular.copy(response);

            $scope.models.geometry.reset.association = angular.copy(response);
            $scope.models.geometry.reset.analysis = angular.copy(response);

            if ($scope.models.privacyUpdate) {
                if (temp_selected[0]) {
                    $scope.models.product.selected = temp_selected;

                    $scope.models.buildTabs(node, 'all', function (items, details) {

                        $scope.models.product.pdf = [];
                        $scope.models.product.items = items;
                        $scope.models.product.details = details.data ? details.data[0] : {};
                        $scope.query.pdfProduct();
                        $scope.models.product.getPhotoList();
                        $scope.query.getProductFiles3d();
                        $scope.models.product.getWA();
                        $scope.models.product.association = angular.copy($scope.models.product.reset.association);

                        var selected = [];

                        angular.forEach($scope.models.product.association, function (association) {
                            if ($scope.models.product.details[association.key] != undefined) {
                                angular.forEach(association.data, function (data) {
                                    if (data.value == $scope.models.product.details[association.key]) {
                                        association.select = data;
                                        selected.push({
                                            id: association.select.id,
                                            key: association.key,
                                            value: association.select.value,
                                            last: true
                                        });
                                    }
                                });
                            }
                        });

                        if (selected.length) {
                            $scope.models.product.add = false;
                            request.items(selected, "geometry", $scope.userLoadInfo).then(function (details) {
                                $scope.models.product.associationDetails = details.data;
                                $scope.models.product.associationMembers = details.members;
                                $scope.models.product.associationSections = details.secs;
                                $scope.models.product.associationNodes = details.nodes;

                                $scope.render.redraw('product');
                            });
                        } else {
                            $scope.models.product.associationDetails = [];
                            $scope.models.product.associationSections = [];
                            $scope.models.product.associationNodes = [];
                            $scope.render.redraw('product');
                        }
                    })
                }
            } else {
                $scope.models.product.items = angular.copy(response);

                $scope.models.product.selected = [];
                $scope.models.product.details = [];
                $scope.models.product.pdf = [];
                $scope.models.product.associationDetails = [];
                $scope.models.product.associationSections = [];
                $scope.models.product.associationNodes = [];

                $scope.models.product.dataLoaded = false;
                $scope.render.redraw('product');
            }
        });
    };

    $scope.query.resetGeometry = function () {
        var temp_selected = $scope.models.geometry.selected;

        request.get("geometry", $scope.userLoadInfo).then(function (response) {

            if (temp_selected[0]) {
                var node = {};
                node.key = temp_selected[0].key;
                node.select = {};
                node.select.value = temp_selected[0].value;


                var sel_id = '';

                if (Array.isArray($scope.models.geometry.details)) {
                    sel_id = $scope.models.geometry.details[0] ? $scope.models.geometry.details[0].id : null;
                } else {
                    sel_id = $scope.models.geometry.details.id;
                }

                $scope.models.geometry.searchList.forEach(function (item) {
                    if (item.id == sel_id) {
                        $scope.models.privacyUpdate = true;
                    }
                });
            }

            $scope.models.product.association = angular.copy(response);
            $scope.models.product.association.pop();
            $scope.models.product.reset.association = angular.copy(response);
            $scope.models.product.reset.association.pop();


            if ($scope.models.privacyUpdate) {
                if (temp_selected[0]) {
                    $scope.models.geometry.selected = temp_selected;

                    $scope.models.buildTabs(node, 'geometry', function (items, details) {

                        if (details.data) {

                            $scope.models.geometry.items = items;

                            $scope.models.nodes.add.db_geo_PK = details.data[0].id;
                            $scope.models.secs.add.db_geo_PK = details.data[0].id;
                            $scope.models.geometry.newMaterial.db_geo_PK = details.data[0].id;
                            $scope.models.geometry.db_geo_PK = details.data[0].id;
                            $scope.models.geometry.details = details.data || [];
                            $scope.models.geometry.members = details.members;
                            if ($scope.models.geometry.members) $scope.models.geometry.members.sort($scope.sortByIntId);
                            $scope.models.geometry.nodes = details.nodes;
                            if ($scope.models.geometry.nodes) $scope.models.geometry.nodes.sort($scope.sortByIntId);
                            $scope.models.geometry.nodes_p = details.nodes_p || [];
                            $scope.models.geometry.secs = details.secs;
                            if ($scope.models.geometry.secs) $scope.models.geometry.secs.sort($scope.sortByIntId);
                            $scope.models.geometry.materials = details.materials;
                            if ($scope.models.geometry.materials) $scope.models.geometry.materials.sort($scope.sortByIntId);
                            $scope.models.geometry.connectors = details.connectors || [];
                            if ($scope.models.geometry.connectors) $scope.models.geometry.connectors.sort($scope.sortByIntId);
                            $scope.models.geometry.connections = details.connections || [];
                            if ($scope.models.geometry.connections) $scope.models.geometry.connections.sort($scope.sortByIntId);
                            // $scope.models.geometry.association = angular.copy($scope.models.geometry.reset.association);

                            $scope.models.geometry.nodes_p.forEach(function (parameter) {
                                $scope.models.geometry.changeSection(parameter);
                            });

                            $scope.models.geometry.pdf = [];
                            $scope.models.geometry.list_assoc = [];
                            $scope.models.geometry.list_analysis_eq = [];
                            $scope.models.geometry.list_analysis_lc = [];
                            $scope.models.geometry.list_analysis_dc = [];


                            angular.forEach($scope.models.geometry.secs, function (item) {
                                item.shapeList = angular.copy($scope.models.geometry.shapesList.shapeList);
                                item.size1List = angular.copy($scope.models.geometry.shapesList.size1List);
                                item.size2List = angular.copy($scope.models.geometry.shapesList.size2List);
                            });

                            angular.forEach($scope.models.geometry.materials, function (item) {
                                item.orgList = angular.copy($scope.models.geometry.materialsLists.orgList);
                                item.standardList = angular.copy($scope.models.geometry.materialsLists.standardList);
                                item.gradeList = angular.copy($scope.models.geometry.materialsLists.gradeList);

                                if (item.E) {
                                    var crtValue = parseFloat(item.E);
                                    var crtUnit = $scope.shared_units.find('db_material', 'e');
                                    var unit2be = $scope.units.find('db_geo_mat', 'e');
                                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                                    item.E = value2be;
                                }

                                if (item.Rho) {
                                    var crtValue = parseFloat(item.Rho);
                                    var crtUnit = $scope.shared_units.find('db_material', 'density');
                                    var unit2be = $scope.units.find('db_geo_mat', 'rho');
                                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                                    item.Rho = value2be;

                                }

                                if (item.G) {
                                    var crtValue = parseFloat(item.G);
                                    var crtUnit = $scope.shared_units.find('db_material', 'g');
                                    var unit2be = $scope.units.find('db_geo_mat', 'g');
                                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                                    item.G = value2be;
                                }

                                if (item.fy) {
                                    var crtValue = parseFloat(item.fy);
                                    var crtUnit = $scope.shared_units.find('db_material', 'fy');
                                    var unit2be = $scope.units.find('db_geo_mat', 'fy');
                                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                                    item.fy = value2be;
                                }

                                if (item.fu) {
                                    var crtValue = parseFloat(item.fu);
                                    var crtUnit = $scope.shared_units.find('db_material', 'fu');
                                    var unit2be = $scope.units.find('db_geo_mat', 'fu');
                                    var value2be = unitConversion(crtValue, crtUnit, unit2be);
                                    item.fu = value2be;
                                }
                            });

                            $scope.query.pdfGeometry();
                            $scope.models.geometry.getPhotoList();

                            var product = {};

                            angular.forEach($scope.models.geometry.items, function (item) {
                                if (item.select) {
                                    product[item.key] = item.select.value;
                                }
                            });

                            $scope.models.geometry.getGeometryAssociationsList(function (assoc_list) {

                                request.getGeometryAssociationNew(assoc_list).then(function (response) {

                                    $scope.models.geometry.list_assoc = response;

                                    angular.forEach($scope.models.geometry.list_assoc, function (list) {
                                        list.association = angular.copy($scope.models.geometry.reset.association);

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

                                });

                            });
                            $scope.models.geometry.getAnalysisCombinations();

                            $scope.models.geometry.getAnalysis(function (lc_ids) {

                                request.getAnalysisEqpt(lc_ids).then(function (response_data) {

                                    if (response_data) {

                                        var products_analys = [];

                                        $scope.models.product.list.forEach(function (item) {

                                            response_data.forEach(function (product) {

                                                if (item.id == product.db_pro_PK) {
                                                    var tmp = angular.copy(item);
                                                    tmp.analysis_name = product.name;
                                                    tmp.analysis_notes = product.notes;
                                                    tmp.eqpt_id = product.id;
                                                    tmp.createdOn = product.createdOn;
                                                    products_analys.push(tmp);
                                                }
                                            })
                                        });

                                        $scope.models.geometry.list_analysis_eq = products_analys;
                                        if ($scope.models.geometry.list_analysis_eq) $scope.models.geometry.list_analysis_eq.sort($scope.sortByCreatedDate);

                                        $scope.models.geometry.lc_analysis_active_details_list = [];
                                        $scope.models.geometry.lc_analysis_active_details_reset_list = [];
                                        $scope.models.geometry.list_analys_lc_details.forEach(function (item) {

                                            if (item.analysis_PK == $scope.models.geometry.lc_analysis_active.id) {
                                                $scope.models.geometry.lc_analysis_active_details_list.push(item);
                                                $scope.models.geometry.lc_analysis_active_details_reset_list.push(item);
                                            }
                                        });

                                        angular.forEach($scope.models.geometry.list_analysis_eq, function (list) {
                                            list.association = angular.copy($scope.models.geometry.reset.association);

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

                                    }

                                    $scope.models.geometry.drawWholeGeometry();

                                })
                            });

                        }
                    });
                }
            } else {
                $scope.models.geometry.items = angular.copy(response);

                $scope.models.geometry.selected = [];
                $scope.models.geometry.details = [];
                $scope.models.geometry.list_assoc = [];
                $scope.models.geometry.list_analysis_eq = [];
                $scope.models.geometry.list_analysis_lc = [];
                $scope.models.geometry.list_analysis_dc = [];
                $scope.models.geometry.connectors = [];
                $scope.models.geometry.connections = [];
                $scope.models.geometry.pdf = [];
                $scope.models.geometry.members = [];
                $scope.models.geometry.secs = [];
                $scope.models.geometry.nodes = [];
                $scope.models.geometry.nodes_p = [];
                $scope.models.geometry.materials = [];

                $scope.models.geometry.dataLoaded = false;
                $scope.models.geometry.drawWholeGeometry();
            }
        });
    };

    $scope.query.resetSite = function () {
        // var temp_selected = $scope.models.site.selected;

        $scope.models.site.pattern = [];


        request.getSitesItemList($scope.userLoadInfo, $scope.models.site.pattern).then(function (response) {


            $scope.models.site.items = angular.copy(response.ddls);

            $scope.models.site.selected = [];

            $scope.models.geometry.details = [];
            $scope.models.geometry.list_assoc = [];
            $scope.models.geometry.list_analysis_eq = [];
            $scope.models.geometry.list_analysis_lc = [];
            $scope.models.geometry.list_analysis_dc = [];
            $scope.models.geometry.connectors = [];
            $scope.models.geometry.connections = [];
            $scope.models.geometry.pdf = [];
            $scope.models.geometry.members = [];
            $scope.models.geometry.secs = [];
            $scope.models.geometry.nodes = [];
            $scope.models.geometry.nodes_p = [];
            $scope.models.geometry.materials = [];

            $scope.models.geometry.dataLoaded = false;
            $scope.models.geometry.drawWholeGeometry();


        });
    };

    $scope.query.loadModels = function (type) {
        type = type || '';

        request.getModels(type).then(function (response) {
            $scope.models.geometry.models = response || [];
        });
    };

    $scope.query.loadShapes = function () {
        request.getShapes().then(function (response) {
            $scope.models.geometry.shapes = response || [];
        });
    };

    $scope.query.loadMaterials = function () {
        request.getMaterials().then(function (response) {
            // $scope.models.geometry.materials = response || [];
            request.getMaterialsLists().then(function (material) {
                $scope.models.geometry.materialsLists.orgList = material[0] ? material[0].data : [];
                $scope.models.geometry.materialsLists.standardList = material[1] ? material[1].data : [];
                $scope.models.geometry.materialsLists.gradeList = material[2] ? material[2].data : [];
            });
        });
    };

    $scope.query.loadSizesList = function () {
        request.loadSizesList().then(function (aisc) {
            $scope.models.geometry.shapesList.shapeList = aisc[0] ? aisc[0].data : [];

            $scope.models.geometry.shapesList.shapeList.push({value: "SR"});
            $scope.models.geometry.shapesList.shapeList.push({value: "Plate"});

            $scope.models.geometry.shapesList.size1List = aisc[1] ? aisc[1].data : [];
            $scope.models.geometry.shapesList.size2List = aisc[2] ? aisc[2].data : [];
        });
    };

    $scope.query.loadUnits = function () {
        request.loadUnits().then(function (response) {
            $scope.units.items = response.units;
            $scope.shared_units.items = response.shared_units;
        });
    };

    $scope.query.getProductsList = function () {
        request.getProductsList($scope.userLoadInfo).then(function (response) {
            $scope.models.product.list = response;
            $scope.models.product.formSearchList();
            $scope.models.product.formProductTreeList();
        });
    };

    $scope.query.getGeometriesList = function () {
        request.getGeometriesList($scope.userLoadInfo).then(function (response) {
            $scope.models.geometry.list = response;
            $scope.models.geometry.formSearchList();
            $scope.models.geometry.formGeometriesTreeList();
        })
    };

    $scope.query.getSitesList = function () {
        request.getSitesList($scope.userLoadInfo).then(function (response) {
            $scope.models.site.list = response;
            // $scope.models.site.formSearchList();
            $scope.models.site.formSitesTreeList();
        });
    };

    $scope.query.load = function () {

        //
        $scope.query.getProductsList();
        $scope.query.getGeometriesList();
        $scope.query.getSitesList();
        //


        $scope.query.resetProduct();
        $scope.query.resetGeometry();
        $scope.query.resetSite();
        $scope.query.loadModels();
        $scope.query.loadShapes();
        $scope.query.loadMaterials();
        $scope.query.loadSizesList();
        $scope.query.loadUnits();
    };

    // TODO: Bootstrap
    $scope.query.load();

    // TODO: Webgl
    $scope.render = {};

    $scope.newSkyboxColor = '#ffffff';
    $scope.newTerrainColor = '#ffffff';

    $scope.changeSkyboxColor = function (newSkyboxColor) {
        $scope.viewSettings.skyboxColor = newSkyboxColor;
        webgl.changeViewSettingsWID($scope.viewSettings);
    };

    $scope.changeTerrainColor = function (newTerrainColor) {
        $scope.viewSettings.terrainColor = newTerrainColor;
        webgl.changeViewSettingsWID($scope.viewSettings);
    };

    $scope.setDefaultAngleWID = function () {
        $scope.viewSettings.defaultAngle = true;
        $scope.cameraSettings.position = webgl.changeViewSettingsWID($scope.viewSettings);
        $scope.viewSettings.defaultAngle = false;
    };

    $scope.render.redraw = function (drawMode, equipments) {
        $scope.base.showNodeDistanceInfo = false;
        $scope.base.showAddEqPanel = false;

        if (drawMode === 'equipment') {

            // var newNodes = $scope.models.geometry.rotateAndDeposeNodes($scope.models.geometry.nodes, $scope.models.geometry.TR);

            draw($scope.models.geometry.members, $scope.models.geometry.nodes, $scope.models.geometry.secs, $scope.gridViewSettings.shrink, equipments, $scope.models.geometry.TR, $scope.sectionsInfo);
        } else {
            if ($scope.models.tabs === "all") {
                if ($scope.models.product.details.geometryType === 'single_object') {
                    if ($scope.models.product.details.geometryShapeType === 'FlatPanel') {
                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2, $scope.models.product.details.d3, $scope.models.product.details.d4],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, 'draw', 'flat_panel');
                        $scope.models.product.plotResize($scope.models.product.details.d2, $scope.models.product.details.d3);
                        $scope.models.product.formEpaChart({d1: 0, d2: 0, d3: 0, geometryShapeType: "Cuboid"});

                    } else if ($scope.models.product.details.geometryShapeType === 'Cuboid') {
                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2, $scope.models.product.details.d3],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, 'draw', 'cuboid');
                        $scope.models.product.plotResize($scope.models.product.details.d2, $scope.models.product.details.d3);
                        $scope.models.product.formEpaChart({d1: 0, d2: 0, d3: 0, geometryShapeType: "Cuboid"});

                    } else if ($scope.models.product.details.geometryShapeType === 'Cylinder') {
                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, "draw", "cylinder");
                        $scope.models.product.plotResize($scope.models.product.details.d1, $scope.models.product.details.d2);
                        $scope.models.product.formEpaChart({d1: 0, d2: 0, d3: 0, geometryShapeType: "Cuboid"});

                    } else if ($scope.models.product.details.geometryShapeType === 'Sphere') {
                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, "draw", "sphere");
                        $scope.models.product.plotResize($scope.models.product.details.d1, $scope.models.product.details.d1);
                        $scope.models.product.formEpaChart({d1: 0, d2: 0, d3: 0, geometryShapeType: "Cuboid"});

                    } else if ($scope.models.product.details.geometryShapeType === 'ConicalDishShroud') {

                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2, $scope.models.product.details.d3, $scope.models.product.details.d4],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, "draw", "conical_dish_w_shroud");
                        $scope.models.product.plotResize($scope.models.product.details.d1, $scope.models.product.details.d1);
                        $scope.models.product.formEpaChart({d1: 0, d2: 0, d3: 0, geometryShapeType: "Cuboid"});


                    } else if ($scope.models.product.details.geometryShapeType === 'CylinderDishShroud') {

                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2, $scope.models.product.details.d3, $scope.models.product.details.d4],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }

                        }, "draw", "cylindrical_dish_w_shroud");

                    } else if ($scope.models.product.details.geometryShapeType === 'DishRadom') {

                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2, $scope.models.product.details.d3, $scope.models.product.details.d4],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, "draw", "dish_w_radome");

                    } else if ($scope.models.product.details.geometryShapeType === 'ParabolicGridDish') {

                        webgl.draw({
                            dimensions: [$scope.models.product.details.d1, $scope.models.product.details.d2, $scope.models.product.details.d3, $scope.models.product.details.d4],
                            texture: {
                                type: $scope.models.product.details.texture_type,
                                color: $scope.models.product.details.color,
                                name: $scope.models.product.details.texture
                            },
                            product: {
                                id: $scope.models.product.details.id
                            }
                        }, "draw", "parabolic_grid_dish");

                    }

                } else if ($scope.models.product.details.geometryType === 'structure') {

                    $scope.models.geometry.getSectionsInfo(function (response) {
                        if (response.data) {
                            $scope.sectionsInfo = response.data;
                            $scope.sectionsInfo.forEach(function (item) {
                                $scope.unitConversionProcess(item);
                            });
                        }
                    });

                    draw($scope.models.product.associationMembers, $scope.models.product.associationNodes, $scope.models.product.associationSections, $scope.gridViewSettings.shrink, '', '', '', $scope.sectionsInfo);

                } else if ($scope.models.product.details.geometryType === '3d_files') {

                    webgl.draw({}, 'delete');

                    if ($scope.models.product.files_list) {
                        $scope.models.product.files_list.forEach(function (item) {
                            if (item.show === 'true') {
                                if (item.file.indexOf('.obj') !== -1) {
                                    webgl.draw({
                                        file: item.file,
                                        id: $scope.models.product.details.id
                                    }, "draw", "custom_object");
                                }
                            }
                        });
                    }
                    // draw([],[],[]);
                } else {
                    draw([], [], []);
                }
            } else {
                if (drawMode !== 'product') {
                    // var newNodes = $scope.models.geometry.rotateAndDeposeNodes($scope.models.geometry.nodes, $scope.models.geometry.TR);

                    draw($scope.models.geometry.members, $scope.models.geometry.nodes, $scope.models.geometry.secs, $scope.gridViewSettings.shrink, null, $scope.models.geometry.TR, $scope.sectionsInfo);
                }
            }
        }

        function draw(details, nodes, sections, shrink, equipments, dc, sectionsInfo) {
            var objects = [];

            if (details != false) {
                angular.forEach(details, function (data) {
                    var x = 0;
                    var y = 0;
                    var z = 0;

                    var shape = false;
                    var size1 = false;
                    var size2 = false;

                    var NodeS = null;
                    var NodeE = null;

                    var Nodes = {
                        s: null,
                        e: null
                    };

                    angular.forEach(nodes, function (nodes) {
                        if (data.NodeS == nodes.no) {
                            x = nodes.x;
                            y = nodes.y;
                            z = nodes.z;

                            NodeS = nodes.no;
                            Nodes.s = [nodes.x, nodes.y, nodes.z];
                        }

                        if (data.NodeE == nodes.no) {
                            NodeE = nodes.no;
                            Nodes.e = [nodes.x, nodes.y, nodes.z];
                        }
                    });

                    if (Nodes.s && Nodes.e) {
                        data.Mbr_Lth = Math.pow(Math.pow(Nodes.e[0] - Nodes.s[0], 2) +
                            Math.pow(Nodes.e[1] - Nodes.s[1], 2) +
                            Math.pow(Nodes.e[2] - Nodes.s[2], 2),
                            1 / 2);

                        if (data.Mbr_Lth) {
                            data.Mbr_Lth = data.Mbr_Lth.toFixed(4);
                        }
                    } else {
                        data.Mbr_Lth = data.Mbr_Lth || 5;
                    }

                    angular.forEach(sections, function (secs) {
                        if (data.sec_name == secs.sec_name) {
                            shape = secs.shape;
                            size1 = secs.size1;
                            size2 = secs.size2;
                        }
                    });

                    objects.push({
                        id: data['no'],
                        name: data['Mbr_Name'] || "",
                        shape: shape || false,
                        length: data['Mbr_Lth'] || 5,
                        size1: size1 || false,
                        size2: size2 || false,
                        other: {
                            x1: x || 0,
                            y1: y || 0,
                            z1: z || 0,
                            x2: 0,
                            y2: data['ROT'] || 0,
                            z2: 0,
                            node: Nodes
                        },
                        nodes: {
                            NodeS: NodeS || null,
                            NodeE: NodeE || null
                        }
                    });
                });
            }

            webgl.draw(nodes, "draw", "nodes");

            if ($scope.viewByStatusColor.enabled) {
                angular.forEach(equipments, function (lc) {
                    lc.eq.color = $scope.viewByStatusColor.changeColorForEquipment(lc.lc.status);
                });
            }

            webgl.draw(objects, "draw", "wid_objects", {}, shrink, equipments, dc, sectionsInfo);
        }
    };

    $scope.units = {};

    $scope.units.items = [];

    $scope.units.find = function (table, variable) {
        var unit = null;

        angular.forEach($scope.units.items, function (item) {
            if (item.dbtable == table && item.var == variable) {
                unit = item.unit;
                return false;
            }
        });
        return unit;
    };

    $scope.shared_units = {};

    $scope.shared_units.items = [];

    $scope.shared_units.find = function (table, variable) {
        var unit = null;

        angular.forEach($scope.shared_units.items, function (item) {
            if (item.dbtable == table && item.var == variable) {
                unit = item.unit;
                return false;
            }
        });
        return unit;
    };

    // TODO: Watchers
    $scope.$watch("auth.data.id", function () {

        if($scope.auth.data.id) {

            $scope.auth.getUsersInfo(function (usersInfo) {

                if (usersInfo) {

                    let keys = Object.keys(usersInfo);

                    let list = [];

                    request.getConfig().then(function (response) {

                        let userIds = [];

                        if (response.data) {
                            userIds = response.data.publicUsersID.match(/\d+/g);
                        }

                        $scope.userLoadInfo.userIds = [];

                        keys.forEach(function (key) {
                            if (usersInfo[key]) {

                                if (userIds.indexOf(key) >= 0) {
                                    let check = true;

                                    if (key === "175") {
                                        check = false;
                                    }

                                    if (check) {
                                        $scope.userLoadInfo.userIds.push(key);
                                    }

                                    list.push({
                                        id: key,
                                        check: check,
                                        firstName: usersInfo[key].firstName,
                                        lastName: usersInfo[key].lastName
                                    });
                                }


                            }
                        });

                        $scope.usersList = list;

                        $scope.publicUsersID = [];

                        $scope.usersList.forEach(function (user) {

                            if (user.check) {
                                $scope.publicUsersID.push('' + user.id);
                            }

                        });

                        $scope.query.load();

                    });

                }

            });


        }


    });

    $scope.$watch('viewSettings', function () {
        if ($scope.viewSettings.nodes == false) {
            $scope.viewSettings.nodesName = false;
        }

        if ($scope.viewSettings.wireframe == false) {
            $scope.viewSettings.wireframeName = false;
        }

        webgl.changeViewSettingsWID($scope.viewSettings);
    }, true);

    $scope.$watch('gridViewSettings', function () {
        webgl.changeGridSettings($scope.gridViewSettings);
    }, true);

    $scope.$watch("models.geometry.details", function () {
        if ($scope.webgl.selected.member) {
            $scope.webgl.selected.member = false;
        } else {
            angular.forEach($scope.models.geometry.details, function (details) {
                details.selected = false;
            });
        }
    }, true);

    $scope.$watch("models.product.settings.private", function () {
        $scope.userLoadInfo = {
            shared: false,
            private: false,
            privateId: '',
            userIds: []
        };

        $scope.models.privacyUpdate = false;

        if (this.last) {
            $scope.userLoadInfo.userIds.push($scope.auth.data.id);
            $scope.userLoadInfo.private = true;
            $scope.userLoadInfo.privateId = $scope.auth.data.id;
            // $scope.models.privacyUpdate = true;
        }

        if ($scope.models.product.settings.shared) {
            $scope.publicUsersID.forEach(function (item) {
                if (!$scope.userLoadInfo.userIds.includes(item)) {
                    $scope.userLoadInfo.userIds.push(item);
                }
            });
            $scope.userLoadInfo.shared = true;
        }

        $scope.models.product.formSearchList();
        $scope.models.geometry.formSearchList();

        $scope.query.resetProduct();
        $scope.query.resetGeometry();
        $scope.query.resetSite();
    });

    $scope.$watch("models.product.settings.shared", function () {
        $scope.userLoadInfo = {
            shared: false,
            private: false,
            privateId: '',
            userIds: []
        };

        $scope.models.privacyUpdate = false;

        if (this.last) {
            $scope.publicUsersID.forEach(function (item) {
                $scope.userLoadInfo.userIds.push(item);
            });
            $scope.userLoadInfo.shared = true;
            // $scope.models.privacyUpdate = true;
        }

        if ($scope.models.product.settings.private) {
            if (!$scope.userLoadInfo.userIds.includes($scope.auth.data.id)) {
                $scope.userLoadInfo.userIds.push($scope.auth.data.id);
            }
            $scope.userLoadInfo.private = true;
            $scope.userLoadInfo.privateId = $scope.auth.data.id;
        }

        $scope.models.product.formSearchList();
        $scope.models.geometry.formSearchList();

        $scope.query.resetProduct();
        $scope.query.resetGeometry();
        $scope.query.resetSite();
    });

    // TODO: Input callback
    $window.pdf = function (data) {
        $scope.query.pdf();
    };

    // TODO: Webgl event
    webgl.selected(function (object) {

        if ($scope.models.tabs === "geometry") {
            $scope.webgl.selected.member = true;
            $scope.webgl.selected.node = true;

            $scope.base.showNodeDistanceInfo = false;
            $scope.base.nodeDistanceInfo = [];

            if (object && object.ctrlKey) {
                if (object.type === "node" && $scope.base.showNodeInfo) {

                    angular.forEach($scope.models.geometry.nodes, function (nodes) {
                        if (nodes.no == object.item) {

                            angular.forEach($scope.models.geometry.nodes, function (n) {

                                if (n.selected && n.no !== nodes.no) {

                                    $scope.base.showNodeDistanceInfo = true;

                                    let dx = n.x - nodes.x;
                                    let dy = n.y - nodes.y;
                                    let dz = n.z - nodes.z;

                                    let node = {
                                        name: nodes.node_name,
                                        distance: Math.sqrt(dx * dx + dy * dy + dz * dz).toFixed(2)
                                    };

                                    $scope.base.nodeDistanceInfo.push(node);

                                }

                            });

                        }

                    });

                    return false;

                }
            }

            $scope.base.showAxesHelperForMesh = false;

            $scope.base.selectedMember = null;
            $scope.base.selectedMemberMesh = null;

            $scope.base.selectedMemberNodes = {};

            $scope.base.selectedMemberNodes.NodeS = null;
            $scope.base.selectedMemberNodes.NodeE = null;
            $scope.base.selectedMemberNodes.NodeO = null;


            $scope.base.showNodeInfo = false;
            $scope.base.showMemberInfo = false;
            $scope.base.showAddEqPanel = false;
            $scope.base.memberInfo.showAll = false;
            $scope.base.memberInfo.showFirst = false;
            $scope.base.memberInfo.showSecond = false;
            $scope.base.showAssocInfo = false;

            $scope.base.changeMemberInfoNode = function (id, node) {
                angular.forEach($scope.models.geometry.nodes, function (item) {
                    if(item.no === id) $scope.base.selectedMemberNodes[node] = item;
                });
                $scope.models.geometry.saveMember($scope.base.selectedMember);
            };

            angular.forEach($scope.models.geometry.members, function (member) {
                member.selected = false;
            });

            angular.forEach($scope.models.geometry.secs, function (sec) {
                sec.selected = false;
            });

            angular.forEach($scope.models.geometry.nodes, function (nodes) {
                nodes.selected = false;
            });

            angular.forEach($scope.models.geometry.lc_analysis_active_details_list, function (lc) {
                lc.selected = false;
            });

            if (object) {
                if (object.type === "Mesh") {

                    if (object.parent && object.parent.lc_id) {

                        $scope.base.selectedEqId = '';
                        $scope.base.selectedLcId = '';
                        $scope.base.selectedLc = null;

                        angular.forEach($scope.models.geometry.lc_analysis_active_details_list, function (lc) {
                            if (lc.id == object.parent.lc_id) {
                                lc.selected = true;
                                $scope.base.showAxesHelperForMesh = true;
                            }
                        });

                        angular.forEach($scope.models.geometry.list_analysis_eq, function (eqpt) {

                            if (object.parent.eqpt_id == eqpt.id) {

                                $scope.base.selectedEqId = eqpt.id;
                                $scope.base.showAxesHelperForMesh = true;

                                $scope.base.showAssocInfo = true;
                            }
                        });

                        angular.forEach($scope.models.geometry.activeGeometryLcList, function (lc) {
                            if (object.parent.lc_id == lc.id) {

                                $scope.base.selectedLc = lc;
                                $scope.base.selectedLcId = lc.id;

                                $scope.base.lcInfo.azm = `Azimuth: ${lc.azm} deg;`;
                                $scope.base.lcInfo.rad = ` Rad: ${lc.rad} ft`;

                            }
                        })
                    } else {

                        angular.forEach($scope.models.geometry.members, function (member) {
                            member.selected = member.no === object.item_no;
                            if (member.no === object.item_no) {
                                $scope.base.selectedMemberMesh = object;
                                $scope.base.selectedMember = member;
                                $scope.base.showAxesHelperForMesh = true;
                            }
                            $scope.base.showMemberInfo = true;


                            angular.forEach($scope.models.geometry.secs, function (sec) {
                                if (member.selected && sec.sec_name === member.sec_name) {
                                    $scope.base.memberInfo.sectionInfo = `${sec.shape} - ${sec.size1} - ${sec.size2}`;
                                    sec.selected = true;
                                }
                            });

                            angular.forEach($scope.models.geometry.materials, function(material){
                                if (member.selected && material.name === member.Mat) {
                                    $scope.base.memberInfo.materialInfo = `${material.org} - ${material.standard} - ${material.grade}`;
                                }
                            });
                        });

                        angular.forEach($scope.models.geometry.nodes, function (node) {
                            if (node.no === $scope.base.selectedMember.NodeS) $scope.base.selectedMemberNodes.NodeS = node;
                            else if (node.no === $scope.base.selectedMember.NodeE) $scope.base.selectedMemberNodes.NodeE = node;
                            else if (node.no === $scope.base.selectedMember.NodeO) $scope.base.selectedMemberNodes.NodeO = node;
                        });
                    }

                } else if (object.type === "node") {
                    angular.forEach($scope.models.geometry.nodes, function (selectedNode) {
                        if (selectedNode.no === object.item) {
                            selectedNode.selected = true;
                            $scope.base.showNodeInfo = true;
                            $scope.base.selectedNode = selectedNode;
                        }

                    });
                }
            }

            $scope.$apply();
        }

    });

    webgl.rightClickSelected(function (object, event) {

        if ($scope.models.tabs === "geometry") {

            if (object && object.type === "Mesh" && object.parent && object.parent.type === "member") {

                if ($scope.base.selectedMemberMesh == object) {

                    $scope.base.showAddEqPanel = true;

                    $scope.models.geometry.newObject = {
                        mbr_name: $scope.base.selectedMember.Mbr_Name,
                        dx: 0,
                        dy: 0,
                        dz: 0,
                        rotx: 0,
                        roty: 0,
                        rotz: 0,
                        rad: 0,
                        azm: 0
                    };

                }

            }

        }

    });

    webgl.cameraUpdate(function (position) {

        let x = position.x.toFixed(2);
        let y = position.y.toFixed(2);
        let z = position.z.toFixed(2);

        $scope.cameraSettings.position.x = x;
        $scope.cameraSettings.position.y = y;
        $scope.cameraSettings.position.z = z;

    });

    $scope.uploadFile = function () {
        var file = $scope.myFile;
        var notes = $scope.models.product.file_notes;
        var show = $scope.models.product.file_show;
        var id = $scope.models.product.details.id;

        file.forEach(function (item) {
            request.uploadFileToUrl(item, id, notes, show).then(function (response) {
                $scope.query.getProductFiles3d();
            });
        });

    };
});