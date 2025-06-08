<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ConfigModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $clienteModel = new ClienteModel();
        $configModel = new ConfigModel();

        $configuracoes = $configModel->getConfiguracoes();
        $diasInatividade = (int) ($configuracoes['dias_inatividade'] ?? 60);

        $clientes = $clienteModel->findAll();

        $totalClientes = count($clientes);
        $clientesRecorrentes = count(array_filter($clientes, fn($c) => $c['recorrente']));
        $clientesInativos = count(array_filter($clientes, function ($c) use ($diasInatividade) {
            if (empty($c['data_ultima_compra'])) return true;
            $dataUltima = new \DateTime($c['data_ultima_compra']);
            $hoje = new \DateTime();
            return $dataUltima->diff($hoje)->days > $diasInatividade;
        }));

        $totalGasto = array_sum(array_column($clientes, 'total_gasto'));
        $ticketMedio = $totalClientes > 0 ? $totalGasto / $totalClientes : 0;

        // Cidade com mais clientes
        $cidades = array_column($clientes, 'cidade');
        $contagem = array_count_values($cidades);
        arsort($contagem);
        $cidadeTop = key($contagem);

        return view('dashboard/index', [
            'totalClientes' => $totalClientes,
            'clientesRecorrentes' => $clientesRecorrentes,
            'clientesInativos' => $clientesInativos,
            'totalGasto' => $totalGasto,
            'ticketMedio' => $ticketMedio,
            'cidadeTop' => $cidadeTop,
            'configuracoes' => $configuracoes
        ]);
    }
}
