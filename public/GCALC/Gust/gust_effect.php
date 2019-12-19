<?php
    // require_once("./../../../../../../../config.php");
    require_once("./../../../../../../../../config.php");
?>

<!DOCTYPE html>
<html ng-app="TIA-WL-APP">
<head>
    <?php include "./../jsCSS-TIA-222.php"; ?>

    <script src="gust_effect.js"></script>

    <?php include "./../loader.php"; ?>

    <a href="#" id="pdf" onclick="return xepOnline.Formatter.Format('iframeId',
        {pageWidth:'216mm', pageHeight:'279mm',namespaces:['xmlns:ng=&quot;http://www.foo.net&quot;']});">
    </a>

    <style>
        body {
            padding: 0 9px 0 11px !important;
        }

        [class*="col-xs"]:not(:empty), input{
            border: 1px solid green;
            border-radius: 5px;
            margin: 1px 0;
        }
        .col-xs-2{
            padding: 1px 3px;
        }
        input, select{
            width: 100%;
        }

    </style>    

</head>
<body>
<!--    <h4 style="padding-left:5px; margin-top: 0;">TIA-222-G Gust Effect</h4>-->
    <div  id="iframeId" style="margin: 0 20px 0 20px; min-height: 116px;" ng-controller="gust_effect_Controller as geCtrlr" debug="<?php echo $accessType?>">

        <div ng-if="calculation.access">
            <div class="row" style="padding: 0 0px 0 0px; font-weight: bold; font-size:20px; clear:both;">
                <div style="background: grey;" class="col-xs-1">Sym.</div>
                <div style="background: grey;" class="col-xs-2">Value</div>
                <div style="background: grey;" class="col-xs-9">Description</div>
            </div>

            <div class="row">
                <div class="col-xs-3" style="">
                    <select style="background-color:#FFF380;" id="str_type_select" class="seclection" ng-options="k as v for (k,v) in calculation.optionlist.str_type" ng-model="calculation.inputData.str_type" ng-change="calculation.change()">
                        <option value=""></option>
                    </select>
                </div>

                <div style="" class="col-xs-9" style="padding: 0 0 0 0;">Structure Type

                <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
                  ng-click="calculation.info(['#structural_type'])"></span>

                    <div class="row" ng-show="calculation.inputData.str_type == 'latticed'">
                        <div style="" class="col-xs-1"><b>h</b></div>
                        <input type="text" style="background-color:#FFF380;" id="h" name="h"   ng-change="calculation.change()" ng-model="calculation.inputData.h" class="col-xs-2">
                        <div style="" class="col-xs-9">{{Notation.h}}</div>
                    </div>

                    <div class="row" ng-show="calculation.inputData.str_type == 'str_sptd_on_other_str'">
                        <div style="" class="col-xs-1">-</div>

                        <div class="col-xs-6" style="">
                            <select style="background-color:#FFF380;" id="str_sptd_on_other_str_select" class="seclection" ng-options="k as v for (k,v) in calculation.optionlist.str_sptd_on_other_str" ng-model="calculation.inputData.str_sptd_on_other_str" ng-change="calculation.change()">
                                <option value=""></option>
                            </select>
                        </div>

                        <div style="" class="col-xs-5">structure supported on other structure.</div>
                    </div>


                    <div class="row">
                        <div style="" class="col-xs-1"><b>G<sub>h</sub></b></div>
                        <input type="text" id="G_h" name="G_h"  disabled="true" ng-change="calculation.change()" ng-model="calculation.inputData.G_h" class="col-xs-2">

                        <div style="" class="col-xs-9">{{Notation.G_h}}</div>
                    </div>

                </div>

            </div>
        </div>


        <div ng-if="!calculation.access">ACCESS DENIED</div>
    </div>
</body>
</html>