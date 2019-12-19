
    <div style="float:left; width: 200px; height: 100%; font-style: italic; font-size: 10px; border-right: 1px solid black;">

        <p class="centeredImage" style="cursor: pointer; height: 40%; width: 100%" ng-click="head.modalLogo = true;">
            <img style="max-height: 100%; max-width: 100%" ng-src="../../../assets/img/userCompanyLogo/engineering3c.png">

        </p>
        <p class="company_info" ng-bind="model.companyInfo.name" style="font-weight: bold; font-size: 16px; margin-top: 0px;"></p>
        <!-- p class="company_info" ng-bind="model.companyInfo.street" style="margin-bottom: 1px;">Engineering3C, LLC.</p -->
        <p class="company_info" style="margin-bottom: 0px; font-weight: bold;">Engineering3C, LLC.</p>
        <p class="company_info" style="margin-bottom: 0px;">www.engineering3c.com</p>
        <p class="company_info" style="margin-bottom: 0px;">573-639-1820</p>
        <p class="company_info" style="margin-bottom: 0px;">contact@engineering3c.com</p>
    </div>

    <div style="float:left; width: calc(100% - 200px); height: 100%;" class="headerForm">
     
        <div class="col-md-6">
            <div class="row" style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 2px">
                <div class="col-md-12">
                    <div class="h_table_label">Job</div>
                </div>
                <div class="col-md-12">
                    <input class="h_table_cont" ng-change="header.change()" ng-model="model.header_calcs.job">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row" style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 2px">
                <div class="col-md-12">
                    <div class="h_table_label">Page</div>
                </div>
                <div class="col-md-12">
                    <input class="h_table_cont" ng-change="header.change()" ng-model="model.header_calcs.page">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row" style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 2px">
                <div class="col-md-12">
                    <div class="h_table_label">Project</div>
                </div>
                <div class="col-md-12">
                    <input class="h_table_cont" ng-change="header.change()" ng-model="model.header_calcs.project">
                </div>
            </div>
        </div>



        <div class="col-md-6">
            <div class="row" style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 2px">
                <div class="col-md-12">
                    <div class="h_table_label">Date</div>
                </div>
                <div class="col-md-12">
                    <input class="h_table_cont" ng-change="header.change()" ng-model="model.header_calcs.date">
                </div>
            </div>
        </div>        



        <div class="col-md-6">
            <div class="row" style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 2px">
                <div class="col-md-12">
                    <div class="h_table_label">Client</div>
                </div>
                <div class="col-md-12">
                    <input class="h_table_cont" ng-change="header.change()" ng-model="model.header_calcs.client">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row" style="border-bottom: 1px solid black; border-right: 1px solid black; padding: 2px">
                <div class="col-md-12">
                    <div class="h_table_label">Designed By</div>
                </div>
                <div class="col-md-12">
                    <input class="h_table_cont" ng-change="header.change()" ng-model="model.header_calcs.designed">
                </div>
            </div>
        </div>
    </div>
