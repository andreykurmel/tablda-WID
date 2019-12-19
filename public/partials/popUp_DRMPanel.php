<div ng-show="models.product.panel == true" style="height: 100%;">
    <div class="container popup" style="width: 100%; height: 100%;">

        <div class="close" style="position: absolute; right: 15px; top: -37px; opacity: 1; font-weight: normal; font-size: 24px;" ng-click="models.product.panel = false">x</div>

        <div class="content" style="padding: 15px 5px 5px 5px; height: 100%;">

            <div class="transferDataPopUp" ng-show="actions.transferDataPopUp.show">

                <div class="overlay" ng-click="actions.transferDataPopUp.show = false;"><style>
                        .transferDataPopUp .overlay{
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: black;
                            opacity: 0.3;
                            z-index: 1000;
                        }

                        .transferDataPopUp .content{
                            height: 230px;
                            width: 400px;
                            padding: 15px;
                            background-color: white;
                            position: absolute;
                            /*top: calc(50% - 200px);*/
                            /*left: calc(50% - 400px);*/
                            top: 30%;
                            left:40%;
                            z-index: 1500;
                            display: flex;
                            justify-content: flex-start;
                            flex-direction: column;
                            align-items: baseline;

                        }

                        .transferDataPopUp .content .propsTransfer{
                            display: flex;
                        }
                        .transferDataPopUp .content .propsTransfer input{
                            width: 290px;
                            margin-bottom: 30px;
                        }
                        .transferDataPopUp .propsTransfer select{
                            width: 80px;
                            margin-bottom: 30px;
                        }
                        .transferDataPopUp .content p{
                            margin-bottom: 20px;
                        }
                        .transferDataPopUp .content h4{
                            margin-top: 0;
                        }
                        .transferDataPopUp .content button{
                            width: 100px;
                            align-self: flex-end;
                        }

                        .transferDataPopUp .content .close{
                            align-self: flex-end;
                        }

                    </style></div>
                <div class="content">
                    <div class="close" ng-click="actions.transferDataPopUp.show = false; actions.transferDataPopUp.resetTransferDataPopUpFields();">x</div>
                    <h4>Transfering Data Records</h4>
                    <p>You can transfer selected record to another user. Just set E-mail and click on "Transfer" button.</p>
                    <div class="propsTransfer">
                        <input type="text" class="userQuery" ng-model="actions.transferDataPopUp.selectedUser" placeholder="Enter E-mail here..">
                        <select name="transferMode" id="transferMode" ng-model="actions.transferDataPopUp.transferMode">
                            <option ng-repeat="permission in actions.transferDataPopUp.permissions" ng-value="permission.value">{{ permission.description }}</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" ng-click="actions.transferDataPopUp.acceptPermission();" ng-disabled="!actions.transferDataPopUp.selectedUser">Done</button>
                </div>

            </div>

            <div id="self" class="tab-pane fade in active" style="height: 100%;">
                <div style="width: 20%; height: 100%; overflow-y: auto; float: left; background-color: #eeeeee; padding-left: 5px; border: 1px solid #ddd;">
                    <div class="panel-body" style="padding: 0!important; margin-left: -20px;">
                        <div treecontrol class="tree-classic" tree-model="models.product.tree.data" options="models.product.tree.options" on-selection="models.product.tree.showSelected(node, 'product')" selected-node="models.product.tree.node" expanded-nodes="models.product.tree.expanded">
                            <span context-menu="models.product.tree.context(node)" class="panel-product-tree-element" data-folderid="{{node.id}}" ng-mouseup="models.product.panelDragEnd(node);">
                                {{node.name || node.no}}
                            </span>
                        </div>
                    </div>
                    
                    <div style="border-bottom: 1px solid #bbb; margin-top: 10px; margin-bottom: 10px; width: 95%"></div>
                    <div class="panel-body" style="padding: 0!important; margin-left: -20px;">
                        <div treecontrol class="tree-classic" tree-model="models.geometry.tree.data" options="models.geometry.tree.options" on-selection="models.geometry.tree.showSelected(node, 'geometry')" selected-node="models.geometry.tree.node" expanded-nodes="models.geometry.tree.expanded">
                            <span context-menu="models.product.tree.context(node)" class="panel-geometry-tree-element" data-folderid="{{node.id}}" ng-mouseup="models.geometry.panelDragEnd(node);">
                                {{node.name || node.no}}
                            </span>
                        </div>
                    </div>

                    <div style="border-bottom: 1px solid #bbb; margin-top: 10px; margin-bottom: 10px; width: 95%"></div>
                    <div class="panel-body" style="padding: 0!important; margin-left: -20px;">
                        <div treecontrol class="tree-classic" tree-model="models.site.tree.data" options="models.site.tree.options" on-selection="models.site.tree.showSelected(node, 'site')" selected-node="models.site.tree.node" expanded-nodes="models.site.tree.expanded">
                            <span context-menu="models.product.tree.context(node)" class="panel-site-tree-element" data-folderid="{{node.id}}">
                                {{node.name || node.no}}
                            </span>
                        </div>
                    </div>
                </div>

                <div style="width: 80%; height: 100%; float: left; user-select: none;" onselectstart="return false;">
                    <div>
                        <table class="table table-hover table-striped table-bordered" style="margin-bottom: 0px;">
                            <thead style="background-color: #EEEEEE;" ng-if="models.product.tree.selectedNodeType !== 'site'">
                                <tr>
                                    <th style="min-width: 30px; width: 30px; text-align: center;">#</th>
                                    <th style="width: 10%">Type</th>
                                    <th style="width: 15%">Sub Type</th>
                                    <th style="width: 15%">Shape</th>
                                    <th style="width: 15%">Manufacturer</th>
                                    <th style="width: 20%">Model</th>
                                    <th ng-if="!models.product.tree.linksShow" style="width: 15%">Notes</th>
                                    <th ng-if="models.product.tree.linksShow" style="width: 15%">Owner</th>
                                    <th style="min-width: 110px; width: 110px;">Action</th>
                                </tr>
                            </thead>
                            <thead style="background-color: #EEEEEE;" ng-if="models.product.tree.selectedNodeType === 'site'">
                                <tr>
                                    <th style="min-width: 30px; width: 30px; text-align: center;">#</th>
                                    <th style="width: 15%">FA</th>
                                    <th style="width: 18%">Name</th>
                                    <th style="width: 18%">RAD Elev</th>
                                    <th style="width: 15%">Sectors</th>
                                    <th style="width: 20%">Geo Model</th>
                                    <th style="min-width: 110px; width: 110px;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div style="height: calc(100% - 28px); overflow: auto;">
                        <table class="table table-hover table-striped table-bordered">
                            <tbody ng-if="models.product.tree.selectedNodeType === 'product'">
                                <tr ng-repeat="product in models.product.tree.selectedNodes">
                                    <td style="min-width: 30px; width: 30px; cursor: pointer; text-decoration: underline; text-align: center;" ng-mouseup="models.product.panel = false; models.product.searchInputChange({item:product});" ng-mousedown="models.product.panelDrag(product, $index)">{{$index + 1}}</td>
                                    <td style="width: 10%"><input ng-model="product.type"     class="form-control" ng-change="product.change = true" ng-focus="models.product.panelInputSelect(product.parentID);" type="text"></td>
                                    <td style="width: 15%"><input ng-model="product.sub_type" class="form-control" ng-change="product.change = true" ng-focus="models.product.panelInputSelect(product.parentID);" type="text"></td>
                                    <td style="width: 15%"><input ng-model="product.shape"    class="form-control" ng-change="product.change = true" ng-focus="models.product.panelInputSelect(product.parentID);" type="text"></td>
                                    <td style="width: 15%"><input ng-model="product.mftr"     class="form-control" ng-change="product.change = true" ng-focus="models.product.panelInputSelect(product.parentID);" type="text"></td>
                                    <td style="width: 20%"><input ng-model="product.model"    class="form-control" ng-change="product.change = true" ng-focus="models.product.panelInputSelect(product.parentID);" type="text"></td>
                                    <td ng-if="!models.product.tree.linksShow" style="width: 15%"><input ng-model="product.notes"    class="form-control" ng-change="product.change = true" ng-focus="models.product.panelInputSelect(product.parentID);" type="text"></td>
                                    <td ng-if="models.product.tree.linksShow" style="width: 15%"><input ng-model="product.userInfo"  class="form-control" type="text"></td>

                                    <td style="min-width: 110px; width: 110px;">
                                        <div style="width: 110px; text-align: center;" ng-if="!product.link">
                                            <button class="btn btn-sm" ng-class="{'btn-success': product.change}" style="line-height: 16px;" ng-click="models.product.updateProduct(product);">
                                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                            </button>
                                            <button class="btn btn-sm btn-danger" style="line-height: 16px;" ng-click="models.product.deleteProduct(product.id);">
                                                <span class="glyphicon glyphicon-floppy-remove"></span>
                                            </button>
                                            <button class="btn btn-sm" style="line-height: 16px;" ng-click="actions.transferDataPopUp.transferSelected(product, 'product');">
                                                <span class="glyphicon glyphicon-transfer"></span>
                                            </button>                                            
                                        </div>

                                        <div style="width: 75px; text-align: center;" ng-if="product.link">
                                            <button class="btn btn-sm btn-danger" style="line-height: 16px;" ng-click="models.product.deleteProductLink(product.id);">
                                                <span class="glyphicon glyphicon-floppy-remove"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="min-width: 30px; width: 30px; text-align: center;">{{models.product.tree.selectedNodes.length + 1}}</td>
                                    <td style="width: 10%"><input ng-model="models.product.tree.newProduct.type" class="form-control" type="text"></td>
                                    <td style="width: 15%"><input ng-model="models.product.tree.newProduct.sub_type" class="form-control" type="text"></td>
                                    <td style="width: 15%"><input ng-model="models.product.tree.newProduct.shape" class="form-control" type="text"></td>
                                    <td style="width: 15%"><input ng-model="models.product.tree.newProduct.mftr" class="form-control" type="text"></td>
                                    <td style="width: 20%"><input ng-model="models.product.tree.newProduct.model" class="form-control" type="text"></td>
                                    <td style="width: 15%"><input ng-model="models.product.tree.newProduct.notes" class="form-control" type="text"></td>
                                    
                                    <td style="min-width: 85px; width: 85px;">
                                        <div style="text-align: center;">
                                            <button class="btn btn-sm btn-success" style="line-height: 16px;" ng-click="models.product.addNewProduct(models.product.tree.newProduct);">
                                                Add
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody ng-if="models.product.tree.selectedNodeType === 'geometry'">
                                <tr ng-repeat="geometry in models.product.tree.selectedNodes">
                                    <td style="min-width: 30px; width: 30px; cursor: pointer; text-decoration: underline; text-align: center;" ng-mouseup="models.product.panel = false; models.geometry.searchInputChange({item:geometry});" ng-mousedown="models.geometry.panelDrag(geometry, $index)">{{$index + 1}}</td>
                                    <td><input ng-model="geometry.Type_G"     class="form-control" ng-change="geometry.change = true" ng-focus="models.geometry.panelInputSelect(geometry.parentID);" type="text"></td>
                                    <td><input ng-model="geometry.Sub_type_G" class="form-control" ng-change="geometry.change = true" ng-focus="models.geometry.panelInputSelect(geometry.parentID);" type="text"></td>
                                    <td><input ng-model="geometry.Shape_G"    class="form-control" ng-change="geometry.change = true" ng-focus="models.geometry.panelInputSelect(geometry.parentID);" type="text"></td>
                                    <td><input ng-model="geometry.Mftr_G"     class="form-control" ng-change="geometry.change = true" ng-focus="models.geometry.panelInputSelect(geometry.parentID);" type="text"></td>
                                    <td><input ng-model="geometry.Model_G"    class="form-control" ng-change="geometry.change = true" ng-focus="models.geometry.panelInputSelect(geometry.parentID);" type="text"></td>
                                    <td ng-if="!models.product.tree.linksShow"><input ng-model="geometry.notes"      class="form-control" ng-change="geometry.change = true" ng-focus="models.geometry.panelInputSelect(geometry.parentID);" type="text"></td>
                                    <td ng-if="models.product.tree.linksShow"><input ng-model="geometry.userInfo"      class="form-control" type="text"></td>

                                    <td>
                                    <div style="width: 110px; text-align: center;" ng-if="!geometry.link">
                                        <button class="btn btn-sm" ng-class="{'btn-success': geometry.change}" style="line-height: 16px;" ng-click="models.geometry.updateGeometry(geometry);">
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                        </button>
                                        <button class="btn btn-sm btn-danger" style="line-height: 16px;" ng-click="models.geometry.deleteGeometry(geometry.id);">
                                            <span class="glyphicon glyphicon-floppy-remove"></span>
                                        </button>
                                        <button class="btn btn-sm" style="line-height: 16px;" ng-click="actions.transferDataPopUp.transferSelected(geometry, 'geometry');">
                                            <span class="glyphicon glyphicon-transfer"></span>
                                        </button>                                        
                                    </div>
                                    <div style="width: 75px; text-align: center;" ng-if="geometry.link">
                                        <button class="btn btn-sm btn-danger" style="line-height: 16px;" ng-click="models.geometry.deleteGeometryLink(geometry.id);">
                                            <span class="glyphicon glyphicon-floppy-remove"></span>
                                        </button>
                                    </div>
                                </td>
                                </tr>
                                <tr>
                                    <td style="min-width: 30px; width: 30px; text-align: center;">{{models.product.tree.selectedNodes.length + 1}}</td>
                                    <td><input ng-model="models.geometry.tree.newProduct.Type_G" class="form-control" type="text"></td>
                                    <td><input ng-model="models.geometry.tree.newProduct.Sub_type_G" class="form-control" type="text"></td>
                                    <td><input ng-model="models.geometry.tree.newProduct.Shape_G" class="form-control" type="text"></td>
                                    <td><input ng-model="models.geometry.tree.newProduct.Mftr_G" class="form-control" type="text"></td>
                                    <td><input ng-model="models.geometry.tree.newProduct.Model_G" class="form-control" type="text"></td>
                                    <td><input ng-model="models.geometry.tree.newProduct.notes" class="form-control" type="text"></td>

                                    <td>
                                    <div style="text-align: center;">
                                        <button class="btn btn-sm btn-success" style="line-height: 16px;" ng-click="models.geometry.addNewGeometry(models.geometry.tree.newProduct);">
                                            Add
                                        </button>
                                    </div>
                                </td>
                                </tr>
                            </tbody>

                            <tbody ng-if="models.product.tree.selectedNodeType === 'site'">
                                <tr ng-repeat="site in models.product.tree.selectedNodes">
                                    <td style="min-width: 30px; width: 30px; cursor: pointer; text-decoration: underline; text-align: center;" ng-mouseup="models.product.panel = false; models.site.selectSite(site);">{{$index + 1}}</td>
                                    <td style="width: 15%"><input ng-model="site.fa"     class="form-control" ng-change="site.change = true" type="text"></td>
                                    <td style="width: 18%"><input ng-model="site.site_name" class="form-control" ng-change="site.change = true" type="text"></td>
                                    <td style="width: 18%"><input ng-model="site.elev"    class="form-control" ng-change="site.change = true" type="text"></td>
                                    <td style="width: 15%"><input ng-model="site.sectors"     class="form-control" ng-change="site.change = true" type="text"></td>
                                    <td style="width: 20%">
                                        <select class="form-control"  ng-model="site.geo_id" ng-change="site.change = true">
                                            <option ng-repeat="geo_id in models.site.geometries_ids" value="{{geo_id.model}}">{{ geo_id.model }}</option>
                                        </select>
                                    </td>
                                    <td style="min-width: 110px; width: 110px;">
                                        <div style="text-align: center;">
                                            <button class="btn btn-sm" ng-class="{'btn-success': site.change}" style="line-height: 16px;" ng-click="models.site.updateSite(site);">
                                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                            </button>
                                            <button class="btn btn-sm btn-danger" style="line-height: 16px;" ng-click="models.site.deleteSite(site.id);">
                                                <span class="glyphicon glyphicon-floppy-remove"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="min-width: 30px; width: 30px; text-align: center;">{{models.product.tree.selectedNodes.length + 1}}</td>
                                    <td style="width: 15%"><input ng-model="models.site.tree.newSite.fa" class="form-control" type="text"></td>
                                    <td style="width: 18%"><input ng-model="models.site.tree.newSite.site_name" class="form-control" type="text"></td>
                                    <td style="width: 18%"><input ng-model="models.site.tree.newSite.elev" class="form-control" type="text"></td>
                                    <td style="width: 15%"><input ng-model="models.site.tree.newSite.sectors" class="form-control" type="text"></td>
                                    <td style="width: 20%">
                                        <select class="form-control"  ng-model="models.site.tree.newSite.geo_id">
                                            <option ng-repeat="geo_id in models.site.geometries_ids" value="{{geo_id.model}}">{{ geo_id.model }}</option>
                                        </select>
                                    </td>

                                    <td style="width: 110px;">
                                        <div style="text-align: center;">
                                            <button class="btn btn-sm btn-success" style="line-height: 16px;" ng-click="models.site.addNewSite(models.site.tree.newSite);">
                                                Add
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
