<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1>Painel de Controle: <?= esc($cliente->nome) ?></h1>

<div class="row g-4 mt-3">
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h5>Total de Pedidos</h5>
            <p class="fs-2"><?= $totalPedidos ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h5>Total Gasto (R$)</h5>
            <p class="fs-2"><?= number_format($somaTotal, 2, ',', '.') ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h5>Valor Médio (R$)</h5>
            <p class="fs-2"><?= number_format($valorMedio, 2, ',', '.') ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h5>Última Compra</h5>
            <p class="fs-5"><?= $ultimaCompra ? date('d/m/Y', strtotime($ultimaCompra)) : '—' ?></p>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="<?= base_url('/clientes') ?>" class="btn btn-secondary">Voltar à Lista</a>
    <a href="<?= base_url("/pedidos/adicionar?cliente_id={$cliente->id}") ?>" class="btn btn-primary">
        + Novo Pedido
    </a>
</div>

<hr class="my-4">

<h4>📦 Histórico de Pedidos</h4>

<!-- Formulário de filtros -->
<form method="get" class="row g-3 mb-4">
    <div class="col-md-3">
        <label for="data_inicio">Data Inicial</label>
        <input type="date" id="data_inicio" name="data_inicio" value="<?= esc($filtros['data_inicio'] ?? '') ?>" class="form-control">
    </div>
    <div class="col-md-3">
        <label for="data_fim">Data Final</label>
        <input type="date" id="data_fim" name="data_fim" value="<?= esc($filtros['data_fim'] ?? '') ?>" class="form-control">
    </div>
    <div class="col-md-2">
        <label for="valor_min">Valor Mínimo</label>
        <input type="number" id="valor_min" name="valor_min" step="0.01" value="<?= esc($filtros['valor_min'] ?? '') ?>" class="form-control">
    </div>
    <div class="col-md-2">
        <label for="valor_max">Valor Máximo</label>
        <input type="number" id="valor_max" name="valor_max" step="0.01" value="<?= esc($filtros['valor_max'] ?? '') ?>" class="form-control">
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">🔍 Filtrar</button>
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <a href="<?= current_url() ?>" class="btn btn-outline-secondary w-100">⟳ Limpar</a>
    </div>
</form>

<?php if (empty($pedidos)): ?>
    <div class="alert alert-info">Este cliente ainda não possui pedidos registrados.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= formatar_data_br($pedido->data_compra) ?></td>
                        <td><?= formatar_real($pedido->valor) ?></td>
                        <td><?= esc($pedido->descricao) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('pedidos/editar/' . $pedido->id) ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <a href="<?= base_url('pedidos/excluir/' . $pedido->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja excluir este pedido?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>