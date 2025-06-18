<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Models\ClienteModel;
use App\Models\PedidoModel;   // modelo novo (Option B)
use App\Models\PedidosModel;  // modelo antigo (para métodos já existentes)

/**
 * Controller unificado para Pedidos
 * — adiciona método index() para listar TODOS os pedidos
 */
class Pedidos extends Controller
{
    /**
     * GET /pedidos
     * Lista todos os pedidos de todos os clientes.
     */
    public function index()
    {
        $pedidoModel = new PedidoModel();
        $perPage = 20;

        // Filtros
        $status = $this->request->getGet('status');
        $forma_pagamento = $this->request->getGet('forma_pagamento');
        $q = trim($this->request->getGet('q'));

        $pedidoModel
            ->select('pedidos.*, clientes.nome AS cliente')
            ->join('clientes', 'clientes.id = pedidos.cliente_id')
            ->orderBy('pedidos.created_at', 'DESC');

        if (!empty($status)) {
            $pedidoModel->where('pedidos.status', $status);
        }

        if (!empty($forma_pagamento)) {
            $pedidoModel->where('pedidos.forma_pagamento', $forma_pagamento);
        }

        if (!empty($q)) {
            $pedidoModel->groupStart()
                ->like('clientes.nome', $q)
                ->orLike('pedidos.descricao', $q)
                ->groupEnd();
        }

        $dados = [
            'pedidos' => $pedidoModel->paginate($perPage),
            'pager'   => $pedidoModel->pager,
            'status' => $status,
            'forma_pagamento' => $forma_pagamento,
            'q' => $q,
        ];

        return view('pedidos/index', $dados);
    }

    /**
     * Exibe formulário para adicionar pedido.
     */
    public function adicionar()
    {
        $clienteId     = $this->request->getGet('cliente_id');
        $clienteModel  = new ClienteModel();
        $clientes      = $clienteModel->findAll();
        $cliente       = $clienteId ? $clienteModel->find($clienteId) : null;

        return view('pedidos/form', [
            'cliente'  => $cliente,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Salva novo pedido vindo do formulário.
     */
    public function salvar()
    {
        $clienteId    = $this->request->getPost('cliente_id');
        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($clienteId);

        $total        = (float) $this->request->getPost('total');
        $data         = $this->request->getPost('data');
        $descricao    = $this->request->getPost('descricao');
        $status       = $this->request->getPost('status');
        $erros        = [];

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
            'cliente_id'     => $cliente->id,
            'total'          => $total,
            'data_entrega'   => null,
            'descricao'      => $descricao,
            'status'         => $status,
            'forma_pagamento' => $this->request->getPost('forma_pagamento'),
        ]);

        $cliente->total_gasto += $total;
        $cliente->data_ultima_compra = $data;
        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente->id)
            ->with('success', 'Pedido cadastrado com sucesso!');
    }

    public function excluir($id)
    {
        $pedidoModel = new \App\Models\PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Não encontramos esse pedido para excluir.');
        }

        $clienteModel = new \App\Models\ClienteModel();
        $cliente = $clienteModel->find($pedido->cliente_id);

        // Corrigido: campo correto é total
        $cliente->total_gasto -= $pedido->total;
        $clienteModel->save($cliente);

        // Exclusão forçada, já que useSoftDeletes = false
        $pedidoModel->delete($id, true);

        return redirect()->to('/clientes/historico/' . $cliente->id)->with('success', 'Pedido excluído com sucesso!');
    }

    public function editar($id)
    {
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Não foi possível localizar este pedido.');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($pedido->cliente_id);
        $clientes = $clienteModel->findAll();

        $pedido->total = number_format((float) $pedido->total, 2, '.', '');

        return view('pedidos/form', [
            'pedido'   => $pedido,
            'cliente'  => $cliente,
            'clientes' => $clientes
        ]);
    }

    public function show($id)
    {
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->to('/clientes')->with('error', 'Pedido não encontrado.');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($pedido->cliente_id);

        return view('pedidos/show', [
            'pedido'  => $pedido,
            'cliente' => $cliente
        ]);
    }

    public function atualizar($id)
    {
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Este pedido não está disponível ou já foi removido.');
        }

        $valorAntigo = $pedido->total;
        $clienteId   = $pedido->cliente_id;

        $valorNovo   = (float) $this->request->getPost('valor');
        $data        = $this->request->getPost('data');
        $descricao   = $this->request->getPost('descricao');
        $status      = $this->request->getPost('status');


        $erros = [];

        if ($valorNovo <= 0) {
            $erros[] = 'O valor do pedido deve ser maior que zero.';
        }
        if (empty($data)) {
            $erros[] = 'A data do pedido é obrigatória.';
        }

        if (!empty($erros)) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        $pedidoModel->update($id, [
            'total'       => $valorNovo,
            'data_compra' => Time::createFromFormat('Y-m-d H:i:s', $data . ' 00:00:00'),
            'descricao'   => $descricao,
            'status'      => $status,
            'forma_pagamento' => $this->request->getPost('forma_pagamento'),
        ]);

        return redirect()->to('/clientes/historico/' . $clienteId)->with('success', 'Pedido atualizado com sucesso!');
    }
}
