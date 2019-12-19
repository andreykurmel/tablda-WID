<div id="loading-tab" class="tab-pane">

    <h5>Design Wind Force (Loading) of All DAs (site dependent)</h5>


    <div style="text-align: left; border-style: none; padding: 0;" class="col-xs-4">
        <div style="float:left;">
            <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#vp'])"></span>
            <b>q<sub>z</sub></b> calc.:  
        </div>
        <div style="float:left; min-width: 100px;">
            <select class="loading-vp-select" ng-model="loadingActiveVpCalc" ng-disabled="!parent.auth.isAuth();" ng-change="updatewlda();" ng-model-options="{debounce: 700}">
                <option value=""></option>
                <option ng-repeat="vp in vpCalcList" value="{{vp.RcdNo}}">{{vp.usersname4Calc}}</option>
            </select>
        </div>
    </div>

    <!-- div style="" class="col-xs-3">
        <select ng-model="calculation.inputData.vp_calc">
            <option value="" ng-repeat="item in equipmentsVpCalcList">{{item.vp_calc}}</option>
            <option value=""></option>
        </select>
    </div -->

    <div style="text-align: left; border-style: none;" class="col-xs-4">

        <div style="border-style: none; text-align: right;" class="col-xs-6">

          <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#loading_ice_thk'])"></span>
          <b>t<sub>i</sub></b>, {{Unit.ice_thk}}:
        </div>

        <input type="text" class="col-xs-6" id="ice_thk" ng-model="design_ice_thk" name="ice_thk" ng-disabled="!parent.auth.isAuth();" ng-change="updatewlda();" ng-model-options="{debounce: 700}">

    </div>

    <div style="text-align: left; border-style: none; padding: 0;" class="col-xs-4">

        <div style="border-style: none; text-align: right;" class="col-xs-10">

          <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#wind_dir'])"></span>
          Wind Direction, {{Unit.wind_dir}}:
        </div>

        <input type="text" class="col-xs-2" id="wind_dir" ng-model="wind_dir" name="wind_dir" ng-change="updatewlda();" ng-model-options="{debounce: 700}">

    </div>


    <div class="loading-tab-second-table-container" style="margin-top: 10px;">

            <table id="wlda-loading-second-table" class="table table-striped table-bordered table-for-jack">
                <tr>
                    <th width="20px" rowspan="2" style="text-align: center;">#</th>
                    <th width="60px" rowspan="2" style="text-align: center;" ng-click="calculation.info(['#loading_name'])">Name</th>
                    <th width="60px" rowspan="2" style="text-align: center;">DA ID</th>
                    <th width="80px" rowspan="2" style="text-align: center;" ng-click="calculation.info(['#loading_status'])">Status</th>

                    <th width="30px" style="text-align: center; " ng-click="calculation.info(['#loading_frt_azm'])">Front Azm.</th>

                    <th width="30px" style="text-align: center; " ng-click="calculation.info(['#loading_height'])">z</th>
                    <th width="30px" style="text-align: center; " ng-click="calculation.info(['#loading_ice_thk'])"><b>t<sub>iz</sub></b></th>

                    <!-- th width="50px" style="text-align: center;">Ice Thk</th -->
                    <th width="40px" style="text-align: center;" ng-click="calculation.info(['#loading_q_z'])">q<sub>z</sub></th>
                    <th width="30px" rowspan="2" style="text-align: center; " ng-click="calculation.info(['#loading_g_h'])">G<sub>h</sub></th>
                    <th width="30px" rowspan="2" style="text-align: center; " ng-click="calculation.info(['#loading_k_a'])">K<sub>a</sub></th>
                    <th width="50px" style="text-align: center; " ng-click="calculation.info(['#loading_epa_a'])">(EPA)<sub>A</sub></th>
                    <th width="50px" style="text-align: center;" ng-click="calculation.info(['#loading_dwf'])">DWF</th>
                    <th width="20px" rowspan="2" style="text-align: center;" ng-click="calculation.info(['#loading_quantity'])">Quan -tity</th>
                    <th width="90px" rowspan="2" style="text-align: center;">Action</th>
                </tr>
                <tr>
                    <th style="text-align: center;">{{Unit.frt_azm}}</th>
                    <th style="text-align: center;">{{Unit.ctr_elev}}</th>
                    <th style="text-align: center;">{{Unit.ice_thk}}</th>

                    <!-- th style="text-align: center;">ft</th -->
                    <th style="text-align: center;">{{Unit.q_z}}</th>
                    <th style="text-align: center;">{{Unit.epa_a}}</th>
                    <th style="text-align: center;">{{Unit.dwf}}</th>
                </tr>

                <tr ng-repeat="list in equipmentsIdaActiveList | orderBy: 'createdOn' track by $index">
                    <td style="cursor: pointer; text-decoration: underline;" ng-click="selectList(list)">{{$index + 1}}</td>
                    <td><input class="form-control status-color-{{list.status}}" ng-model="list.name" ng-change="list.change = true;"></td>

                    <td>
                        <select ng-options="equipment.eqpt_id as equipment.name for equipment in equipmentsActiveList" ng-model="list.tia_222_g_wl_da_lib_PK" ng-change="list.change = true;">
                        </select>
                    </td>

                    <td>
                        <select class="form-control optional status-color-{{list.status}}" ng-model="list.status" ng-change="list.change = true;">
                          <option value="existing">Existing</option>
                          <option value="tbrmvd">Tbrmvd</option>
                          <option value="proposed">Proposed</option>
                          <option value="reserved">Reserved</option>
                          <option value="future">Future</option>
                      </select>
                  </td>

                  <td><input class="form-control required" ng-model="list.frt_azm" ng-change="changeListRow(list, 'frt_azm');"></td>

                  <td><input class="form-control required" ng-model="list.ctr_elev" ng-change="changeListRow(list, 'ctr_elev');"></td>

                  <td><input class="form-control optional" ng-model="list.ice_thk" ng-change="changeListRow(list, 'ice_thk');"></td>

                  <!-- td><input class="form-control" ng-model="list.ice_thk" ng-change="list.change = true;"></td -->
                  <td><input class="form-control optional" ng-model="list.q_z" ng-change="changeListRow(list, 'q_z');"></td>
                  <td><input class="form-control optional" ng-model="list.g_h" ng-change="changeListRow(list, 'g_h');"></td>
                  <td><input class="form-control optional" ng-model="list.k_a" ng-change="changeListRow(list, 'k_a');"></td>
                  <td><input class="form-control optional" ng-model="list.epa_a" ng-change="changeListRow(list, 'epa_a');"></td>
                  <td><input class="form-control optional" ng-model="list.dwf" ng-change="changeListRow(list, 'dwf');"></td>
                  <td><input class="form-control required" ng-model="list.quantity" ng-change="list.change = true;"></td>
                  <td class="text-center">
                    <button class="btn btn-sm" ng-class="{'btn-success': list.change}" ng-click="updateList(list)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    <button class="btn btn-sm btn-danger" ng-click="removeList(list)"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>


            <tr>
                <td style="cursor: pointer">{{equipmentsIdaActiveList.length + 1}}</td>
                <td><input class="form-control" ng-model="newList.name"></td>                

                <td>
                    <select ng-options="equipment as equipment.name for equipment in equipmentsActiveList" ng-model="selectedEq">
                        <!--<select ng-options="equipment as equipment.name for equipment in equipmentsActiveList" ng-model="selectedEq" ng-change="">-->

                        <!--<option ng-repeat="equipment in equipmentsActiveList" value="{{equipment.db_pro_PK}}" >{{equipment.name}}</option>-->
                    </select>
                </td>

                <td>
                    <select class="form-control optional" ng-model="newList.status">
                      <option value="existing">Existing</option>
                      <option value="tbrmvd">Tbrmvd</option>
                      <option value="proposed">Proposed</option>                      
                      <option value="reserved">Reserved</option>
                      <option value="future">Future</option>
                  </select>
              </td>                

              <td><input class="form-control required" ng-model="newList.frt_azm" ></td>

              <td><input class="form-control required" ng-model="newList.ctr_elev" ></td>

              <td><input class="form-control optional" ng-model="newList.ice_thk" ></td>

              <!-- td><input class="form-control" ng-model="newList.ice_thk" ></td -->
              <td><input class="form-control optional" ng-model="newList.q_z" ></td>
              <td><input class="form-control optional" ng-model="newList.g_h" ></td>
              <td><input class="form-control optional" ng-model="newList.k_a" ></td>
              <td><input class="form-control optional" ng-model="newList.epa_a" ></td>
              <td><input class="form-control optional" ng-model="newList.dwf" ></td>
              <td><input class="form-control required" ng-model="newList.quantity" value=1></td>
              <td class="text-center">
                <button class="btn btn-sm btn-success" ng-click="prepareListForEquipment(selectedEq, newList)"><span class="glyphicon glyphicon-plus"></span></button>
            </td>
        </tr>
    </table>
</div>

    <div class="loading-total-container">
        <div class="title">
            <div class="total-label">Total</div>
            <div class="dwf-label">DWF</div>
            <div class="epa-label">Epa</div>
        </div>
        <div class="main-container">
            <div class="list-row">
                <div class="list-label">
                    Existing:
                </div>
                <div class="epa-value status-color-existing">
                    {{ loadingTotalValues.existing.epa }}
                </div>
                <div class="dwf-value status-color-existing">
                    {{ loadingTotalValues.existing.dwf }}
                </div>
            </div>
            <div class="list-row">
                <div class="list-label">
                    To be removed:
                </div>
                <div class="epa-value status-color-tbrmvd">
                    {{ loadingTotalValues.tbrmvd.epa }}
                </div>
                <div class="dwf-value status-color-tbrmvd">
                    {{ loadingTotalValues.tbrmvd.dwf }}
                </div>
            </div>
            <div class="list-row">
                <div class="list-label">
                    Proposed:
                </div>
                <div class="epa-value status-color-proposed">
                    {{ loadingTotalValues.proposed.epa }}
                </div>
                <div class="dwf-value status-color-proposed">
                    {{ loadingTotalValues.proposed.dwf }}
                </div>
            </div>
            <div class="list-row">
                <div class="list-label">
                    Reserved:
                </div>
                <div class="epa-value status-color-reserved">
                    {{ loadingTotalValues.reserved.epa }}
                </div>
                <div class="dwf-value status-color-reserved">
                    {{ loadingTotalValues.reserved.dwf }}
                </div>
            </div>
            <div class="list-row">
                <div class="list-label">
                    Future:
                </div>
                <div class="epa-value status-color-future">
                    {{ loadingTotalValues.future.epa }}
                </div>
                <div class="dwf-value status-color-future">
                    {{ loadingTotalValues.future.dwf }}
                </div>
            </div>
        </div>

    </div>

</div>