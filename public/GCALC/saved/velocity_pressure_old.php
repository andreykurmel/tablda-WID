<!DOCTYPE html>
<html ng-app="TIA-WL-APP">
<head>
    <link rel="stylesheet" href="../TIA-222.css">

    <!-- <script src="./../../../assets/angular/angular.min.js"></script>-->

    <?php include "../jsCSS-TIA-222.php"; ?>
    <script src="velocity_pressure.js"></script>

    <!-- script src="./../../../api/css-to-pdf-master/js/xepOnline.jqPlugin.js"></script>

    <script type="text/javascript" src="./../../../assets/jspdf.min.js"></script>
    <script src="./../../../assets/jquery/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-touch.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-animate.js"></script>
    <script src="https://ui-grid.info/docs/grunt-scripts/csv.js"></script>
    <script src="https://ui-grid.info/docs/grunt-scripts/pdfmake.js"></script>
    <script src="https://ui-grid.info/docs/grunt-scripts/vfs_fonts.js"></script>
    <script src="https://ui-grid.info/release/ui-grid.js"></script>
    <link rel="stylesheet" href="https://ui-grid.info/release/ui-grid.css" type="text/css" -->

    <a href="#" id="pdf" onclick="return xepOnline.Formatter.Format('iframeId',
        {pageWidth:'216mm', pageHeight:'279mm',namespaces:['xmlns:ng=&quot;http://www.foo.net&quot;']});">
</a>
    <style>
        input, select, .as-input{
            font-size: 13px;
            background-color: #FFF380;
        }
    </style>
</head>

<body>
<div id="iframeId" style="display:table;width:100%; z-index=1;margin:auto;" ng-controller="vpController as vpCtrlr">

    <div style="padding: 0 5px 0 5px; font-weight: bold; font-size:20px; clear:both;">
        <div style="background: grey;" class="symbol">Sym.</div>
        <div style="background: grey;" class="value">Value</div>
        <div style="background: grey;" class="description">Description</div>
    </div>

    <div class="row">
        <div style="" class="symbol">-<span ng-class="calculation.isPdf"> ={{calculation.inputData.expCAT}}</span></div>
        <div class="value">
            <span ng-class="calculation.isPdf"> = {{calculation.inputData.expCAT}}</span>
            <select style="background-color:#FFF380; width:95%;" 
                id="exposureCat" 
                class="seclection" 
                ng-options="item for item in calculation.optionlist.expCAT" 
                ng-change="calculation.change()"
                ng-model="calculation.inputData.expCAT">
                <option value=""></option>
            </select>
        </div>
        <div style="" class="description" style="padding: 0 0 0 0;"><b>Exposure Category</b>

            <div id="table2-4" ng-show="calculation.inputData.expCAT">

                <div class="row">

                    <div style="" class="symbol"><b>z<sub>g</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.z_g}}</span>
                    </div>
                    <input type="text" step="10" id="z_g" name="z_g" ng-model="calculation.inputData.z_g"  class="value" disabled="true">

                    <div style="" class="description">{{Unit.z_g}}, {{Notation.z_g}}</div>
                </div>

                <div class="row">
                    <div style="" class="symbol">&#945;<span ng-class="calculation.isPdf"> ={{calculation.inputData.alpha}}</span>
                    </div>
                    <input type="text" id="alpha" ng-model="calculation.inputData.alpha" name="alpha" class="value"
                           disabled="true">

                    <div style="" class="description">{{Notation.alpha}}</div>
                </div>

                <div class="row">

                    <div style="" class="symbol"><b>K<sub>zmin</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.K_zmin}}</span>
                    </div>
                    <input type="text" id="K_zmin" step="0.1" ng-model="calculation.inputData.K_zmin" name="K_zmin"
                           class="value" disabled="true">

                    <div style="" class="description">{{Notation.K_zmin}} <b>K<sub>z</sub></b>.</div>
                </div>

                <div class="row">

                    <div style="" class="symbol"><b>K<sub>e</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.K_e}}</span>
                    </div>
                    <input type="text" id="K_e" step="0.1" ng-model="calculation.inputData.K_e" name="K_e"
                           class="value" disabled="true">


                    <div style="" class="description">{{Notation.K_e}}</div>
                </div>

            </div>

        </div>
    </div>

    <div class="row">
        <div style="" class="symbol">z<span ng-class="calculation.isPdf"> ={{calculation.inputData.z}}</span></div>
        <div style="" ng-class="calculation.isPdf"><span> ={{calculation.inputData.z}}</span></div>
        <input type="text" id="z" step="0.01" ng-model="calculation.inputData.z" name="z" class="value"
               ng-change="calculation.change()" style="background-color:#FFF380;">

        <div style="" class="description">{{Unit.z}}, {{Notation.z}}</div>
    </div>


    <div class="row">

        <div style="" class="symbol"><b>K<sub>z</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.K_z}}</span>
        </div>
<!--        <input type="text" id="K_z" ng-model="calculation.inputData.K_z.toFixed(4)" name="K_z" class="value" disabled="true">testtest-->
        <div class="value" disabled="true">{{calculation.inputData.K_z.toFixed(4)}}</div>


        <div style="" class="description">{{Notation.K_z}}, <b>K<sub>zmin</sub></b>&#8804; 2.01*(z/z<sub>g</sub>)<sup>z/&#945;</sup>&#8804;
            2.01
        </div>
    </div>


    <div class="row">
        <div style="" class="symbol">-<span ng-class="calculation.isPdf"> ={{calculation.inputData.topCAT}}</span></div>

        <!-- div style="" class="value">
            <select style="background-color:#FFF380; width:95%;" 
            id="top_cat_select" 
            class="seclection" 
            ng-change="prmtrUpon('topCAT'); calculation.change()"
            ng-model="calculation.inputData.topCAT">
            <option value=""></option>
            <option 
            ng-selected="calculation.inputData.topCAT" 
            ng-repeat="item in calculation.optionlist.topCAT" value="{{item}}">{{item}}</option></select>
        </div -->


        <div class="value">
            <select style="background-color:#FFF380; width:95%;" 
            id="top_cat_select" 
            class="seclection" 
            ng-change="calculation.change()"  

            ng-options="item for item in calculation.optionlist.topCAT" 

            ng-model="calculation.inputData.topCAT">

            <option value=""></option></select>
        </div>        

        <div style="" class="description" style="padding: 0 0 0 0;"><b>Topographic Category</b><br/>


            <div id="table2-5" style="" ng-hide="calculation.inputData.topCAT == 1 || calculation.inputData.topCAT == 5">
                <div class="row">
                    <div style="" class="symbol"><b>K<sub>t</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.K_t}}</span>
                    </div>
                    <input type="text" id="K_t" step="0.01" ng-model="calculation.inputData.K_t" name="K_t"
                           class="value" disabled="true">

                    <div style="" class="description">{{Notation.K_t}}</div>
                </div>

                <div class="row">
                    <div style="" class="symbol">f<span
                            ng-class="calculation.isPdf"> ={{calculation.inputData.f}}</span></div>
                    <input type="text" id="f" step="0.01" ng-model="calculation.inputData.f" name="f" class="value"
                           disabled="true">

                    <div style="" class="description">{{Notation.f}}</div>
                </div>
            </div>

            <div id="table2-5-tc1" ng-show="calculation.inputData.topCAT == 1">For category 1, no abrupt changes in general topography,
                e.g., flat or rolling 
                terrain, no wind speed-up consideration shall be required. 
                Topographic factor (for wind speed-up effect) equals to 1.0.
            </div>

            <div id="table2-5-tc5" style="" ng-show="calculation.inputData.topCAT == 5">For category 5, 
                topographic factor (for wind speed-up effect) shall be based on recognized published literature, 
                site-specific investigation, and/or reseach findings.
            </div>

            <div id="tf" style="" ng-hide="calculation.inputData.topCAT == 1 || calculation.inputData.topCAT == 5">
                <div class="row">
                    <div style="" class="symbol">H
                        <span ng-class="calculation.isPdf"> ={{calculation.inputData.H}}</span>
                    </div>
                    <input style="background-color:#FFF380;" type="text" id="H" ng-model="calculation.inputData.H" name="H" class="value"
                           ng-change="calculation.change()">

                    <div style="" class="description">{{Unit.H}}, {{Notation.H}}</div>
                </div>

                <div class="row">
                    <div style="" class="symbol"><b>K<sub>h</sub></b>
                        <span ng-class="calculation.isPdf"> ={{calculation.inputData.K_h}}</span>
                    </div>
                    <!-- input type="text" id="K_h" name="K_h" ng-model="calculation.inputData.K_h" class="value"
                           disabled="true" -->
                    <div class="value as-input" disabled="true">{{calculation.inputData.K_h.toFixed(4)}}</div>

                    <div style="" class="description">{{Notation.K_h}} = <b>e<sup>f*z/H</sup></b> where <b>e</b>,
                        natural logarithmic base, is euqal to 2.718.
                    </div>
                </div>
            </div>

            <div class="row">

                <div style="" class="symbol">
                    <b>K<sub>zt</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.K_zt}}</span>
                </div>

                <input class="value" type="text" style="background-color:#FFF380;" id="K_zt" name="K_zt" ng-model="calculation.inputData.K_zt" ng-change="calculation.change()" ng-disabled="calculation.inputData.topCAT != 5">

<!--                <div class="value" ng-show="calculation.inputData.topCAT != 5">{{calculation.inputData.K_zt.toFixed(4)}}</div>-->

                <div class="description"><span ng-bind-html="Notation.K_zt"></span>, = (1 + <b>K</b><sub>e</sub>*<b>K</b><sub>t</sub>/<b>K</b><sub>h</sub>)<sup>2</sup></div>
            </div>

        </div>
    </div>

    <div class="row">
        <div style="" class="symbol">-<span ng-class="calculation.isPdf"> ={{calculation.inputData.str_type}}</span></div>
        <div style="" class="value">

            <!--  select style="background-color:#FFF380; width:95%;" id="str_type_select" class="seclection" ng-change="prmtrUpon('str_type'); calculation.change()"
                    ng-model="calculation.inputData.str_type">
                <option value=""></option>
                <option ng-repeat="data in calculation.optionlist.str_type" value="{{data}}">{{data}}</option>                
            </select -->


            <select style="background-color:#FFF380; width:95%;" 
                id="str_type_select" 
                class="seclection" 
                ng-options="k as v for (k,v) in calculation.optionlist.str_type" 
                ng-model="calculation.inputData.str_type" 
                ng-change="calculation.change(); prmtrUpon('str_type');">
            <option value=""></option>
            </select>


        </div>

        <div style="" class="description" style="padding: 0 0 0 0;"><b>Structure Type</b><br/>

            <div class="row" id="cros_sec_type" ng-show="calculation.inputData.str_type">
                <div style="" class="symbol">-<span ng-class="calculation.isPdf"> ={{calculation.inputData.str_cros_sec}}</span></div>

                <!-- div class="value">
                    <select style="background-color:#FFF380; width:95%;" 
                    id="str_cros_sec_select"                     
                    class="seclection" 
                    ng-change="prmtrUpon('str_cros_sec'); calculation.change()"

                    ng-model="calculation.inputData.str_cros_sec">
                    <option value=""></option>
                    <option ng-repeat="data in calculation.optionlist.str_cros_sec" value="{{data}}">{{data}}
                    </option></select>
                </div -->


                <div class="value">
                    <select style="background-color:#FFF380; width:95%;" 
                    id="str_cros_sec_select" 
                    class="seclection" 
                    ng-change="prmtrUpon('str_cros_sec'); calculation.change()"  

                    ng-options="item for item in calculation.optionlist.str_cros_sec" 

                    ng-model="calculation.inputData.str_cros_sec">
                    <option value=""></option></select>
                </div>


                <div style="" class="description">latticed structure <b>Cross Section</b></div>
            </div>

            <div class="row">
                <div style="" class="symbol"><b>K<sub>d</sub></b><span ng-class="calculation.isPdf"> ={{calculation.inputData.K_d}}</span>
                </div>
                <!-- input type="text" step="0.01" id="K_d" name="K_d" ng-change="calculation.change()"
                       ng-model="calculation.inputData.K_d" class="value" -->

                <div class="value as-input" disabled="true">{{calculation.inputData.K_d.toFixed(2)}}</div>
                <div style="" class="description">{{Notation.K_d}}</div>
            </div>
        </div>

    </div>

    <div class="row">
        <div style="" class="symbol"><b>V</b><span ng-class="calculation.isPdf"> ={{calculation.inputData.V}}</span>
        </div>
        <input type="text" id="V" name="V" ng-model="calculation.inputData.V" ng-change="calculation.change()" class="value" style="background-color:#FFF380;" >

        <div style="" class="description"><span ng-bind-html="Unit.V + ', ' + Notation.V"></div>
    </div>

    <div class="row">
        <div style="" class="symbol">-<span ng-class="calculation.isPdf"> ={{calculation.inputData.str_class}}</span>
        </div>
        <div style="" class="value">
            <select id="str_class_select" style="background-color:#FFF380; width:90%;" ng-options="item for item in calculation.optionlist.str_class" ng-change="prmtrUpon('str_class'); calculation.change()"
                    ng-model="calculation.inputData.str_class" >
                <option value=""></option>
            </select>
        </div>
        <div style="" class="description"><b>Classification of Structures</b><br/>

            <div class="row">
                <div style="" class="symbol">-<span ng-class="calculation.isPdf"> ={{calculation.inputData.I_mptc}}</span></div>
                <div class="value">
                    <select style="background-color:#FFF380; width:95%;" id="loadcaseSelect" class="seclection" ng-options="k as v for (k,v) in calculation.optionlist.purpose_of_calculation" ng-model="calculation.inputData.purpose_of_calculation" ng-change="calculation.change()">
                        <option value=""></option>
<!--                        <option ng-repeat="(key, value) in calculation.optionlist.purpose_of_calculation" value="{{key}}">-->
<!--                            {{value}}-->
<!--                        </option>-->
                    </select>
                </div>
                <div style="" class="description">load case or purpose of calculation.</div>
            </div>       

            <div class="row" id="I_mptc">
                <div style="" class="symbol"><b>I</b><span ng-class="calculation.isPdf"> ={{calculation.inputData.I}}</span>
                </div>
                <input type="text" id="I" name="I" ng-change="calculation.change()"
                       ng-model="calculation.inputData.I" class="value" disabled="true">

                <div style="" class="description">{{Notation.I}}</div>
            </div>

        </div>
    </div>

    <div class="row">
        <div style="" class="symbol"><b>q<sub>z</sub></b>
            <span ng-class="calculation.isPdf"> ={{calculation.inputData.q_z}}</span>
        </div>

        <!-- input type="text" step="0.1" id="q_z" name="q_z" ng-model="calculation.inputData.q_z" class="value" disabled="true" -->

        <div class="value" disabled="true">{{calculation.inputData.q_z.toFixed(4)}}</div>

        <!-- div style="" class="description">{{Unit.q_z}}, {{Notation.q_z}}</div-->

        <div style="" class="description"><span ng-bind-html="Unit.q_z + ', ' + Notation.q_z"></span></div>

    </div>

    <div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"
         style="position: absolute; top:-5000px"></div>

</div>




</body>
</html>