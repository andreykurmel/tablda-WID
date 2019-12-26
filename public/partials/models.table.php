<div class="container-fluid">
    <div class="row">
        <div class="col-sm-1" style="width: 4%; padding-top: 10px;">
            <div class="drmp-panel-icon-container" ng-disabled="!auth.isAuth()" title="Manage Your Private Data">
                <img src="style/images/popuppanel.png" alt="Shared" ng-click="models.openPanelPopUp();">
            </div>
            <div class="copy-buttons-icons-container">
                <div class="copy-data-button-container" title="Copy Current Data Record to Your Private Data" ng-disabled="!auth.isAuth()" ng-click="models.copyProductPopUp();">
                    <img src="assets/img/copy.png">
                </div>
                <div class="link-data-button-container" title="Create link for current data record" ng-disabled="!auth.isAuth()" ng-click="models.createLink();">
                    <img src="style/images/link.svg">
                </div>
            </div>
        </div>

        <div class="col-sm-6" style="padding-top: 10px;">

            <div class="tab-content">

                <div id="product" class="tab-pane">
                    <table class="table table-bordered" style="margin: 0;">
                        <tr>
                            <th ng-repeat="item in models.product.items track by $index" ng-style="{ width: item.size }">{{ item.name }}</th>
                        </tr>
                        <tr>
                            <td ng-repeat="item in models.product.items track by $index">
                                <div style="height: 25px; overflow: hidden;">
                                    <select class="form-control" ng-click="models.selectChange();" ng-model="item.select" ng-options="data.value for data in item.data" ng-change="models.product.changeItem(item)">
                                        <option value=""></option>
                                    </select>
<!--                                    <input type="text" class="form-control" ng-model="models.product.details[item.key]" ng-keyup="models.product.changeNew($event)" ng-show="item.select.id == 'new'">-->
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="geometry" class="tab-pane active">
                    <table class="table table-bordered" style="margin: 0;">
                        <tr>
                            <th ng-repeat="item in models.geometry.items track by $index" ng-style="{ width: item.size }" ng-if="item.name != 'App'">{{ item.name }}</th>
                        </tr>
                        <tr>
                            <td ng-repeat="item in models.geometry.items track by $index" ng-if="item.name != 'App'">
                                <div style="height: 25px; overflow: hidden;">
                                    <select class="form-control" ng-click="models.selectChange();" ng-model="item.select" ng-options="data.value for data in item.data" ng-change="models.geometry.changeItem(item)" ng-hide="item.select.id == 'new'">
                                        <option value=""></option>
                                    </select>
<!--                                    <input type="text" class="form-control" ng-model="item.select.value" ng-keyup="models.geometry.changeNew($event)" ng-show="item.select.id == 'new'">-->
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="analysis" class="tab-pane">
                    Under construction...
                </div>

                <div id="site" class="tab-pane">
                    <table class="table table-bordered" style="margin: 0;">
                        <tr>
                            <th ng-repeat="item in models.site.items track by $index" ng-style="{ width: item.size }" ng-if="item.name != 'App'">{{ item.name }}</th>
                        </tr>
                        <tr>
                            <td ng-repeat="item in models.site.items track by $index" ng-if="item.name != 'App'">
                                <div style="height: 25px; overflow: hidden;">
                                    <select class="form-control" ng-click="models.selectChange();" ng-model="item.select" ng-options="data.value for data in item.data" ng-change="models.site.changeItem(item)">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>

        </div>

        <div class="col-sm-1" style="padding-left: 5px;">
            <ul class="nav nav-tabs tabs-right" style="padding-top: 0;" id="panelTabs">
                <li id="product-tab">
                    <a href="javascript:void(0)" style="overflow: hidden; padding: 0 4px; font-size: 12px;" data-target="#product" data-toggle="tab" ng-class="{'selected_tab': models.tabs == 'all' }" ng-click="models.changeTabs('all')">Equipment</a>
                </li>
                <li id="geometry-tab" class="active">
                    <a href="javascript:void(0)" style="overflow: hidden; padding: 0 4px; font-size: 12px;" data-target="#geometry" data-toggle="tab" ng-class="{'selected_tab': models.tabs == 'geometry' }"  ng-click="models.changeTabs('geometry')">Geometry</a>
                </li>
                <li id="analysis-tab">
                    <a href="javascript:void(0)" style="overflow: hidden; padding: 0 4px; font-size: 12px;" data-target="#analysis" data-toggle="tab" ng-class="{'selected_tab': models.tabs == 'analysis' }"  ng-click="models.changeTabs('analysis')">Analysis</a>
                </li>
                <li id="site-tab">
                    <a href="javascript:void(0)" style="overflow: hidden; padding: 0 4px; font-size: 12px;" data-target="#site" data-toggle="tab" ng-class="{'selected_tab': models.tabs == 'site' }"  ng-click="models.changeTabs('site')">Site</a>
                </li>
            </ul>
        </div>

        <!-- div class="col-sm-3" ng-if="base.auth.isAuth()" -->
        <div class="col-sm-4" style="padding-top: 5px; margin-left: 5%;">
            <ul class="nav nav-tabs tabs-left vaa" style="float: left; max-width: 110px;">
                <li><a style="cursor: pointer;" ng-class="{'selected_tab': models.right_tabs == 'intro' }" ng-click="models.right_tabs = 'intro'" data-toggle="tab" data-target="#intro">Intro</a></li>
                <li class="active"><a style="cursor: pointer;" ng-class="{'selected_tab': models.right_tabs == 'search' }" ng-click="models.right_tabs = 'search'" data-toggle="tab" data-target="#settings">Search</a></li>
            </ul>
            <div class="tab-content" style="float: left; margin-left: 15px; width: 100%; max-width: 75%;">
                <div id="intro" class="tab-pane fade" style="width: 95%; font-size: 12px;">
                    <p><b>Engineering Data</b> for all wireless infrastructure products you need for cell site and tower development - equipments, mounts, and many others.</p>
                </div>
                <div id="settings" class="tab-pane fade in active">
                    <div class="category-include" style="height: 70px;">
                        <div class="public-access-container">
                            <div class="access-button">
                                <span class="glyphicon glyphicon-cog" ng-click="showPublicAccessPanel = !showPublicAccessPanel;"></span>
                            </div>
                            <div class="global-navigation-menu" ng-show="showPublicAccessPanel">
                                <div class="user-row" ng-repeat="user in usersList">
                                    <div class="checkbox-container">
                                        <input type="checkbox" ng-model="user.check" ng-change="publicAccess();" ng-model-options="{debounce: 700}">
                                    </div>
                                    <div class="user-name">
                                       {{ user.firstName }}  {{ user.lastName }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="width: calc(80% - 40px); text-align: center; float: left;">
                            <input class="" type="checkbox" name="shared" ng-model="models.product.settings.shared">
                            <img style="margin-bottom: 10px;" src="style/images/shared2.jpg" alt="Shared" height="15" >

                            <input style="margin-left: 30%;" type="checkbox" name="private" ng-model="models.product.settings.private" ng-disabled="!auth.isAuth()">
                            <img style="margin-bottom: 10px;" src="style/images/private2.jpg" alt="Shared" height="15" >
                        </div>
                        <div class="input-group" style="width: 100%; top: 15px;" ng-show="models.tabs == 'all'">
                            <span class="input-group-addon glyphicon glyphicon-search" style="font-size: 11px; top: 0;" id="basic-addon1"></span>
                            <input type="text" class="form-control" ng-model="selectedProduct" bs-options="state.value for state in models.product.searchList" bs-on-select="models.product.searchInputChange" data-min-length="2" placeholder="Search..." bs-typeahead>
                        </div>

                        <div class="input-group" style="width: 100%; top: 15px;" ng-show="models.tabs == 'geometry'">
                            <span class="input-group-addon glyphicon glyphicon-search" style="font-size: 11px; top: 0;" id="basic-addon2"></span>
                            <input type="text" class="form-control" ng-model="selectedGeometry" bs-options="state.value for state in models.geometry.searchList" bs-on-select="models.geometry.searchInputChange" data-min-length="2" placeholder="Search..." bs-typeahead>
                        </div>
                    </div>
                </div>
                <div class="global-navigation-container">
                    <div class="navigation-button" ng-click="showGlobalNavigationPanel = ! !showGlobalNavigationPanel;">
                        <span class="glyphicon glyphicon-globe"></span>
                    </div>
                    <div class="global-navigation-menu" ng-show="showGlobalNavigationPanel">
                        <div class="navigation-list-container">
                            <div class="navigation-item">
                                <div class="nav-icon">
                                    <a href="<?php echo SUB_DIR ?>/general/calcs">
                                        <span class="glyphicon glyphicon-cog"></span>
                                    </a>
                                </div>
                                <div class="navigation-label">
                                    Calculations
                                </div>
                            </div>
                            <div class="navigation-item">
                                <div class="nav-icon">
                                    <a href="<?php echo SUB_DIR ?>/speciality/WID">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </a>
                                </div>
                                <div class="navigation-label">
                                    WID
                                </div>
                            </div>
                            <div class="navigation-item">
                                <div class="nav-icon">
                                    <a href="<?php echo SUB_DIR ?>/speciality/Constructor">
                                        <span class="glyphicon glyphicon-wrench"></span>
                                    </a>
                                </div>
                                <div class="navigation-label">
                                    Constructor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
