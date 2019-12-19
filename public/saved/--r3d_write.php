<?php

require_once("r3d_write_class.php");
$write = new r3d_write();

require_once("config.php");
require_once("generic.php");
$this = new Generic();

$my_file = 'mount.r3d';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

$data = '[RISA-3D_INPUT_DATA]'."\r\n";
fwrite($handle, $data);

$risa3d_v = '15.04';
$data ="\r\n".'[VERSION_NO] <1>'."\r\n".$risa3d_v."\r\n".'[END_VERSION_NO]'."\r\n";
fwrite($handle, $data);

$program_info = '64';
$data ="\r\n".'[PROGRAM_INFO] <1>'."\r\n".$program_info."\r\n".'[END_PROGRAM_INFO]'."\r\n";
fwrite($handle, $data);

$data_integrity_key = '64';
$data ="\r\n".'[DATA_INTEGRITY_KEY] <1>'."\r\n".$data_integrity_key."\r\n".'[END_DATA_INTEGRITY_KEY]'."\r\n";
fwrite($handle, $data);

$cloudid = ''; // raphael.mohamed@mastec.com
$data ="\r\n".'[CLOUDID] <1>'."\r\n".$cloudid."\r\n".'[END_CLOUDID]'."\r\n";
fwrite($handle, $data);

$os_version = ''; // 6.1 (Windows 7);
$data ="\r\n".'[OS_VERSION] <1>'."\r\n".$os_version."\r\n".'[END_OS_VERSION]'."\r\n";
fwrite($handle, $data);


$write->units($handle, '');




$gloabl_prtrs = array();
$gloabl_prtrs['proj_dsrpn'] = array('model_title'=>'072-082', 'compay_name'=>'MasTec', 'designer_name'=>'Bruce', 'job_number'=>'xxx-yyy');
$gloabl_prtrs['sol_prtrs']     = array();
$gloabl_prtrs['design_codes']  = array();

$wind_prtrs = array();
$wind_prtrs['is_wind_prtrs']   = array();
$wind_prtrs['mexi_wind_prtrs'] = array();
$wind_prtrs['nbc_wind_prtrs']  = array();
$gloabl_prtrs['wind_prtrs']    = $wind_prtrs;

$seismic_prtrs = array();
$seismic_prtrs['is_seismic_prtrs']   = array();
$seismic_prtrs['mexi_seismic_prtrs'] = array();
$seismic_prtrs['nbc_seismic_prtrs']  = array();

$gloabl_prtrs['seismic_prtrs']    = $seismic_prtrs;
$gloabl_prtrs['ntnl_load_prtrs']     = array();
$gloabl_prtrs['conc_prtrs'] = array();
$gloabl_prtrs['ftn_prtrs']  = array();
$gloabl_prtrs['lc_grtr_rll_optns']  = array();
$write->gloabl_parameters($handle, $gloabl_prtrs);


$material_prtrs = array();
$material_prtrs['gen_mat']   = array();
$material_prtrs['hr_steel']  = array();
$material_prtrs['cf_steel']  = array();
$material_prtrs['aluminum']  = array();
$material_prtrs['concrete']  = array();
$material_prtrs['wood']      = array();
$material_prtrs['masonry']   = array();
$write->material_parameters($handle, $material_prtrs);

$sec_sets = array();
$sec_sets['hr_steel']  = array();
$sec_sets['cf_steel']  = array();
$sec_sets['wood']      = array();
$sec_sets['general']   = array();
$sec_sets['concrete']  = array();
$sec_sets['aluminum']  = array();
$sec_sets['masonry']   = array();
$write->section_sets($handle, $sec_sets);

$wood_skedus = array();
$wood_skedus['one']  = array();
$wood_skedus['two']  = array();
$write->wood_schedules($handle, $wood_skedus);

$wood_skedu_data = array();
$write->wood_schedule_data($handle, $wood_skedu_data);

$wood_hodn_series = array();
$wood_hodn_series['one']  = array();
$wood_hodn_series['two']  = array();
$write->wood_holddown_series($handle, $wood_hodn_series);


$design_rules = array();
$design_rules['size_uc']     = array();
$design_rules['deflection']  = array();
$design_rules['rebar']       = array();
$design_rules['masonry_wallpanel']   = array();
$design_rules['wood_wallpanel']      = array();
$write->design_rules($handle, $design_rules);


$mbr_design_rules = array();
$mbr_design_rules['size_uc']     = array();
$mbr_design_rules['deflection']  = array();
$mbr_design_rules['rebar']       = array();
$write->member_design_rules($handle, $mbr_design_rules);


$wall_design_rules = array();
$wall_design_rules['masonry_wallpanel']  = array();
$wall_design_rules['wood_wallpanel']     = array();
$wall_design_rules['conc_wallpanel']     = array();
$wall_design_rules['uc_wallpanel']       = array();
$write->wall_design_rules($handle, $wall_design_rules);


$seismic_design_rules = array();
$write->seismic_design_rules($handle, $seismic_design_rules);


$conn_rules = array();
$write->connection_rules($handle, $conn_rules);

?>