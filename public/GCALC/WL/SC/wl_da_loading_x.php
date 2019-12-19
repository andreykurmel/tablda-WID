<div id="loading-tab" class="tab-pane">

        <h4>Design Wind Force (Loading) of All DAs (site depdendent)</h4>


        <div style="" class="col-xs-2">VP <b>q<sub>Z</sub></b> calc.:
            <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#vp', '#pc'])"></span>
        </div>
        <div style="" class="col-xs-3">
<!--            <select ng-model="calculation.inputData.vp_calc" ng-change="" ng-options="">-->
            <select ng-model="calculation.inputData.vp_calc">
                <option value="" ng-repeat="item in equipmentsVpCalcList">{{item.vp_calc}}</option>
                <option value=""></option>
            </select>
        </div>

        <div style="" class="col-xs-2">Ice Thickness:</div>
<!--    <input type="text" class="col-xs-2" id="ice_thk" step="" ng-model="calculation.inputData.ice_thk" name="ice_thk" ng-change="calculation.change()">-->
        <input type="text" class="col-xs-1" id="ice_thk" ng-model="calculation.inputData.ice_thk" name="ice_thk" ng-change="calculation.change()">
 

    <div class="loading-tab-second-table-container" style="margin-top: 0px;">

        <table id="wlda-loading-second-table" class="table table-striped table-bordered">
            <tr>
                <th width="20px" rowspan="2" style="text-align: center;">#</th>
                <th width="60px" rowspan="2" style="text-align: center;">Name</th>

                <th width="50px" style="text-align: center;">Front Azm.</th>

                <th width="50px" style="text-align: center;">Ctr. Elev.</th>

                <!-- th width="50px" style="text-align: center;">Ice Thk</th -->                
                <th width="50px" style="text-align: center;">q<sub>z</sub></th>
                <th width="50px" rowspan="2" style="text-align: center;">G<sub>h</sub></th>
                <th width="50px" rowspan="2" style="text-align: center;">K<sub>a</sub></th>
                <th width="50px" style="text-align: center;">(EPA)<sub>A</sub></th>
                <th width="50px" style="text-align: center;">DWF</th>
                <th width="30px" rowspan="2" style="text-align: center;">Quantity</th>
                <th width="90px" rowspan="2" style="text-align: center;">Action</th>
            </tr>
            <tr>
                <th style="text-align: center;">deg.</th>
                <th style="text-align: center;">in.</th>                
                <!-- th style="text-align: center;">ft</th -->
                <th style="text-align: center;">psf</th>
                <th style="text-align: center;">ft^2</th>
                <th style="text-align: center;">lbf</th>
            </tr>
            <tr ng-repeat="list in equipmentsIdaActiveList track by $index">
                <td style="cursor: pointer; text-decoration: underline;" ng-click="selectList(list)">{{$index + 1}}</td>
                <td><input class="form-control" ng-model="list.name" ng-change="list.change = true;"></td>

                <td><input class="form-control" ng-model="list.frt_azm" ng-change="list.change = true;"></td>

                <td><input class="form-control" ng-model="list.ctr_elev" ng-change="list.change = true;"></td>

                <!-- td><input class="form-control" ng-model="list.ice_thk" ng-change="list.change = true;"></td -->
                <td><input class="form-control" ng-model="list.q_z" ng-change="list.change = true;"></td>
                <td><input class="form-control" ng-model="list.g_h" ng-change="list.change = true;"></td>
                <td><input class="form-control" ng-model="list.k_a" ng-change="list.change = true;"></td>
                <td><input class="form-control" ng-model="list.epa_a" ng-change="list.change = true;"></td>
                <td><input class="form-control" ng-model="list.dwf" ng-change="list.change = true;"></td>
                <td><input class="form-control" ng-model="list.quantity" ng-change="list.change = true;"></td>
                <td class="text-center">
                    <button class="btn btn-sm" ng-class="{'btn-success': list.change}" ng-click="updateList(list)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    <button class="btn btn-sm btn-danger" ng-click="removeList(list)"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
            <tr>
                <td style="cursor: pointer">{{equipmentsIdaActiveList.length + 1}}</td>
                <td>
                    <select ng-options="equipment as equipment.name for equipment in equipmentsActiveList" ng-model="selectedEq" ng-change="prepareListForEquipment(selectedEq)">
<!--                        <option ng-repeat="equipment in equipmentsActiveList" value="{{equipment.db_pro_PK}}" >{{equipment.name}}</option>-->
                    </select>
                </td>

                <td><input class="form-control" ng-model="newList.frt_azm" ></td>

                <td><input class="form-control" ng-model="newList.ctr_elev" ></td>

                <!-- td><input class="form-control" ng-model="newList.ice_thk" ></td -->
                <td><input class="form-control" ng-model="newList.q_z" ></td>
                <td><input class="form-control" ng-model="newList.g_h" ></td>
                <td><input class="form-control" ng-model="newList.k_a" ></td>
                <td><input class="form-control" ng-model="newList.epa_a" ></td>
                <td><input class="form-control" ng-model="newList.dwf" ></td>
                <td><input class="form-control" ng-model="newList.quantity" ></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-success" ng-click="insertList(newList)"><span class="glyphicon glyphicon-plus"></span></button>
                </td>
            </tr>
        </table>
    </div>

    <div ng-show="activeList">

        <h5>Wind Exposure Faces of a DA (not site depdendent)</h5>        
        <table id="wlda-loading-table" class="table table-striped table-bordered" >

            <tr>
                <th width="30px" rowspan="2" style="text-align: center;">#</th>
                <th width="60px" rowspan="2" style="text-align: center;">Name</th>
                <th width="80px" rowspan="2" style="text-align: center;">Face Shape</th>
                <th width="80px" rowspan="2" style="text-align: center;">On/Off</th>
                <th width="70px" rowspan="2" style="text-align: center;">Face Name</th>
                <th width="70px" rowspan="2" style="text-align: center;">View</th>
                <th width="80px" style="text-align: center;">Face Norm Azm.</th>
                <th width="80px" rowspan="2" style="text-align: center;">Face Exposed</th>
                <th width="70px" style="text-align: center;">Projected Area A<sub>A</sub></th>
                <th width="70px" style="text-align: center;">Aspect Ratio</th>
                <th width="70px" style="text-align: center;">Force Coeff. C<sub>a</sub></th>
                <th width="70px" style="text-align: center;">(EPA)<sub>A</sub></th>
                <th width="50px" rowspan="2" style="text-align: center;">Action</th>
            </tr>
            <tr>
                <th width="80px" style="text-align: center;">deg</th>
                <th width="70px" style="text-align: center;">ft^2</th>
                <th width="80px" style="text-align: center;">-</th>
                <th width="70px" style="text-align: center;">-</th>
                <th width="70px" style="text-align: center;">ft^2</th>
            </tr>
            <tr>
                <td>{{$index + 1}}</td>
                <td><input class="form-control" ng-model="activeList.name" ng-change="list.change = true;"></td>
                <td colspan="11" style="padding: 0;">
                    <table class="table table-bordered table-striped loading-inner-table">
                        <tr ng-repeat="row in activeList.faces">
<!--                            <td width="80px" class="loading-inner-table-td"><input class="form-control" ng-model="row.geo_shape_type" ng-change="row.change = true;"></td>-->
                            <td width="80px" class="loading-inner-table-td"><input class="form-control" ng-model="row.face_shape" ng-change="row.change = true;"></td>
                            <td width="80px" class="loading-inner-table-td"><input class="form-control" ng-model="row.inclusion" type="checkbox" ng-true-value="'1'" ng-false-value="'0'" ng-change="row.change = true;" style="height: 15px; width: 15px; margin: auto"></td>
                            <td width="70px" class="loading-inner-table-td"><input class="form-control" ng-model="row.face_name" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="70px" class="loading-inner-table-td"><input class="form-control" ng-model="row.display" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="81px" class="loading-inner-table-td"><input class="form-control" ng-model="row.face_azm" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="81px" class="loading-inner-table-td"><input class="form-control" ng-model="row.exposed" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="71px" class="loading-inner-table-td"><input class="form-control" ng-model="row.p_a" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="81px" class="loading-inner-table-td"><input class="form-control" ng-model="row.aspect_ratio" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="71px" class="loading-inner-table-td"><input class="form-control" ng-model="row.c_a" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="71px" class="loading-inner-table-td"><input class="form-control" ng-model="row.epa_a" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                            <td width="52px" class="loading-inner-table-td" class="text-center">
                                <button class="btn btn-sm" ng-class="{'btn-success': row.change}" ng-click="updateLoading(row)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


        </table>
    </div>

</div>