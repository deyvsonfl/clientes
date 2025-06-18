<?php

namespace App\Controllers;


use App\Models\ClienteModel;
use CodeIgniter\Controller;
use App\Models\PedidosModel;
use App\Models\NichoModel;
use App\Validation\ClienteRules;



class Clientes extends Controller
{
    public function index()
    {
        $buscar = $this->request->getGet('q');
        $model  = new \App\Models\ClienteModel();

        if ($buscar) {
            $model->like('nome', $buscar);
        }

        $clientes = $model
            ->orderBy('nome', 'asc')
            ->paginate(10, 'grupoClientes');
        $pager     = $model->pager;

        return view('clientes/index', [
            'clientes'    => $clientes,
            'pager'       => $pager,
            'buscar'      => $buscar,
            // Column visibility is configured within the view
            'mostrarColunas' => [],
        ]);
    }
    public function criar()
    {
        $nichoModel = new NichoModel();
        $dados['nichos'] = $nichoModel->findAll();

        return view('clientes/form', $dados);
    }

    public function salvar()
    {
        helper(['form']);
        helper('format');

        if (! $this->validate(ClienteRules::regrasCadastro())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $input = $this->request->getPost();

        $data = [
            'nome'               => trim($input['nome']),
            'telefone'           => trim($input['telefone']),
            'instagram'          => trim($input['instagram'] ?? ''),
            'cep'                => trim($input['cep'] ?? ''),
            'estado'             => $input['estado'],
            'cidade'             => $input['cidade'],
            'bairro'             => $input['bairro'],
            'endereco'           => $input['endereco'],
            'nicho'              => $input['nicho'] ?? '',
            'data_ultima_compra' => null,
            'total_gasto'        => floatval(str_replace(',', '.', preg_replace('/[^\d,]/', '', $input['total_gasto'] ?? 0)))
        ];

        $model = new \App\Models\ClienteModel();
        $model->save($data);

        $clienteId = $model->getInsertID(); // pega o ID do cliente recém-cadastrado

        // Redirecionar diretamente para o pedido
        return redirect()->to('/pedidos/adicionar?cliente_id=' . $clienteId)
            ->with('success', 'Cliente cadastrado com sucesso. Agora você pode adicionar um pedido.');
    }

    public function editar($id)
    {
        $model = new ClienteModel();
        $cliente = $model->find($id);

        if (! $cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cliente com ID $id não encontrado.");
        }

        $nichoModel = new NichoModel();
        $dados['nichos'] = $nichoModel->findAll();
        $dados['cliente'] = $cliente;

        return view('clientes/form', $dados);
    }

    public function atualizar($id)
    {
        helper(['form']);
        helper('format');

        if (! $this->validate(ClienteRules::regrasAtualizacao())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ClienteModel();

        $data = [
            'id' => $id,
            'nome' => $this->request->getPost('nome'),
            'telefone' => $this->request->getPost('telefone'),
            'instagram' => $this->request->getPost('instagram'),
            'cep' => $this->request->getPost('cep'),
            'estado' => $this->request->getPost('estado'),
            'cidade' => $this->request->getPost('cidade'),
            'bairro' => $this->request->getPost('bairro'),
            'endereco' => $this->request->getPost('endereco'),
            'data_ultima_compra' => $this->request->getPost('data_ultima_compra'),
            'total_gasto' => format_real_to_float($this->request->getPost('total_gasto')),
            'status' => $this->request->getPost('status'),
            'recorrente' => $this->request->getPost('recorrente'),
            'nicho' => $this->request->getPost('nicho')
        ];

        $model->save($data);
        return redirect()->to('/clientes');
    }

    public function excluir($id)
    {
        $model = new ClienteModel();
        $model->delete($id);
        return redirect()->to('/clientes');
    }

    public function historico($id)
    {
        $clienteModel = new ClienteModel();
        $pedidoModel = new \App\Models\PedidoModel();

        $cliente = $clienteModel->find($id);
        $pedidos = $pedidoModel->getPedidosComClientes($id); // <- novo método

        return view('clientes/historico', [
            'cliente' => $cliente,
            'pedidos' => $pedidos
        ]);
    }

    public function painel($id)
    {
        $clienteModel = new ClienteModel();
        $pedidoModel  = new \App\Models\PedidoModel();

        $cliente = $clienteModel->find($id);
        if (! $cliente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Cliente #{$id} não encontrado");
        }

        $pedidos = $pedidoModel->getPedidosComClientes($id); // <- novo método

        // Cálculo de métricas
        $totalPedidos = count($pedidos);
        $ticketMedio = 0;
        $dataUltimoPedido = null;

        if ($totalPedidos > 0) {
            $somaTotal = array_sum(array_map(fn($p) => (float) $p->total, $pedidos));
            $ticketMedio = number_format($somaTotal / $totalPedidos, 2, ',', '.');
            $dataUltimoPedido = date('d/m/Y', strtotime($pedidos[0]->data_entrega ?? $pedidos[0]->created_at));
        }

        return view('clientes/painel', [
            'cliente'           => $cliente,
            'pedidos'           => $pedidos,
            'totalPedidos'      => $totalPedidos,
            'ticketMedio'       => $ticketMedio,
            'dataUltimoPedido'  => $dataUltimoPedido,
        ]);
    }
}
