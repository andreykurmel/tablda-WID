<?php
// error_reporting(-1); // -1:Report all PHP errors
// session_name("STIM");
// session_start();
require_once('database.php');
$db = new dbManagement();

$data = json_decode(file_get_contents('php://input'));

if(!$data){
    $data = (object)$_POST;
}

$action = $data->action;
switch($action){
    case "get_aisc_sizes_by_type":
        if(!empty($data->shape_type)){
            $sizesArray = $db->getSteelshapeSizes($data->shape_type);
        }else{
            $sizesArray = $db->getSteelshapeSizes();
        }
        echo json_encode($sizesArray);
        break;
    case "get_aisc_type_by_size":
        if(!empty($data->shape_size)){
            $type = $db->getSteelshapeTypes($data->shape_size);
            echo json_encode($type);
        } else {
            $typesArray = $db->getSteelshapeTypes();
            echo json_encode($typesArray);
        }
        break;

    case "get_steel_shape_size_details":
    case "get_aisc_sizes_detail":
        $dbSRC = $data->dbSRC;
        $Type = $data->Type;
        $SizeType = $data->SizeType;
        $SizeUnit = $data->SizeUnit;
        $Size1 = $data->Size1;
        $Size2 = $data->Size2;

        $db->getSteelshapeSizeDetails($dbSRC, $Type, $SizeType, $SizeUnit, $Size1, $Size2);
        break;
    case "get_steel_standards":
        if(!empty($data->grade)){
            $standardsArray = $db->getSteelstandards($data->use, $data->grade);
        } else {
            $standardsArray = $db->getSteelstandards($data->use);
        }
        echo json_encode($standardsArray);
        break;
    case "get_steel_grades":
        $gradesArray = $db->getSteelgrades($data->use, $data->standard);
        echo json_encode($gradesArray);
        break;
    case "get_steel_grade_details":
        break;
    case "getUserData":
        $userData = array();
        $userData['projectsList'] = $db->getDDL4usersBC($data->userId, 'project');
        $userData['templatesList'] = $db->getDDL4usersBC($data->userId, 'template');
        echo json_encode($userData);
        break;
    case "add":
        $RcdData = $data; $db->addRcd($RcdData); break;
    case "delete":
        $RcdID = $data->bcid; $db->deleteModel($RcdID); break;
    case "save":
        $RcdData = $data; $db->saveModel($RcdData->model, $RcdData->userId); break;
    case "saveAs":
        $db->saveModelAs($data->model, $data->userData, $data->userId); break;
    case 'get':
        $datatype = $data->datatype;
        switch($datatype){
            case "specific":
                $idType = isset($data->idType) ? $data->idType: '';
                $idName = isset($data->idName) ? $data->idName: '';
                $calcs = array();
                $modelData = $db->getRcd($idType, $idName);
                if($modelData && $idName){
                    $modelData[0]->stiffener_g = $db->getStiffenerG($modelData[0]->BCID);
                    $modelData[0]->stiffener_l = $db->getStiffenerL($modelData[0]->BCID);
                    $modelData[0]->calcs = $db->getCalcs($modelData[0]->BCID);
                    $modelData[0]->ilc = $db->getilc($modelData[0]->BCID);
                    $modelData[0]->lc = $db->getlc($modelData[0]->BCID);
                }
                // convert to json
                $json = json_encode( array('modelData' => $modelData) );
                // echo the json string
                echo $json;
                break;
            case 'general':
                $GD = new stdClass();
                $GD->DDL2 = $db->getDDL('listid', '2');
                $GD->bf_lcs_offset_options   = $db->getDDL('listid', '60');
                $GD->bf_g_start_options      = $db->getDDL('listid', '61');
                $GD->bf_g_baseshape_options  = $db->getDDL('listid', '62');
                $GD->bf_m_type_options       = $db->getDDL('listid', '63');
                $GD->abr_type_options  = $db->getDDL('listid', '64');
                $GD->abr_cip_dia_options = 	$db->getDDL('listid', '65');
                $GD->abr_layout_pattern_options	= $db->getDDL('listid', '66');
                $GD->abr_layout_oshape_options = $db->getDDL('listid', '67');
                $GD->pc_d_crosec_options = $db->getDDL('listid', '68');
                $GD->bf_m_conc_crkstatus_options = $db->getDDL('listid', '69');
                $GD->bf_reinf_anchor_options = $db->getDDL('listid', '70');
                $GD->pc_d_polygon_sidenbr_options = $db->getDDL('listid', '71');
                $GD->pc_d_polygon_OD_type_options = $db->getDDL('listid', '72');
                // $GD->aisc_steelshape_types = $db->getSteelshapeTypes();
                // $GD->aisc_steelshape_sizes = $db->getSteelshapeSizes();
                $GD->bf_ic_drilling_options = $db->getDDL('listid', '73');
                $GD->bf_ic_water_options    = $db->getDDL('listid', '74');
                $GD->bf_ic_hole_options     = $db->getDDL('listid', '75');
                $GD->bf_reinf_spltl_size_options = $db->getDDL('listid', '76');
                $GD->bf_reinf_spltl_shearcdnt_options = $db->getDDL('listid', '77');
                $GD->bf_reinf_spltl_tensioncdnt_options = $db->getDDL('listid', '78');
                $GD->abr_cip_subtype_options = $db->getDDL('listid', '79');
                $GD->ABR_pi_type_options = $db->getDDL('listid', '80');
                $GD->ABR_pi_expn_trq_type_options = $db->getDDL('listid', '81');
                $GD->abr_pi_mftr_options = $db->getDDL('listname', 'abr_pi_mftr_options');
                // $GD->bp_d_innerhole_shape_options = $db->getDDL('listname', 'bp_d_innerhole_shape_options');
                $GD->bp_d_innerhole_shape_options = $db->getDDL('listid', '83');
                $GD->bp_d_baseshape_options = $db->getDDL('listname', 'bp_d_baseshape_options');
                $GD->abr_cip_steel_standard_options = $db->getSteelstandards('bolt');
                $GD->bp_steel_standard_options = $db->getSteelstandards('mbr');
                $GD->pc_steel_standard_options = $GD->bp_steel_standard_options;
                $GD->units = $db->getUnits($data->bcid);
                $GD->anchoragecode_options = $db->getDDL('listname', 'anchoragecode_options');
                $json4GD = json_encode($GD);
                echo $json4GD;
                break;
            default:
                break;
        }
        break;
    default:
        break;
}
