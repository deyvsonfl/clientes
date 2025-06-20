<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Models\ClienteModel;
use App\Models\PedidoModel;

class Pedidos extends Controller
{
    public function index()
    {
        $pedidoModel = new PedidoModel();
        $perPage = 20;

        // Filtros
        $status          = $this->request->getGet('status');
        $forma_pagamento = $this->request->getGet('forma_pagamento');
        $dataInicial     = $this->request->getGet('data_inicial');
        $dataFinal       = $this->request->getGet('data_final');
        $q               = trim($this->request->getGet('q'));

        $pedidoModel
            ->select('pedidos.*, clientes.nome AS cliente')
            ->join('clientes', 'clientes.id = pedidos.cliente_id')
            ->orderBy('pedidos.created_at', 'DESC');

        if (!empty($status)) {
            $pedidoModel->where('pedidos.status', $status); // Ex: em_aberto, em_producao, etc.
        }

        if (!empty($forma_pagamento)) {
            $pedidoModel->where('pedidos.forma_pagamento', $forma_pagamento);
        }

        if (!empty($dataInicial)) {
            $pedidoModel->where('data_compra >=', $dataInicial);
        }

        if (!empty($dataFinal)) {
            $pedidoModel->where('data_compra <=', $dataFinal);
        }

        if (!empty($q)) {
            $pedidoModel->groupStart()
                ->like('clientes.nome', $q)
                ->orLike('pedidos.descricao', $q)
                ->groupEnd();
        }

        return view('pedidos/index', [
            'pedidos'         => $pedidoModel->paginate($perPage),
            'pager'           => $pedidoModel->pager,
            'status'          => $status,
            'forma_pagamento' => $forma_pagamento,
            'dataInicial'     => $dataInicial,
            'dataFinal'       => $dataFinal,
            'q'               => $q,
        ]);
    }

    public function adicionar()
    {
        $clienteId    = $this->request->getGet('cliente_id');
        $clienteModel = new ClienteModel();
        $clientes     = $clienteModel->findAll();
        $cliente      = $clienteId ? $clienteModel->find($clienteId) : null;

        return view('pedidos/form', [
            'cliente'  => $cliente,
            'clientes' => $clientes,
        ]);
    }

    public function salvar()
    {
        $clienteId     = $this->request->getPost('cliente_id');
        $clienteModel  = new ClienteModel();
        $cliente       = $clienteModel->find($clienteId);

        $total         = (float) $this->request->getPost('total');
        $data          = $this->request->getPost('data');
        $descricao     = $this->request->getPost('descricao');
        $status        = $this->request->getPost('status');
        $formaPagto    = $this->request->getPost('forma_pagamento');
        $erros         = [];

        if (! $cliente) {
            $erros[] = 'O cliente selecionado não foi encontrado.';
        }
        if ($total <= 0) {
            $erros[] = 'Informe um valor maior que zero para o pedido.';
        }
        if (empty($data)) {
            $erros[] = 'A data da compra é obrigatória.';
        }
        if ($erros) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        $pedidoModel = new PedidoModel();
        $pedidoModel->insert([
            'cliente_id'      => $cliente->id,
            'total'           => $total,
            'data_entrega'    => null,
            'data_compra'     => Time::createFromFormat('Y-m-d', $data),
            'descricao'       => $descricao,
            'status'          => $status,
            'forma_pagamento' => $formaPagto,
        ]);

        $cliente->total_gasto += $total;
        $cliente->data_ultima_compra = $data;
        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente->id)
            ->with('success', 'Pedido cadastrado com sucesso!');
    }

    public function excluir($id)
    {
        $pedidoModel  = new PedidoModel();
        $pedido       = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Não encontramos esse pedido para excluir.');
        }

        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($pedido->cliente_id);

        $cliente->total_gasto -= $pedido->total;
        $clienteModel->save($cliente);

        $pedidoModel->delete($id, true);

        return redirect()->back()->with('success', 'Pedido excluído com sucesso!');
    }

    public function editar($id)
    {
        $pedidoModel = new PedidoModel();
        $pedido      = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Não foi possível localizar este pedido.');
        }

        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($pedido->cliente_id);
        $clientes     = $clienteModel->findAll();

        $pedido->total = number_format((float) $pedido->total, 2, '.', '');

        return view('pedidos/form', [
            'pedido'   => $pedido,
            'cliente'  => $cliente,
            'clientes' => $clientes
        ]);
    }

    public function show($id)
    {
        $pedidoModel  = new PedidoModel();
        $pedido       = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->to('/clientes')->with('error', 'Pedido não encontrado.');
        }

        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($pedido->cliente_id);

        return view('pedidos/show', [
            'pedido'  => $pedido,
            'cliente' => $cliente
        ]);
    }

    public function atualizar($id)
    {
        $pedidoModel = new PedidoModel();
        $pedido      = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Este pedido não está disponível ou já foi removido.');
        }

        $clienteId    = $pedido->cliente_id;
        $totalNovo    = (float) $this->request->getPost('total');
        $data         = $this->request->getPost('data');
        $descricao    = $this->request->getPost('descricao');
        $status       = $this->request->getPost('status');
        $formaPagto   = $this->request->getPost('forma_pagamento');

        $erros = [];

        if ($totalNovo <= 0) {
            $erros[] = 'O valor do pedido deve ser maior que zero.';
        }
        if (empty($data)) {
            $erros[] = 'A data do pedido é obrigatória.';
        }

        if (!empty($erros)) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        $pedidoModel->update($id, [
            'total'           => $totalNovo,
            'data_compra'     => Time::createFromFormat('Y-m-d H:i:s', $data . ' 00:00:00'),
            'descricao'       => $descricao,
            'status'          => $status,
            'forma_pagamento' => $formaPagto,
        ]);

        return redirect()->to('/clientes/historico/' . $clienteId)
            ->with('success', 'Pedido atualizado com sucesso!');
    }
}
