<?php

// 2.6.9.2.2 Effective Projected Area for Mounting Frames (Figure 2-5)

$shape_mtn_frm = 'sqr_truss'; // sqr_truss, tri_truss, square or triangular truss

$A_g = 

$A_r = 

$A_f = 

$epsilon = ($A_f + $A_r) / $A_g;

$R_rf = 0.6 + 0.4 * pow($epsilon, 2);

IF($epsilon <= 0.6){
    $C_as = 1.58 + 1.05*pow(0.6 - $epsilon, 1.8);
}else{
    $C_as = 1.58 + 2.63*pow($epsilon - 0.6, 2.0);
}

if($shape_mtn_frm == 'sqr_truss' || $shape_mtn_frm == 'tri_truss'){
    $C_as = $C_f; 
}

$EPA_MN = $C_as*($Af + $Rrf*$Ar); // Effective projected area of the frame

// ------------------------------

$SUM_A_fs = // projected area of flat components supporting the mounting frame without regard to shielding or overlapping members

$SUM_A_rs = // projected area of round components supporting the mounting frame without regard to shielding or overlapping members

$EPA_FN = 0.5* (2.0 * $SUM_A_fs + 1.2 * $SUM_A_rs);


// -----------------------------------------------------------------------

$EPA_N = $EPA_MN + $EPA_FN;






// -----------------------------------------------------------------------

$EPA_FT = 

$SUM_EPA_FTi = 

$SUM_EPA_MT = 

$EPA_T = $EPA_FT + 0.5*$SUM_EPA_FTi + 0.5*$SUM_EPA_MT;


return $da;

?>