<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Cliente;

class ClienteModel extends Model
{
    protected $table      = 'clientes';
    protected $primaryKey = 'id';
    protected $returnType = Cliente::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nome',
        'telefone',
        'instagram',
        'cep',
        'estado',
        'cidade',
        'bairro',
        'endereco',
        'nicho',
        'data_ultima_compra',
        'total_gasto'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
