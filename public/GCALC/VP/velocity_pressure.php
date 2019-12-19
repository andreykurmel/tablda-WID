<?php
require_once("./../../../../../../../../config.php");
?>

<!DOCTYPE html>
<html ng-app="TIA-WL-APP">
<head>
    <?php include "./../../jsCSS-TIA-222.php"; ?>

    <script src="velocity_pressure.js"></script>

    <?php include "./../../loader.php"; ?>

    <a href="#" id="pdf" onclick="return xepOnline.Formatter.Format('iframeId',
    {pageWidth:'216mm', pageHeight:'279mm',namespaces:['xmlns:ng=&quot;http://www.foo.net&quot;']});">
</a>

<style>
body {
    padding: 0 9px 0 11px !important;
}

[class*="col-xs"]:not(:empty), input {
    border: 1px solid green;
    border-radius: 10px;
    margin: 1px 0;
}

.col-xs-2 {
    padding: 1px 3px;
}

input, select {
    width: 100%;
    background-color: #FFF380;
}

input[type="text"]:disabled {
    background: #D0D0D0;
}
</style>

</head>

<body>

    <!--<h4 style="padding-left:5px; margin-top: 0;">TIA-222-G Velocity Pressure</h4>-->

    <div style="height: 680px;">
        <div id="iframeId" style="margin: 0 20px 0 20px;" ng-controller="vpController as vpCtrlr" debug="<?php echo $accessType?>">

            <div ng-if="calculation.access">
                <div class="row" style="padding: 0 0px 0 0px; font-weight: bold; font-size:20px; clear:both;">
                    <h3 style="background: grey;" class="col-xs-1">Sym.</h3>

                    <h3 style="background: grey;" class="col-xs-2">Value</h3>

                    <h3 style="background: grey;" class="col-xs-9">Description</h3>
                </div>

                <div class="row">
                    <div style="" class="col-xs-1">-</div>

                    <div style="" class="col-xs-2">
                        <select style=""
                        id="exposureCat"
                        class="seclection"
                        ng-options="item for item in calculation.optionlist.expCAT"
                        ng-change="calculation.change()"
                        ng-model="calculation.inputData.expCAT">
                        <option value=""></option>
                    </select>
                </div>

                <div style="" class="col-xs-9" id="table2-4">
                    <b>Exposure Category</b>
                    <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
                    ng-click="calculation.info(['#exposure_category', '#references'])"></span>

                    <div ng-show="calculation.inputData.expCAT" class="border-none">
                        <div class="row">
                            <div style="" class="col-xs-1"><b>z<sub>g</sub></b></div>
                            <input class="col-xs-2" type="text" step="10" id="z_g" name="z_g"
                            ng-model="calculation.inputData.z_g" class="value" disabled="true">

                            <div style="" class="col-xs-9">{{Unit.z_g}}, {{Notation.z_g}}</div>
                        </div>

                        <div class="row">
                            <div style="" class="col-xs-1">&#945;</div>
                            <input class="col-xs-2" type="text" id="alpha" ng-model="calculation.inputData.alpha"
                            name="alpha"
                            class="value" disabled="true">

                            <div style="" class="col-xs-9">{{Notation.alpha}}</div>
                        </div>

                        <div class="row">
                            <div style="" class="col-xs-1"><b>K<sub>zmin</sub></b></div>
                            <input class="col-xs-2" type="text" id="K_zmin" step="0.1"
                            ng-model="calculation.inputData.K_zmin"
                            name="K_zmin" class="value" disabled="true">

                            <div style="" class="col-xs-9">{{Notation.K_zmin}} <b>K<sub>z</sub></b>.</div>
                        </div>

                        <div class="row">
                            <div style="" class="col-xs-1"><b>K<sub>e</sub></b></div>
                            <input class="col-xs-2" type="text" id="K_e" step="0.1" ng-model="calculation.inputData.K_e"
                            name="K_e" class="value" disabled="true">

                            <div style="" class="col-xs-9">{{Notation.K_e}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div style="" class="col-xs-1">z</div>
                <input type="text" class="col-xs-2" id="z" step="0.01" ng-model="calculation.inputData.z" name="z"
                ng-change="calculation.change()">

                <div style="" class="col-xs-9">{{Unit.z}}, {{Notation.z}}</div>
            </div>

            <div class="row">
                <div style="" class="col-xs-1"><b>K<sub>z</sub></b></div>

                <input class="col-xs-2" type="text" id="K_z" ng-model="calculation.inputData.K_z" name="K_z" class="value" disabled="true">

                <div style="" class="col-xs-9">{{Notation.K_z}}, <b>K<sub>zmin</sub></b>&#8804; 2.01*(z/z<sub>g</sub>)<sup>z/&#945;</sup>&#8804;2.01
                </div>
            </div>


            <div class="row">
                <div style="" class="col-xs-1">-</div>

                <div class="col-xs-2">
                    <select style=""
                    id="top_cat_select"
                    class="seclection"
                    ng-change="calculation.change()"

                    ng-options="item for item in calculation.optionlist.topCAT"

                    ng-model="calculation.inputData.topCAT">

                    <option value=""></option></select>
                </div>

                <div style="" class="col-xs-9" style="padding: 0 0 0 0;">
                    <b>Topographic Category</b>
                    <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
                    ng-click="calculation.info(['#topographic_category'])"></span>
                    <br/>

                    <div id="table2-5" style=""
                    ng-hide="calculation.inputData.topCAT == 1 || calculation.inputData.topCAT == 5"
                    class="border-none">
                    <div class="row">
                        <div style="" class="col-xs-1"><b>K<sub>t</sub></b>
                        </div>
                        <input type="text" id="K_t" ng-model="calculation.inputData.K_t" name="K_t"
                        class="col-xs-2" disabled="true">

                        <div style="" class="col-xs-9">{{Notation.K_t}}</div>
                    </div>

                    <div class="row">
                        <div style="" class="col-xs-1">f</div>
                        <input type="text" id="f" step="0.01" ng-model="calculation.inputData.f" name="f"
                        class="col-xs-2"
                        disabled="true">

                        <div style="" class="col-xs-9">{{Notation.f}}</div>
                    </div>
                </div>

                <div id="table2-5-tc1" ng-show="calculation.inputData.topCAT == 1">For category 1, no abrupt changes in
                    general topography,
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
                        <div style="" class="col-xs-1">H</div>

                        <input style="" type="text" id="H" ng-model="calculation.inputData.H_crest" name="H" class="col-xs-2"
                        ng-change="calculation.change()">

                        <div style="" class="col-xs-9">{{Unit.H_crest}}, {{Notation.H_crest}}
                            <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#crest_height'])"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div style="" class="col-xs-1"><b>K<sub>h</sub></b></div>
                        <input type="text" id="K_h" ng-model="calculation.inputData.K_h" name="K_h" class="col-xs-2"
                        disabled="true">

                        <div style="" class="col-xs-9">{{Notation.K_h}} = <b>e<sup>f*z/H</sup></b> where <b>e</b>,
                            natural logarithmic base, is euqal to 2.718.
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div style="" class="col-xs-1"><b>K<sub>zt</sub></b>
                    </div>

                    <input class="col-xs-2" type="text" style="" id="K_zt5x" name="K_zt5x" disabled="true"
                    ng-model="calculation.inputData.K_zt5x" ng-change="calculation.change()" ng-show="calculation.inputData.topCAT == 5 && calculation.inputData.use_seaw_rsm == 1">                    

                    <input class="col-xs-2" type="text" style="" id="K_zt5"  name="K_zt5"
                    ng-model="calculation.inputData.K_zt5" ng-change="calculation.change()" ng-show="calculation.inputData.topCAT == 5 && calculation.inputData.use_seaw_rsm == 0">

                    <input class="col-xs-2" type="text" style="" id="K_zt"   name="K_zt"    disabled="true"
                    ng-model="calculation.inputData.K_zt" ng-change="calculation.change()" ng-show="calculation.inputData.topCAT != 5">

                    <div class="col-xs-9" ng-show="calculation.inputData.topCAT != 5"><span ng-bind-html="Notation.K_zt"></span>, = (1 +
                        <b>K</b><sub>e</sub>*<b>K</b><sub>t</sub>/<b>K</b><sub>h</sub>)<sup>2</sup>
                    </div>

                    <div class="col-xs-9" ng-show="calculation.inputData.topCAT == 5">
                        <span style="float:left;">Use SEAW-RSM-03?</span>
                        <input class="col-xs-1" type="checkbox" style="" id="use_seaw_rsm" name="use_seaw_rsm"
                        ng-model="calculation.inputData.use_seaw_rsm" ng-change="calculation.change()">
                        <span ng-show="calculation.inputData.use_seaw_rsm == 1">Yes</span>
                        <span ng-show="calculation.inputData.use_seaw_rsm == 0">No</span>
                        <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
                        ng-click="calculation.info(['#seaw_rsm_03'])"></span>

                        <div ng-show="calculation.inputData.topCAT == 5 && calculation.inputData.use_seaw_rsm == 1">

                            <div class="row">
                                <div class="col-xs-5">
                                    <select style=""
                                    id="topofeature"
                                    class="seclection"
                                    ng-change="calculation.change()"

                                    ng-options="item for item in calculation.optionlist.topofeature"

                                    ng-model="calculation.inputData.topofeature">

                                    <option value=""></option></select>
                                </div> 
                                <div class="col-xs-7">topographic feature.</div>  
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="elev_crest" name="elev_crest"
                                ng-model="calculation.inputData.elev_crest" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.elev_crest}}, crest point elevation (AMSL).</div>
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="elev_base" name="elev_base"
                                ng-model="calculation.inputData.elev_base" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.elev_base}}, base point elevation (AMSL).</div>
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="ht_crest" name="ht_crest"
                                ng-model="calculation.inputData.ht_crest" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.ht_crest}}, crest height.</div>
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="elev_midht" name="elev_midht"
                                ng-model="calculation.inputData.elev_midht" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.elev_midht}}, mid-height elevation (AMSL).</div>
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="elev_twrpt" name="elev_twrpt"
                                ng-model="calculation.inputData.elev_twrpt" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.elev_twrpt}}, tower point elevation (AMSL).</div>    
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="dis_crest2midht" name="dis_crest2midht"
                                ng-model="calculation.inputData.dis_crest2midht" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.dis_crest2midht}}, crest to mid-height distance.</div>
                            </div>

                            <div class="row">
                                <input class="col-xs-3" type="text" style="" id="dis_str_updwnwind" name="dis_str_updwnwind"
                                ng-model="calculation.inputData.dis_str_updwnwind" ng-change="calculation.change()">
                                <div class="col-xs-9">{{Unit.dis_str_updwnwind}}, structure upwind/downwind distance.</div>                                                                                     
                            </div>

                        </div>

                    </div>               
                </div>



            </div>
        </div>


        <div class="row">
            <div style="" class="col-xs-4">

                <select style=""
                id="str_type_select"
                class="seclection"
                ng-options="k as v for (k,v) in calculation.optionlist.str_type"
                ng-model="calculation.inputData.str_type"
                ng-change="calculation.change(); prmtrUpon('str_type');">
                <option value=""></option></select>


            </div>

            <div style="" class="col-xs-8" style="">
                <b>Structure Type</b>
                <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
                ng-click="calculation.info(['#structural_type', '#references'])"></span>
                <br/>

                <div class="row" id="cros_sec_type" ng-show="calculation.inputData.str_type">

                    <div class="col-xs-3">
                        <select style=""
                        id="str_cros_sec_select"
                        class="seclection"
                        ng-change="prmtrUpon('str_cros_sec'); calculation.change()"

                        ng-options="item for item in calculation.optionlist.str_cros_sec"

                        ng-model="calculation.inputData.str_cros_sec">
                        <option value=""></option>
                    </select>
                </div>

                <div style="" class="col-xs-9">latticed structure <b>Cross Section</b></div>
            </div>

            <div class="row">
                <div style="" class="col-xs-1"><b>K<sub>d</sub></b>
                </div>

                <input class="col-xs-2" type="text" style="" id="K_d" name="K_d" disabled="true"
                ng-model="calculation.inputData.K_d">


                <div style="" class="col-xs-9">{{Notation.K_d}}</div>
            </div>


                    <!-- div class="row" ng-show="calculation.inputData.str_type == 'latticed'">
                        <div style="" class="col-xs-1"><b>h</b></div>
                        <input type="text" style="background-color:#FFF380;" id="h" name="h"   ng-change="calculation.change()" ng-model="calculation.inputData.h_str" class="col-xs-2">
                        <div style="" class="col-xs-9">{{Notation.h_str}}</div>
                    </div>

                    <div class="row" ng-show="calculation.inputData.str_type == 'str_sptd_on_other_str'">

                        <div class="col-xs-6" style="">
                            <select style="background-color:#FFF380;" id="str_sptd_on_other_str_select" class="seclection" ng-options="k as v for (k,v) in calculation.optionlist.str_sptd_on_other_str" ng-model="calculation.inputData.str_sptd_on_other_str" ng-change="calculation.change()">
                                <option value=""></option>
                            </select>
                        </div>

                        <div style="" class="col-xs-6">structure supported on other structure.</div>
                    </div>


                    <div class="row">
                        <div style="" class="col-xs-1"><b>G<sub>h</sub></b></div>
                        <input type="text" id="G_h" name="G_h"  disabled="true" ng-change="calculation.change()" ng-model="calculation.inputData.G_h" class="col-xs-2">

                        <div style="" class="col-xs-9">{{Notation.G_h}}</div>
                    </div -->

                </div>

            </div>

            <div class="row">
                <div style="" class="col-xs-1"><b>V</b>
                </div>
                <input type="text" id="V" name="V" ng-model="calculation.inputData.V" ng-change="calculation.change()"
                class="col-xs-2" ng-disabled="calculation.inputData.windspeed_src != 'input'">

                <div style="" class="col-xs-9">
                    <span ng-bind-html="Unit.V + ', ' + Notation.V"></span>
                    <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
                    ng-click="calculation.info(['#basic_wind_speed', '#references'])"></span><br/>


                    <div class="row">
                        <div class="col-xs-3">
                            <select style=""
                            id="windspeed_src"
                            class="seclection"
                            ng-change="calculation.change()"

                            ng-options="k as v for (k,v) in calculation.optionlist.windspeed_src"

                            ng-model="calculation.inputData.windspeed_src">
                            <option value=""></option></select>
                        </div>

                        <div style="" class="col-xs-9">Get windspeed from?</b>  
                            <button type="button" ng-click="" ng-show="calculation.inputData.windspeed_src == 'atc_web'">Get Windspeed</button>
                        </div>
                    </div>



                    <!-- input type="checkbox" name="windspeed_atcweb" ng-model="calculation.inputData.windspeed_atcweb" ng-change="calculation.change()"> 
                    Get Windspeed by Location from ATC website.<br/ -->

                    <div class="row" id="windspeed_atcweb" ng-hide="calculation.inputData.windspeed_src != 'atc_web'">

                        <div class="col-xs-3">
                            <select style=""
                            id="windspeed_by_select"
                            class="seclection"
                            ng-change="calculation.change()"

                            ng-options="k as v for (k,v) in calculation.optionlist.loc_by"

                            ng-model="calculation.inputData.loc_by">
                            <option value=""></option>
                        </select>
                    </div>

                    <div style="" class="col-xs-9">Location given by?


                        <div class="row" id="loc_lat_long" ng-show="calculation.inputData.loc_by == 'lat_long'">

                            <div class="col-xs-3">
                                <select style=""
                                id="windspeed_by_select"
                                class="seclection"
                                ng-change="calculation.change()"

                                ng-options="item for item in calculation.optionlist.lat_long_format"

                                ng-model="calculation.inputData.lat_long_format">
                                <option value=""></option>
                            </select>
                        </div>

                        <div style="" class="col-xs-9">Lat. & Long Format?

                            <div class="row" id="lat_long_decimal" ng-show="calculation.inputData.lat_long_format == 'decimal'">
                                <input type="text" id="lat" placeholder="latitude" name="lat" ng-model="calculation.inputData.latitude" ng-change="calculation.change()"
                                class="col-xs-6" style=""> 
                                <input type="text" id="long" placeholder="longitude" name="long" ng-model="calculation.inputData.longitude" ng-change="calculation.change()"
                                class="col-xs-6" style="">                                                                
                            </div>

                            <div class="row" id="lat_long_dms" ng-show="calculation.inputData.lat_long_format == 'DMS'">
                                <span class="col-xs-3">Latitude:</span>
                                <input type="text" id="lat_degree" placeholder="deg." name="lat_degree" ng-model="calculation.inputData.lat_degree" ng-change="calculation.change()"
                                class="col-xs-3" style=""> 
                                <input type="text" id="lat_minute" placeholder="min." name="lat_minute" ng-model="calculation.inputData.lat_minute" ng-change="calculation.change()"
                                class="col-xs-3" style="">
                                <input type="text" id="lat_second" placeholder="sec." name="lat_second" ng-model="calculation.inputData.lat_second" ng-change="calculation.change()"
                                class="col-xs-3" style=""> 

                                <span class="col-xs-3">Longitude:</span>
                                <input type="text" id="long_degree" placeholder="deg." name="long_degree" ng-model="calculation.inputData.long_degree" ng-change="calculation.change()"
                                class="col-xs-3" style=""> 
                                <input type="text" id="long_minute" placeholder="min." name="long_minute" ng-model="calculation.inputData.long_minute" ng-change="calculation.change()"
                                class="col-xs-3" style="">
                                <input type="text" id="long_second" placeholder="sec." name="long_second" ng-model="calculation.inputData.long_second" ng-change="calculation.change()"
                                class="col-xs-3" style=""> 
                            </div>

                        </div>


                    </div>

                    <div class="row" id="loc_address" ng-show="calculation.inputData.loc_by == 'address'">
                        <input type="text" id="street" name="street" placeholder="street address" ng-model="calculation.inputData.street" ng-change="calculation.change()"
                        class="col-xs-12" style="">

                        <input type="text" id="city" name="city" placeholder="city" ng-model="calculation.inputData.city" ng-change="calculation.change()"
                        class="col-xs-6" style=""> 

                        <!-- input type="text" id="county" name="county" placeholder="county" ng-model="calculation.inputData.county" ng-change="calculation.change()"
                        class="col-xs-3" style="" --> 

                        <input type="text" id="state" name="state" placeholder="state" ng-model="calculation.inputData.state" ng-change="calculation.change()"
                        class="col-xs-3" style=""> 

                        <input type="text" id="zipcode" name="zipcode" placeholder="zipcode" ng-model="calculation.inputData.zipcode" ng-change="calculation.change()"
                        class="col-xs-3" style="">
                    </div>                            
                </div>
            </div> 

            

            <div class="row" ng-show="calculation.inputData.windspeed_src == 'atc_web'">
                <div class="col-xs-5">
                    <select style=""
                    id="windspeed2use"
                    class="seclection"
                    ng-change="calculation.change()"

                    ng-options="k as v for (k,v) in calculation.optionlist.windspeed2use"

                    ng-model="calculation.inputData.windspeed2use">
                    <option value=""></option></select>
                </div>

                <div style="" class="col-xs-7">Wind speed to use.
                </div>
            </div>                

            <div class="row" id="windspeed_tia222g" ng-show="calculation.inputData.windspeed_src == 'tia_222_g'">

                <div style="" class="col-xs-2">State</b></div>

                <div class="col-xs-4">
                    <select style=""
                    id="us_state"
                    class="seclection"
                    ng-change="calculation.change()"

                    ng-options="item for item in calculation.optionlist.states"

                    ng-model="calculation.inputData.state">
                    <option value=""></option>
                </select>
            </div>

            <div style="" class="col-xs-2">County</b></div>

            <div class="col-xs-4">
                <select style=""
                id="us_county"
                class="seclection"
                ng-change="calculation.change()"

                ng-options="item for item in calculation.optionlist.counties"

                ng-model="calculation.inputData.county">
                <option value=""></option>
            </select>
        </div>


    </div> 


</div>
</div>

<div class="row">
    <div style="" class="col-xs-1">-
    </div>
    <div style="" class="col-xs-2">
        <select id="str_class_select" style="" ng-options="item for item in calculation.optionlist.str_class"
        ng-change="prmtrUpon('str_class'); calculation.change()"
        ng-model="calculation.inputData.str_class">
        <option value=""></option>
    </select>
</div>
<div style="" class="col-xs-9"><b>Classification of Structures</b>
    <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
    ng-click="calculation.info(['#classification_structure', '#references'])"></span>
    <br/>

    <div class="row">
        <div class="col-xs-5">
            <select style="" id="loadcaseSelect" class="seclection"
            ng-options="k as v for (k,v) in calculation.optionlist.purpose_of_calculation"
            ng-model="calculation.inputData.purpose_of_calculation"
            ng-change="calculation.change()">
            <option value=""></option>
        </select>
    </div>
    <div style="" class="col-xs-7">load case or purpose of calculation.</div>
</div>

<div class="row" id="I_mptc">
    <div style="" class="col-xs-1"><b>I</b>
    </div>
    <input type="text" id="I" name="I" ng-change="calculation.change()"
    ng-model="calculation.inputData.I" class="col-xs-2" disabled="true">

    <div class="col-xs-9">{{Notation.I}}</div>
</div>

</div>
</div>

<div class="row">
    <div style="" class="col-xs-1"><b>q<sub>z</sub></b>

    </div>

    <input type="text" disabled="true" id="I" name="I" ng-change="calculation.change()"
    ng-model="calculation.inputData.q_z" class="col-xs-2" disabled="true">

    <div style="" class="col-xs-9"><span ng-bind-html="Unit.q_z + ', ' + Notation.q_z"></span></div>

</div>



<div class="row">

    <input class="col-xs-4" type="text" id="" name=""  disabled="true" ng-change="" ng-model="calculation.optionlist.str_type[calculation.inputData.str_type]" class="col-xs-12">

    <div style="" class="col-xs-8" style="padding: 0 0 0 0;">Structure Type

        <div class="row" ng-show="calculation.inputData.str_type == 'latticed'">
            <div style="" class="col-xs-1"><b>h</b></div>
            <input type="text" style="background-color:#FFF380;" id="h_str" name="h_str"   ng-change="calculation.change()" ng-model="calculation.inputData.h_str" class="col-xs-2">
            <div style="" class="col-xs-9">{{Unit.h_str}}, {{Notation.h_str}}

                <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#h_str'])"></span>

            </div>
        </div>

        <div class="row" ng-show="calculation.inputData.str_type == 'str_sptd_on_other_str'">

            <div class="col-xs-6" style="">
                <select style="background-color:#FFF380;" id="str_sptd_on_other_str_select" class="seclection" ng-options="k as v for (k,v) in calculation.optionlist.str_sptd_on_other_str" ng-model="calculation.inputData.str_sptd_on_other_str" ng-change="calculation.change()">
                    <option value=""></option>
                </select>
            </div>

            <div style="" class="col-xs-6">structure supported on other structure.</div>
        </div>


        <div class="row">
            <div style="" class="col-xs-1"><b>G<sub>h</sub></b></div>
            <input type="text" id="G_h" name="G_h"  disabled="true" ng-change="calculation.change()" ng-model="calculation.inputData.G_h" class="col-xs-2">

            <div style="" class="col-xs-9">{{Notation.G_h}}
                <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue" ng-click="calculation.info(['#G_h'])"></span>
            </div>
        </div>

    </div>

</div>

<div class="row">
    <div style="" class="col-xs-1"><b>t<sub>i</sub></b>
    </div>
    <input type="text" id="t_i" name="t_i" ng-model="calculation.inputData.t_i" ng-change="calculation.change()"
    class="col-xs-2" style="">

    <div style="" class="col-xs-9"><span ng-bind-html="Unit.t_i + ', ' + Notation.t_i"></span>
        <span class="glyphicon glyphicon-info-sign" style="color: cornflowerblue"
        ng-click="calculation.info(['#design_ic_thk', '#references'])"></span>

        <div class="row">
            <div style="" class="col-xs-1"><b>K<sub>iz</sub></b>
            </div>

            <input class="col-xs-2" type="text" style="" id="K_iz" name="K_iz" disabled="true"
            ng-model="calculation.inputData.K_iz">


            <div style="" class="col-xs-9">{{Notation.t_iz}}</div>
        </div>


        <div class="row">
            <div style="" class="col-xs-1"><b>t<sub>iz</sub></b>
            </div>

            <input class="col-xs-2" type="text" style="" id="t_iz" name="t_iz" disabled="true"
            ng-model="calculation.inputData.t_iz">


            <div style="" class="col-xs-9">{{Notation.t_iz}}</div>
        </div>


    </div>
</div>            



<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"
style="position: absolute; top:-5000px"></div>
</div>


<div ng-if="!calculation.access">ACCESS DENIED</div>
</div>
</div>

</body>
</html>