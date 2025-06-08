<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nome',
        'telefone',
        'instagram',
        'cep',
        'estado',
        'cidade',
        'bairro',
        'endereco',
        'data_ultima_compra',
        'total_gasto',
        'status',
        'recorrente',
        'nicho',
    ];
}
