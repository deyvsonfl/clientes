<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table = 'configuracoes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome_sistema',
        'dias_inatividade',
        'mostrar_colunas',
        'mostrar_status',
        'nichos' // 👈 novo campo incluído aqui
    ];
    public $timestamps = false;

    public function getConfiguracoes()
    {
        return $this->first() ?? [
            'nome_sistema'       => 'Sistema',
            'dias_inatividade'   => 60,
            'mostrar_colunas'    => 'instagram,data_ultima_compra,total_gasto,status,recorrente',
            'mostrar_status'     => 1,
            'nichos'             => '', // 👈 valor padrão
        ];
    }
}
