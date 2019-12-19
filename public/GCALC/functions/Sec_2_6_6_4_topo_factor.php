<?php

$e = 2.718;

if ($H == 0) {
    $K_h = Infinity;
} else {
    $K_h = parseFloat((Math.pow($e, $f * $z['value'] / $H['value'])));
                    // console.log('e=' + e + ', f=' + f + ', z=' + z + ', H=' + H);
}

switch ($topCAT) {
    case '1':
    case 1:
    $K_zt = 1.0;
    break;

    case '2':
    case '3':
    case '4':
    $K_zt = pow(1 + K_e * K_t / K_h, 2);
    break;

    case '5':
    $K_zt = $K_zt5;
    break;
    default:
    break;
}

return $K_zt;

?>