<div id="faces-tab" class="tab-pane">

    <div ng-show="activeList">

        <h5 class="titleFaces">Wind Exposure Faces of a SC (not site depdendent)</h5>
        <button class="btn btn-sm btn-saveAll" ng-class="{}" ng-click="initializeLoadingFace()">Initialize</button>
      
        <table id="wlda-loading-table-faces" class="table table-striped table-bordered table-for-jack" >

            <tr>
                <th width="30px" rowspan="2" style="text-align: center;">#</th>
                <th width="80px" rowspan="2" style="text-align: center;">Name</th>
                <th width="100px" rowspan="2" style="text-align: center;">Face Shape</th>
                <th width="30px" rowspan="2" style="text-align: center;">On / Off</th>
                <th width="70px" rowspan="2" style="text-align: center;">Face Name</th>
                <!-- th width="70px" rowspan="2" style="text-align: center;">View</th -->
                <th width="80px" style="text-align: center;">Face Norm Azm.</th>
                <th width="70px" rowspan="2" style="text-align: center;">Face Exposed</th>
                <th width="70px" style="text-align: center;">Projected Area A<sub>A</sub></th>
                <th width="50px" rowspan="2" style="text-align: center;">Aspect Ratio</th>
                <th width="50px" rowspan="2" style="text-align: center;">Force Coeff. C<sub>a</sub></th>
                <th width="50px" style="text-align: center;">(EPA)<sub>A</sub></th>
                <th width="90px" rowspan="2" style="text-align: center;">Action</th>
            </tr>
            <tr>
                <th width="" style="text-align: center;">deg.</th>
                <th width="" style="text-align: center;">ft^2</th>
                <th width="" style="text-align: center;">ft^2</th>
            </tr>
            <tr>
                <td rowspan="{{activeList.faces.length + 1}}"><!--{{$index + 1}}--></td>
                <td rowspan="{{activeList.faces.length + 1}}" ><input class="form-control" ng-model="activeList.name" ng-change="list.change = true;" ></td>
            </tr>

            <tr ng-repeat="row in activeList.faces">
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.face_shape" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.inclusion" type="checkbox" ng-true-value="'1'" ng-false-value="'0'" ng-change="row.change = true;" style="height: 15px; width: 15px; margin: auto"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.face_name" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.face_azm" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.exposed" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.p_a" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.aspect_ratio" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.c_a" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td"><input class="form-control" ng-model="row.epa_a" ng-readonly="row.display == 'false'" ng-change="row.change = true;"></td>
                <td width="" class="loading-inner-table-td" class="text-center" style="min-width: 80px;">
                    <button class="btn btn-sm" ng-class="{'btn-success': row.change}" ng-click="updateLoadingFace(row)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    <button class="btn btn-danger btn-sm"                             ng-click="removeLoadingFace(row)"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                </td>
            </tr>


        </table>
    </div>

</div>