<?php
function calculation(&$input, &$extra) {

	include "unit2use.php"; // the units for plotting process and calculation.
	include "./../../../../../../SHARED/php/array_unit_conversion.php";
	// include "./../../../SHARED/php/unitConversion.php";	no need array_unit_conversion.php includes this already.
	
	// include 'profiles/initialization.php'; // no initialization is needed.

	$get_params = (object)$_GET;
	$data = json_decode($get_params->data);
	$unit = json_decode($get_params->unit);
	$template = $get_params->template;
	$cvns_wth = $get_params->cvns;
	$whatschagned = $get_params->whatschanged;

	$input_src = $get_params->input_src;

    $procs_stage = 'bf_all'; include "output_json_files_for_check.php"; 

    // $procs_stage = 'af_ini_bf_web2model';   include "output_json_files_for_check.php"; 

	if($input_src == 'template'){
	include $template;
	// to import a file saving a defined bc model.	
	// echo 'loaded a template file: ';	

		$tpl_ptn = $bc['stfnr']['geo']['pattern'];
		if($bc['stfnr']['status'] == 1){
			if($tpl_ptn == '1p1' || $tpl_ptn == '1p1b' || $tpl_ptn == '1p1s' || $tpl_ptn == '1p1e'){
				$bc['stfnr']['geo']['configuration'] = 1;
			}else if($tpl_ptn == '1p2'){
				$bc['stfnr']['geo']['configuration'] = 2;
			}else if($tpl_ptn == '2p1'){
				$bc['stfnr']['geo']['configuration'] = 3;
			}else{
				$bc['stfnr']['geo']['configuration'] = '';
			}
		}else{
			$bc['stfnr']['geo']['configuration'] = 0;
		}

    $procs_stage = 'af_tmplt_bf_plot'; include "output_json_files_for_check.php";   


	}else if($input_src == 'web'){

    include "profiles/web_input_to_model_file.php"; // to be done, on top of aero_round.php.
    // to use web inputs to create a bc model with defined file format.
    // echo 'web input is obtained: ';

    $procs_stage = 'af_web2model_bf_plot'; include "output_json_files_for_check.php";   

	}else{}

	$bc_input = $bc; // $bc from template or webinput after going through the process of converting webinput to standard input format .

	// this part of code is to generate necessary data for generating the 2D plot of the bc.
	include "Plot/data_plot.php"; // this takes &$input, &$extra and generate $bc to be used for plotting.

	$procs_stage = 'af_plot_bf_calc'; include "output_json_files_for_check.php";

	$bc_plot = $bc; // $bc after going through the plotting process functions.

	// include "Calculations/calc_main.php";
	$bc_calc = $bc; // $bc after going through the calculation functions.

	$procs_stage = 'af_calc'; include "output_json_files_for_check.php";

	include 'output_for_web.php'; // the loaded template or processed webinput are done in $unit2use and need to be converted to the units in bc2d.json
	$bc_web = output_for_web($bc, $unit);

	$bc['input'] = $bc_input;
	$bc['plot']  = $bc_plot;
	$bc['calc']  = $bc_calc;
	$bc['web']   = $bc_web;

	$procs_stage = 'af_all'; include "output_json_files_for_check.php";

	return $bc;
}

?>