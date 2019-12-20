<div class="close" style="position: absolute; right: 15px; top: -37px; opacity: 1; font-weight: normal; font-size: 24px;" ng-click="models.geometry.analysis_panel = false">x</div>
<div style="padding: 10px; height: 100%;">
    <ul class="nav nav-tabs" id="analysisTabs">
        <li class="item"><a href="javascript:void(0)" ng-click="models.analysis_tabs = 'ac'"  ng-class="{'selected_tab': models.analysis_tabs == 'ac' }" data-target="#an-dc" data-toggle="tab">Design Configuration</a></li>
        <li class="item"><a href="javascript:void(0)" ng-click="models.analysis_tabs = 'equipments'" ng-class="{'selected_tab': models.analysis_tabs == 'equipments' }" data-target="#an-equipments" data-toggle="tab">Equipments</a></li>
        <li class="item active"><a href="javascript:void(0)" ng-click="models.analysis_tabs = 'lc'"  ng-class="{'selected_tab': models.analysis_tabs == 'lc' }" data-target="#an-lc" data-toggle="tab">Loading Configurations</a></li>
        <li class="item"><a href="javascript:void(0)" ng-click="models.analysis_tabs = 'lc_sum'"  ng-class="{'selected_tab': models.analysis_tabs == 'lc_sum' }" data-target="#an-lc_sum" data-toggle="tab">Loading Summary</a></li> 
        <li class="item"><a href="javascript:void(0)" ng-click="models.analysis_tabs = 'reporting'"  ng-class="{'selected_tab': models.analysis_tabs == 'reporting' }" data-target="#an-reporting" data-toggle="tab">Reporting</a></li>    
    </ul>
    <div class="tab-content" style="height: calc(100% - 40px);">
        <div id="an-equipments" class="tab-pane" style="height: 100%;">
            <div style="padding: 10px; width:100%; height: 100%;">
                <div style="display: flex; align-items: center">
                    <h4 style="margin-top: 0; margin-right: 20px;">Loading Equipment
                        <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue; position: absolute; cursor: pointer; right: 5px; top: 5px;" ng-click="showInfo(['#analysis_eq'], 'details_panel')"></span>
                    </h4>
                    <div class="input-group" style="width: 30%; margin-bottom: 10px;">
                        <span class="input-group-addon glyphicon glyphicon-search" style="font-size: 11px; top: 0;" id="basic-addon2"></span>
                        <input type="text" class="form-control" ng-model="selectedProduct" bs-options="state.value for state in models.product.searchList" bs-on-select="models.product.addingNewEntryFromSearch" data-min-length="2" placeholder="Search by name of product..." bs-typeahead>
                    </div>
                </div>
                <table class="table table-bordered" style="margin: 0;">
                    <thead>
                    <tr>
                        <th width="3%" style="text-align: center;">#</th>
                        <th width="12%" style="text-align: center;">Name</th>
                        <th width="12%" style="text-align: center;">Type</th>
                        <th width="12%" style="text-align: center;">Sub Type</th>
                        <th width="12%" style="text-align: center;">Shape</th>
                        <th width="12%" style="text-align: center;">Manufacturer</th>
                        <th width="12%" style="text-align: center;">Model</th>
                        <th width="12%" style="text-align: center;">Notes</th>
                        <th width="12%" style="text-align: center;">Action</th>
                    </tr>
                    </thead>
                </table>
                <div style="height: calc(100% - 40px); overflow-y: scroll;">
                    <table class="table table-bordered" style="margin: 0;">
                    <tr ng-repeat="list in models.geometry.list_analysis_eq track by $index">
                        <td width="3%">{{$index + 1}}</td>
                        <td width="12%"><input class="form-control" ng-model="list.analysis_name" ng-change="list.change = true;" ng-disabled="!models.geometry.allowEdit"></td>
                        <td width="12.39%" ng-repeat="item in list.association track by $index">
                            <select class="form-control" ng-model="item.select" ng-change="models.geometry.changeAnalysis(item, $parent.$index, list); list.change = true;" ng-options="data.value for data in item.data" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td width="12%"><input class="form-control" ng-model="list.analysis_notes" ng-change="list.change = true;" ng-disabled="!models.geometry.allowEdit"></td>
                        <td width="12%" class="text-center">
                            <button class="btn btn-sm" ng-class="{'btn-success': list.change}" ng-click="models.geometry.saveAnalysisEqpt(list)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeAnalysisEqpt($index, list)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>{{models.geometry.list_analysis_eq.length + 1}}</td>
                        <td><input type="text" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.analysis_name"></td>
                        <td ng-repeat="item in models.geometry.analysis track by $index">
                            <select class="form-control" ng-model="item.select" ng-change="models.geometry.changeAnalysis(item)" ng-options="data.value for data in item.data" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.analysis_notes"></td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm" ng-click="models.geometry.addAnalysisEqpt()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus" ></span></button>
                        </td>
                    </tr>
                </table>
                </div>

            </div>
        </div>

        <div id="an-lc" class="tab-pane active" style="height: 100%;">
            <div class="container popup" style="width: 100%; height: 100%;">
                <div class="content" style="padding-top: 5px; height: 100%;">
                    <div>
                        <div class="lc-title">
                            Loading Configuration (LC) Name:
                        </div>
                        <input type="text" title="lc name" class="lc-title-input form-control" ng-change="models.geometry.active_lc.change = true;" ng-model="models.geometry.active_lc.lc_name"/>
                        <div class="edit-container">
                            <button class="btn btn-sm" ng-class="{'btn-success': models.geometry.active_lc.change}" ng-click="models.geometry.updateAnalysisLcParent();" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeAnalysisLcParent();" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </div>
                        <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue; position: absolute; cursor: pointer; right: 5px; top: 5px;" ng-click="showInfo(['#analysis_lc'], 'details_panel')"></span>
                        <div class="copyDDL">
                            <select name="lcForCopy" id="lcForCopy" ng-model="models.geometry.lcForCopy" ng-disabled="!models.geometry.allowEdit">
                                <option  ng-repeat="lc in models.geometry.activeGeometryLcParentList" ng-value="lc.id" ng-hide="lc.id == models.geometry.active_lc.id">{{lc.lc_name}}</option>
                            </select>
                            <button class="btn btn-xs btn-primary" ng-click="models.geometry.copyAnalysisLcDetails(models.geometry.lcForCopy);" ng-disabled="!models.geometry.allowEdit">Copy LC</button>
                        </div>

                        <div class="filtering">
                            <input type="checkbox" style="display: none" id="color_by_status" ng-model="detailsFilter.enabled"/>

                            <label for="color_by_status" ng-class="detailsFilter.enabled ? 'detailsFilterEnabled' : 'detailsFilterDisabled'"><span class="glyphicon glyphicon-tags"></span></label>


                            <div class="detailsFilter" ng-if="detailsFilter.enabled">

                                <input type="checkbox" style="margin-left: 5px;" id="filtersViewAll" ng-model="detailsFilter.viewAll" ng-change="detailsFilter.changeViewAll();"/>

                                <label for="filtersViewAll" style="font-size: 16px; font-weight: 600; width: 40px;">ALL</label>

                                <div ng-repeat="(key, value) in detailsFilter.filters" class="filter-enable status-color-{{key}} status-filter">
                                    <input type="checkbox" id="{{ key }}" ng-change="detailsFilter.changeFilter(key);" ng-model="detailsFilter.filters[key]"/>
                                    <label style="margin-bottom: 2px; line-height: 20px;" for="{{ key }}">{{ key }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered" style="margin: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th rowspan="3" width="3%" style="text-align: center; vertical-align: middle;">#</th>
                            <th rowspan="3" width="12%" style="text-align: center; vertical-align: middle;">Member</th>
                            <th colspan="7" style="text-align: center;">Attachments
                                <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue; cursor: pointer;" ng-click="showInfo(['#analysis_attachments'], 'details_panel')"></span>
                            </th>
                            <th rowspan="2" width="4%" style="text-align: center; vertical-align: middle;">RAD</th>
                            <th rowspan="2" width="4%" style="text-align: center; vertical-align: middle;">Azimuth</th>
                            <th rowspan="3" width="8%"
                                ng-click="sortArrayByField(models.geometry.lc_analysis_active_details_list, 'status');"
                                style="text-align: center; vertical-align: middle;">
                                <span class="tableSortDirection" ng-class="sortDirections['status'] === 'asc' ? 'desc' : 'asc'"></span>

                                Status</th>
                            <th rowspan="3" width="8%" style="text-align: center; vertical-align: middle;">Owner</th>
                            <th rowspan="3" width="8%" style="text-align: center; vertical-align: middle;">Sys. \ Tech. </th>
                            <th rowspan="3" width="8%" style="text-align: center; vertical-align: middle;">Notes</th>
                            <th rowspan="3" width="9%" style="text-align: center; vertical-align: middle;">Action</th>
                        </tr>
                        <tr>
                            <th rowspan="2" width="12%" style="text-align: center; vertical-align: middle;">Equipment</th>
                            <th width="4%" style="text-align: center;">dx</th>
                            <th width="4%" style="text-align: center;">dy</th>
                            <th width="4%" style="text-align: center;">dz</th>
                            <th width="4%" style="text-align: center;">rotx</th>
                            <th width="4%" style="text-align: center;">roty</th>
                            <th width="4%" style="text-align: center;">rotz</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: center;">ft</th>
                            <th colspan="3" style="text-align: center;">degs</th>
                            <th colspan="1" style="text-align: center;">ft</th>
                            <th colspan="1" style="text-align: center;">degs</th>
                        </tr>
                        </thead>
                    </table>
                    <div style="height: calc(100% - 150px); overflow-y: scroll;">
                        <table class="table table-bordered" style="margin: 0; width: 100%;">

                            <tr ng-repeat="lc in models.geometry.lc_analysis_active_details_list track by $index" ng-class="{ 'highlight': lc.selected, 'filter-enable': detailsFilter.enabled }" class="status-color-{{lc.status}}">
                                <td width="3%">{{$index + 1}}</td>
                                <td width="12%">
                                    <select class="form-control" ng-change="lc.change = true" ng-model="lc.mbr_name" ng-options="data.Mbr_Name as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                    </select>
                                </td>
                                <td width="12%">
                                    <select class="form-control" ng-change="lc.change = true" ng-model="lc.eqpt_name" ng-options="data.analysis_name as data.analysis_name for data in models.geometry.list_analysis_eq" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                    </select>
                                </td>
                                <td width="4%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.dx" ng-disabled="!models.geometry.allowEdit"></td>
                                <td width="4%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.dy" ng-disabled="!models.geometry.allowEdit"></td>
                                <td width="4%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.dz" ng-disabled="!models.geometry.allowEdit"></td>
                                <td width="4%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.rotx" ng-disabled="!models.geometry.allowEdit"></td>
                                <td width="4%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.roty" ng-disabled="!models.geometry.allowEdit"></td>
                                <td width="4%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.rotz" ng-disabled="!models.geometry.allowEdit"></td>
                                
                                <td width="4%"><div class="form-control">{{ lc.rad = (+models.geometry.active_dc.dy) + (+lc.dy) | number:2}}</div></td>
                                <td width="4%"><div class="form-control">{{ lc.azm = lc.has_azm == "1" ? (+models.geometry.active_dc.roty) + (+lc.roty) : "-"}}</div></td>

                                <td width="8%">
                                    <select class="form-control" ng-change="lc.change = true" ng-model="lc.status" ng-disabled="!models.geometry.allowEdit">
                                        <option value="Existing">Existing</option>
                                        <option value="Proposed">Proposed</option>
                                        <option value="Rlctd">Rlctd</option>
                                        <option value="Reserved">Reserved</option>
                                        <option value="Future">Future</option>
                                        <option value="TbRlctd">TbRlctd</option>
                                        <option value="TbRmvd">TbRmvd</option>
                                    </select>
                                </td>
                                <td width="8%">
                                    <select class="form-control" ng-change="lc.change = true" ng-model="lc.owner" ng-disabled="!models.geometry.allowEdit">
                                        <option value="none"></option>                                        
                                        <option value="att">ATT</option>
                                        <option value="verizon">Verizon</option>
                                        <option value="sprint">Sprint</option>
                                        <option value="tmobile">T-Mobile</option>
                                        <option value="cricket">Cricket</option>  

                                        <option value="other">Other</option>                                                                                                                                                                
                                    </select>
                                </td>
                                <td width="8%">
                                    <select class="form-control" ng-change="lc.change = true" ng-model="lc.systech" ng-disabled="!models.geometry.allowEdit">
                                        <option value="none"></option>                                        
                                        <option value="lte">LTE</option>
                                        <option value="2">Option2</option>
                                        <option value="1">Option1</option>
                                        <option value="2">Option2</option>                                        
                                    </select>
                                </td>
                                <td width="8%"><input class="form-control" ng-change="lc.change = true" type="text" ng-model="lc.notes" ng-disabled="!models.geometry.allowEdit"></td>
                                <td width="7.5%" class="text-center">
                                    <button class="btn btn-sm" ng-class="{'btn-success': lc.change}" ng-click="models.geometry.saveAnalysisLcDetails(lc)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                    <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeAnalysisLcDetails($index, lc.id)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                                </td>
                            </tr>
                            <tr>
                                <td>{{models.geometry.lc_analysis_active_details_list.length + 1}}</td>
                                <td>
                                    <select class="form-control" ng-model="models.geometry.new_analys_lc_details.mbr_name" ng-options="data.Mbr_Name as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" ng-model="models.geometry.new_analys_lc_details.eqpt_name" ng-options="data.analysis_name as data.analysis_name for data in models.geometry.list_analysis_eq" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.dx" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.dy" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.dz" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.rotx" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.roty" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.rotz" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.rad" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.azm" ng-disabled="!models.geometry.allowEdit"></td>                                
                                <td>
                                    <select class="form-control" ng-model="models.geometry.new_analys_lc_details.status" ng-disabled="!models.geometry.allowEdit">
                                        <option value="Existing">Existing</option>
                                        <option value="Proposed">Proposed</option>
                                        <option value="Rlctd">Rlctd</option>
                                        <option value="Reserved">Reserved</option>
                                        <option value="Future">Future</option>
                                        <option value="TbRlctd">TbRlctd</option>
                                        <option value="TbRmvd">TbRmvd</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" ng-model="models.geometry.new_analys_lc_details.owner" ng-disabled="!models.geometry.allowEdit">
                                        <option value="1">Owner1</option>
                                        <option value="2">Owner2</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" ng-model="models.geometry.new_analys_lc_details.systech" ng-disabled="!models.geometry.allowEdit">
                                        <option value="1">Option1</option>
                                        <option value="2">Option2</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" ng-model="models.geometry.new_analys_lc_details.notes" ng-disabled="!models.geometry.allowEdit"></td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-sm" ng-click="models.geometry.addAnalysisLcDetails('standard')" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus" ></span></button>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div id="an-lc_sum" class="tab-pane" style="height: 100%;">  
        </div>              

        <div id="an-dc" class="tab-pane" style="height: 100%;">
            <div style="padding: 5px; width: 800px; position: relative; display: inherit;">
                <!-- div class="col-md-12" -->
                <div class="col-md-12">
                    <div class="lc-title">
                        Design Configuration (DC) Name:
                    </div>
                    <input type="text" title="dc name" class="lc-title-input form-control" ng-change="models.geometry.active_dc.change = true;" ng-model="models.geometry.active_dc.dc_name"/>
                    <div class="edit-container">
                        <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeAnalysisDC();" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                    </div>
                    <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue; cursor: pointer; position: absolute; right: 5px; top: 5px;" ng-click="showInfo(['#analysis_dc'], 'details_panel')"></span>
                </div>
                    <!-- div class="col-md-2" style="padding: 10px;">
                        <button class="btn btn-sm" ng-class="{'btn-success': models.geometry.active_dc.change}" ng-click="models.geometry.updateAnalysisDc(models.geometry.active_dc)" ng-disabled="!models.geometry.allowEdit">Save</button>
                    </div -->
                <!-- /div -->
                <div class="col-md-12">
                    <label style="text-align: right; width: 100px; margin-top: 23px; padding-left: 0; padding-right: 0;" class="col-sm-4">Global Offsets:</label>
                    <div style="padding-left: 15px; text-align: center;" class="col-sm-2">
                        <label style="margin-bottom: 0;">DX</label>
                        <div class="inputForOffsets">
                            <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.dx" ng-disabled="!models.geometry.allowEdit || models.geometry.active_dc.dx_chk=='false'">
                            <input type="checkbox" ng-change="models.geometry.active_dc.change = true" ng-model="models.geometry.active_dc.dx_chk" ng-true-value="'true'" ng-false-value="'false'">
                        </div>
                    </div>
                    <div style="padding-left: 15px;  text-align: center;" class="col-sm-2">
                        <label style="margin-bottom: 0;">DY</label>
                        <div class="inputForOffsets">
                            <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.dy" ng-disabled="!models.geometry.allowEdit || models.geometry.active_dc.dy_chk=='false'">
                            <input type="checkbox" ng-change="models.geometry.active_dc.change = true" ng-model="models.geometry.active_dc.dy_chk" ng-true-value="'true'" ng-false-value="'false'">
                        </div>
                    </div>
                    <div style="padding-left: 15px;  text-align: center;" class="col-sm-2">
                        <label style="margin-bottom: 0;">DZ</label>
                        <div class="inputForOffsets">
                            <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.dz" ng-disabled="!models.geometry.allowEdit || models.geometry.active_dc.dz_chk=='false'">
                            <input type="checkbox" ng-change="models.geometry.active_dc.change = true" ng-model="models.geometry.active_dc.dz_chk" ng-true-value="'true'" ng-false-value="'false'">
                        </div>
                    </div>
                    <div style="padding-left: 5px; text-align: start;" class="col-sm-2">
                        <label style="margin-top: 25px;">{{ units.find('db_geo_mbr', 'length') || 'nf' }}</label>
                    </div>
                </div>
                <div style="margin-top: 5px;" class="col-md-12">
                    <label style="text-align: right; width: 100px; margin-top: 23px; padding-left: 0; padding-right: 0;" class="col-sm-4">Global Rotations:</label>
                    <div style="padding-left: 15px; text-align: center;" class="col-sm-2">
                        <label style="margin-bottom: 0;">ROTX</label>
                        <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.rotx" ng-disabled="!models.geometry.allowEdit" >
                    </div>
                    <div style="padding-left: 15px;  text-align: center;" class="col-sm-2">
                        <label style="margin-bottom: 0;">ROTY</label>
                        <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.roty" ng-disabled="!models.geometry.allowEdit">
                    </div>
                    <div style="padding-left: 15px;  text-align: center;" class="col-sm-2">
                        <label style="margin-bottom: 0;">ROTZ</label>
                        <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.rotz" ng-disabled="!models.geometry.allowEdit">
                    </div>
                    <div style="padding-left: 5px; text-align: start;" class="col-sm-2">
                        <label style="margin-top: 25px;">{{ units.find('db_geo_mbr', 'rot') || 'nf' }}</label>
                    </div>
                </div>
                <div style="margin-top: 5px;" class="col-md-12">
                    <label style="text-align: right; width: 100px; padding-left: 0; padding-right: 0;" class="col-sm-4">Code:</label>
                    <div  class="col-sm-6">
                        <select class="form-control" ng-change="models.geometry.active_dc.change = true" ng-model="models.geometry.active_dc.code" ng-disabled="!models.geometry.allowEdit">
                            <option value="">ASCE 7-05</option>
                            <option value="">ANSI/TIA-222-G</option>
                            <option value="">EIA/TIA-222-F</option>
                        </select>
                    </div>
                </div>
                <div style="margin-top: 5px;" class="col-md-12">
                    <label style="text-align: right; width: 100px; padding-left: 0; padding-right: 0;" class="col-sm-4">Wind Pressure:</label>
                    <div  class="col-sm-6">
                        <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.wind_pressure" ng-disabled="!models.geometry.allowEdit">
                    </div>
                    <div style="padding-left: 5px; text-align: start;" class="col-sm-2">
                        <label style="margin-top: 3px;">{{ units.find('db_geo_mat', 'rho') || 'nf' }}</label>
                    </div>
                </div>

                <div style="margin-top: 5px;" class="col-md-12">
                    <label style="text-align: right; width: 100px; padding-left: 0; padding-right: 0;" class="col-sm-4">Wind Directions:</label>
                    <div class="col-sm-6">
                        <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.wind_dir" ng-disabled="!models.geometry.allowEdit">
                    </div>
                    <div style="padding-left: 5px; text-align: start;" class="col-sm-4">
                        <label style="margin-top: 3px;"> deg. (e.g., 0:30:210, 240, 300, 360)</label>
                    </div>
                </div>

                <div style="margin-top: 5px;" class="col-md-12">
                    <label style="text-align: right; width: 100px; padding-left: 0; padding-right: 0;" class="col-sm-4">Notes:</label>
                    <div  class="col-sm-6">
                        <input class="form-control" ng-change="models.geometry.active_dc.change = true" type="text" ng-model="models.geometry.active_dc.notes" ng-disabled="!models.geometry.allowEdit">
                    </div>
                </div>

                <div style="margin-top: 5px;" class="col-md-12">
                    <div class="col-md-6" style="padding: 10px;">
                        <button class="btn btn-sm" ng-class="{'btn-success': models.geometry.active_dc.change}" ng-click="models.geometry.updateAnalysisDc(models.geometry.active_dc)" ng-disabled="!models.geometry.allowEdit">Save</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="an-reporting" class="tab-pane" style="height: 100%;">
            <div style="width: 760px; height: 700px;">
                <div class="report-header col-md-12">
                    <div style="margin-left: -15px;">
                        <span>Header:</span>
                        <select ng-model="head.activeHeadLayout">
                            <option value="0"></option>
                            <option ng-repeat="headOption in head.headerCombs" value="{{headOption.id}}">{{headOption.name}}</option>
                        </select>
                    </div>
                    <div class="inner-header row" ng-include="'SHARED/headers_footers/usersCalcHead.php'"></div>
                </div>
                <div class="report-footer col-md-12">
                    <div style="margin-left: -15px;">
                        <span>Footer:</span>
                        <select ng-model="foot.activeFooterLayout">
                            <option value="0"></option>
                            <option ng-repeat="footOption in foot.footerCombs" value="{{footOption.id}}">{{footOption.name}}</option>
                        </select>
                    </div>
                    <div class="inner-footer row" ng-include="'SHARED/headers_footers/usersCalcFooter.php'"></div>
                </div>
                <div style="margin-top: 5px; margin-left: -15px;" class="col-md-12">
                    <div class="col-md-6" style="padding: 10px;">
                        <button class="btn btn-sm" ng-class="{'btn-success': models.geometry.report_changed}" ng-click="models.geometry.updateAnalysisReport()" ng-disabled="!models.geometry.allowEdit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="info-panel" ng-show="infoPanelDetailsPanel">
        <div bind-html-compile="infoResolveDetailsPanel"></div>
        <div style="position: absolute; right: 5px; top: 5px; cursor: pointer;" ng-click="infoPanelDetailsPanel = false;">X</div>
    </div>
</div>


