<style type="text/css">
  .centeredImage
    {
      text-align:center;
      margin-top:0px;
      margin-bottom:0px;
      padding:0px;
      cursor: pointer;
      width: 100%;
      height: 100%;
      position: relative;
    }

  .centeredImage img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%,-50%);
      max-width: 100%;
      max-height: 100%;
  }

  .headerForm .row{
      margin-left: 0;
      margin-right: 0;
  }

  .backIcon {
      height: 100px;
      background-color: rgb(79, 176, 79);;
      font-weight: bold;
      text-align: center;
      color: #ffffff;
      border-radius: 23px;
      padding: 10px;
      line-height: 20px;
  }

  .h_table_label {
      float: left;
      font-weight: bold;
      height: 11px;
      font-size: 10px;
      width: 100px;
      text-align: left;
  }

  .h_table_cont {
      float: left;
      width: 95%;
      height: 20px;
      position: relative;
      overflow: hidden;
      padding-top: 5px;
      font-size: 16px;
  }

  .h_table_cont input {
      width: 100%;
      height: 20px;
  }

  .h_table_cont .button {
      float: right;
      position: absolute;
      right: 0;
      top: 0
  }


  /*---AECOM---*/

  .h_table_label_aecom {
      float: left;
      font-weight: bold;
      height: 24px;
      font-size: 13px;
      width: 100px;
      text-align: left;
      color: #ffffff;
  }

  .h_table_cont_aecom {
      float: left;
      width: 95%;
      height: 22px;
      position: relative;
      overflow: hidden;
      border-bottom: 1px solid black;
      color: #ffffff;
  }

  .h_table_cont_aecom input {
      width: 100%;
      height: 25px;
  }

  .h_table_cont_aecom .button {
      float: right;
      position: absolute;
      right: 0;
      top: 0
  }

  /*---AECOM---*/

  .company_info {
      margin: 0;
  }
</style>

<div ng-show="!auth.isAuth() && head.activeHeadLayout != '6'" style="border: 1px solid black; height: 100%; padding: 20px; background-color: cornflowerblue;">
    <h3 style="text-align:center; margin-top: 0;">Customizable Calculation Header</h3>
    <div style="text-align:center;">(Register and request for customized header with company logo, desired layout and fields, etc.</div>
    <div style="text-align:center;">One <span style="cursor: pointer; text-decoration: underline;" ng-click="header.setDefaultHeader();">default style</span> for header and footer will be used for unsaved calcs.)</div>
</div>

<div ng-show="auth.isAuth() && head.checkStyle() && head.activeHeadLayout != '6'" style="border: 1px solid black; height: 100%; padding: 35px; background-color: cornflowerblue;">
    <h3 style="text-align:center; margin-top: 0;"><span style="cursor: pointer; text-decoration: underline;" ng-click="project.current = 'all';">Select</span> header style for present calculation.</h3>
    <div style="text-align:center;">(<span style="cursor: pointer; text-decoration: underline;" ng-click="header.setDefaultHeader();">Use default style</span> for header and footer.)</div>
</div>

<div ng-show="head.activeHeadLayout == '6'" style="height: 100%; background-color: cornflowerblue;">
  <?php include "style_default_header.php"; ?>
</div>

<div ng-show="auth.isAuth() && head.activeHeadLayout == '3'" style="height: 100%; background-color: cornflowerblue;">
  <?php include "style_003_header.php"; ?>
</div>

<div ng-show="auth.isAuth() && head.activeHeadLayout == '4'" style="height: 100%; border: 2px solid black;">
  <?php include "style_004_header.php"; ?>
</div>

<div ng-show="auth.isAuth() && head.activeHeadLayout == '5'" style="height: 100%; border: 2px solid black;">
  <?php include "style_005_header.php"; ?>
</div>


