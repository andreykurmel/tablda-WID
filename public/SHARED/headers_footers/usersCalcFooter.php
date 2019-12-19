<?php ?>

    <style type="text/css">

        .footerForm .row{
            margin-left: 0;
            margin-right: 0;
            height: 38px;
        }

        .f_table_label {
            display: inline-block;
            height: 38px;
            font-size: 14px;
            text-align: right;
        }

        .f_table_cont {
            display: inline-block;
            width: 75px;
            height: 37px;
            position: relative;
            overflow: hidden;
            padding: 0px 0px 5px 5px;
            font-size: 16px;
            max-width: 270px;
        }

        .f_table_cont input {
            width: 75px;
            height: 20px;
        }

        .align_right {
            text-align: right!important;
        }

        .align_center {
            text-align: center!important;
        }
    </style>

    <div ng-show="!auth.isAuth() && foot.activeFooterLayout != '7'" style="height: 100%; padding: 8px;">
        <div style="text-align:center;">Customizable Calculation Footer (Register and reqeust for customized footers.)(<span style="cursor: pointer; text-decoration: underline;" ng-click="footer.setDefaultFooter();">Use default style</span>)</div>
    </div>

    <div ng-show="auth.isAuth() && foot.checkStyle() && foot.activeFooterLayout != '7'" style="height: 100%; padding: 10px;">
        <div style="text-align:center;"><span style="cursor: pointer; text-decoration: underline;" ng-click="project.current = 'all';">Select</span> footer style for present calculation.(<span style="cursor: pointer; text-decoration: underline;" ng-click="footer.setDefaultFooter();">Use default style</span>)</div>
    </div>   

    <div ng-show="foot.activeFooterLayout == '7'" style="height: 100%;">
        <?php include "style_default_footer.php"; ?>
    </div>             

    <div ng-show="auth.isAuth() && foot.activeFooterLayout == '1'" style="height: 100%;">
        <?php include "style_001_footer.php"; ?>
    </div>

    <div ng-show="auth.isAuth() && foot.activeFooterLayout == '2'" style="height: 100%;">
        <?php include "style_002_footer.php"; ?>
    </div>


