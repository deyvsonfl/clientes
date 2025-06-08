<?php

namespace App\Controllers;

use App\Models\ClientesModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $model = new ClientesModel();

        $totalClientes = $model->countAll();
        $clientesRecorrentes = $model->where('recorrente', 1)->countAllResults();
        $totalGasto = $model->selectSum('total_gasto')->first()['total_gasto'] ?? 0;
        $ticketMedio = $totalClientes > 0 ? $totalGasto / $totalClientes : 0;

        $cidadeTop = $model
            ->select('cidade, COUNT(*) as total')
            ->groupBy('cidade')
            ->orderBy('total', 'DESC')
            ->limit(1)
            ->first()['cidade'] ?? 'Nenhuma';

        return view('dashboard', [
            'totalClientes' => $totalClientes,
            'clientesRecorrentes' => $clientesRecorrentes,
            'totalGasto' => $totalGasto,
            'ticketMedio' => $ticketMedio,
            'cidadeTop' => $cidadeTop,
        ]);
    }
}
