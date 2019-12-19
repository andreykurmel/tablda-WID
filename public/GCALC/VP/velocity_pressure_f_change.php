<?php
function calculation(&$data, &$extra) {
    $data->I = $extra['table']['importance_factor'][$data->str_class][$data->purpose_of_calculation];
    $I = $data->I;

    $prmtr_based_on_expCAT = $extra['table']['prmtr_based_on_expCAT'][$data->expCAT];
    $data->z_g = $prmtr_based_on_expCAT['z_g'];
    $data->alpha = $prmtr_based_on_expCAT['alpha'];
    $data->K_zmin = $prmtr_based_on_expCAT['K_zmin'];
    $data->K_e = $prmtr_based_on_expCAT['K_e'];

    $z_g = $data->z_g;
    $alpha = $data->alpha;
    $K_zmin = $data->K_zmin;
    $K_e = $data->K_e;

    $prmtr_based_on_topCAT = $extra['table']['prmtr_based_on_topCAT'][$data->topCAT];
    $data->K_t = $prmtr_based_on_topCAT['K_t'];
    $data->f = $prmtr_based_on_topCAT['f'];

    $K_t = $data->K_t;
    $f = $data->f;

    $z = $data->z;

    $data->K_z = (float)(min(max(2.01 * (pow(($z / $z_g), (2 / $alpha))), $K_zmin), 2.01));

    $K_z = $data->K_z;
    $e = $data->exp;
    $H_crest = $data->H_crest;
    $f = $data->f;

    if ($H_crest == 0) {
        $data->K_h = 0;
    } else {
        $data->K_h = (float)(pow($e, $f * $z / $H_crest));
    }

    $K_e = $data->K_e;
    $K_h = $data->K_h;
    $K_t = $data->K_t;

    switch ($data->topCAT) {
        case '1':
        case 1:
            $data->K_zt = 1.0;
            break;

        case '2':
        case '3':
        case '4':
            if ($K_h == 0) {
                $data->K_zt = 0;
            } else {
                $data->K_zt = pow(1 + $K_e * $K_t / $K_h, 2);
            }            
            break;

        case '5':
            $data->K_zt = $data->K_zt5;
            break;
        default:
            break;
    }

    switch ($data->str_type) {
        case 'Latticed':
        case 'latticed':
        case 'guyed_mast':

            switch ($data->str_cros_sec) {
                case 'triangular':
                case 'square':
                case 'rectangular':
                    $data->K_d = 0.85;
                    break;
                case 'others':
                    $data->K_d = 0.95;
                    break;
                default:
                    break;
            }
            break;

        case 'tubular_pole':
        case 'other_pole':
        case 'appurtenance':
            $data->K_d = 0.95;
            break;
        default:
            break;
    }

    $K_zt = $data->K_zt;
    $K_d = $data->K_d;
    $V = $data->V;

    if (!is_numeric($I)) {
        $I = 1.0;
    }

    $data->q_z = (float)(0.00256 * $K_z * $K_zt * $K_d * (pow($V, 2)) * $I);
}