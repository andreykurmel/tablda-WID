<?php
function output_for_web($bc, $unit2use) {

  //Design Factors/Coefficients
  $bc_webX['design_code'] = isset(  $bc['design_parameters']['design_code'] )?  $bc['design_parameters']['design_code'] :'';
  $bc_webX['design_method'] = isset(  $bc['design_parameters']['design_method'] )?  $bc['design_parameters']['design_method'] :'';
  $bc_webX['lrfd_type'] = isset(  $bc['design_parameters']['design_lrfd_type']  )?  $bc['design_parameters']['design_lrfd_type']  :'';

  $bc_webX['g_phi_rod'] = isset(  $bc['design_parameters']['phi_for_rod'] )?  $bc['design_parameters']['phi_for_rod'] :'';
  $bc_webX['g_phi_plate'] = isset(  $bc['design_parameters']['phi_for_plate'] )?  $bc['design_parameters']['phi_for_plate'] :'';

  $bc_webX['omega_rod'] = isset(  $bc['design_parameters']['omega_rod'] )?  $bc['design_parameters']['omega_rod'] :'';
  $bc_webX['omega_plate'] = isset(  $bc['design_parameters']['omega_plate'] )?  $bc['design_parameters']['omega_plate'] :'';

  // Reactions at the base
  $bc_webX['R_code']  = isset(  $bc['loading']['R_code']  )?  $bc['loading']['R_code']  :'';
  $bc_webX['R_method']  = isset(  $bc['loading']['R_method']  )?  $bc['loading']['R_method']  :'';  
  $bc_webX['R_M'] = isset(  $bc['loading']['M'] )?  $bc['loading']['M'] :'';
  $bc_webX['R_P'] = isset(  $bc['loading']['P'] )?  $bc['loading']['P'] :'';
  $bc_webX['R_V'] = isset(  $bc['loading']['V'] )?  $bc['loading']['V'] :'';
  $bc_webX['R_V_dir_angle'] = isset(  $bc['loading']['V']['angle']  )?  $bc['loading']['V']['angle']  :'';
  $bc_webX['R_V_dist_to_base'] = isset(  $bc['loading']['V']['dist_to_base']  )?  $bc['loading']['V']['dist_to_base']  :'';

  //Pole Data - Design Input
  $bc_webX['pc_mftr'] = isset(  $bc['pc']['mftr'] )?  $bc['pc']['mftr'] :'';
  $bc_webX['pc_shape']  = isset(  $bc['pc']['geo']['shape'] )?  $bc['pc']['geo']['shape'] :'';

  $bc_webX['pc_c_od'] = isset(  $bc['pc']['geo']['odia']  )?  $bc['pc']['geo']['odia']  :'';
  $bc_webX['pc_rp_nbr_sides'] = isset(  $bc['pc']['geo']['nbr_sides'] )?  $bc['pc']['geo']['nbr_sides'] :'';
  $bc_webX['pc_rp_od_f2f']  = isset(  $bc['pc']['geo']['od_f2f']  )?  $bc['pc']['geo']['od_f2f']  :'';
  $bc_webX['pc_rp_od_c2c']  = isset(  $bc['pc']['geo']['od_c2c']  )?  $bc['pc']['geo']['od_c2c']  :'';
  $bc_webX['pc_rp_first_cnr_angle'] = isset(  $bc['pc']['geo']['first_cnr_angle'] )?  $bc['pc']['geo']['first_cnr_angle'] :'';

  $bc_webX['pc_crcmfrc']  = isset(  $bc['pc']['geo']['crcmfrc'] )?  $bc['pc']['geo']['crcmfrc'] :'';

  $bc_webX['pc_steel_shape_type']  = isset(  $bc['pc']['geo']['steel_shape_type']  )?  $bc['pc']['geo']['steel_shape_type']  :'';
  $bc_webX['pc_steel_shape_size1'] = isset(  $bc['pc']['geo']['steel_shape_size1']  )?  $bc['pc']['geo']['steel_shape_size1']  :'';
  $bc_webX['pc_steel_shape_size2'] = isset(  $bc['pc']['geo']['steel_shape_size2']  )?  $bc['pc']['geo']['steel_shape_size2']  :'';  
  $bc_webX['pc_steel_shape_roty']  = isset(  $bc['pc']['geo']['steel_shape_roty']  )?  $bc['pc']['geo']['steel_shape_roty']  :'';

  $bc_webX['pc_thk']  = isset(  $bc['pc']['geo']['thk'] )?  $bc['pc']['geo']['thk'] :'';

  $bc_webX['pc_mat']  = isset(  $bc['pc']['material']['name'] )?  $bc['pc']['material']['name'] :'';
  $bc_webX['pc_mat_fy'] = isset(  $bc['pc']['material']['fy'] )?  $bc['pc']['material']['fy'] :'';
  $bc_webX['pc_mat_fu'] = isset(  $bc['pc']['material']['fu'] )?  $bc['pc']['material']['fu'] :'';

  $bc_webX['pc_has_fillet_welded_reinf'] = isset(  $bc['pc']['geo']['has_fillet_welded_reinf']  )?  $bc['pc']['geo']['has_fillet_welded_reinf']  :'';
  $bc_webX['pc_reinf_weld_fillet_size'] = isset(  $bc['pc']['geo']['reinf_weld_fillet_size']  )?  $bc['pc']['geo']['reinf_weld_fillet_size']  :'';

  // geo calc
  $bc_webX['pc_area'] = isset(  $bc['pc']['geo']['rslt']['Ag']  )?  $bc['pc']['geo']['rslt']['Ag']  :'';
  $bc_webX['pc_amoi'] = isset(  $bc['pc']['geo']['rslt']['Ix']  )?  $bc['pc']['geo']['rslt']['Ix']  :'';
  
  // calculation
  // $bc_webX['pc_area'] = isset( $bc['pc']['geo']['cross section area'] ) ? $bc['pc']['geo']['cross section area'] : '';
  // $bc_webX['pc_amoi'] = isset( $bc['pc']['geo']['cross section area moment of interia'] ) ? $bc['pc']['geo']['cross section area moment of interia'] : '';

  //Base Plate Data

  $bc_webX['bp_shape']  = isset(  $bc['bp']['geo']['shape'] )?  $bc['bp']['geo']['shape'] :'';
  $bc_webX['bp_c_od'] = isset(  $bc['bp']['geo']['odia']  )?  $bc['bp']['geo']['odia']  :'';

  $bc_webX['bp_rp_nbr_sides'] = isset(  $bc['bp']['geo']['nbr_sides'] )?  $bc['bp']['geo']['nbr_sides'] :'';
  $bc_webX['bp_rp_od_f2f']  = isset(  $bc['bp']['geo']['od_f2f']  )?  $bc['bp']['geo']['od_f2f']  :'';
  $bc_webX['bp_rp_od_c2c']  = isset(  $bc['bp']['geo']['od_c2c']  )?  $bc['bp']['geo']['od_c2c']  :'';
  $bc_webX['bp_crcmfrc']  = isset(  $bc['bp']['geo']['crcmfrc'] )?  $bc['bp']['geo']['crcmfrc'] :'';
  $bc_webX['bp_rp_first_cnr_angle'] = isset(  $bc['bp']['geo']['first_cnr_angle']  )?  $bc['bp']['geo']['first_cnr_angle']  :'';

  $bc_webX['bp_rect_dx']  = isset(  $bc['bp']['geo']['rect_dx'] )?  $bc['bp']['geo']['rect_dx'] :'';
  $bc_webX['bp_rect_dz']  = isset(  $bc['bp']['geo']['rect_dz'] )?  $bc['bp']['geo']['rect_dz'] :'';
  $bc_webX['bp_rect_roty']  = isset(  $bc['bp']['geo']['rect_roty'] )?  $bc['bp']['geo']['rect_roty'] :'';

  $bc_webX['bp_thk']  = isset(  $bc['bp']['geo']['thk'] )?  $bc['bp']['geo']['thk'] :'';
  $bc_webX['bp_mat']  = isset(  $bc['bp']['material']['name'] )?  $bc['bp']['material']['name'] :'';
  $bc_webX['bp_mat_fy'] = isset(  $bc['bp']['material']['fy'] )?  $bc['bp']['material']['fy'] :'';
  $bc_webX['bp_mat_fu'] = isset(  $bc['bp']['material']['fu'] )?  $bc['bp']['material']['fu'] :'';

  $bc_webX['bp_eff_wth']  = isset(  $bc['bp']['geo']['single rod effective bending width']  )?  $bc['bp']['geo']['single rod effective bending width']  :'';

  //Anchor Bolt/Rod Data
  $bc_webX['abr_layout_shape']  = isset(  $bc['abr']['geo']['layout_shape'] )?  $bc['abr']['geo']['layout_shape'] :'';

  $bc_webX['abr_rect_nbr_x']  = isset(  $bc['abr']['geo']['nbr_x'] )?  $bc['abr']['geo']['nbr_x'] :'';
  $bc_webX['abr_rect_nbr_z']  = isset(  $bc['abr']['geo']['nbr_z'] )?  $bc['abr']['geo']['nbr_z'] :'';
  $bc_webX['abr_rect_sx'] = isset(  $bc['abr']['geo']['sx']  )?  $bc['abr']['geo']['sx']  :'';
  $bc_webX['abr_rect_sz'] = isset(  $bc['abr']['geo']['sz']  )?  $bc['abr']['geo']['sz']  :'';
  $bc_webX['abr_rect_roty'] = isset(  $bc['abr']['geo']['roty']  )?  $bc['abr']['geo']['roty']  :'';

  $bc_webX['abr_nbr_grp_circ']  = isset(  $bc['abr']['geo']['nbr_grp_circ'] )?  $bc['abr']['geo']['nbr_grp_circ'] :'';
  $bc_webX['abr_nbr_eagrp_circ']  = isset(  $bc['abr']['geo']['nbr_eagrp_circ'] )?  $bc['abr']['geo']['nbr_eagrp_circ'] :'';
  $bc_webX['abr_angle_1stAbr_1stGrp'] = isset(  $bc['abr']['geo']['angle_1stAbr_1stGrp']  )?  $bc['abr']['geo']['angle_1stAbr_1stGrp']  :'';
  $bc_webX['abr_angle_spcn_eagrp']  = isset(  $bc['abr']['geo']['angle_spacing_eagrp']  )?  $bc['abr']['geo']['angle_spacing_eagrp']  :'';

  $bc_webX['abr_nbr_eacirc']  = isset(  $bc['abr']['geo']['nbr_eacirc'] )?  $bc['abr']['geo']['nbr_eacirc'] :'';
  $bc_webX['abr_first_abr_angle'] = isset(  $bc['abr']['geo']['first_abr_angle']  )?  $bc['abr']['geo']['first_abr_angle']  :'';
  $bc_webX['abr_linear_dist_eagrp'] = isset(  $bc['abr']['geo']['linear_dist_eagrp']  )?  $bc['abr']['geo']['linear_dist_eagrp']  :'';
  $bc_webX['abr_icirc_dia'] = isset(  $bc['abr']['geo']['icirc_dia']  )?  $bc['abr']['geo']['icirc_dia']  :'';

  $bc_webX['abr_odia'] = isset(  $bc['abr']['geo']['odia'] )?  $bc['abr']['geo']['odia'] :'';
  $bc_webX['abr_area']  = isset(  $bc['abr']['geo']['area'] )?  $bc['abr']['geo']['area'] :'';

  $bc_webX['abr_nbr_nuts_abv_bp'] = isset(  $bc['abr']['geo']['nuts_per_rod']['above']  )?  $bc['abr']['geo']['nuts_per_rod']['above']  :'';
  $bc_webX['abr_nbr_nuts_blw_bp'] = isset(  $bc['abr']['geo']['nuts_per_rod']['below']  )?  $bc['abr']['geo']['nuts_per_rod']['below']  :'';
  $bc_webX['abr_lth_abv_bp_top']  = isset(  $bc['abr']['geo']['lth_abv_bptop'] )?  $bc['abr']['geo']['lth_abv_bptop'] :'';

  $bc_webX['abr_mat'] = isset(  $bc['abr']['material']['name']  )?  $bc['abr']['material']['name']  :'';
  $bc_webX['abr_mat_fy']  = isset(  $bc['abr']['material']['fy']  )?  $bc['abr']['material']['fy']  :'';
  $bc_webX['abr_mat_fu']  = isset(  $bc['abr']['material']['fu']  )?  $bc['abr']['material']['fu']  :'';

  $bc_webX['abr_grp_dmoi']  = isset(  $bc['abr']['geo']['grp_dmoi'] )?  $bc['abr']['geo']['grp_dmoi'] :'';
  $bc_webX['abr_grp_S'] = isset(  $bc['abr']['geo']['grp_S']  )?  $bc['abr']['geo']['grp_S']  :'';
  $bc_webX['abr_grp_Z'] = isset(  $bc['abr']['geo']['grp_Z']  )?  $bc['abr']['geo']['grp_Z']  :'';

  $bc_webX['abr_tn_avabl'] = isset($bc['abr']['results']['available'])? $bc['abr']['results']['available'] : '';
  $bc_webX['abr_tn_max']   = isset($bc['abr']['results']['required'])? $bc['abr']['results']['required'] : '';

  $bc_webX['stfnr_status']  = isset(  $bc['stfnr']['status']  )?  $bc['stfnr']['status']  :'';

  $bc_webX['stfnr_layout_ptrn'] = isset(  $bc['stfnr']['geo']['pattern']  )?  $bc['stfnr']['geo']['pattern']  :'';

  $bc_webX['stfnr_d1']  = isset(  $bc['stfnr']['geo']['D1'] )?  $bc['stfnr']['geo']['D1'] :'';
  $bc_webX['stfnr_d3']  = isset(  $bc['stfnr']['geo']['D3'] )?  $bc['stfnr']['geo']['D3'] :'';
  $bc_webX['stfnr_thk'] = isset(  $bc['stfnr']['geo']['thk']  )?  $bc['stfnr']['geo']['thk']  :'';
  $bc_webX['stfnr_notch'] = isset(  $bc['stfnr']['geo']['notch size'] )?  $bc['stfnr']['geo']['notch size'] :'';

  $bc_webX['stfnr_mat'] = isset(  $bc['stfnr']['material']['name']  )?  $bc['stfnr']['material']['name']  :'';
  $bc_webX['stfnr_mat_fy']  = isset(  $bc['stfnr']['material']['fy']  )?  $bc['stfnr']['material']['fy']  :'';
  $bc_webX['stfnr_mat_fu']  = isset(  $bc['stfnr']['material']['fu']  )?  $bc['stfnr']['material']['fu']  :'';

  $bc_webX['stfnr_weld_type'] = isset(  $bc['conn']['stfnr_bp']['weld']['type'] )?  $bc['conn']['stfnr_bp']['weld']['type'] :'';

  if($bc_webX['stfnr_weld_type'] == "groove"){
    $bc_webX['stfnr_weld_grv_dpth'] = isset($bc['conn']['stfnr_bp']['weld']['groove']['depth'])? $bc['conn']['stfnr_bp']['weld']['groove']['depth']:'';
    $bc_webX['stfnr_weld_grv_angle'] = isset($bc['conn']['stfnr_bp']['weld']['groove']['angle'])? $bc['conn']['stfnr_bp']['weld']['groove']['angle']:'';
  }else if($bc_webX['stfnr_weld_type'] == "fillet"){
    $bc_webX['stfnr_weld_fillet_H'] = isset($bc['conn']['stfnr_bp']['weld']['fillet']['H'])?$bc['conn']['stfnr_bp']['weld']['fillet']['H']:'';
    $bc_webX['stfnr_weld_fillet_V'] = isset($bc['conn']['stfnr_bp']['weld']['fillet']['V'])?$bc['conn']['stfnr_bp']['weld']['fillet']['V']:'';
  }else{
    $bc_webX['stfnr_weld_grv_dpth'] = '';
    $bc_webX['stfnr_weld_grv_angle'] = '';
  }

  //Base Foundation Data
  $bc_webX['stfnr_weld_mat']  = isset(  $bc['conn']['stfnr_bp']['weld']['material'] )?  $bc['conn']['stfnr_bp']['weld']['material'] :'';
  $bc_webX['stfnr_weld_mat_fy'] = isset(  $bc['conn']['stfnr_bp']['weld']['material']['fy'] )?  $bc['conn']['stfnr_bp']['weld']['material']['fy'] :'';
  $bc_webX['stfnr_weld_mat_fu'] = isset(  $bc['conn']['stfnr_bp']['weld']['material']['fu'] )?  $bc['conn']['stfnr_bp']['weld']['material']['fu'] :'';

  $bc_webX['bf_shape']  = isset(  $bc['bf']['geo']['shape'] )?  $bc['bf']['geo']['shape'] :'';
  $bc_webX['bf_c_od'] = isset(  $bc['bf']['geo']['odia']  )?  $bc['bf']['geo']['odia']  :'';

  $bc_webX['bf_rect_dx']  = isset(  $bc['bf']['geo']['rect_dx'] )?  $bc['bf']['geo']['rect_dx'] :'';
  $bc_webX['bf_rect_dz']  = isset(  $bc['bf']['geo']['rect_dz'] )?  $bc['bf']['geo']['rect_dz'] :'';
  $bc_webX['bf_rect_roty']  = isset(  $bc['bf']['geo']['rect_roty']  )?  $bc['bf']['geo']['rect_roty']  :'';

  $bc_webX['bf_rp_nbr_sides'] = isset(  $bc['bf']['geo']['nbr_sides'] )?  $bc['bf']['geo']['nbr_sides'] :'';
  $bc_webX['bf_rp_od_f2f']  = isset(  $bc['bf']['geo']['od_f2f']  )?  $bc['bf']['geo']['od_f2f']  :'';
  $bc_webX['bf_rp_od_c2c']  = isset(  $bc['bf']['geo']['od_c2c']  )?  $bc['bf']['geo']['od_c2c']  :'';
  $bc_webX['bf_thk']  = isset(  $bc['bf']['geo']['thk'] )?  $bc['bf']['geo']['thk'] :'';
  $bc_webX['bf_crcmfrc']  = isset(  $bc['bf']['geo']['crcmfrc'] )?  $bc['bf']['geo']['crcmfrc'] :'';
  $bc_webX['bf_rp_first_cnr_angle'] = isset(  $bc['bf']['geo']['first_cnr_angle'] )?  $bc['bf']['geo']['first_cnr_angle'] :'';

  $bc_webX['grt_status']  = isset(  $bc['grt']['status']  )?  $bc['grt']['status']  :'';
  $bc_webX['grt_mat'] = isset(  $bc['grt']['material']['name']  )?  $bc['grt']['material']['name']  :'';
  $bc_webX['grt_mat_fcp'] = isset(  $bc['grt']['material']['fcp'] )?  $bc['grt']['material']['fcp'] :'';
  $bc_webX['grt_spcn']  = isset(  $bc['grt']['geo']['spcn'] )?  $bc['grt']['geo']['spcn'] :'';
  $bc_webX['grt_thk'] = isset(  $bc['grt']['geo']['thk']  )?  $bc['grt']['geo']['thk']  :'';
  $bc_webX['grt_delta_d1']  = isset(  $bc['grt']['geo']['delta_d1'] )?  $bc['grt']['geo']['delta_d1'] :'';
  $bc_webX['grt_delta_d2']  = isset(  $bc['grt']['geo']['delta_d2'] )?  $bc['grt']['geo']['delta_d2'] :'';

  // for each $bc_webX's property, if it has a property 'value', then perform a unit conversion using



     $bc_web = array();
     $ikey = 0;
     $unit2useArr = (array)$unit2use;
     foreach($bc_webX as $key => $value) {

       if ( is_array($value) == 1){

         $xxx = array(
             'value'=> !empty($bc_webX[$key]['value']) ? $bc_webX[$key]['value'] : '',
             'unit'=> !empty($bc_webX[$key]['unit']) ? $bc_webX[$key]['unit'] : ''
         );

         if(!empty($unit2useArr[$key])) {

           $xxx = unitConversion($xxx, $unit2useArr[$key]);

         }

         $bc_web[$key] = $xxx;

       }else{
         $bc_web[$key] = $bc_webX[$key];
       }

       $ikey += 1;
     }


    return $bc_web;
    // return $bc_webX;

  }
  ?>
