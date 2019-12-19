<input type="hidden" id="type" ng-value="models.tabs">
<input type="hidden" id="item-id" ng-value="models.tabs == 'all' ? models.product.details['id'] : models.geometry.details[0]['id']">

<div ng-show="models.tabs === 'all'" class="main-tabs">
    <button ng-if='auth.isAuth();' style="position: absolute; top: 3px; right: 5%;" class="btn" ng-class="{'btn-success': models.product.changed}" ng-click="models.product.saveItem();" ng-disabled="!models.product.allowEdit">Save</button>
    <ul class="nav nav-tabs geometry_list">
        <li class="item active" ng-click="models.product.checkDataLoaded(); models.product_tabs = 'associations'" ng-disabled="!models.product.dataLoaded"><a ng-class="{'selected_tab': models.product_tabs == 'associations' }" href="javascript:void(0)" data-target="#all-association" data-toggle="tab">Geometry Association</a></li>
        <li class="item" ng-click="models.product.checkDataLoaded(); models.product_tabs = 'areas'" ng-disabled="!models.product.dataLoaded"><a ng-class="{'selected_tab': models.product_tabs == 'areas' }" href="javascript:void(0)" data-target="#all-areas" data-toggle="tab">Wind Faces</a></li>
        <li class="item" ng-click="models.product.checkDataLoaded(); models.product_tabs = 'documents'" ng-disabled="!models.product.dataLoaded"><a ng-class="{'selected_tab': models.product_tabs == 'documents' }" href="javascript:void(0)" data-target="#all-documents" data-toggle="tab">Documents</a></li>
        <li class="item" ng-click="models.product.checkDataLoaded(); models.product_tabs = 'photos'" ng-disabled="!models.product.dataLoaded"><a ng-class="{'selected_tab': models.product_tabs == 'photos' }" href="javascript:void(0)" data-target="#all-photos" data-toggle="tab">Photos</a></li>
        <li class="item" ng-click="models.product.checkDataLoaded(); models.product_tabs = 'spec'" ng-disabled="!models.product.dataLoaded"><a ng-class="{'selected_tab': models.product_tabs == 'spec' }" href="javascript:void(0)" data-target="#all-spec" data-toggle="tab">Specifications</a></li>
    </ul>

    <div class="tab-content">
        <div id="all-association" ng-show="models.product.dataLoaded" class="tab-pane active">
            <div style="margin-top: 10px; padding-left: 0;" class="col-md-12">
                <div style="padding-left: 0;" class="col-md-3">
                    <span>Select Type:</span>
                    <select class="form-control" style="width: 130px; margin-top: 5px;" ng-model="models.product.details.geometryType" ng-change="models.product.changed = true; render.redraw(); models.product.getWA();" ng-disabled="!models.product.allowEdit">
                        <option value="structure">Structure</option>
                        <option value="single_object">Single Object</option>
                        <option value="3d_files">3D file(s)</option>
                    </select>
                </div>

                <div class="col-md-4" ng-show="models.product.details.geometryType == 'single_object'">
                    <span>Geometry Shape/Type:</span>
                    <select class="form-control" style="width: 150px; margin-top: 5px;" ng-model="models.product.details.geometryShapeType" ng-change="models.product.changed = true; render.redraw(); models.product.getWA();" ng-disabled="!models.product.allowEdit">
                        <option value="FlatPanel">Flat Panel</option>
                        <option value="ConicalDishShroud">Conical Dish w/ Shroud</option>
                        <option value="CylinderDishShroud">Cylinder Dish w/ Shroud</option>
                        <option value="DishRadom">Dish w/ Radom</option>
                        <option value="DishwoRadom">Dish w/ Radom</option>                        
                        <option value="ParabolicGridDish">Parabolic Grid Dish</option>
                        <option value="Cuboid">Cuboid</option>
                        <option value="Cylinder">Cylinder</option>
                        <option value="Sphere">Sphere</option>
                    </select>
                </div>

                <div class="col-md-3" ng-show="models.product.details.geometryType == 'single_object'">
                    <span>Look:</span>
                    <select style="width: 120px;" class="form-control" ng-model="models.product.details.texture_type"  ng-change="models.product.changed = true;">
                        <option value="color" selected>Color</option>
                        <option value="texture">Texture</option>
                    </select>
                    <input ng-show="models.product.details.texture_type == 'color'" class="form-control" style="z-index: 2; width: 100px; position: absolute; bottom: -35px; background-color: {{models.product.details.color}}" ng-disabled="!models.product.allowEdit" ng-style="{'color':(models.product.details.color | colorFilter)}" colorpicker type="text" ng-change="models.product.changed = true; render.redraw();" ng-model="models.product.details.color" value="#DCDCDC"/>
                    <input ng-show="models.product.details.texture_type == 'texture'" type="file" file-model="soTexture" class="form-control" style="width: 250px; height:28px; position: absolute; bottom: -35px;"/>
                    <div ng-show="models.product.details.texture_type == 'texture'" style="position: absolute; bottom: -60px;">{{models.product.details.texture}}</div>
                </div>

                <div class="col-md-2" ng-show="models.product.details.geometryType == 'single_object'">
                    <div>Has Azimuth?</div>
                    <input type="checkbox" ng-model="models.product.details.has_azm">   
                    <span ng-show="models.product.details.has_azm == 1">Yes</span>                 
                </div>                


            </div>

            <div ng-show="models.product.details.geometryType == 'single_object'">
                <div class="row">
                    <div class="col-md-11"><h5>General Dimensions & Weight</h5></div>
                </div>

                 <div class="col-md-8">

                <table class="table table-bordered table-hover dimTable" style="width: 500px;">
                    <tr>
                        <th style="width: 60px">D1</th>
                        <th style="width: 60px">D2</th>
                        <th style="width: 60px">D3</th>
                        <th style="width: 60px">D4</th>
                        <th style="width: 60px">D5</th>
                        <th colspan="2" style="width: 300px">Weight _ mounting kit</th>

                    </tr>

                    <tr>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].d1.exp}}</td>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].d2.exp}}</td>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].d3.exp}}</td>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].d4.exp}}</td>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].d5.exp}}</td>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].w.exp}}</td>
                        <td>{{singleObjectsConfig[models.product.details.geometryShapeType].wo.exp}}</td>
                    </tr>

                    <tr>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].d1.units) || 'nf' }}</td>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].d2.units) || 'nf' }}</td>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].d3.units) || 'nf' }}</td>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].d4.units) || 'nf' }}</td>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].d5.units) || 'nf' }}</td>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].w.units) || 'nf' }}</td>
                        <td>{{ units.find('db_product',singleObjectsConfig[models.product.details.geometryShapeType].wo.units) || 'nf' }}</td>
                    </tr>

                    <tr>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.details.d1" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        
                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput input-mockup form-control" ng-disabled="true" ng-if="!singleObjectsConfig[models.product.details.geometryShapeType].d2.show">
                            <input type="text" class="itemInfoInput form-control" ng-model="models.product.details.d2" ng-change="models.product.changed = true; models.product.plotResize(models.product.details.d2, models.product.details.d3);" ng-disabled="!models.product.allowEdit" ng-if="singleObjectsConfig[models.product.details.geometryShapeType].d2.show">
                        </td>

                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput input-mockup form-control" ng-disabled="true" ng-if="!singleObjectsConfig[models.product.details.geometryShapeType].d3.show">
                            <input type="text" class="itemInfoInput form-control" ng-model="models.product.details.d3" ng-change="models.product.changed = true; models.product.plotResize(models.product.details.d2, models.product.details.d3);" ng-if="singleObjectsConfig[models.product.details.geometryShapeType].d3.show" ng-disabled="!models.product.allowEdit">
                        </td>

                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput input-mockup form-control" ng-disabled="true" ng-if="!singleObjectsConfig[models.product.details.geometryShapeType].d4.show">
                            <input type="text" class="itemInfoInput form-control" ng-model="models.product.details.d4" ng-change="models.product.changed = true;" ng-if="singleObjectsConfig[models.product.details.geometryShapeType].d4.show" ng-disabled="!models.product.allowEdit">
                        </td>

                        <td style="position: relative;">
                            <input type="text" class="itemInfoInput input-mockup form-control" ng-disabled="true" ng-if="!singleObjectsConfig[models.product.details.geometryShapeType].d5.show">
                            <input type="text" class="itemInfoInput form-control" ng-model="models.product.details.d5" ng-change="models.product.changed = true;" ng-if="singleObjectsConfig[models.product.details.geometryShapeType].d5.show" ng-disabled="!models.product.allowEdit">
                        </td>                        

                        <!-- td><input type="text" class="itemInfoInput form-control" ng-model="models.product.details.d5"     ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit || true"></td -->
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.details.weight_wo_mkit" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.details.weight_w_mkit" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>

                    </tr>

                </table>

                    </div>

                <div class="col-md-4" >
                        <img ng-if="models.product.details.geometryShapeType == 'FlatPanel'" src="images/flat_panel.png" alt="" height="60%" width="80%">

                        <img ng-if="models.product.details.geometryShapeType == 'DishRadom'" src="images/dish_radome.png" alt="" height="" width="100%">

                        <img ng-if="models.product.details.geometryShapeType == 'CylinderDishShroud'" src="images/cyl_dish_shroud.png" alt="" height="" width="100%">

                        <img ng-if="models.product.details.geometryShapeType == 'ConicalDishShroud'" src="images/con_dish_shroud.png" alt="" height="" width="100%">
                   
                        <img ng-if="models.product.details.geometryShapeType == 'ParabolicGridDish'" src="images/grid_dish.png" alt="" height="" width="100%">

                    </div>
            </div>

            <div class="col-md-12" style="margin: 0; padding: 14px 0; width: 650px;" ng-show="models.product.details.geometryType == 'structure' && models.product.association.length">
                <table class="table table-bordered" style="margin: 0;">
                    <tr>
                        <th ng-repeat="item in models.product.association track by $index" ng-style="{ width: item.size }"  ng-if="item.name != 'App'">{{ item.name }}</th>
                    </tr>
                    <tr>
                        <td ng-repeat="item in models.product.association track by $index" ng-if="item.name != 'App'">
                            <select class="form-control" ng-model="item.select" ng-change="models.product.changeAssociation(item); models.product.changed = true;" ng-options="data.value for data in item.data" ng-disabled="!models.product.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-12" ng-show="models.product.details.geometryType == '3d_files'" style="margin-top: 20px; padding-left: 0;">
                <table class="table table-bordered table-hover" style="width: 650px">
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th style="width: 120px;">File</th>
                        <th style="width: 40px;">Show</th>
                        <th style="width: 60px;">Notes</th>
                        <th ng-show="auth.isAuth()" style="width: 80px;">Action</th>
                    </tr>
                    <tr ng-repeat="file in models.product.files_list">
                        <td>{{$index + 1}}</td>
                        <td>{{file.file}}</td>
                        <td style="text-align: center;"><input type="checkbox" ng-change="file.change = true" ng-model='file.show' ng-true-value="'true'" ng-false-value="'false'" ng-disabled="!models.product.allowEdit"></td>
                        <td><input class="form-control" type="text" ng-change="file.change = true" ng-model="file.notes"></td>
                        <td ng-show="auth.isAuth()">
                            <button type="button" class="btn save-file-info-btn btn-sm" ng-class="{'btn-success': file.change}"  ng-click="models.product.file3dUpdate(file)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button type="button" class="btn btn-danger remove-file-btn btn-sm" ng-click="models.product.file3dRemove(file, $index)"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </td>
                    </tr>
                    <tr ng-show="auth.isAuth()" >
                        <td>#</td>
                        <td><input type="file" file-model="myFile" multiple/></td>
                        <td style="text-align: center;"><input type="checkbox" ng-model='models.product.file_show' ng-true-value="'true'" ng-false-value="'false'" ng-disabled="true"></td>
                        <td><input class="form-control" type="text" ng-model="models.product.file_notes" ng-disabled="!models.product.allowEdit"></td>
                        <td>
                            <button class="btn btn-success btn-sm" ng-click="uploadFile()" ng-disabled="!models.product.allowEdit">Upload</button>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div id="all-areas" ng-show="models.product.dataLoaded" class="tab-pane">
            <div class="container" style="margin: 0; padding: 14px 0; width: 820px;">

                    <div class="wind_areas" style="display: inline-block;">
                        <div style="margin: 5px; float: left;">Ice thickness:</div>
                        <input type="text" style="width: 50px; margin-top: 5px; float: left;" class="itemInfoInput form-control" ng-model="models.product.ice_thk" ng-change="models.product.changed = true">                        
                        <div style="width: 30px; margin: 5px 0 0 5px; float: left;">{{ units.find('db_product', 'd') || 'nf' }}</div>
                        <button type="button" class="btn btn-info btnCalc" ng-click="models.product.calc_wind_faces()">Initialize</button>                        
                    </div>

                <table class="table table-bordered" style="text-align:center;">
                    <tr>
                        <th rowspan="3" style="width:20px; vertical-align: middle; text-align: center;">#</th>
                        <th colspan="2" rowspan="2" style="width:60px; vertical-align: middle; text-align: center;">Face</th>
                        <th colspan="3" style="width:40px; vertical-align: middle; text-align: center;">Position</th>
                        <th colspan="2" rowspan="1" style="width:70px; vertical-align: middle; text-align: center;">Dimensions</th>
                        <th rowspan="2" style="width:60px; vertical-align: middle; text-align: center;">A_A (P.A.)</th>
                        <th colspan="4" rowspan="2" style="width:60px; vertical-align: middle; text-align: center;">Normal Dir. Vector / Azimuth</th>
                        <th rowspan="3" style="width:80px; vertical-align: middle; text-align: center;">Notes</th>
                        <th rowspan="3" style="width:82px; vertical-align: middle; text-align: center;">Actions</th>
                    </tr>

                    <tr>
                        <th style="text-align: center;">x</th>
                        <th style="text-align: center;">y</th>
                        <th style="text-align: center;">z</th>
                        <th style="text-align: center;">Width</th>
                        <th style="text-align: center;">Height</th>
                    </tr>

                    <tr>
                        <th style="text-align: center;">name</th>                        
                        <th style="text-align: center;">shape</th>
                        <!-- th style="text-align: center;">type</th -->                         
                        <th style="text-align: center;">{{ units.find('db_product', 'd') || 'nf' }}</th>
                        <th style="text-align: center;">{{ units.find('db_product', 'd') || 'nf' }}</th>
                        <th style="text-align: center;">{{ units.find('db_product', 'd') || 'nf' }}</th>
                                               
                        <th style="text-align: center;">{{ units.find('db_product', 'd') || 'nf' }}</th>
                        <th style="text-align: center;">{{ units.find('db_product', 'd') || 'nf' }}</th>
                        <th style="text-align: center;">{{ units.find('db_product', 'd') || 'nf' }}^2</th>
                        <th style="text-align: center;">x</th>
                        <th style="text-align: center;">y</th>
                        <th style="text-align: center;">z</th>
                        <th style="text-align: center;">{{ units.find('db_product', 'angle') || 'nf' }}</th>
                    </tr>


                    <tr ng-repeat="item in models.product.wind_areas">
                        <td>{{ $index + 1 }}</td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.face_name" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td>
                            <select class="form-control" ng-model="item.shape" ng-change="models.product.changed = true;" ng-disabled="!models.product.allowEdit">
                                <option value=""></option>
                                <option value="rectangular">Rectangular</option>
                                <option value="cylindrical">Cylindrical</option>
                                <option value="sphere">Sphere</option>
                            </select>
                        </td>
                        <!-- td></td -->  

                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.px" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.py" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.pz" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.width"  ng-change="models.product.changed = true;" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.height" ng-change="models.product.changed = true;" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.p_a_a"  ng-change="models.product.changed = true;" ng-disabled="!models.product.allowEdit"></td>

                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.ndx" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.ndy" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.ndz" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.azimuth" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>

                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.notes" ng-change="models.product.changed = true" ng-disabled="!models.product.allowEdit"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btnDelete" ng-click="models.product.deleteWA(item.id, $index)" ng-disabled="!models.product.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </td>
                    </tr>

                    <tr>
                        <td>{{models.product.wind_areas.length + 1}}</td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.face_name" ng-disabled="!models.product.allowEdit"></td>
                        <td>
                            <select class="form-control" ng-model="models.product.new_wa.shape" ng-disabled="!models.product.allowEdit">
                                <option value=""></option>
                                <option value="rectangular">Rectangular</option>
                                <option value="cylindrical">Cylindrical</option>
                                <option value="square">Square</option>
                            </select>
                        </td>
                        <!-- td></td -->

                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.px" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.py" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.pz" ng-disabled="!models.product.allowEdit"></td>

                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.width"  ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.height" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.p_a_a"  ng-disabled="!models.product.allowEdit"></td>

                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.ndx" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.ndy" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.ndz" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.azimuth" ng-disabled="!models.product.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.product.new_wa.notes" ng-disabled="!models.product.allowEdit"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm btnAdd"  ng-click="models.product.addWA()" ng-disabled="!models.product.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">

                    <div class="col-md-7">
                        <canvas class="chart chart-line" chart-data="models.product.chart_data" chart-series="models.product.chart_series" chart-labels="models.product.chart_labels"></canvas>
                        <div style="position: absolute; bottom: 17px; left: {{models.product.slider_left}}; width: {{models.product.slider_width}}" ng-show="models.product.sliderShow">
                            <slider ng-model="models.product.slider_value" ng-change="models.product.epaSlider();" min="models.product.slider_min" step="models.product.slider_step" max="models.product.slider_max"></slider>
                        </div>
                    </div>

                    <div class="col-md-5" style="right: 0px;">
                        <div style="left: 95px; top: 205px; position: absolute; transform: translate(-50%,0%); text-align: center;">
                            <div>
                                <span>{{models.product.epa_slider_value}} in.^2</span>
                            </div>
                            <div>
                                <span>EPA</span>
                            </div>
                        </div>

                        <div style="height: 200px; width: 100px; position: relative; top: -50px; left: 30px;">
                            <div class="wind_direction_container" style="transform: rotate({{models.product.slider_value}}deg);">
                                <img style="width: 100%; height: 100%;" src="style/images/wind_arrow_2.png">
                            </div>
                            <div class="ring_container">
                                <img style="width: 100%; height: 100%;" src="style/images/wind_ring_1.png">
                            </div>
                            <div class="arrow_container">
                                <img style="width: 100%; height: 100%;" src="style/images/arrow.png">
                            </div>
                            <div class="epa_cuboid_container">
                                <div class="epa_cuboid" ng-show="models.product.details.geometryShapeType == 'Cuboid'" style="height: {{models.product.plot_height}}px; width: {{models.product.plot_width}}px;"></div>
                                <div class="epa_cuboid" ng-show="models.product.details.geometryShapeType != 'Cuboid'" style="height: 60px; width: 60px; border-radius: 60px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- div class="col-md-4" style="margin-top: 20px;"></div -->

        </div>

        <div id="all-documents" ng-show="models.product.dataLoaded" class="tab-pane">
            <div class="container" style="margin: 0; padding-top: 30px; width: 100%;">
                <div class="list-group" ng-show="models.product.pdf.length">
                    <div class="row fileholder" ng-repeat="pdf in models.product.pdf">
                        <div class="col-md-3">
                            <span style="position: absolute;">{{$index + 1}}</span>
                            <a style="margin-left: 15px; overflow: hidden;" ng-href="documents/product/{{ models.product.details['id'] }}/{{ pdf.filename }}" class="list-group-item" target="_blank">{{ pdf.filename }}</a>
                        </div>
                        <div class="col-md-7">
                            <textarea class="form-control file-notes" style="width: 100%; padding: 5px; height: 42px;" rows="2" ng-model="pdf.note" ng-change="pdf.change = true" ng-disabled="!models.product.allowEdit"></textarea>
                        </div>
                        <div class="col-md-2" ng-show="auth.isAuth()">
                            <button type="button" class="btn save-file-info-btn btn-sm" ng-class="{'btn-success': pdf.change}"  ng-click="models.pdfSave(pdf, 'all')"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button type="button" class="btn btn-danger remove-file-btn btn-sm" ng-click="models.pdfRemove(pdf.id, 'all')"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 10px 0;">
                    </div>
                </div>
                <select style="width: 150px; margin-left: 15px;" class="form-control col-md-2" ng-model="models.product.uploadMode" ng-disabled="!models.product.allowEdit">
                    <option value="browse">Browse</option>
                    <option value="link">Link</option>
                    <option value="drag">Drag and Drop</option>
                </select>
                <div class="col-md-8" style="margin-top: -5px;">
                    <h5 ng-show="models.product.uploadMode == 'browse'">Select files to upload</h5>
                    <h5 ng-show="models.product.uploadMode == 'link'">Place below the web link to a document your want to upload:</h5>
                </div>

                <div ng-show="models.product.uploadMode === 'browse'" style="margin-top: 15px;" class="col-md-12">
                    <form style="height: 130px;" id="upload-pdf">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file" ng-disabled="!models.product.allowEdit">
                                    Browse <input name="pdf" type="file" multiple ng-disabled="!models.product.allowEdit">
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly ng-disabled="!models.product.allowEdit">
                        </div>
                        <!-- span class="help-block">
                            Try selecting one or more files and watch the feedback
                        </span-->
                        <button style="margin-top: -83px;" type="submit" class="btn btn-primary pull-right" ng-disabled="!models.product.allowEdit">Upload</button>
                    </form>
                </div>
                <div ng-show="models.product.uploadMode === 'link'" style="margin-top: 15px;" class="col-md-12">
                    <form style="height: 130px;">
                        <input style="height: 34px;" type="text" class="form-control" placeholder="https://example.com/users/file.txt" ng-model="models.product.pdfUrl">
                        <button style="margin-top: -83px;" ng-click="query.pdfFromUrl('all');" class="btn btn-primary pull-right" ng-disabled="!models.product.allowEdit">Upload</button>
                    </form>
                </div>
                <div ng-show="models.product.uploadMode === 'drag'" style="position: relative; margin-top: 15px;" class="col-md-12">
                    <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif, application/pdf, application/msword, text/plain]" file="models.product.image" file-name="models.product.imageFileName" data-max-file-size="5">
                        <span>Drag and Drop File Here</span>
                    </div>
                    <div class="image-container">
                        <span class="file-name">{{models.product.imageFileName}}</span>
                    </div>
                    <button style="margin-top: -169px;" ng-click="query.fileDragNDrop('all');" class="btn btn-primary pull-right" ng-disabled="!models.product.allowEdit">Upload</button>
                </div>
            </div>
        </div>

        <div id="all-photos" ng-show="models.product.dataLoaded" class="tab-pane">
            <div class="photos-tab-container">
                <div class="photos-input-block">
                    <select class="doc-input-select form-control" ng-model="models.product.uploadModePhotos">
                        <option value="browse">Browse</option>
                        <option value="link">Link</option>
                        <option value="drag">Drag and Drop</option>
                    </select>

                    <div class="doc-input-container">

                        <div ng-show="models.product.uploadModePhotos === 'browse'" class="container-input" >
                            <form style="height: 130px;">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <span class="btn btn-primary btn-file">
                                          Select photo to upload<input type="file" file-model="models.product.photoBrowseFile" file-model-name="models.product.photoBrowseFileName" multiple>
                                      </span>
                                    </span>
                                    <input type="text" class="form-control" ng-model="models.product.photoBrowseFileName" readonly>
                                </div>
                                <button class="btn btn-primary upload-button" ng-click="models.product.uploadPhotoFile();">Upload</button>
                            </form>
                        </div>

                        <div ng-show="models.product.uploadModePhotos === 'link'" class="container-input">
                            <form style="height: 130px;">
                                <input style="height: 34px;" type="text" class="form-control" placeholder="Place here the link for a photo to upload: https://example.com/users/file.jpg" ng-model="models.product.photoUploadURL">
                                <button ng-click="models.product.uploadPhotoFromUrl();" class="btn btn-primary upload-button">Upload</button>
                            </form>
                        </div>

                        <div ng-show="models.product.uploadModePhotos === 'drag'" class="container-input">
                            <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="models.product.photoDragFile" file-name="models.product.photoDragName" data-max-file-size="5">
                                <span>Drag and Drop File Here</span>
                            </div>
                            <div class="image-container">
                                <span class="file-name">{{models.product.photoDragName}}</span>
                            </div>
                            <button ng-click="models.product.uploadPhotoFromDnd();" class="btn btn-primary upload-button">Upload</button>
                        </div>

                    </div>
                </div>
                <div class="photos-list-block">
                    <div class="photo-row" ng-repeat="photo in models.product.photo_list">
                        <div class="photo-image-container">
                            <img src="documents/product/{{ models.product.details['id'] }}/{{ photo.name }}">
                        </div>
                        <div class="info-container">
                            <div class="notes-container">
                                <textarea ng-model="photo.notes" ng-change="photo.change = true;"></textarea>
                            </div>
                            <div class="actions-container">
                                <div class="buttons-container">
                                    <button type="button" class="btn btn-sm" ng-class="{'btn-success': photo.change}"  ng-click="models.product.updatePhotoFile(photo)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="models.product.removePhotoFile(photo, $index)"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="all-spec" ng-show="models.product.dataLoaded" class="tab-pane"> 
        </div>               

    </div>

    <span class="knowledge-center-button glyphicon glyphicon-info-sign" ng-click="showInfo('#product')"></span>
</div>

<div ng-show="models.tabs === 'geometry' || models.tabs === 'site'" class="main-tabs">
    <ul class="nav nav-tabs geometry_list">
        <li class="item active" ng-click="models.geometry.changeGeoTabs('materials');" ng-disabled="!models.geometry.dataLoaded"><a style="padding: 10px 13px;" ng-class="{'selected_tab': models.geometry_tabs == 'materials' }" href="javascript:void(0)" data-target="#geo-materials" data-toggle="tab">Materials</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('sections');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'sections' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-sections" data-toggle="tab">Sections</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('nodes');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'nodes' }" href="javascript:void(0)" data-target="#geo-nodes" data-toggle="tab">Nodes</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('members');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'members' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-members" data-toggle="tab">Members</a></li>
        <!-- li class="item" ng-click="models.geometry.checkDataLoaded(); models.geometry_tabs = 'connectors'" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'connectors' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-connectors" data-toggle="tab">Connectors</a></li -->
        <li class="item" ng-click="models.geometry.changeGeoTabs('connections');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'connections' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-connections" data-toggle="tab">Connections</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('documents');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'documents' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-documents" data-toggle="tab">Documents</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('photos');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'photos' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-photos" data-toggle="tab">Photos</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('association');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'association' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-association" data-toggle="tab">Association</a></li>
        <li class="item" ng-click="models.geometry.changeGeoTabs('analysis');" ng-disabled="!models.geometry.dataLoaded"><a ng-class="{'selected_tab': models.geometry_tabs == 'analysis' }" style="padding: 10px 13px;" href="javascript:void(0)" data-target="#geo-analysis" data-toggle="tab">Analysis</a></li>
    </ul>

    <div class="tab-content">
        <div id="geo-materials" class="tab-pane active" >
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                <h4 class="print-show" style="display: none;">Materials</h4>
                <table class="table table-striped table-bordered">
                    <thead style="text-align:center;">
                        <tr>
                            <th colspan="5" style="text-align: center;">Materials</th>
                            <th width="" style="text-align: center;">E</th>
                            <th width="" style="text-align: center;">Rho</th>
                            <th width="" style="text-align: center;">G</th>
                            <th width="" style="text-align: center;">Nu</th>                            
                            <th width="" style="text-align: center;">f<sub>y</sub></th>
                            <th width="" style="text-align: center;">f<sub>u</sub></th>                            
                            <!-- th width="60">v</th -->
                            <th class="print-hide" rowspan="2" width="90" style="text-align: center; vertical-align: middle; ">Action</th>
                        </tr>
                        <tr>
                            <th width="40" style="text-align: center;">#</th>
                            <th width="80" style="text-align: center;">ORG</th>
                            <th width="80" style="text-align: center;">STD</th>
                            <th width="60" style="text-align: center;">Gr</th>
                            <th width="100" style="text-align: center;">Name</th>
                            <th width="80" style="text-align: center;">{{ units.find('db_geo_mat', 'e') || 'nf' }}</th>
                            <th width="80" style="text-align: center;">{{ units.find('db_geo_mat', 'rho') || 'nf' }}</th>
                            <th width="80" style="text-align: center;">{{ units.find('db_geo_mat', 'g') || 'nf' }}</th>
                            <th width="80" style="text-align: center;">-</th>
                            <th width="80" style="text-align: center;">{{ units.find('db_geo_mat', 'fy') || 'nf' }}</th>
                            <th width="80" style="text-align: center;">{{ units.find('db_geo_mat', 'fu') || 'nf' }}</th>                            
                            <!-- th width="80">{{ units.find('db_material', 'v') || '' }}</th -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in models.geometry.materials" ng-class="{ 'highlight': item.selected }">
                            <td><input type="text" class="form-control" placeholder="$index + 1" ng-value="$index + 1" disabled></td>
                            <td>
                                <select class="form-control" ng-model="item.org" ng-options="org.value as org.value for org in item.orgList" ng-init="item.org = item.orgList[0].value" ng-change="models.geometry.materialChange(item, item, item.org, 'org'); item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                    <!--<option ng-repeat="org in item.orgList" ng-selected="item.org == org.value" value="{{ org.value }}">{{ org.value }}</option>-->
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-options="standard.value as standard.value for standard in item.standardList" ng-model="item.standard" ng-change="models.geometry.materialChange(item, item, item.standard, 'standard'); item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                    <!--<option ng-repeat="standard in item.standardList" ng-selected="item.standard == standard.value" value="{{ standard.value }}">{{ standard.value }}</option>-->
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-options="grade.value as grade.value for grade in item.gradeList" ng-model="item.grade" ng-change="models.geometry.materialChange(item, item, item.grade, 'grade'); item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                    <!--<option ng-repeat="grade in item.gradeList" ng-selected="item.grade == grade.value" value="{{ grade.value }}">{{ grade.value }}</option>-->
                                </select>
                            </td>
                            <td><input type="text" class="form-control" placeholder="Name"  ng-model="item.name" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                            <td><div type="text" class="form-control" placeholder="E"   ng-disabled="!models.geometry.allowEdit">{{item.E | number : 2}}</div></td>
                            <td><div type="text" class="form-control" placeholder="Rho" ng-disabled="!models.geometry.allowEdit">{{item.Rho | number : 2}}</div></td>
                            <td><div type="text" class="form-control" placeholder="G"   ng-disabled="!models.geometry.allowEdit">{{item.G | number : 2}}</div></td>
                            <td><div type="text" class="form-control" placeholder="Nu"   ng-disabled="!models.geometry.allowEdit">{{item.Nu | number : 2}}</div></td>

                            <td><div type="text" class="form-control" placeholder="fy" ng-disabled="!models.geometry.allowEdit">{{item.fy | number : 2}}</div></td>
                            <td><div type="text" class="form-control" placeholder="fu"   ng-disabled="!models.geometry.allowEdit">{{item.fu | number : 2}}</div></td>                            

                            <!-- td><input type="text" class="form-control" placeholder="v" ng-model="item.v"></td -->

                            <td class="text-center print-hide">
                                <button class="btn btn-sm btn-success" ng-class="{ 'disabled': !item.changed }" ng-click="models.geometry.saveMaterial(item)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                <button class="btn btn-sm btn-danger" ng-click="models.geometry.removeMaterial(item.RcdId, $index)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-remove"></span></button>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="text" class="form-control" placeholder="{{models.geometry.materials.length + 1}}" disabled></td>
                            <td>
                                <select class="form-control" ng-init="models.geometry.newMaterial.org = models.geometry.materialsLists.orgList[0].value" ng-model="models.geometry.newMaterial.org" ng-options="org.value as org.value for org in models.geometry.materialsLists.orgList" ng-change="" ng-disabled="!models.geometry.allowEdit">
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-options="standard.value as standard.value for standard in models.geometry.materialsLists.standardList" ng-model="models.geometry.newMaterial.standard" ng-change="models.geometry.materialChange(models.geometry.newMaterial, models.geometry.materialsLists, models.geometry.newMaterial.standard, 'standard');" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                    <!--<option ng-repeat="standard in selected.material.standardList" value="{{ standard.value }}">{{ standard.value }}</option>-->
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-options="grade.value as grade.value for grade in models.geometry.materialsLists.gradeList" ng-model="models.geometry.newMaterial.grade" ng-change="models.geometry.materialChange(models.geometry.newMaterial, models.geometry.materialsLists, models.geometry.newMaterial.grade, 'grade');" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                    <!--<option ng-repeat="grade in selected.material.gradeList" value="{{ grade.value }}">{{ grade.value }}</option>-->
                                </select>
                            </td>
                            <td><input type="text" class="form-control" placeholder="" ng-model="models.geometry.newMaterial.name" ng-change="" ng-disabled="!models.geometry.allowEdit"></td>
                            <td><input type="text" class="form-control" placeholder="" i-number-format="models.geometry.newMaterial.E" ng-model="models.geometry.newMaterial.E" ng-change="onChange(item,'material')" ng-disabled="!models.geometry.allowEdit"></td>
                            <td><input type="text" class="form-control" placeholder="" i-number-format="models.geometry.newMaterial.Rho" ng-model="models.geometry.newMaterial.Rho" ng-change="onChange(item,'material')" ng-disabled="!models.geometry.allowEdit"></td>
                            <td><input type="text" class="form-control" placeholder="" i-number-format="models.geometry.newMaterial.G" ng-model="models.geometry.newMaterial.G" ng-change="onChange(item,'material')" ng-disabled="!models.geometry.allowEdit"></td>
                            <td><input type="text" class="form-control" placeholder="" i-number-format="models.geometry.newMaterial.Nu" ng-model="models.geometry.newMaterial.Nu" ng-change="onChange(item,'material')" ng-disabled="!models.geometry.allowEdit"></td>
                            
                            <td><input type="text" class="form-control" placeholder="" i-number-format="models.geometry.newMaterial.fy" ng-model="models.geometry.newMaterial.fy" ng-change="onChange(item,'material')" ng-disabled="!models.geometry.allowEdit"></td>
                            <td><input type="text" class="form-control" placeholder="" i-number-format="models.geometry.newMaterial.fu" ng-model="models.geometry.newMaterial.fu" ng-change="onChange(item,'material')" ng-disabled="!models.geometry.allowEdit"></td>
                            <!-- td><input type="text" class="form-control" placeholder="v" ng-model="material.create.v"></td -->
                            <td class="print-hide" style="padding: 1px 8px;"><button class="btn btn-sm btn-block btn-success" ng-click="models.geometry.addMaterial()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span> Add</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="geo-nodes" class="tab-pane" style="position: absolute;">
            <div ng-show="models.geometry.dataLoaded" style="position: fixed; width: 35px;">
                <ul class="nav nav-tabs tabs-left vertical-text">
                    <li class="item" ng-click="models.nodes_tabs = 'parameters'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': models.nodes_tabs == 'parameters' }" href="javascript:void(0)" data-target="#node-parameters" data-toggle="tab">Parameters</a></li>
                    <li class="item active" ng-click="models.nodes_tabs = 'listing'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': models.nodes_tabs == 'listing' }" href="javascript:void(0)" data-target="#node-listing" data-toggle="tab">Listing</a></li>
                </ul>
            </div>
            <div class="tab-content" style="position: relative; left: 35px; width: calc(100% - 40px); overflow-x: visible;">
                <div id="node-listing" class="container tab-pane active" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%; text-align: center; overflow: visible;">
                    <div class="node-scroll-container">
                        <table class="table table-bordered table-hover">
                            <tr style="vertical-align: middle;">
                                <th rowspan="2" width="30px" style="vertical-align: middle; text-align: center;">#</th>
                                <th rowspan="2" width="80px" style="vertical-align: middle; text-align: center;">Name</th>
                                <th width="70px" style="text-align: center;">x</th>
                                <th width="70px" style="text-align: center;">y</th>
                                <th width="70px" style="text-align: center;">z</th>
                                <!-- th rowspan="2" width="80px" style="vertical-align: middle; text-align: center;">Notes</th -->
                                <th rowspan="2" width="90px" style="vertical-align: middle; text-align: center;">Actions</th>

                                <th colspan="2"  width="100px" style="text-align: center;">Base</th>
                                <th colspan="4"  width="150px" style="text-align: center;">Delta</th>
                            </tr>

                            <tr>
                                <th width="50px" style="text-align: center;">{{ units.find('db_geo_node', 'xyz') || 'nf' }}</th>
                                <th width="50px" style="text-align: center;">{{ units.find('db_geo_node', 'xyz') || 'nf' }}</th>
                                <th width="50px" style="text-align: center;">{{ units.find('db_geo_node', 'xyz') || 'nf' }}</th>
                                <th width="80px" style="text-align: center;">Node</th>
                                <th width="50px" style="text-align: center;">roty</th>                                
                                <th width="70px" style="text-align: center;">dx</th>
                                <th width="70px" style="text-align: center;">dy</th>
                                <th width="70px" style="text-align: center;">dz</th>
                                <th width="50px" style="text-align: center;">roty</th>
                            </tr>

                            <tr ng-repeat="item in models.geometry.nodes" ng-class="{ 'highlight': item.selected }">
                                <td>{{ $index + 1 }}</td>

                                <td><input type="text" class="itemInfoInput form-control" ng-model="item.node_name" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><div class="itemInfoInput form-control">{{item.x | number:4}}</div></td>
                                <td><div class="itemInfoInput form-control">{{item.y | number:4}}</div></td>
                                <td><div class="itemInfoInput form-control">{{item.z | number:4}}</div></td>
                                <!-- td><input type="text" class="itemInfoInput form-control" ng-model="item.notes" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td -->
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm btnSave" ng-class="{ 'disabled': !item.changed }" ng-click="models.geometry.saveNode(item)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                    <button type="button" class="btn btn-danger btn-sm btnDelete" ng-click="models.geometry.removeNode(item.no, $index)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                                </td>
                                <td>
                                    <select type="text" class="itemInfoInput form-control" ng-model="item.base_node" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                        <option value="0"></option>
                                        <option ng-repeat="node in models.geometry.nodes" ng-if="node.no != item.no" value="{{node.no}}">{{node.node_name}}</option>
                                    </select>
                                </td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="item.rot_y_n" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>

                                <td style="position: relative;"><input type="text" class="itemInfoInput formula-input form-control" ng-model="item.x_f" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td style="position: relative;"><input type="text" class="itemInfoInput formula-input form-control" ng-model="item.y_f" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td style="position: relative;"><input type="text" class="itemInfoInput formula-input form-control" ng-model="item.z_f" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="item.rot_y_f" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                            </tr>

                            <tr>
                                <td>{{ models.geometry.nodes.length + 1 }}</td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes.add.node_name" placeholder="N{{ models.geometry.nodes.length + 1 }}" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><div class="itemInfoInput form-control">x</div></td>
                                <td><div class="itemInfoInput form-control">y</div></td>
                                <td><div class="itemInfoInput form-control">z</div></td>
                                <!-- td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes.add.notes" placeholder="" ng-disabled="!models.geometry.allowEdit"></td -->
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm btnAdd" ng-click="models.geometry.addNode()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                                    <button type="button" name="paste node data" class="btn btn-success btn-sm" ng-click="models.geometry.insertNodeModal = true" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-envelope"></span></button>
                                </td>
                                <td>
                                    <select type="text" class="itemInfoInput form-control" ng-model="models.nodes.add.base_node" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                        <option value="0"></option>
                                        <option ng-repeat="node in models.geometry.nodes" value="{{node.no}}">{{node.node_name}}</option>
                                    </select>
                                </td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes.add.rot_y_n" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>

                                <td style="position: relative;"><input type="text" class="itemInfoInput formula-input form-control" ng-model="models.nodes.add.x_f" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>
                                <td style="position: relative;"><input type="text" class="itemInfoInput formula-input form-control" ng-model="models.nodes.add.y_f" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>
                                <td style="position: relative;"><input type="text" class="itemInfoInput formula-input form-control" ng-model="models.nodes.add.z_f" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes.add.rot_y_f" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div id="node-parameters" class="container tab-pane" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 15px 0 0 0; width: 100%; text-align: left; overflow: visible;">
                    <div class="node-scroll-container">
                        <h4 style="margin-top: 0px;">Define parameters</h4>
                        <table class="table table-bordered table-hover">
                            <tr style="vertical-align: middle;">
                                <th rowspan="2" width="30px" style="vertical-align: middle; text-align: center;">#</th>
                                <th rowspan="2" width="100px" style="vertical-align: middle; text-align: center;">Name</th>
                                <th width="50px" style="text-align: center;">Value</th>
                                <th rowspan="2" width="150px" style="vertical-align: middle; text-align: center;">Notes</th>

                                <th rowspan="2" width="90px" style="vertical-align: middle; text-align: center;">Actions</th>

                                <th rowspan="2" width="50px" style="vertical-align: middle; text-align: center;">Section</th>
                                <th rowspan="2" width="50px" style="vertical-align: middle; text-align: center;">Dim</th>
                                <th width="50px" style="text-align: center;">Value</th>

                                <th rowspan="2" width="100px" style="vertical-align: middle; text-align: center;">
                                    <img src="assets/img/Calculator-icon.png" alt="operation" style="height: 40px;">
                                </th>
                            </tr>

                            <tr style="vertical-align: middle;">
                                <th width="50px" style="text-align: center;">{{ units.find('db_geo_node', 'xyz') || 'nf' }}</th>

                                <th width="50px" style="text-align: center;">{{ units.find('db_geo_node', 'xyz') || 'nf' }}</th>
                            </tr>

                            <tr ng-repeat="item in models.geometry.nodes_p">
                                <td>{{ $index + 1 }}</td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="item.name" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="item.value" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="item.notes" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm btnSave" ng-class="{ 'disabled': !item.changed }" ng-click="models.geometry.saveNodeP(item)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                    <button type="button" class="btn btn-danger btn-sm btnDelete" ng-click="models.geometry.removeNodeP(item.id, $index)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                                </td>

                                <td>
                                    <select class="form-control" title="sec_name" ng-model="item.sec_name" ng-change="item.changed = true; models.geometry.changeSection(item);" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                        <option ng-repeat="sec in models.geometry.secs" value="{{ sec.sec_name }}">{{ sec.sec_name }}</option>
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" title="sec_dim" ng-model="item.sec_dim" ng-change="item.changed = true; models.geometry.changeDim(item);" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                        <option ng-repeat="dim in item.sec_dim_list" value="{{dim.name}}">{{dim.name}}</option>
                                    </select>
                                </td>

                                <td>
                                    <div type="text" class="form-control" ng-disabled="!models.geometry.allowEdit">{{item.sec_dim_val}}</div>
                                </td>

                                <td style="position: relative;">
                                    <input type="text" class="itemInfoInput formula-input form-control" ng-model="item.value_formula" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                </td>

                            </tr>

                            <tr>
                                <td>{{ models.geometry.nodes_p.length + 1 }}</td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes_p.add.name" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes_p.add.value" ng-disabled="!models.geometry.allowEdit"></td>
                                <td><input type="text" class="itemInfoInput form-control" ng-model="models.nodes_p.add.notes" ng-disabled="!models.geometry.allowEdit"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm btnAdd" ng-click="models.geometry.addNodeP()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                                </td>

                                <td>
                                    <select class="form-control" title="sec_name" ng-model="models.nodes_p.add.sec_no" ng-change="models.geometry.changeSection(models.nodes_p.add);" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                        <option ng-repeat="sec in models.geometry.secs" value="{{ sec.no }}">{{ sec.sec_name }}</option>
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control" title="sec_dim" ng-model="models.nodes_p.add.sec_dim" ng-change="models.geometry.changeDim(models.nodes_p.add);" ng-disabled="!models.geometry.allowEdit">
                                        <option value=""></option>
                                        <option ng-repeat="dim in models.nodes_p.add.sec_dim_list" value="{{dim.name}}">{{dim.name}}</option>
                                    </select>
                                </td>

                                <td>
                                    <div type="text" class="form-control" ng-disabled="!models.geometry.allowEdit">{{models.nodes_p.add.sec_dim_val}}</div>
                                </td>

                                <td style="position: relative;">
                                    <input type="text" class="itemInfoInput formula-input form-control" ng-model="models.nodes_p.add.value_formula" ng-disabled="!models.geometry.allowEdit">
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="geo-sections" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                <!-- h4>Sections of the Geometry</h4 -->
                <table class="table table-bordered table-hover">
                    <tr>
                        <th rowspan="2" width="30px" style="text-align: center;">#</th>
                        <th rowspan="2" width="80px" style="text-align: center;">Name</th>
                        <th rowspan="2" width="100px" style="text-align: center;">Shape</th>

                        <th rowspan="1" width="120px" style="text-align: center;">Size1</th>
                        <th rowspan="1" width="180px" style="text-align: center;">Size2</th>

                        <th rowspan="2" width="100px" style="text-align: center;">Materials</th>
                        <th width="90px" style="text-align: center;">A</th>
                        <th width="90px" style="text-align: center;">I<sub>yy<sub></th>
                        <th width="90px" style="text-align: center;">I<sub>zz<sub></th>
                        <th width="90px" style="text-align: center;">J</th>
                                                                                                
                        <th rowspan="2" width="90px"  style="text-align: center;">Actions</th>
                    </tr>

                    <tr>
                        <th width="" style="text-align: center;">- / {{ units.find('db_geo_sec', 'size1') || 'nf' }}</th>
                        <th width="" style="text-align: center;">- / {{ units.find('db_geo_sec', 'size2') || 'nf' }}</th>
                        <th width="" style="text-align: center;">{{ units.find('db_geo_sec', 'A') || 'nf' }}</th>
                        <th width="" style="text-align: center;">{{ units.find('db_geo_sec', 'Iyy') || 'nf' }}</th>
                        <th width="" style="text-align: center;">{{ units.find('db_geo_sec', 'Izz') || 'nf' }}</th>
                        <th width="" style="text-align: center;">{{ units.find('db_geo_sec', 'J') || 'nf' }}</th>
                    </tr>                        

                    <tr ng-repeat="item in models.geometry.secs" ng-class="{ 'highlight': item.selected }">
                        <td>{{ $index + 1 }}</td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.sec_name" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        <td>
                            <select class="itemInfoInput form-control shapesDdl forward-size" ng-model="item.shape" ng-change="item.changed = true; models.geometry.sectionChange(item, item, item.shape, 'shape');" ng-options="shape.value as shape.value for shape in item.shapeList" ng-disabled="!models.geometry.allowEdit">
                                <option></option>
                            </select>
                        </td>

                        <td>
                            <select class="itemInfoInput form-control shapesDdl forward-size" ng-options="size1.value as size1.value for size1 in item.size1List" ng-if="item.shape !== 'SR' && item.shape !== 'Plate'" ng-model="item.size1" ng-change="item.changed = true; models.geometry.sectionChange(item, item, item.size1, 'size_1');" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                           </select>
                            <input type="text" name="size1" class="form-control" ng-if="item.shape === 'SR' || item.shape === 'Plate'" ng-model="item.size1" ng-change="item.changed = true; models.geometry.sectionChange(item, item, item.size1, 'size_1');" ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td>
                            <select class="itemInfoInput form-control shapesDdl forward-size" ng-options="size2.value as size2.value for size2 in item.size2List" ng-if="item.shape !== 'Plate'" ng-model="item.size2" ng-change="item.changed = true; models.geometry.sectionChange(item, item, item.size2, 'size_2');" ng-disabled="!models.geometry.allowEdit || item.shape === 'SR'">
                                <option value=""></option>
                            </select>
                            <input type="text" name="size2" class="form-control" ng-if="item.shape === 'Plate'" ng-model="item.size2" ng-change="item.changed = true; models.geometry.sectionChange(item, item, item.size2, 'size_2');" ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td>
                            <select class="form-control" ng-model="item.mat" ng-options="material.name as material.name for material in models.geometry.materials" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.A" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.Iyy" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.Izz" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.J" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        
                        <!-- td class="text-center" ng-show="base.auth.isAuth()" -->
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm btnSave" ng-class="{ 'disabled': !item.changed }" ng-click="models.geometry.saveSec(item)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button type="button" class="btn btn-danger btn-sm btnDelete" ng-click="models.geometry.removeSec(item.no, $index)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>{{models.geometry.secs.length + 1}}</td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.secs.add.sec_name" placeholder="S{{models.geometry.secs.length + 1}}" ng-disabled="!models.geometry.allowEdit"></td>
                        <td>
                            <select class="itemInfoInput form-control shapesDdl" ng-model="models.secs.add.shape" ng-change="models.geometry.sectionChange(models.secs.add, models.geometry.shapesList, models.secs.add.shape, 'shape');" ng-options="shape.value as shape.value for shape in models.geometry.shapesList.shapeList" ng-disabled="!models.geometry.allowEdit">
                                <option></option>
                            </select>
                        </td>
                        <td>
                            <select class="itemInfoInput form-control shapesDdl forward-size" ng-options="size1.value as size1.value for size1 in models.geometry.shapesList.size1List" ng-if="models.secs.add.shape !== 'SR' && models.secs.add.shape !== 'Plate'" ng-model="models.secs.add.size1" ng-disabled="!models.geometry.allowEdit" ng-change="models.geometry.sectionChange(models.secs.add, models.geometry.shapesList, models.secs.add.size1, 'size_1');">
                                <option value=""></option>
                            </select>
                            <input type="text" name="size1" class="form-control" ng-if="models.secs.add.shape === 'SR' || models.secs.add.shape === 'Plate'" ng-model="models.secs.add.size1" ng-change=" models.geometry.sectionChange(models.secs.add, models.geometry.shapesList, models.secs.add.size1, 'size_1');" ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td>
                            <select class="itemInfoInput form-control shapesDdl forward-size" ng-options="size2.value as size2.value for size2 in models.geometry.shapesList.size2List" ng-if="models.secs.add.shape !== 'Plate'" ng-model="models.secs.add.size2" ng-disabled="!models.geometry.allowEdit || models.secs.add.shape === 'SR'" ng-change="models.geometry.sectionChange(models.secs.add, models.geometry.shapesList, models.secs.add.size2, 'size_2');">
                                <option value=""></option>
                            </select>
                            <input type="text" name="size2" class="form-control" ng-if="models.secs.add.shape === 'Plate'" ng-model="models.secs.add.size2" ng-change="models.geometry.sectionChange(models.secs.add, models.geometry.shapesList, models.secs.add.size2, 'size_2');" ng-disabled="!models.geometry.allowEdit">
                        </td>
                        <td>
                            <select class="form-control" ng-model="models.secs.add.mat" ng-options="material.name as material.name for material in models.geometry.materials" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.secs.add.A" placeholder="area" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.secs.add.Iyy" placeholder="moi w.r.t y" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.secs.add.Izz" placeholder="moi w.r.t z" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.secs.add.J" placeholder="J" ng-disabled="!models.geometry.allowEdit"></td>
                        
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm btnAdd" ng-click="models.geometry.addSec()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="geo-members" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                <!-- h4>Geometry members</h4 -->
                <table class="table table-bordered table-hover" style="text-align:center;">
                    <tr>
                        <th rowspan="2" style="width:40px; vertical-align: middle; text-align: center;">#</th>
                        <th rowspan="2" style="width:100px; vertical-align: middle; text-align: center;">Name</th>
                        <th rowspan="2" style="width:80px; vertical-align: middle; text-align: center;">Section</th>
                        <th rowspan="2" style="width:100px; vertical-align: middle; text-align: center;">Materials</th>
                        <th rowspan="2" style="width:50px; vertical-align: middle; text-align: center;">Face</th>
                        <th rowspan="2" style="width:80px; vertical-align: middle; text-align: center;">NodeI</th>
                        <th rowspan="2" style="width:80px; vertical-align: middle; text-align: center;">NodeJ</th>
                        <th rowspan="2" style="width:80px; vertical-align: middle; text-align: center;">NodeK</th>
                        <th style="width:80px" style="text-align: center;">Length</th>                        
                        <th style="width:60px" style="text-align: center;">rotx</th>
                        <th rowspan="2" style="width:80px; vertical-align: middle; text-align: center;">Notes</th>
                        <th rowspan="2" style="width:100px; vertical-align: middle; text-align: center;">Actions</th>
                    </tr>

                    <tr>
                        <th style="text-align: center;">{{ units.find('db_geo_mbr', 'length') || 'nf' }}</th>                        
                        <th style="text-align: center;">{{ units.find('db_geo_mbr', 'rot') || 'nf' }}</th>
                    </tr>

                    <tr ng-repeat="item in models.geometry.members" ng-class="{ 'highlight': item.selected }">
                        <!--td>{{ item.no }}</td -->
                        <td>{{ $index + 1 }}</td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.Mbr_Name" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        <td>
                            <select class="form-control" title="sec_name" ng-model="item.sec_name" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-repeat="sec in models.geometry.secs" ng-selected="item.sec_name == sec.sec_name" value="{{ sec.sec_name }}">{{ sec.sec_name }}</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" ng-model="item.Mat" ng-options="material.name as material.name for material in models.geometry.materials" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" title="Face" ng-model="item.Face" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>                                
                            </select>
                        </td>
                        <td>
                            <!--<input type="text" class="itemInfoInput form-control" ng-model="item.NodeS">-->
                            <select class="form-control" title="NodeS" ng-model="item.NodeS" ng-change="item.changed = true; models.geometry.memberNodesChange(item, 'NodeS');" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-repeat="nodes in models.geometry.nodes" ng-selected="item.NodeS == nodes.no" value="{{ nodes.no }}">{{ nodes.node_name }}</option>
                            </select>
                        </td>
                        <td>
                            <!--<input type="text" class="itemInfoInput form-control" ng-model="item.NodeE">-->
                            <select class="form-control" title="NodeE" ng-model="item.NodeE" ng-change="item.changed = true; models.geometry.memberNodesChange(item, 'NodeE');" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-repeat="nodes in models.geometry.nodes" ng-selected="item.NodeE == nodes.no" value="{{ nodes.no }}">{{ nodes.node_name }}</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" title="NodeS" ng-model="item.NodeO" ng-change="item.changed = true; models.geometry.calculateRotation(item);" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-if="nodes.no != item.NodeE && nodes.no != item.NodeS" ng-repeat="nodes in models.geometry.nodes" ng-selected="item.NodeO == nodes.no" value="{{ nodes.no }}">{{ nodes.node_name }}</option>
                            </select>
                        </td>
                        <!-- td><div type="text" class="itemInfoInput form-control" ng-disabled="!models.geometry.allowEdit">{{item.Mbr_Lth | number : 2}}</div></td -->                        
                        <td><div type="text" class="itemInfoInput form-control" disabled>{{item.Mbr_Lth | number : 2}}</div></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.ROT" ng-change="item.changed = true; item.NodeO = '';" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="item.Note_G" ng-change="item.changed = true" ng-disabled="!models.geometry.allowEdit"></td>
                        <!-- td class="text-center" ng-show="base.auth.isAuth()" -->
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm btnSave" ng-class="{ 'disabled': !item.changed }" ng-click="models.geometry.saveMember(item)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button type="button" class="btn btn-danger btn-sm btnDelete" ng-click="models.geometry.removeMember(item.no, $index)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </td>
                    </tr>

                    <!-- tr ng-show="base.auth.isAuth()" -->
                    <tr>
                        <td>{{models.geometry.members.length + 1}}</td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.add.Mbr_Name" placeholder="M{{models.geometry.members.length + 1}}" ng-disabled="!models.geometry.allowEdit"></td>
                        <td>
                            <select class="form-control" title="NodeS" ng-model="models.add.sec_name" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-repeat="sec in models.geometry.secs" value="{{ sec.sec_name }}">{{ sec.sec_name }}</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" ng-model="models.add.Mat" ng-options="material.name as material.name for material in models.geometry.materials" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td>
                            <!-- input type="text" class="itemInfoInput form-control" ng-model="models.add.Face" placeholder="Face" -->
                            <select class="form-control" title="Face" ng-model="models.add.Face" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>                               
                            </select>
                        </td>
                        <td>
                            <select class="form-control" title="NodeS" ng-model="models.add.NodeS" ng-change="models.geometry.memberNodesChange(models.add, 'NodeS');" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-repeat="nodes in models.geometry.nodes" value="{{ nodes.no }}">{{ nodes.node_name }}</option>
                            </select>                            
                        </td>

                        <td>
                            <select class="form-control" title="NodeE" ng-model="models.add.NodeE" ng-change="models.geometry.memberNodesChange(models.add, 'NodeE');" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-repeat="nodes in models.geometry.nodes" value="{{ nodes.no }}">{{ nodes.node_name }}</option>
                            </select>                            
                        </td>
                        <td>
                            <select class="form-control" title="NodeS" ng-model="models.add.NodeO" ng-change="item.changed = true; models.geometry.calculateRotation(models.add);" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                                <option ng-if="nodes.no != models.add.NodeE && nodes.no != models.add.NodeS" ng-repeat="nodes in models.geometry.nodes" value="{{ nodes.no }}">{{ nodes.node_name }}</option>
                            </select>
                        </td>
                        <td>
                             <!-- input type="text" class="itemInfoInput form-control" ng-model="models.add.Mbr_Lth" placeholder="" ng-disabled="!models.geometry.allowEdit" -->
                             <input type="text" class="itemInfoInput form-control" ng-model="models.add.Mbr_Lth" placeholder="" disabled>                             
                        </td>                        
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.add.ROT" ng-change="models.add.NodeO = '';" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>
                        <td><input type="text" class="itemInfoInput form-control" ng-model="models.add.Note_G" placeholder="" ng-disabled="!models.geometry.allowEdit"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm btnAdd"  ng-click="models.geometry.addMember()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                            <button type="button" name="insert new member" class="btn btn-success btn-sm" ng-click="models.geometry.insertMemberModal = true" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-envelope"></span></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="geo-documents" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding-top: 30px; width: 100%;">
                <div class="list-group" ng-show="models.geometry.pdf.length">
                    <div class="row fileholder" ng-repeat="pdf in models.geometry.pdf">
                        <div class="col-md-3">
                            <span style="position: absolute;">{{$index + 1}}</span>
                            <a style="margin-left: 15px; overflow: hidden;" ng-href="documents/geometry/{{ models.geometry.details[0]['id'] }}/{{ pdf.filename }}" class="list-group-item" target="_blank">{{ pdf.filename }}</a>
                        </div>
                        <div class="col-md-7">
                            <textarea class="form-control file-notes" style="width: 100%; padding: 5px; height: 42px;" rows="2" ng-model="pdf.note" ng-change="pdf.change = true" ng-disabled="!models.geometry.allowEdit"></textarea>
                        </div>
                        <div class="col-md-2" ng-show="auth.isAuth()">
                            <button type="button" class="btn save-file-info-btn btn-sm" ng-class="{'btn-success': pdf.change}" ng-click="models.pdfSave(pdf, 'geometry')" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button type="button" class="btn btn-danger remove-file-btn btn-sm" ng-click="models.pdfRemove(pdf.id, 'geometry')" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 10px 0;">
                    </div>
                </div>
                <select style="width: 150px; margin-left: 15px;" class="form-control col-md-2" ng-model="models.geometry.uploadMode" ng-disabled="!models.geometry.allowEdit">
                    <option value="browse">Browse</option>
                    <option value="link">Link</option>
                    <option value="drag">Drag and Drop</option>
                </select>
                <div class="col-md-8" style="margin-top: -5px;">
                    <h5 ng-show="models.geometry.uploadMode == 'browse'">Select files to upload</h5>
                    <h5 ng-show="models.geometry.uploadMode == 'link'">Place below the web link to a document your want to upload:</h5>
                </div>
                <div style="margin-top: 15px;" ng-show="models.geometry.uploadMode === 'browse'" class="col-md-12">
                    <form style="height: 130px;" id="upload-pdf">
                        <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                                Browse <input name="pdf" type="file" multiple ng-disabled="!models.geometry.allowEdit">
                            </span>
                        </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <button type="submit" style="margin-top: -83px;" class="btn btn-primary pull-right" ng-disabled="!models.geometry.allowEdit">Upload</button>
                    </form>
                </div>
                <div style="margin-top: 15px;" ng-show="models.geometry.uploadMode === 'link'" class="col-md-12">
                    <form style="height: 130px;">
                        <input style="height: 34px;" type="text" class="form-control" placeholder="https://example.com/users/file.txt" ng-model="models.product.pdfUrl">
                        <button style="margin-top: -83px;"  ng-click="query.pdfFromUrl('geometry');" class="btn btn-primary pull-right" ng-disabled="!models.geometry.allowEdit">Upload</button>
                    </form>
                </div>
                <div ng-show="models.geometry.uploadMode === 'drag'" style="position: relative; margin-top: 15px;" class="col-md-12">
                    <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif, application/pdf, application/msword, text/plain]" file="models.geometry.image" file-name="models.geometry.imageFileName" data-max-file-size="5">
                        <span>Drag & Drop File Here</span>
                    </div>
                    <div class="image-container">
                        <span class="file-name">{{models.geometry.imageFileName}}</span>
                    </div>
                    <button style="margin-top: -169px;" ng-click="query.fileDragNDrop('geometry');" class="btn btn-primary pull-right" ng-disabled="!models.geometry.allowEdit">Upload</button>
                </div>
            </div>
        </div>

        <div id="geo-photos" ng-show="models.geometry.dataLoaded" class="tab-pane">
            <div class="photos-tab-container">
                <div class="photos-input-block">
                    <select class="doc-input-select form-control" ng-model="models.geometry.uploadModePhotos">
                        <option value="browse">Browse</option>
                        <option value="link">Link</option>
                        <option value="drag">Drag and Drop</option>
                    </select>

                    <div class="doc-input-container">

                        <div ng-show="models.geometry.uploadModePhotos === 'browse'" class="container-input" >
                            <form style="height: 130px;">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <span class="btn btn-primary btn-file">
                                          Select photo to upload<input type="file" file-model="models.geometry.photoBrowseFile" file-model-name="models.geometry.photoBrowseFileName" multiple>
                                      </span>
                                    </span>
                                    <input type="text" class="form-control" ng-model="models.geometry.photoBrowseFileName" readonly>
                                </div>
                                <button class="btn btn-primary upload-button" ng-click="models.geometry.uploadPhotoFile();">Upload</button>
                            </form>
                        </div>

                        <div ng-show="models.geometry.uploadModePhotos === 'link'" class="container-input">
                            <form style="height: 130px;">
                                <input style="height: 34px;" type="text" class="form-control" placeholder="Place here the link for a photo to upload: https://example.com/users/file.jpg" ng-model="models.geometry.photoUploadURL">
                                <button ng-click="models.geometry.uploadPhotoFromUrl();" class="btn btn-primary upload-button">Upload</button>
                            </form>
                        </div>

                        <div ng-show="models.geometry.uploadModePhotos === 'drag'" class="container-input">
                            <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="models.geometry.photoDragFile" file-name="models.geometry.photoDragName" data-max-file-size="5">
                                <span>Drag and Drop File Here</span>
                            </div>
                            <div class="image-container">
                                <span class="file-name">{{models.geometry.photoDragName}}</span>
                            </div>
                            <button ng-click="models.geometry.uploadPhotoFromDnd();" class="btn btn-primary upload-button">Upload</button>
                        </div>

                    </div>
                </div>
                <div class="photos-list-block">
                    <div class="photo-row" ng-repeat="photo in models.geometry.photo_list">
                        <div class="photo-image-container">
                            <img src="documents/geometry/{{ models.geometry.details[0]['id'] }}/{{ photo.name }}">
                        </div>
                        <div class="info-container">
                            <div class="notes-container">
                                <textarea ng-model="photo.notes" ng-change="photo.change = true;"></textarea>
                            </div>
                            <div class="actions-container">
                                <div class="buttons-container">
                                    <button type="button" class="btn btn-sm" ng-class="{'btn-success': photo.change}"  ng-click="models.geometry.updatePhotoFile(photo)"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="models.geometry.removePhotoFile(photo, $index)"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- div id="geo-connectors" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                Later - connectors for geometry memebrs.
            </div>
        </div -->

        <div id="geo-connections" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                <div>
                    <h4>Add Connectors</h4>
                    <table class="table table-bordered connectors-table" style="margin: 0; width: 100%;">
                        <tr>
                            <th width="20px"  rowspan="3">#</th>
                            <th width="80px"  rowspan="3">Name</th>
                            <th width="80px"  rowspan="3">Type</th>
                            <th width="80px"  rowspan="3">Material</th>
                            <th width="50px" rowspan="2">Size</th>
                            <th width="30px" rowspan="3">Qty.</th>
                            <th width="80px"  rowspan="3">BCs</th>
                            <th width="200px" rowspan="1" colspan="4" style="text-align: center;">Strength, kips</th>
                            <th width="50px"  rowspan="3">Notes</th>
                            <th width="90px"  rowspan="3">Action</th>
                        </tr>
                        <tr>
                            <th colspan="2">Tension</th>
                            <th colspan="2">Shear</th>
                        </tr>
                        <tr>
                            <th>in.</th>
                            <th>ASD</th>
                            <th>LRFD</th>
                            <th>ASD</th>
                            <th>LRFD</th>
                        </tr>
                        <tr ng-repeat="list in models.geometry.connectors track by $index">
                            <td>{{$index + 1}}</td>
                            <td><input class="form-control" ng-model="list.name" ng-change="list.change = true;" ng-disabled="!models.geometry.allowEdit" ng-change="list.change = true;"></td>
                            <td>
                                <select title="type" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.type" ng-change="list.change = true;">
                                    <option value="ubolts">U-bolts</option>
                                    <option value="bolts">Bolts</option>
                                    <option value="welds">Welds</option>
                                </select>
                            </td>
                            <td>
                                <select title="material" class="form-control" ng-options="material.name as material.name for material in models.geometry.materials" ng-disabled="!models.geometry.allowEdit" ng-model="list.material" ng-change="list.change = true;">
                                </select>
                            </td>
                            <td><input type="text" title="size" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.size" ng-change="list.change = true;"></td>
                            <td><input type="text" title="quantity" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.quantity" ng-change="list.change = true;"></td>
                            <td>
                                <select title="designation" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.designation" ng-change="list.change = true;">
                                    <option value="pinned">Pinned</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </td>
                            <td><input type="text" title="tension asd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.tension_asd" ng-change="list.change = true;"></td>
                            <td><input type="text" title="tension lrfd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.tension_lrfd" ng-change="list.change = true;"></td>
                            <td><input type="text" title="shear asd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.shear_asd" ng-change="list.change = true;"></td>
                            <td><input type="text" title="shear lrfd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.shear_lrfd" ng-change="list.change = true;"></td>
                            <td><input type="text" title="notes" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="list.notes" ng-change="list.change = true;"></td>
                            <td class="text-center">
                                <button class="btn btn-sm" ng-class="{'btn-success': list.change}" ng-click="models.geometry.saveConnector(list)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk" ></span></button>
                                <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeConnector($index, list.id)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{models.geometry.connectors.length + 1}}</td>
                            <td><input type="text" title="name" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.name"></td>
                            <td>
                                <select title="type" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.type">
                                    <option value="ubolts">U-bolts</option>
                                    <option value="bolts">Bolts</option>
                                    <option value="welds">Welds</option>
                                </select>
                            </td>
                            <td>
                                <select title="material" class="form-control" ng-options="material.name as material.name for material in models.geometry.materials" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.material">
                                </select>
                            </td>
                            <td><input type="text" title="size" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.size"></td>
                            <td><input type="text" title="quantity" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.quantity"></td>
                            <td>
                                <select title="designation" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.designation">
                                    <option value="pinned">Hinged</option>
                                    <option value="fixed">Moment</option>
                                </select>
                            </td>
                            <td><input type="text" title="tension asd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.tension_asd"></td>
                            <td><input type="text" title="tension lrfd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.tension_lrfd"></td>
                            <td><input type="text" title="shear asd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.shear_asd"></td>
                            <td><input type="text" title="shear lrfd" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.shear_lrfd"></td>
                            <td><input type="text" title="notes" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="models.geometry.newConnector.notes"></td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm" ng-click="models.geometry.addConnector()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h4>Define Connections</h4>
                    <table class="table table-bordered connectors-table" style="margin: 0; width: 100%;">
                        <tr>
                            <th rowspan="2" width="20px">#</th>
                            <th rowspan="2" width="100px">Name</th>
                            <th colspan="4" witdh="180px">Members</th>
                            <th rowspan="2" width="120px">Connector Name</th>
                            <th rowspan="2" width="100px">Notes</th>
                            <th rowspan="2" width="90px">Action</th>
                        </tr>
                        <tr>
                            <th>#A</th>
                            <th>Loc</th>
                            <th>#B</th>
                            <th>Loc</th>
                        </tr>
                        <tr ng-repeat="con in models.geometry.connections">
                            <td>{{$index + 1}}</td>
                            <td><input class="form-control" type="text" ng-model="con.name" ng-change="con.change = true" ng-disabled="!models.geometry.allowEdit"></td>
                            
                            <td>
                                <select class="form-control" ng-change="con.change = true" ng-model="con.mbrA" ng-options="data.no as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>

                                <select title="type" class="form-control" ng-change="con.change = true" ng-disabled="!models.geometry.allowEdit" ng-model="con.mbrA_loc">
                                    <option value="start">Start</option>
                                    <option value="end">End</option>
                                    <option value="middle">Middle</option>
                                </select>

                            </td>
                            <td>
                                <select class="form-control" ng-change="con.change = true" ng-model="con.mbrB" ng-options="data.no as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>
                                <select title="type" class="form-control" ng-change="con.change = true" ng-disabled="!models.geometry.allowEdit" ng-model="con.mbrB_loc">
                                    <option value="start">start</option>
                                    <option value="end">end</option>
                                    <option value="middle">middle</option>
                                </select>
                            </td>

                            <td>
                                <select class="form-control" ng-change="con.change = true" ng-model="con.cntr" ng-options="data.name as data.name for data in models.geometry.connectors" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td><input class="form-control" type="text" ng-model="con.notes" ng-change="con.change = true" ng-disabled="!models.geometry.allowEdit"></td>
                            <td class="text-center">
                                <button class="btn btn-sm" ng-class="{'btn-success': con.change}" ng-click="models.geometry.updateConnection(con)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeConnection($index, con.id)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{models.geometry.connections.length + 1}}</td>
                            <td><input class="form-control" type="text" ng-model="models.geometry.new_connection.name" ng-disabled="!models.geometry.allowEdit"></td>
                            <td>
                                <select class="form-control" ng-model="models.geometry.new_connection.mbrA" ng-options="data.no as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>
                                <select title="type" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="con.mbrA_loc">
                                    <option value="start">start</option>
                                    <option value="end">end</option>
                                    <option value="middle">middle</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-model="models.geometry.new_connection.mbrB" ng-options="data.no as data.Mbr_Name for data in models.geometry.members" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>
                                <select title="type" class="form-control" ng-disabled="!models.geometry.allowEdit" ng-model="con.mbrB_loc">
                                    <option value="start">start</option>
                                    <option value="end">end</option>
                                    <option value="middle">middle</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-model="models.geometry.new_connection.cntr" ng-options="data.name as data.name for data in models.geometry.connectors" ng-disabled="!models.geometry.allowEdit">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td><input class="form-control" type="text" ng-model="models.geometry.new_connection.notes" ng-disabled="!models.geometry.allowEdit"></td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm" ng-click="models.geometry.addConnection()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus"></span></button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div id="geo-association" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                <h4>Managing products associated with present geometry</h4>
                <table class="table table-bordered" style="margin: 0;">
                    <tr>
                        <th ng-repeat="item in models.geometry.association track by $index" style="text-align: center;" ng-style="{ width: item.size }">{{ item.name }}</th>
                        <th style="width: 15%; text-align: center;">Action</th>
                    </tr>
                    <tr ng-repeat="list in models.geometry.list_assoc track by $index">
                        <td ng-repeat="item in list.association track by $index">
                            <select class="form-control" ng-model="item.select" ng-change="models.geometry.changeAssociation(item, $parent.$index, list)" ng-options="data.value for data in item.data" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm" ng-click="models.geometry.saveAssociationNew(list)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeAssociationNew($index, list.no)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                        </td>
                    </tr>
                    <tr>
                        <td ng-repeat="item in models.geometry.association track by $index">
                            <select class="form-control" ng-model="item.select" ng-change="models.geometry.changeAssociation(item)" ng-options="data.value for data in item.data" ng-disabled="!models.geometry.allowEdit">
                                <option value=""></option>
                            </select>
                        </td>
                        <td class="text-center" >
                            <button class="btn btn-success btn-sm" ng-click="models.geometry.addAssociation()" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus" ></span></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="geo-analysis" class="tab-pane">
            <div class="container" ng-show="models.geometry.dataLoaded" style="margin: 0; padding: 14px 0; width: 100%;">
                <div>
                    <h4>Define Loading Configurations (LCs) and Design Configurations (DCs) for Structural Analysis (SA)</h4>
                    <table class="table table-bordered" style="margin: 0;">
                        <thead>
                            <th width="20px" style="text-align: center; vertical-align: middle;">#</th>
                            <th width="100px" style="text-align: center; vertical-align: middle;">LC Name</th>
                            <th width="50px" style="text-align: center; vertical-align: middle;">3D</th>
                            <th width="100px" style="text-align: center;">DC Name</th>
                            <th width="20px" style="text-align: center; vertical-align: middle;">Analysis</th>
                            <th width="50px" style="text-align: center; vertical-align: middle;">Results</th>
                            <th width="50px" style="text-align: center; vertical-align: middle;">Report</th>
                            <th width="100px" style="text-align: center; vertical-align: middle;">Notes</th>
                            <th width="100px" style="text-align: center; vertical-align: middle;">Action</th>
                        </thead>
                        <tbody>
                        <tr ng-repeat="comb in models.geometry.analysisCombinations">
                            <td>{{$index + 1}}</td>
                            <td style="cursor: pointer; text-align: center;">
                                <div class="input-group">
                                    <input type="text" class="form-control" ng-model="models.geometry.new_lc" ng-change="comb.change = true" ng-disabled="!models.geometry.allowEdit" ng-show="comb.lc_id == 'create'">
                                    <select class="form-control" ng-model="comb.lc_id" ng-disabled="!models.geometry.allowEdit" ng-change="comb.change = true" ng-hide="comb.lc_id == 'create'">
                                        <option value="{{ lc.id }}" ng-repeat="lc in models.geometry.activeGeometryLcParentList">{{ lc.lc_name }}</option>
                                        <option value="create">..or create new</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" ng-click="models.geometry.editDetails(comb, 'LC')" style="padding: 1px 7px 3px 7px; line-height: 19px;" type="button">D</button>
                                    </span>
                                </div>
                            </td>

                            <td style="text-align: center;"><input type="checkbox" ng-change="models.geometry.changeLcDraw(comb); models.geometry.saveAllAnalysis();" ng-model='comb.draw' ng-true-value="'true'" ng-false-value="'false'" ng-disabled="!models.geometry.allowEdit"></td>

                            <td style="cursor: pointer; text-align: center;">
                                <div class="input-group">
                                    <input type="text" class="form-control" ng-model="models.geometry.new_dc" ng-change="comb.change = true" ng-disabled="!models.geometry.allowEdit" ng-show="comb.dc_id == 'create'">
                                    <select class="form-control" ng-model="comb.dc_id" ng-change="comb.change = true" ng-disabled="!models.geometry.allowEdit" ng-hide="comb.dc_id == 'create'">
                                        <option value="{{ dc.id }}" ng-repeat="dc in models.geometry.activeGeometryDcList">{{ dc.dc_name }}</option>
                                        <option value="create">..or create new</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" ng-click="models.geometry.editDetails(comb, 'DC')" style="padding: 1px 7px 3px 7px; line-height: 19px;" type="button">D</button>
                                    </span>
                                </div>
                            </td>

                            <td style="text-align: center;"><span class="run-button glyphicon" ng-class="{'glyphicon-play': !comb.run, 'glyphicon-ok-sign': comb.run}" ng-click="models.geometry.formAnalysisFile(comb)" ng-disabled="!models.geometry.allowEdit"></span></td>
                            <td style="text-align: center;"><a style="text-decoration: none; color: #000;" href="{{$window.location.href + comb.mountName}}" download><span class="open-file-button glyphicon glyphicon-modal-window" ng-show="comb.run" ng-click="models.geometry.openAnalysisFile(comb)" ng-disabled="!models.geometry.allowEdit"></span></a></td>
                            <td style="text-align: center;"><button class="btn btn-default" style="background-color:grey; font-size: bold;" ng-click="models.geometry.formAnalysisPDF(comb)" ng-disabled="!models.geometry.allowEdit">PDF</button></td>
                            <td><input class="form-control" type="text" ng-model="comb.notes" ng-change="comb.change = true" ng-disabled="!models.geometry.allowEdit"></td>
                            <td class="text-center">
                                <button class="btn btn-sm" ng-class="{'btn-success': comb.change}" ng-click="models.geometry.updateCombination(comb)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                <button class="btn btn-danger btn-sm" ng-click="models.geometry.removeAnalysis($index, comb.id)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-floppy-remove"></span></button>
                            </td>
                        </tr>
                        <!-- ///////////////////////////////////////////////////////////////-->
                        <tr>
                            <td>{{models.geometry.analysisCombinations.length + 1}}</td>
                            <td>
                                <input type="text" class="form-control" ng-model="models.geometry.new_combination.new_lc" ng-change="comb.change = true" ng-disabled="!models.geometry.allowEdit" ng-show="models.geometry.new_combination.lc_id == 'create'">
                                <select class="form-control" ng-model="models.geometry.new_combination.lc_id" ng-hide="models.geometry.new_combination.lc_id == 'create'">
                                    <option value="{{ lc.id }}" ng-repeat="lc in models.geometry.activeGeometryLcParentList">{{ lc.lc_name }}</option>
                                    <option value="create">..or create new</option>
                                </select>
                            </td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" ng-model="models.geometry.new_combination.new_dc" ng-disabled="!models.geometry.allowEdit" ng-show="models.geometry.new_combination.dc_id == 'create'">
                                <select class="form-control" ng-model="models.geometry.new_combination.dc_id" ng-hide="models.geometry.new_combination.dc_id == 'create'">
                                    <option value="{{ dc.id }}" ng-repeat="dc in models.geometry.activeGeometryDcList">{{ dc.dc_name }}</option>
                                    <option value="create">..or create new</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input class="form-control" type="text" ng-model="models.geometry.new_combination.notes" ng-disabled="!models.geometry.allowEdit"></td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm" ng-click="models.geometry.addAnalysisCombination(models.geometry.new_combination)" ng-disabled="!models.geometry.allowEdit"><span class="glyphicon glyphicon-plus" ></span></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <span class="copy-tab-button glyphicon glyphicon-duplicate" ng-click="models.geometry.copyTab();"></span>

    <span class="knowledge-center-button glyphicon glyphicon-info-sign" ng-click="showInfo([],'geometry_tabs')"></span>
</div>

<div class="info-panel" ng-show="infoPanel">
    <div bind-html-compile="infoResolve"></div>
    <div style="position: absolute; right: 5px; top: 5px; cursor: pointer;" ng-click="infoPanel = false;">X</div>
</div>