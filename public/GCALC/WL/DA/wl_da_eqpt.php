<div id="an-equipments" class="tab-pane">
    <!-- div style="padding: 10px; width:840px;" -->
        <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue; position: absolute; right: 5px; top: 5px;" ng-click="calculation.info(['#simplified_input'])"></span>
        <div style="display: flex; align-items: center">
            <h5 style="width: 500px; margin-top: 0; margin-right: 20px;">Select and add all equipment models, a local DA lib, for present calculation use.</h5>
            <div class="input-group" style="width: 30%; margin-bottom: 10px;">
                <span class="input-group-addon glyphicon glyphicon-search" style="font-size: 11px; top: 0;" id="basic-addon2"></span>
                <input type="text" class="form-control" ng-model="selectedProduct" bs-options="item.value for item in searchList" bs-on-select="addingNewEntryFromSearch" data-min-length="2" placeholder="Search by name of product..." bs-typeahead>
            </div>
        </div>
        <div class="copy-tab-button-container" ng-click="copyEquipmentTab();">
            <span class="glyphicon glyphicon-duplicate"></span>
        </div>

        <div class="access-settings-panel">
            <div class="public-access-container">
                <div class="access-button">
                    <span class="glyphicon glyphicon-cog" ng-click="showPublicAccessPanel = !showPublicAccessPanel;"></span>
                </div>
                <div class="global-navigation-menu" ng-show="showPublicAccessPanel">
                    <div class="user-row" ng-repeat="user in usersList">
                        <div class="checkbox-container">
                            <input type="checkbox" ng-model="user.check" ng-change="publicAccess();" ng-model-options="{debounce: 600}">
                        </div>
                        <div class="user-name">
                            {{ user.firstName }}  {{ user.lastName }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="access-settings-container">
                <div class="public-container">
                    <input type="checkbox" title="Shared" name="shared" ng-model="public_access.shared" ng-change="publicAccess();">
                    <img src="img/shared2.jpg" alt="Shared" height="15" >
                </div>
                <div class="private-container">
                    <input type="checkbox" title="Private" name="private" ng-model="public_access.private" ng-change="publicAccess();" ng-disabled="!parent.auth.isAuth()">
                    <img src="img/private2.jpg" alt="Private" height="15" >
                </div>
            </div>
        </div>

        <table id="wlda-equip-table" class="table table-striped table-bordered table-for-jack" style="margin: 0;">
            
            <tr>
                <th width="30px" style="text-align: center;">#</th>
                <th width="50px" style="text-align: center;">ID</th>
                <th width="100px" style="text-align: center;">Type</th>
                <th width="100px" style="text-align: center;">Sub Type</th>
                <th width="100px" style="text-align: center;">Shape</th>
                <th width="120px" style="text-align: center;">Manufacturer</th>
                <th width="180px" style="text-align: center;">Model</th>
                <th width="70px" style="text-align: center;">Notes</th>
                <th width="90px" style="text-align: center;">Action</th>
            </tr>

            <tr ng-repeat="list in equipmentsActiveList track by $index">
                <td style="cursor: pointer;" ng-click="showDimPanel(list);">{{$index + 1}}</td>
                <td><input class="form-control required" ng-model="list.name" ng-change="list.change = true;"></td>
                <td ng-repeat="item in list.association track by $index">
                    <select class="form-control" ng-model="item.select" ng-change="changeAddEquipment(item, $parent.$index, list); list.change = true;" ng-options="data.value for data in item.data">
                        <option value=""></option>
                    </select>
                </td>
                <td><input class="form-control" ng-model="list.notes" ng-change="list.change = true;"></td>
                <td class="text-center">
                    <button class="btn btn-sm" ng-class="{'btn-success': list.change}" ng-click="updateEquipment(list)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    <button class="btn btn-danger btn-sm" ng-click="removeEquipment($index, list.eqpt_id)"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                </td>
            </tr>

            <tr>
                <td>{{equipmentsActiveList.length + 1}}</td>
                <td><input type="text" class="form-control required" ng-model="newEquipment.name"></td>
                <td ng-repeat="item in equipmentsList track by $index">
                    <select class="form-control" ng-model="item.select" ng-change="changeAddEquipment(item)" ng-options="data.value for data in item.data">
                        <option value=""></option>
                    </select>
                </td>
                <td><input type="text" class="form-control" ng-model="newEquipment.notes"></td>
                <td class="text-center">
                    <button class="btn btn-success btn-sm" ng-click="addEquipment();"><span class="glyphicon glyphicon-plus" ></span></button>
                </td>
            </tr>

        </table>

        <div class="equipment-dimensions-modal" ng-show="showDimModal">
            <!--div class="close-button" ng-click="showDimModal = false;">x</div-->
            <table class="table table-striped table-bordered dim-table" style="margin: 0;">
                <tr>
                    <th style="width: 60px">D1</th>
                    <th style="width: 60px">D2</th>
                    <th style="width: 60px">D3</th>
                    <th style="width: 60px">D4</th>
                    <th style="width: 60px">D5</th>
                    <th colspan ="2" style="width: 300px">Weight _ mounting kit</th>

                </tr>

                <tr>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].d1.exp}}</td>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].d2.exp}}</td>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].d3.exp}}</td>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].d4.exp}}</td>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].d5.exp}}</td>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].w.exp}}</td>
                    <td>{{singleObjectsConfig[selectedEqDim.geometryShapeType].wo.exp}}</td>
                </tr>

                <tr>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].d1.units]}}</td>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].d2.units]}}</td>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].d3.units]}}</td>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].d4.units]}}</td>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].d5.units]}}</td>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].w.units]}}</td>
                    <td>{{Unit[singleObjectsConfig[selectedEqDim.geometryShapeType].wo.units]}}</td>
                </tr>

                <tr>
                    <td><div class="dim-value">{{selectedEqDim.d1}}</div></td>
                    <td><div class="dim-value">{{selectedEqDim.d2}}</div></td>
                    <td><div class="dim-value">{{selectedEqDim.d3}}</div></td>
                    <td><div class="dim-value">{{selectedEqDim.d4}}</div></td>
                    <td><div class="dim-value">{{selectedEqDim.d5}}</div></td>
                    <td><div class="dim-value">{{selectedEqDim.weight_w_mkit}}</div></td>
                    <td><div class="dim-value">{{selectedEqDim.weight_wo_mkit}}</div></td>
                </tr>
            </table>
        </div>
    <!-- /div -->
</div>