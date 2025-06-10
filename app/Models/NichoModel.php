<?php

namespace App\Models;

use CodeIgniter\Model;

class NichoModel extends Model
{
  protected $table      = 'nichos';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nome'];
}
