<?php
$groupswithaccess = "PUBLIC";
//require_once("./../../Sitelok/slpw/sitelokpw.php");
?>

<!DOCTYPE html>
<html ng-app="TP" ng-controller="Base">
    <head>
        <meta charset="utf-8">

        <link type="text/css" rel="stylesheet" href="assets/jquery/css/jquery.layout.css">
        <link type="text/css" rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="assets/bootstrap/css/bootstrap.vertical.tabs.min.css">
        <link type="text/css" rel="stylesheet" href="assets/angular/css/angular-ui-select.min.css">
        <link type="text/css" rel="stylesheet" href="assets/angular/css/angular-csp.css">
        <link type="text/css" rel="stylesheet" href="assets/sitelock/style.css">
        <link type="text/css" rel="stylesheet" href="style/css/style.css">

        <link rel="stylesheet" href="assets/jsPanel3/vendor/jquery-ui-1.12.0-rc.2/jquery-ui.min.css">
        <link rel="stylesheet" href="assets/jsPanel3/source/jquery.jspanel.min.css">
        <link rel="stylesheet" href="assets/angular-tree-control/css/tree-control-attribute.css">
        <link rel="stylesheet" href="assets/angular-tree-control/css/tree-control.css">
        <link rel="stylesheet" href="assets/angular-bootstrap-colorpicker/css/colorpicker.min.css">
        <link rel="stylesheet" href="assets/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css">

        <script src="assets/jquery/jquery.min.js"></script>
        <script src="assets/jquery/jquery.ui.js"></script>
        <script src="assets/jquery/jquery.layout.js"></script>
        <script src="assets/bootstrap/bootstrap.min.js"></script>
        <script src="assets/angular/angular.min.js"></script>
        <script src="assets/angular/angular-animate.min.js"></script>
        <script src="assets/angular/angular-sanitize.min.js"></script>
        <script src="assets/angular/angular-ui-select.min.js"></script>
        <script src="assets/modules/others.js"></script>
        <script src="assets/modules/moment.js"></script>
        <script src="assets/chart.js/src/chart.min.js"></script>

        <script src="SHARED/jsX/3D/lib/threejs/three.js"></script>
        <script src="SHARED/jsX/3D/lib/threejs/Projector.js"></script>
        <script src="SHARED/jsX/3D/lib/threejs/three.combined.camera.js"></script>
        <script src="SHARED/jsX/3D/lib/threejs/controls/OrbitControls.js"></script>
        <script src="SHARED/jsX/3D/lib/threejs/loaders/OBJLoader.js"></script>
        <script src="SHARED/jsX/3D/lib/threejs/loaders/MTLLoader.js"></script>
        <script src="SHARED/jsX/3D/lib/threejs/loaders/TGALoader.js"></script>

        <script src="SHARED/jsX/3D/customized/drawAISCmembers.js"></script>
        <script src="SHARED/jsX/3D/customized/functions4drawMembers.js"></script>
        <script src="SHARED/jsX/3D/customized/setMaterial.js"></script>
        <script src="SHARED/jsX/3D/customized/dictionary.js"></script>
        <script src="SHARED/jsX/3D/customized/arrow.js"></script>

        <script src="assets/angular-strap/dist/angular-strap.min.js"></script>
        <script src="assets/angular-strap/dist/angular-strap.tpl.min.js"></script>

        <script src="assets/jsPanel3/vendor/jquery-ui-1.12.0-rc.2/jquery-ui.min.js"></script>
<!--        <script src="assets/jsPanel3/vendor/jquery.ui.touch-punch.js"></script>-->
        <script src="assets/jsPanel3/source/jquery.jspanel.js"></script>

        <script src="assets/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>

        <script src="assets/angular-tree-control/angular-tree-control.js"></script>
        <script src="assets/angular-bootstrap-colorpicker/js/bootstrap-colorpicker-module.min.js"></script>
        <script src="assets/angular-chart.js/dist/angular-chart.min.js"></script>
        <script src="assets/angular-bootstrap-slider/slider.js"></script>

        <script type="text/javascript" src="SHARED/jsX/3D/customized/skybox.js"></script>
        <script type="text/javascript" src="SHARED/jsX/3D/customized/TerrainPlatter.js"></script>

        <script src="SHARED/jsX/3D/webgl.js"></script>

        <script src="SHARED/jsX/unitConversion.js"></script>
        <script src="SHARED/jsX/fraction2decimal.js"></script>

        <script src="project/app.js"></script>
        <script src="project/services.js"></script>
        <script src="project/controllers.js"></script>
        <script src="project/plugins.js"></script>
        <script src="auth/auth.js"></script>
        <script src="app/iframe_pusher.js"></script>

        <script src="SHARED/headers_footers/header.js"></script>
        <script src="SHARED/headers_footers/footer.js"></script>
        
        <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>

        <script type="text/javascript">
            jQuery.event.props.push('dataTransfer');
        </script>

        <title>Wireless Infrastructure Data - WID</title>
    </head>
    <body ng-controller="Models" ng-init="auth.init();" id="widBody" ng-mouseup="onMouseUp();">

        <div class="loader" ng-show="base.loader">
            <div class="sk-circle">
                <div class="sk-circle1 sk-child"></div>
                <div class="sk-circle2 sk-child"></div>
                <div class="sk-circle3 sk-child"></div>
                <div class="sk-circle4 sk-child"></div>
                <div class="sk-circle5 sk-child"></div>
                <div class="sk-circle6 sk-child"></div>
                <div class="sk-circle7 sk-child"></div>
                <div class="sk-circle8 sk-child"></div>
                <div class="sk-circle9 sk-child"></div>
                <div class="sk-circle10 sk-child"></div>
                <div class="sk-circle11 sk-child"></div>
                <div class="sk-circle12 sk-child"></div>
            </div>
        </div>

        <div class="ui-layout-north" style="overflow: visible; padding: 5px 10px;">
            <?php require_once("partials/models.table.php"); ?>
        </div>
        
        <div class="ui-layout-east" style="overflow: hidden;">

            <div class="logo">
                <img src="style/images/3DView.png" ng-click="setDefaultAngleWID();" height="28" width="28">
            </div>

            <div class="edges-setting-button" ng-click="viewSettings.edges = !viewSettings.edges">EL</div>

            <div id="wid_camera">
                <img src="style/images/camera.png" height="28">
            </div>

            <div id="wid_filter" ng-show="models.tabs == 'geometry'">
                <img src="style/images/filter.png" ng-click="viewByStatusPanel.showPanel = !viewByStatusPanel.showPanel; viewByStatusPanel.changeFilter();" height="28" width="28">
            </div>

            <div id="wid_status_color" ng-show="models.tabs == 'geometry'">
                <img src="style/images/status_color.png" ng-click="viewByStatusColor.switch();" height="28" width="28">
            </div>

            <div class="settings-btn" data-ng-click="base.toggleSettingsMenu = !base.toggleSettingsMenu">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </div>

            <div class="settings-menu" ng-show="base.toggleSettingsMenu">

                <div class="checkbox" style="display: flex;">
                    <span style="float: left; width: 76px;">Grids:</span>&nbsp;
                    <label style="width: 50px"><input type="checkbox" ng-model="viewSettings.planeXY"/> XY</label>&nbsp;
                    <label style="width: 50px"><input type="checkbox" ng-model="viewSettings.planeYZ"/> YZ</label>&nbsp;
                    <label style="width: 50px"><input type="checkbox" ng-model="viewSettings.planeZX"/> ZX</label>&nbsp;
                    <label>
                    <span style="float: left;">Size:</span>
                    <select style="margin-top: -2px; float: left; width: 75px; margin-left: 5px;" class="form-control" ng-model="gridViewSettings.size">
                        <option value="1in"> 1 inch </option>
                        <option value="3in"> 3 inch </option>
                        <option value="6in"> 6 inch </option>
                        <option value="1ft"> 1 ft </option>
                    </select>
                    </label>
                </div> 

                        
                <div class="checkbox">
                    <span style="float: left; width: 80px;">Nodes:</span>
                    <label style="width: 65px;"><input type="checkbox" ng-model="viewSettings.nodes"/> View </label>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.nodesName"/> Name </label>

                    <label style="position: absolute;">
                        <input style="width: 40px; margin-left: 5px; margin-right: 5px; float: left;" class="form-control" type="number" ng-model-options="{ debounce: 1000 }" ng-model="viewSettings.fontSize">
                        <span>px</span> <span>Font size</span>
                    </label>
                </div>

                <div class="checkbox">
                    <span style="float: left; width: 80px;">Wireframe:</span>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.wireframe"/> View </label>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.wireframeName"/> Name </label>
                </div>

                <div class="checkbox">
                    <span style="float: left; width: 80px;">Members:</span>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.members"/> View </label>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.membersName"/> Name </label>

                    <label style="position: absolute;">
                        <input style="width: 40px; margin-left: 5px; margin-right: 5px; float: left;" class="form-control" type="number"  ng-change="shrinkChange()" ng-model-options="{ debounce: 1000 }"  min="0" max="50" ng-model="gridViewSettings.shrink">
                        <span>%</span> <span>Shrink</span>
                    </label>
                </div>

                <div class="checkbox">
                    <span style="float: left; width: 80px;">Objects:</span>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.objects"/> View </label>
                    <label style="width: 65px"><input type="checkbox" ng-model="viewSettings.showLabelsEqpt"/> Name </label>
                </div>
                <div class="row envRow">
                    <div class="environment">

                        <div class="content">
                            <div class="skyboxContainer">
                                <span>Skybox:</span>
                                <select style="float: left; width: 84px; margin-left: 0px;" class="form-control" ng-model="viewSettings.sky_box">
                                    <option value=""></option>
                                    <option value="skyboxColorPicker">Color</option>
                                    <option ng-repeat="option in skyBoxOptions" value="{{option.value}}">{{option.name}}</option>
                                </select>

                                <span class="colorPicker" ng-show="viewSettings.sky_box == 'skyboxColorPicker'">
                                    <label>
                                        <input ng-change="changeSkyboxColor(newSkyboxColor); render.draw();"
                                               ng-model="newSkyboxColor" class="form-control" colorpicker type="text"/>
                                    </label>
                                </span>
                            </div>

                            <div class="terrainContainer">
                                <span>Terrain:</span>
                                <select style="float: left; width: 84px; margin-left: 0px;" class="form-control" ng-model="viewSettings.terrain">
                                    <option value=""></option>
                                    <option value="terrainColorPicker">Color</option>
                                    <option ng-repeat="option in terrainOptions" value="{{option.src}}">{{option.name}}</option>
                                </select>

                                <span class="colorPicker" ng-show="viewSettings.terrain == 'terrainColorPicker'">
                                    <label>
                                        <input ng-change="changeTerrainColor(newTerrainColor); render.draw();"
                                            ng-model="newTerrainColor" class="form-control" colorpicker type="text"/>
                                    </label>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="frameRange">
                        <span style="margin-bottom: 5px;">CS frame size:</span>
                        <input type="range" step="0.5" min="1" max="5"
                               ng-model="viewSettings.frameScale" ng-model-options="{'debounce': 500}">
                    </div>
                </div>

                <div style="font-weight: 400; height: 25px; margin-top: 5px;">

                    <span style="float: left; width: 80px; ">View From:&nbsp;</span>
                    <span style="float: left;">X:</span>
                        <input style="width: 55px; margin-left: 5px; margin-right: 5px; float: left;" class="form-control" type="text" ng-change="cameraSettings.changePosition();" ng-model="cameraSettings.position.x" ng-model-options="{ debounce: 1000 }" min="-20" max="20" step="1">
                    <span style="float: left;">ft &nbsp;&nbsp;</span>

                    <span style="float: left;">Y:</span>
                        <input style="width: 55px; margin-left: 5px; margin-right: 5px; float: left;" class="form-control" type="text" ng-change="cameraSettings.changePosition();" ng-model="cameraSettings.position.y" ng-model-options="{ debounce: 1000 }" min="-20" max="20" step="1">
                    <span style="float: left;">ft &nbsp;&nbsp;</span> 
                    
                    <span style="float: left;">Z:</span>
                        <input style="width: 55px; margin-left: 5px; margin-right: 5px; float: left;" class="form-control" type="text" ng-change="cameraSettings.changePosition();" ng-model="cameraSettings.position.z" ng-model-options="{ debounce: 1000 }" min="-20" max="20" step="1">
                    <span style="float: left;">ft</span>
                
                </div>

            </div>
            <div id="2d" style="display: none;"></div>
            <div id="node-info" class="node-info-panel" ng-show="base.showNodeInfo">
                <table class="nodesTable table table-bordered">
                    <thead>
                        <tr style="vertical-align: middle;">
                            <th colspan="2"  width="100px" style="text-align: center;">Base</th>
                            <th colspan="4"  width="150px" style="text-align: center;">Delta</th>
                        </tr>

                        <tr>
                            <th width="80px" style="text-align: center;">Node</th>
                            <th width="50px" style="text-align: center;">roty</th>
                            <th width="70px" style="text-align: center;">dx</th>
                            <th width="70px" style="text-align: center;">dy</th>
                            <th width="70px" style="text-align: center;">dz</th>
                            <th width="50px" style="text-align: center;">roty</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <select type="text" class="itemInfoInput form-control"
                                    ng-model="base.selectedNode.base_node"
                                    ng-model-options="{debounce: 500}"
                                    ng-change="models.geometry.saveNode(base.selectedNode)"
                                    ng-disabled="!models.geometry.allowEdit">
                                <option value="0"></option>
                                <option ng-repeat="node in models.geometry.nodes"
                                        ng-if="node.no != base.selectedNode.no"
                                        value="{{node.no}}">{{node.node_name}}
                                </option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="itemInfoInput form-control"
                                   ng-model="base.selectedNode.rot_y_n"
                                   ng-model-options="{debounce: 500}"
                                   ng-disabled="!models.geometry.allowEdit">
                        </td>

                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput formula-input form-control"
                                   ng-model="base.selectedNode.x_f"
                                   ng-model-options="{debounce: 500}"
                                   ng-change="models.geometry.saveNode(base.selectedNode)"
                                   ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput formula-input form-control"
                                   ng-model="base.selectedNode.y_f"
                                   ng-model-options="{debounce: 500}"
                                   ng-change="models.geometry.saveNode(base.selectedNode)"
                                   ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput formula-input form-control"
                                   ng-model="base.selectedNode.z_f"
                                   ng-model-options="{debounce: 500}"
                                   ng-change="models.geometry.saveNode(base.selectedNode)"
                                   ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td>
                            <input type="text" class="itemInfoInput form-control"
                                   ng-model="base.selectedNode.rot_y_f"
                                   ng-model-options="{debounce: 500}"
                                   ng-disabled="!models.geometry.allowEdit">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="nodesTable table table-bordered">
                    <thead>
                        <tr style="vertical-align: middle;">
                            <th width="80px" style="vertical-align: middle; text-align: center;">Name</th>
                            <th width="70px" style="text-align: center;">x ({{ units.find('db_geo_node', 'xyz') || 'nf' }})</th>
                            <th width="70px" style="text-align: center;">y ({{ units.find('db_geo_node', 'xyz') || 'nf' }})</th>
                            <th width="70px" style="text-align: center;">z ({{ units.find('db_geo_node', 'xyz') || 'nf' }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="itemInfoInput form-control"
                                       ng-model="base.selectedNode.node_name"
                                       ng-change="models.geometry.saveNode(base.selectedNode)"
                                       ng-disabled="true">
                            </td>
                            <td>
                                <div ng-disabled="true" class="itemInfoInput form-control">{{base.selectedNode.x | number:4}}</div>
                            </td>
                            <td>
                                <div ng-disabled="true" class="itemInfoInput form-control">{{base.selectedNode.y | number:4}}</div>
                            </td>
                            <td>
                                <div ng-disabled="true" class="itemInfoInput form-control">{{base.selectedNode.z | number:4}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="showMemberInfo" ng-show="base.showMemberInfo">
                <div class="MaterialSection">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th width="30%">Name:</th>
                            <td><input class="form-control" type="text"
                                       ng-model="base.selectedMember.Mbr_Name"
                                       ng-change="models.geometry.saveMember(base.selectedMember);"
                                       ng-model-options="{ debounce: 500 }"
                                       ng-disabled="!models.geometry.allowEdit">
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">Material:</th>
                            <td>
                                <select class="form-control" id="selectedMemberMaterial" name="selectedMemberMaterial"
                                        ng-model="base.selectedMember.Mat"
                                        ng-options="data.name as data.name for data in models.geometry.materials"
                                        ng-change="models.geometry.saveMember(base.selectedMember);"
                                        ng-model-options="{ debounce: 500 }"
                                        ng-disabled="!models.geometry.allowEdit">
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">Section:</th>
                            <td><select class="form-control" name="selectedMemberSection" id="selectedMemberSection"
                                        ng-model="base.selectedMember.sec_name"
                                        ng-options="data.sec_name as data.sec_name for data in models.geometry.secs"
                                        ng-change="models.geometry.saveMember(base.selectedMember);"
                                        ng-model-options="{ debounce: 500 }"
                                        ng-disabled="!models.geometry.allowEdit">
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="materialInfo">
                        <p>{{base.memberInfo.materialInfo}}</p>
                        <p>{{base.memberInfo.sectionInfo}}</p>
                    </div>
                </div>
                <div class="nodeSection">
                    <table class="nodesTable table table-bordered">
                        <thead>
                            <th width="30%">Node I:</th>
                            <th width="30%">Node J:</th>
                            <th width="30%">Node K:</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><select class="form-control" name="" id=""
                                            ng-model="base.selectedMember.NodeS"
                                            ng-options="data.no as data.node_name for data in models.geometry.nodes"
                                            ng-change="base.changeMemberInfoNode(base.selectedMember.NodeS, 'NodeS');"
                                            ng-disabled="!models.geometry.allowEdit">
                                    </select>
                                </td>
                                <td><select class="form-control" name="" id=""
                                            ng-model="base.selectedMember.NodeE"
                                            ng-options="data.no as data.node_name for data in models.geometry.nodes"
                                            ng-change="base.changeMemberInfoNode(base.selectedMember.NodeE, 'NodeE');"
                                            ng-disabled="!models.geometry.allowEdit">
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="" id=""
                                            ng-model="base.selectedMember.NodeO"
                                            ng-options="data.no as data.node_name for data in models.geometry.nodes"
                                            ng-change="base.changeMemberInfoNode(base.selectedMember.NodeO, 'NodeO');"
                                            ng-disabled="!models.geometry.allowEdit">
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 160px; margin: 0 5px;" class="table table-bordered">
                        <thead>
                            <th>Rotation:</th>
                            <th>Length:</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input class="form-control" type="text"
                                ng-model="base.selectedMember.ROT"
                                ng-change="models.geometry.saveMember(base.selectedMember);"
                                ng-model-options="{ debounce: 500 }"
                                ng-disabled="!models.geometry.allowEdit">
                            </td>
                            <td>
                                <div class="form-control" disabled>{{base.selectedMember.Mbr_Lth | number:2 }}</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="showAssocInfo" ng-show="base.showAssocInfo">
                <div class="assocPosInfo">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="25%" style="text-align: center;">Member</th>
                                <td width="25%" colspan="2" style="text-align: center;">
                                    <select class="form-control" ng-model="base.selectedLc.mbr_name" ng-change="models.geometry.changeLcInfoOptions();" ng-options="data.Mbr_Name as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                    </select>
                                </td>
                                <th width="25%" style="text-align: center;">Equipment</th>
                                <td width="25%" colspan="2" style="text-align: center;">
                                    <select class="form-control assocSelect" ng-model="base.selectedLc.eqpt_name" ng-change="models.geometry.changeLcInfoOptions();" ng-options="data.analysis_name as data.analysis_name for data in models.geometry.list_analysis_eq" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-top: 10px">
                        <tbody>
                            <tr>
                                <th width="16.66%" style="text-align: center;">dx</th>
                                <th width="16.66%" style="text-align: center;">dy</th>
                                <th width="16.66%" style="text-align: center;">dz</th>
                                <th width="16.66%" style="text-align: center;">rotx</th>
                                <th width="16.66%" style="text-align: center;">roty</th>
                                <th width="16.66%" style="text-align: center;">rotz</th>
                            </tr>
                            <tr>
                                <td><input class="form-control" type="text" ng-model="base.selectedLc.dx"   ng-model-options="{ debounce: 1000 }" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="base.selectedLc.dy"   ng-model-options="{ debounce: 1000 }" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="base.selectedLc.dz"   ng-model-options="{ debounce: 1000 }" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="base.selectedLc.rotx" ng-model-options="{ debounce: 1000 }" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="base.selectedLc.roty" ng-model-options="{ debounce: 1000 }" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="base.selectedLc.rotz" ng-model-options="{ debounce: 1000 }" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>

                </div>
                <div class="assocAddInfo"><p style="margin-right: 45px;">{{base.lcInfo.azm}}</p> <p>{{base.lcInfo.rad}}</p></div>
                <div>
                    <div class="info-title">Owner:</div>
                    <select title="owner" style="width:100px; margin-right: 10px" class="form-control assocSelect" ng-model="base.selectedLc.owner" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit">
                        <option value="none"></option>
                        <option value="att">ATT</option>
                        <option value="verizon">Verizon</option>
                        <option value="sprint">Sprint</option>
                        <option value="tmobile">T-Mobile</option>
                        <option value="cricket">Cricket</option>

                        <option value="other">Other</option>
                    </select>
                    <div class="info-title">Status:</div>
                    <select title="status" style="width:100px;" class="form-control assocSelect" ng-model="base.selectedLc.status" ng-change="models.geometry.changeLcInfoOptions();" ng-disabled="!models.geometry.allowEdit">
                        <option value="Existing">Existing</option>
                        <option value="Proposed">Proposed</option>
                        <option value="Rlctd">Rlctd</option>
                        <option value="Reserved">Reserved</option>
                        <option value="Future">Future</option>
                        <option value="TbRlctd">TbRlctd</option>
                        <option value="TbRmvd">TbRmvd</option>
                    </select>
                </div>
            </div>
            <div class="addEquipmentPanel" ng-show="base.showAddEqPanel">
                <div class="inner-container">
                    <div class="input-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th width="25%" style="text-align: center; vertical-align: middle;">Equipment</th>
                                    <th width="12.5%" style="text-align: center;">dx</th>
                                    <th width="12.5%" style="text-align: center;">dy</th>
                                    <th width="12.5%" style="text-align: center;">dz</th>
                                    <th width="12.5%" style="text-align: center;">rotx</th>
                                    <th width="12.5%" style="text-align: center;">roty</th>
                                    <th width="12.5%" style="text-align: center;">rotz</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" ng-model="models.geometry.newObject.eqpt_name" ng-options="data.analysis_name as data.analysis_name for data in models.geometry.list_analysis_eq" ng-disabled="!models.geometry.allowEdit">
                                            <option value=""></option>
                                        </select>
                                    </td>
                                    <td><input class="form-control" type="text" ng-model="models.geometry.newObject.dx" ng-disabled="!models.geometry.allowEdit"></td>
                                    <td><input class="form-control" type="text" ng-model="models.geometry.newObject.dy" ng-change="models.geometry.calcRad();" ng-disabled="!models.geometry.allowEdit"></td>
                                    <td><input class="form-control" type="text" ng-model="models.geometry.newObject.dz" ng-disabled="!models.geometry.allowEdit"></td>
                                    <td><input class="form-control" type="text" ng-model="models.geometry.newObject.rotx" ng-disabled="!models.geometry.allowEdit"></td>
                                    <td><input class="form-control" type="text" ng-model="models.geometry.newObject.roty" ng-change="models.geometry.calcAzm();" ng-disabled="!models.geometry.allowEdit"></td>
                                    <td><input class="form-control" type="text" ng-model="models.geometry.newObject.rotz" ng-disabled="!models.geometry.allowEdit"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="eq-info-container">
                        <div class="member-name">
                             Member: {{base.selectedMember.Mbr_Name}}
                        </div>
                        <div class="rad-info-container">
                            <div class="rad-title">
                                rad:
                            </div>
                            <div class="rad-value">
                                {{models.geometry.newObject.rad}};
                            </div>
                        </div>
                        <div class="azm-info-container">
                            <div class="azm-title">
                                azm:
                            </div>
                            <div class="azm-value">
                                {{models.geometry.newObject.azm}}
                            </div>
                        </div>
                    </div>
                    <div class="status-info-container">
                        <div class="owner-info-container">
                            <div class="owner-title">
                                Owner:
                            </div>
                            <div class="owner-value">
                                <select class="form-control" ng-model="models.geometry.newObject.owner" ng-disabled="!models.geometry.allowEdit">
                                    <option value="none"></option>
                                    <option value="att">ATT</option>
                                    <option value="verizon">Verizon</option>
                                    <option value="sprint">Sprint</option>
                                    <option value="tmobile">T-Mobile</option>
                                    <option value="cricket">Cricket</option>

                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="status-info-container">
                            <div class="status-title">
                                Status:
                            </div>
                            <div class="status-value">
                                <select class="form-control" ng-model="models.geometry.newObject.status" ng-disabled="!models.geometry.allowEdit">
                                    <option value="Existing">Existing</option>
                                    <option value="Proposed">Proposed</option>
                                    <option value="Rlctd">Rlctd</option>
                                    <option value="Reserved">Reserved</option>
                                    <option value="Future">Future</option>
                                    <option value="TbRlctd">TbRlctd</option>
                                    <option value="TbRmvd">TbRmvd</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="button-container">
                        <button class="btn btn-sm btn-block btn-success" ng-click="models.geometry.addNewObject();" ng-disabled="!models.geometry.allowEdit">Add Object</button>
                    </div>
                </div>
            </div>
            <div id="node-distance-info" class="node-distance-info-panel" ng-show="base.showNodeDistanceInfo">
                <div class="info-row" ng-repeat="node in base.nodeDistanceInfo">
                   to {{node.name}}: {{node.distance}}
                </div>
            </div>
            <div class="viewByStatusPanel" ng-show="viewByStatusPanel.showPanel">
                <label ng-repeat="(key, filter) in viewByStatusPanel.filters" class="filter-enable status-color-{{key}} status-filter">
                    <input type="checkbox" ng-change="viewByStatusPanel.changeFilter();" ng-model="viewByStatusPanel.filters[key]"/>{{key}}
                </label>
            </div>
            <div id="webgl"></div>
            <div id="DOMaxesHelper" ng-show="base.showAxesHelperForMesh"></div>
        </div>
        <div class="ui-layout-center">
            <?php require_once("partials/builder.table.php"); ?>
        </div>
        <div class="modal" ng-show="models.copyPanel">
            <div class="overlay" ng-click="models.copyPanel = false"></div>
            <div class="container" style="height: 200px; width: 400px; padding: 15px; background-color: white;">
                <div class="close" ng-click="models.copyPanel = false">x</div>
                <div style="position: relative; top: 10%;">
                    <div style="padding-left: 10px; padding-right: 5px;">Select destination:</div>
                    <div style="padding: 13px 5px 5px 5px;">
                        <select class="form-control" ng-model="models.copyFolder">
                            <option ng-repeat="project in models.copyFoldersDdl" value="{{project.id}}">{{project.path}}</option>
                        </select>
                    </div>
                    <div style="padding: 5px;"><button class="btn btn-success" ng-click="models.copyProduct();">Copy</button></div>
                </div>
            </div>
        </div>
        <div class="modal" ng-show="head.modalLogo">
            <div class="overlay" ng-click="head.modalLogo = false;"></div>
            <div class="container favorite">
                <div class="modal-logo-close" ng-click="head.modalLogo = false;">x</div>
                <div class="content">
                    <div style="background-color:#eeeeee; font-size: 24px; padding: 5px;">Chose a Logo</div>
                    <div class="row" style="padding: 15px;">
                        <div class="col-sm-12" ng-repeat="company in auth.allCompaniesAccess" style="padding: 10px;">
                            <div class="modal-logo-image-container" ng-click="model.header_calcs.logo = company.logo" ng-dblclick="header.changeLogo(company);" ng-class="{'active-logo' : model.header_calcs.logo == company.logo}">
                                <img class="modal-logo-image" src="assets/img/userCompanyLogo/{{company.logo}}">
                            </div>
                            <input style="position: absolute; top: 41%; margin-left: 65px;" type="radio" ng-model="model.header_calcs.logo" value="{{company.logo}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" ng-show="models.geometry.insertNodeModal">
            <div class="overlay" ng-click="models.geometry.insertNodeModal = false"></div>
            <div class="container" style="height: 300px; width: 450px; padding: 15px; background-color: white;">
                <div class="close" ng-click="models.geometry.insertNodeModal = false">x</div>
                <div style="position: relative; top: 10%;">
                    <div style="padding-left: 10px; padding-right: 5px;">Insert node data:</div>
                    <div style="padding: 13px 5px 5px 5px;">
                        <textarea style="resize: none;" rows="8" placeholder="name x y z" class="form-control" ng-model="models.geometry.insertedNodeData"></textarea>
                    </div>
                    <div style="padding: 5px;"><button class="btn btn-success" ng-click="models.geometry.insertNewNode();">Add</button></div>
                </div>
            </div>
        </div>
        <div class="modal" ng-show="models.geometry.insertMemberModal">
            <div class="overlay" ng-click="models.geometry.insertMemberModal = false"></div>
            <div class="container" style="height: 180px; width: 450px; padding: 15px; background-color: white;">
                <div class="close" ng-click="models.geometry.insertMemberModal = false">x</div>
                <div style="position: relative; top: 10%;">
                    <div style="padding-left: 10px; padding-right: 5px;">Insert member data:</div>
                    <div style="padding: 13px 5px 5px 5px;">
                        <input type="text" placeholder="name ns ne" class="form-control" ng-model="models.geometry.insertedMemberData">
                    </div>
                    <div style="padding: 5px;"><button class="btn btn-success" ng-click="models.geometry.insertNewMember();">Add</button></div>
                </div>
            </div>
        </div>
        <div id="draggable_clone" class="draggable-node">
            {{draggedName}}
        </div>
        <div style="width: 100vw;height: 100vh; position: fixed; pointer-events: none;" class="border" id="leftDiv" ng-show="models.product.panel == true" >
            <div id="hcontent" style="height: 95%;">
                <?php include_once "partials/popUp_DRMPanel.php"; ?>
            </div>
            <div floating-panel title="Left" parent-tag="leftDiv" html-tag="hcontent" show="models.product.panel == true"></div>
        </div>

        <div style="width: 100vw;height: 100vh; position: fixed; pointer-events: none;" class="border" id="leftDiv1" ng-show="models.geometry.analysis_panel == true" >
            <div id="hcontent1" style="height: 100%; overflow: hidden;">
                <?php include_once "partials/lcDetailsPanel.php"; ?>
            </div>
            <div floating-panel-details title="Left" parent-tag="leftDiv1" html-tag="hcontent1" show="models.geometry.analysis_panel == true"></div>
        </div>
        <script src="assets/screenshotMaker/screenshotMaker.js"></script>
    </body>
</html>