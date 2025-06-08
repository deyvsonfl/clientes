<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nome', 'telefone', 'instagram', 'estado', 'cidade', 'nicho',
        'data_ultima_compra', 'total_gasto', 'recorrente'
    ];
}
