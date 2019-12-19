<!DOCTYPE html>
<html ng-app="WindLoad4D">
<head>
    <?php include "wl_da_jsCSS.php"; ?>

    <script src="wl_da.js"></script>

    <?php include "loader.php"; ?>

    <a href="#" id="pdf" onclick="return xepOnline.Formatter.Format('iframeId',
        {pageWidth:'216mm', pageHeight:'279mm',namespaces:['xmlns:ng=&quot;http://www.foo.net&quot;']});">
    </a>
    <script src="./../../../../../../assets/angular-strap/dist/angular-strap.min.js"></script>
    <script src="./../../../../../../assets/angular-strap/dist/angular-strap.tpl.min.js"></script>
</head>

  <body>
    <div id="iframeId" ng-controller="wl_daController as wl_daCtrlr">

      <ul class="nav nav-tabs">
        <li class="item active" ng-click="main_tab = 'equipment'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': main_tab == 'equipment' }" href="javascript:void(0)" data-target="#equipment" data-toggle="tab">DAs</a></li>
        <li class="item" ng-click="main_tab = 'loading'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': main_tab == 'loading' }" href="javascript:void(0)" data-target="#loading" data-toggle="tab">Loading</a></li>
        <li class="item" ng-click="main_tab = 'faces'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': main_tab == 'faces' }" href="javascript:void(0)" data-target="#faces" data-toggle="tab">Faces of {{activeList.name}}</a></li>      
      </ul>

      <div class="tab-content" id="tabs-container" style="width: 100%;">
        <div id="equipment" class="tab-pane active" style="padding: 5px 0 0 0; float: left;" >
          <?php include 'wl_da_eqpt.php'; ?>
        </div>

        <div id="loading" class="tab-pane" style=" padding: 5px 0 0 0; float: left;">
          <?php include 'wl_da_loading.php'; ?>
        </div>

        <div id="faces" class="tab-pane" style=" padding: 5px 0 0 0; float: left;">
          <?php include 'wl_da_loading_faces.php'; ?>
        </div>
      </div>

    </div>
  </body>
  
  </html>