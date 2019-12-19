        <div style="float:left; width: 100%; height: 100%;" class="footerForm">
            <div class="col-md-4">
                <div class="row" style="padding: 0px 0px 0px 2px; text-align: left;">
                    <!-- div style="padding-top: 6px;" class=" f_table_label"></div -->
                    <input id="footer_input_1" input-index="1" style="border: 0px solid #cccccc; background-color: #f5f5f5;" class="f_table_cont" placeholder="name" ng-change="header.change(); footer.change(1);" ng-model="model.footer_calcs.client">
                </div>
            </div>
            <div class="col-md-4">
                <div class="row align_center" style="padding: 0px 0px 0px 2px; text-align: left;">
                    <!-- div style="padding-top: 6px;" class=" f_table_label"></div -->
                    <input id="footer_input_2" input-index="2" style="border: 0px solid #cccccc; background-color: #f5f5f5;" class="f_table_cont" placeholder="title" ng-change="header.change(); footer.change(2);" ng-model="model.footer_calcs.project">
                </div>
            </div>
            <div class="col-md-4">
                <div class="row align_right" style="padding: 0px 0px 0px 2px; text-align: left;">
                    <!-- div style="padding-top: 6px;" class=" f_table_label">Page:</div -->
                    <input id="footer_input_3" input-index="3" style="border: 0px solid #cccccc; background-color: #f5f5f5;" class="f_table_cont" placeholder="date" ng-change="header.change(); footer.change(3);" ng-model="model.footer_calcs.title">
                </div>
            </div>
        </div>