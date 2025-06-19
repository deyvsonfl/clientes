<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ConfigModel;
use App\Models\PedidoModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $clienteModel = new ClienteModel();
        $pedidoModel = new PedidoModel(); // <-- Adicione esta linha
        $configModel = new ConfigModel();

        $configuracoes = $configModel->getConfiguracoes();
        $diasInatividade = (int) ($configuracoes['dias_inatividade'] ?? 60);

        $clientes = $clienteModel->findAll();
        $pedidos  = $pedidoModel->findAll(); // você pode usar countAllResults() se quiser mais rápido

        $totalClientes = count($clientes);
        $totalPedidos  = count($pedidos); // <-- Aqui

        $clientesRecorrentes = count(array_filter($clientes, fn($c) => $c->recorrente));
        $clientesInativos = count(array_filter($clientes, function ($c) use ($diasInatividade) {
            if (empty($c->data_ultima_compra)) return true;
            $dataUltima = new \DateTime($c->data_ultima_compra);
            $hoje = new \DateTime();
            return $dataUltima->diff($hoje)->days > $diasInatividade;
        }));

        $totalGasto = array_sum(array_column($clientes, 'total_gasto'));
        $ticketMedio = $totalClientes > 0 ? $totalGasto / $totalClientes : 0;

        // Cidade com mais clientes
        $cidades = array_filter(array_column($clientes, 'cidade'), fn($cidade) => !empty($cidade));
        $contagem = array_count_values($cidades);
        arsort($contagem);
        $cidadeMaisClientes = !empty($contagem) ? key($contagem) : '-';

        return view('dashboard/index', [
            'totalClientes'       => $totalClientes,
            'clientesRecorrentes' => $clientesRecorrentes,
            'clientesInativos'    => $clientesInativos,
            'totalGasto'          => $totalGasto,
            'ticketMedio'         => $ticketMedio,
            'totalPedidos'        => $totalPedidos,
            'configuracoes'       => $configuracoes,
            'totalInvestido'      => $totalGasto,
            'diasInatividade'     => $diasInatividade,
            'cidadeTop'           => $cidadeMaisClientes,
        ]);
    }

    public function dadosGraficoVendas()
    {
        $tipo = $this->request->getGet('tipo');
        $inicio = $this->request->getGet('inicio');
        $fim = $this->request->getGet('fim');

        $pedidoModel = new \App\Models\PedidoModel();
        $builder = $pedidoModel->select("DATE(data_compra) as dia, SUM(total) as total")
            ->groupBy('dia')
            ->orderBy('dia', 'ASC');

        if ($tipo === 'semana') {
            $builder->where('data_compra >=', date('Y-m-d', strtotime('-6 days')));
        } elseif ($tipo === 'mes') {
            $builder->where('MONTH(data_compra)', date('m'))
                ->where('YEAR(data_compra)', date('Y'));
        } elseif ($tipo === 'ano') {
            $builder->where('YEAR(data_compra)', date('Y'));
        } elseif ($tipo === 'personalizado' && $inicio && $fim) {
            $builder->where('data_compra >=', $inicio)
                ->where('data_compra <=', $fim);
        }

        $dados = $builder->findAll();

        return $this->response->setJSON($dados);
    }
}
