<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Cliente extends Entity
{
    protected $dates = ['data_ultima_compra','created_at','updated_at'];
    protected $casts = [
        'id'               => 'integer',
        'total_gasto'      => 'float',
    ];
}
