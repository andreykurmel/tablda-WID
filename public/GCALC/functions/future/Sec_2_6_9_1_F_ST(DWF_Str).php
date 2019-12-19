<?php

// The design wind force, FS, applied to "each section" of a structure

$q_z_v = 

$G_h = $da['g_h']; // calculations to be done. 

$EPA_S_v = 

$F_ST_v = $q_z_v * $G_h * $EPA_S_v;

$F_ST = array('value'=>$dwf_v, 'unit'=>$unit2use['force']);


return $F_ST;

?>