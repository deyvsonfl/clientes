<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToPedidos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('pedidos', [
            'status' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'descricao'
            ]
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('pedidos', 'status');
    }
}
