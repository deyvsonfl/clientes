<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use CodeIgniter\Controller;
use App\Models\PedidosModel;
use App\Models\NichoModel;



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
            'mostrarColunas' => [], // seu array de colunas
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

        $validationRules = [
            'nome'      => 'required|min_length[3]',
            'telefone'  => 'required|valid_phone',
            'cep'       => 'permit_empty|valid_cep',
            'estado'    => 'required',
            'cidade'    => 'required',
            'bairro'    => 'required',
            'endereco'  => 'required',
        ];

        if (! $this->validate($validationRules)) {
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

        $validationRules = [
            'nome'     => 'required|min_length[3]',
            'telefone' => 'required|valid_phone',
            'cep'      => 'permit_empty|valid_cep'
        ];

        if (! $this->validate($validationRules)) {
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
            'total_gasto' => $this->request->getPost('total_gasto'),
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
        $pedidoModel = new \App\Models\PedidosModel();

        $cliente = $clienteModel->find($id);
        $pedidos = $pedidoModel
            ->where('cliente_id', $id)
            ->orderBy('data_compra', 'ASC') // ordena do mais antigo ao mais recente
            ->findAll();

        return view('clientes/historico', [
            'cliente' => $cliente,
            'pedidos' => $pedidos
        ]);
    }

    public function painel($id)
    {
        $clienteModel = new ClienteModel();
        $pedidoModel  = new PedidosModel();

        // Carrega o cliente
        $cliente = $clienteModel->find($id);
        if (! $cliente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Cliente #{$id} não encontrado");
        }

        // Estatísticas básicas
        $totalPedidos   = $pedidoModel->where('cliente_id', $id)->countAllResults();
        $somaTotal = $pedidoModel
            ->selectSum('valor', 'total_gasto')
            ->where('cliente_id', $id)
            ->first()->total_gasto ?? 0;
        $valorMedio     = $totalPedidos
            ? round($somaTotal / $totalPedidos, 2)
            : 0;
        $ultimaCompra   = $pedidoModel
            ->where('cliente_id', $id)
            ->orderBy('data_compra', 'DESC')
            ->first()->data_compra ?? null;

        return view('clientes/painel', [
            'cliente'      => $cliente,
            'totalPedidos' => $totalPedidos,
            'somaTotal'    => $somaTotal,
            'valorMedio'   => $valorMedio,
            'ultimaCompra' => $ultimaCompra,
        ]);
    }
}
