<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<?php
$colunasRaw = $configuracoes['mostrar_colunas'] ?? '';
$colunasString = is_array($colunasRaw) ? implode(',', $colunasRaw) : $colunasRaw;
$mostrarColunas = explode(',', $colunasString);
?>

<h1 class="mb-4 fw-bold d-flex align-items-center">
    <i class="bi bi-people-fill text-primary me-2 fs-3"></i> Lista de Clientes
</h1>

<div class="row align-items-center mb-4 g-2">
    <div class="col-auto">
        <a href="<?= base_url('clientes/criar') ?>" class="btn btn-primary rounded-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Cliente
        </a>
    </div>

    <div class="col-md-6 col-lg-5 col-xl-3">
        <form class="input-group shadow-sm" method="get" action="<?= base_url('clientes') ?>">
            <input type="text" name="busca" class="form-control rounded-start-3" placeholder="Buscar cliente..." value="<?= esc($busca ?? '') ?>">
            <button class="btn btn-outline-primary rounded-end-3" type="submit">
                <i class="bi bi-search me-1"></i> Buscar
            </button>
        </form>
    </div>
</div>

<div class="table-responsive rounded-4 shadow-sm bg-white">
    <table class="table table-hover align-middle table-striped mb-0">
        <thead class="table-light">
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <?php if (in_array('instagram', $mostrarColunas)): ?>
                    <th>Instagram</th>
                <?php endif; ?>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Nicho</th>
                <?php if (in_array('data_ultima_compra', $mostrarColunas)): ?>
                    <th>Última Compra</th>
                <?php endif; ?>
                <?php if (in_array('total_gasto', $mostrarColunas)): ?>
                    <th>Total Gasto</th>
                <?php endif; ?>
                <?php if (in_array('status', $mostrarColunas)): ?>
                    <th>Status</th>
                <?php endif; ?>
                <?php if (in_array('recorrente', $mostrarColunas)): ?>
                    <th>Recorrente</th>
                <?php endif; ?>
                <th class="text-end">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= esc($cliente->nome) ?></td>
                    <td><?= esc($cliente->telefone) ?></td>
                    <?php if (in_array('instagram', $mostrarColunas)): ?>
                        <td><?= esc($cliente->instagram) ?></td>
                    <?php endif; ?>
                    <td><?= esc($cliente->estado) ?></td>
                    <td><?= esc($cliente->cidade) ?></td>
                    <td><?= esc($cliente->nicho) ?></td>
                    <?php if (in_array('data_ultima_compra', $mostrarColunas)): ?>
                        <td><?= formatar_data_br($cliente->data_ultima_compra) ?></td>
                    <?php endif; ?>
                    <?php if (in_array('total_gasto', $mostrarColunas)): ?>
                        <td><?= formatar_real($cliente->total_gasto) ?></td>
                    <?php endif; ?>
                    <?php if (in_array('status', $mostrarColunas)): ?>
                        <td><?= statusCliente($cliente) ?></td>
                    <?php endif; ?>
                    <?php if (in_array('recorrente', $mostrarColunas)): ?>
                        <td><?= badge_recorrente($cliente->recorrente) ?></td>
                    <?php endif; ?>
                    <td class="text-end">
                        <a href="<?= base_url('clientes/editar/' . $cliente->id) ?>" class="btn btn-sm btn-warning rounded-3 me-1" title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="<?= base_url('clientes/excluir/' . $cliente->id) ?>" class="btn btn-sm btn-danger rounded-3 me-1" onclick="return confirm('Tem certeza que deseja excluir?')" title="Excluir">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <a href="<?= base_url("/clientes/{$cliente->id}/painel") ?>" class="btn btn-sm btn-info rounded-3 me-1" title="Painel">
                            <i class="bi bi-speedometer2"></i>
                        </a>
                        <a href="<?= base_url('pedidos/adicionar?cliente_id=' . $cliente->id) ?>" class="btn btn-sm btn-success rounded-3" title="Novo Pedido">
                            <i class="bi bi-plus-circle-fill"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?= $pager->links('grupoClientes', 'default_full') ?>
</div>

<?php $this->endSection(); ?>