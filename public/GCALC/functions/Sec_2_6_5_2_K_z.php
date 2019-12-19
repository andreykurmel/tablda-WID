<?php

$z_v_ft = $z['value']/12;

$K_z = min(max(2.01 * (pow(($z_v_ft / $z_g['value']), (2 / $alpha))), $K_zmin), 2.01);

return $K_z;

?>