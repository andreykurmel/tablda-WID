<div id="an-equipments" class="tab-pane">
    <!-- div style="padding: 10px; width:840px;" -->
    <div class="container">
        <div class="row">
            <div class="col-xs-7">
                <h3>Nodes</h3>
                <span class="glyphicon glyphicon-info-sign"
                      style="color: cornflowerblue; position: absolute; right: 15px; top: 5px;"
                      ng-click="calculation.info(['#simplified_input'])"></span>

                <table id="wlda-equip-table" class="table table-bordered table-for-jack" style="margin: 0;">

                    <tr>
                        <th width="30px" rowspan="2" style="text-align: center; vertical-align: middle;">LOC</th>
                        <th width="100px" style="text-align: center;">X</th>
                        <th width="100px" style="text-align: center;">Y</th>
                        <th width="100px" style="text-align: center;">Z</th>
                        <th width="100px" style="text-align: center;">Length</th>
                    </tr>
                    <tr>
                        <th width="100px" style="text-align: center;">ft</th>
                        <th width="100px" style="text-align: center;">ft</th>
                        <th width="100px" style="text-align: center;">ft</th>
                        <th width="100px" style="text-align: center;">ft</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Start</th>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                        <td rowspan="2"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center;">End</th>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>

                </table>
                <h3>Sections</h3>
                <table class="table table-bordered table-for-jack" style="margin: 0; margin-top: 10px">
                    <tr>
                        <th width="30px" rowspan="2" style="text-align: center; vertical-align: middle;">Cross Section</th>
                        <th width="100px" style="text-align: center;">Crfrc</th>
                        <th width="100px" style="text-align: center;">F2F</th>
                        <th width="100px" style="text-align: center;">FWth</th>
                    </tr>
                    <tr>
                        <th width="100px" style="text-align: center;">nf</th>
                        <th width="100px" style="text-align: center;">nf</th>
                        <th width="100px" style="text-align: center;">nf</th>
                    </tr>
                    <tr>
                        <td width="100px"><select name="" id=""></select></td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>
                </table>

                <div class="input-group isMemberOf" style="width: 30%; margin-bottom: 10px;">
                    <span class="input-group-addon" style="font-size: 11px; top: 0;">Elipson</span>
                    <input type="text" class="form-control" placeholder="Solidity Ratio">
                </div>

                <h5 class="structural-component">
                Structural component is a member of a
                <select style="margin-left: 10px;">
                    <option value="lattciedTower">Latticed Tower</option>
                    <option value="mountingFrame">Mounting Frame</option>
                    <option value="symmetricalFrame">Symmetrical Frame or truss platform</option>
                    <option value="lowProfile">Low Profile Platform</option>
                    <option value="symmetricalProfile">Symmetrical circular ring platform</option>
                </select>
            </h5>
            </div>
            <div class="col-xs-5" style="padding-left: 0">
                <div id="2d" style="display: none;"><canvas width="750" height="621"></canvas></div>
                <div id="webgl"></div>
            </div>
        </div>
    </div>

    <!-- /div -->
</div>