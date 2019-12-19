<?php
function calculation(&$data, &$extra) {
    switch ($data->str_type) {
        case 'Latticed':
        case 'latticed':
            if (!empty($data->h)) {
                $data->G_h = min(max(0.85 + 0.15 * ($data->h / 150 - 3.0), 0.85), 1.00);
            } else {
                $data->G_h = 0.85;
            }            
            break;
        case 'guyed_mast':
            $data->G_h = 0.85;
            break;
        case 'tubular_pole':
        case 'other_pole':
            $data->G_h = 1.10;
            break;
        case 'appurtenance':
            $data->G_h = 0.95;
            break;
        case 'str_sptd_on_other_str':

            switch ($data->str_sptd_on_other_str) {
                case 'ballast_RT':
                    $data->G_h = 1.0;
                    break;

                case 'tubular_GT':
                case 'spine_GT':
                case 'pole_GT':
                case 'tubular_SST':
                case 'str_flexible_bldg':
                    $data->G_h = 1.35;
                    break;
                default:
                    $data->G_h = null;
                    break;
            }

            break;
        default:
            break;
    }
}
