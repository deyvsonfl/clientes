<?php

if (!function_exists('formatar_data_br')) {
    function formatar_data_br($data)
    {
        return date('d/m/Y', strtotime($data));
    }
}
