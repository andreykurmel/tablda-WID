<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);



class g_calc {

    function exp_cat_coeff($exp_cat){
        return include "functions/Table_2_4_exp_cat_coeff.php"; // A_A, the symbol for Projected Area (P_A)
    }    

    function K_z($z, $z_g, $alpha, $K_zmin){
        return include "functions/Sec_2_6_5_2_K_z.php"; // velocity_pressure_coeff
    }

    function K_d($str_type, $str_cros_sec){
        return include "functions/Table_2_2_K_d.php"; // A_A, the symbol for Projected Area (P_A)
    }

    function I_p($str_class, $purpose_of_calculation){
        return include "functions/Table_2_3_I_p.php"; // A_A, the symbol for Projected Area (P_A)
    }

    function top_cat_coeff($topCAT, $K_e, $z, $H_crest){
        return include "functions/Table_2_5_top_cat_coeff.php"; // A_A, the symbol for Projected Area (P_A)
    }

    function t_iz($t_i, $I_p, $z, $K_zt){
        return include "functions/Sec_2_6_8_t_iz.php"; // 2.6.8 Design Ice Thickness
    }    

    function q_z($K_z, $K_zt, $K_d, $V, $I_p){
        return include "functions/Sec_2_6_9_6_q_z.php";
    }

    function q_z_api($data){
        return include "functions/Sec_2_6_9_6_q_z_api.php";
    }

    function C_a($member_type, $C, $aspect_ratio){
        return include "functions/Table_2_9_C_a.php"; // A_A, the symbol for Projected Area (P_A)
    } 

    // function doSomethingForFaces($type, $shapeType, $productData){
    //     return include "functions/DA_areas.php";
    //     // return include "functions/DA_faces_array.php";
    // }

    function K_a($csvtv_K_a, $da_type, $ca_flow_status, $da_pos, $epsilon, $ge_3mts_same_elev){
        return include "functions/K_a.php"; //
    }

    function G_h($str_type, $str_sptd_on_other_str){
        return include "functions/Sec_2_6_7_G_h.php"; //
    }

    function DWF_A($da, $unit2use){
        return include "functions/Sec_2_6_9_2_DWF_A.php"; // A_A, the symbol for Projected Area (P_A)
    }    

    function A_A_P_A($da, $unit2use, $ice_thk){
        return include "functions/Sec_2_6_9_2_A_A_P_A.php"; // A_A, the symbol for Projected Area (P_A)
    }

    // following method to be placed in a separate file and use something like include to include in.
    public function EPA_A($da, $unit2use){
        return include "functions/Sec_2_6_9_2_EPA_A.php";
    }

    public function DA_faces_array($da, $unit2use){
//        return include "functions/DA_areas.php"; // A_A, the symbol for Projected Area (P_A)
        return include "functions/DA_faces_array.php"; // A_A, the symbol for Projected Area (P_A)
    }
    
    public function VP($input){
        return include "functions/velocity_pressure.php";
    } 

}
?>