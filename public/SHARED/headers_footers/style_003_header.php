    <div style="float:left; margin-left: 5px; width: 95px; height: 95px; margin-top: 5px; position: relative;">
        <p class="centeredImage" ng-click="head.modalLogo = true;">
            <img ng-src="{{ model.header_calcs.logo ? '../../../assets/img/userCompanyLogo/' + model.header_calcs.logo : '../../../assets/img/userCompanyLogo/AECOM.png' }}">
        </p>
    </div>

    <div style="float:left; width: calc(100% - 100px); height: 100%; padding: 10px;" class="headerForm">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Client:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showClientEdit">
                        {{model.header_calcs.client}}
                        <a href="javascript:void(0);" class="button" ng-click="showClientEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showClientEdit">
                        <input type="text" ng-model='model.header_calcs.client' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showClientEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Project:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showProjectEdit">
                        {{model.header_calcs.project}}
                        <a href="javascript:void(0);" class="button" ng-click="showProjectEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showProjectEdit">
                        <input type="text" ng-model='model.header_calcs.project' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showProjectEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Designed:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showDesEdit">
                        {{model.header_calcs.designed}}
                        <a href="javascript:void(0);" class="button" ng-click="showDesEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showDesEdit">
                        <input type="text" ng-model='model.header_calcs.designed' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showDesEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Title:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showTitleEdit">
                        {{model.header_calcs.title}}
                        <a href="javascript:void(0);" class="button" ng-click="showTitleEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showTitleEdit">
                        <input type="text" ng-model='model.header_calcs.title' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showTitleEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Prepared By:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showPrepbEdit">
                        {{model.header_calcs.preparedBy}}
                        <a href="javascript:void(0);" class="button" ng-click="showPrepbEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showPrepbEdit">
                        <input type="text" ng-model='model.header_calcs.preparedBy' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showPrepbEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Prepared On:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showPreponEdit">
                        {{model.header_calcs.preparedOn}}
                        <a href="javascript:void(0);" class="button" ng-click="showPreponEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showPreponEdit">
                        <input type="text" ng-model='model.header_calcs.preparedOn' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showPreponEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Checked By:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showCheckedbEdit">
                        {{model.header_calcs.checkedBy}}
                        <a href="javascript:void(0);" class="button" ng-click="showCheckedbEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showCheckedbEdit">
                        <input type="text" ng-model='model.header_calcs.checkedBy' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showCheckedbEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="h_table_label_aecom">Checked On:</div>
                </div>
                <div class="col-md-9">
                    <div class="h_table_cont_aecom" ng-show="!showCheckedonEdit">
                        {{model.header_calcs.checkedOn}}
                        <a href="javascript:void(0);" class="button" ng-click="showCheckedonEdit = true">
                            <img src="images/edit.png" alt="edit" width="20">
                        </a>
                    </div>
                    <div class="h_table_cont_aecom" ng-show="showCheckedonEdit">
                        <input type="text" ng-model='model.header_calcs.checkedOn' ng-change="header.change()">
                        <a href="javascript:void(0);" class="button" ng-click="showCheckedonEdit = false">
                            <img src="images/save.png" alt="save" width="20">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>