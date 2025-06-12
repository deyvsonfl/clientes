<?php

if (!function_exists('statusCliente')) {
    /**
     * Retorna um badge de status do cliente considerando o número de dias de inatividade.
     *
     * Aceita tanto objetos (Entities) quanto arrays associativos.
     */
    function statusCliente($cliente, int $diasInatividade = 60): string
    {
        $dataUltima = is_object($cliente)
            ? ($cliente->data_ultima_compra ?? null)
            : ($cliente['data_ultima_compra'] ?? null);

        if (empty($dataUltima)) {
            return '<span class="badge bg-secondary">Inativo</span>';
        }

        $ultimaCompra = \CodeIgniter\I18n\Time::parse($dataUltima);
        $hoje         = \CodeIgniter\I18n\Time::now();

        $diasDesdeUltimaCompra = $hoje->difference($ultimaCompra)->getDays();

        if ($diasDesdeUltimaCompra <= $diasInatividade) {
            return '<span class="badge bg-success">Ativo</span>';
        }

        return '<span class="badge bg-danger">Inativo</span>';
    }
}
