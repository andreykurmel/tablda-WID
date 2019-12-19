<!DOCTYPE html>
<html ng-app="WindLoad4D">
<head>
    <?php include "wl_sc_jsCSS.php"; ?>

    <script type="text/javascript" src="./../../../../../../../../../SHARED/jsX/3D/lib/threejs/three.js"></script>
    <script type="text/javascript" src="./../../../../../../../../../SHARED/jsX/3D/lib/threejs/three.combined.camera.js"></script>
    <script type="text/javascript" src="./../../../../../../../../../SHARED/jsX/3D/lib/threejs/controls/OrbitControls.js"></script>
    <script type="text/javascript" src="./../../../../../../../../../SHARED/jsX/3D/webgl.js"></script>
    <script type="text/javascript" src="./../../../../../../../../../SHARED/jsX/3D/customized/skybox.js"></script>
    <script type="text/javascript" src="./../../../../../../../../../SHARED/jsX/3D/customized/TerrainPlatter.js"></script>
    <script src="wl_sc.js"></script>

    <?php include "loader.php"; ?>

    <a href="#" id="pdf" onclick="return xepOnline.Formatter.Format('iframeId',
        {pageWidth:'216mm', pageHeight:'279mm',namespaces:['xmlns:ng=&quot;http://www.foo.net&quot;']});">
    </a>
</head>

  <body>
    <div id="iframeId" ng-controller="wl_scController as wl_scCtrlr">

      <ul class="nav nav-tabs">
        <li class="item active" ng-click="main_tab = 'structure'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': main_tab == 'structure' }" href="javascript:void(0)" data-target="#structure" data-toggle="tab">Structure</a></li>
        <li class="item" ng-click="main_tab = 'loading'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': main_tab == 'loading' }" href="javascript:void(0)" data-target="#loading" data-toggle="tab">Loading</a></li>
        <li class="item" ng-click="main_tab = 'faces'"><a style="padding: 5px 15px;" ng-class="{'selected_tab': main_tab == 'faces' }" href="javascript:void(0)" data-target="#faces" data-toggle="tab">Faces</a></li>      
      </ul>

      <div class="tab-content" id="tabs-container" style="width: 100%;">
        <div id="structure" class="tab-pane active" style="padding: 5px 0 0 0; float: left;" >
          <?php include 'wl_sc_eqpt.php'; ?>
        </div>

        <div id="loading" class="tab-pane" style=" padding: 5px 0 0 0; float: left;">

          <?php  include 'wl_sc_loading.php'; ?>
        </div>

        <div id="faces" class="tab-pane" style=" padding: 5px 0 0 0; float: left;">

          <?php  include 'wl_sc_loading_faces.php'; ?>
        </div>        

      </div>

    </div>
  </body>
  
  </html>