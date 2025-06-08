<?php

if (!function_exists('statusCliente')) {
    function statusCliente(array $cliente): string
    {
        if (empty($cliente['data_ultima_compra'])) {
            return '<span class="badge bg-secondary">Inativo</span>';
        }

        $ultimaCompra = \CodeIgniter\I18n\Time::parse($cliente['data_ultima_compra']);
        $hoje = \CodeIgniter\I18n\Time::now();

        $diasDesdeUltimaCompra = $hoje->difference($ultimaCompra)->getDays();

        if ($diasDesdeUltimaCompra <= 60) {
            return '<span class="badge bg-success">Ativo</span>';
        }

        return '<span class="badge bg-danger">Inativo</span>';
    }
}
