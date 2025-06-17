<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<?php
$colunasRaw = $configuracoes['mostrar_colunas'] ?? '';
$colunasString = is_array($colunasRaw) ? implode(',', $colunasRaw) : $colunasRaw;
$mostrarColunas = explode(',', $colunasString);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Lista de Clientes</h1>
    <a href="<?= base_url('/clientes/criar') ?>" class="btn btn-primary">
        <i class="bi bi-person-plus-fill"></i> Adicionar Cliente
    </a>
</div>

<form method="get" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control" placeholder="Buscar cliente..." value="<?= esc($buscar) ?>">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary">
            <i class="bi bi-search"></i> Buscar
        </button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
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
                <th>Ações</th>
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
                    <td>
                        <div class="btn-group" role="group">
                            <a href="<?= base_url("/clientes/{$cliente->id}/painel") ?>" class="btn btn-sm btn-outline-info" title="Painel">
                                <i class="bi bi-person-lines-fill"></i>
                            </a>
                            <a href="<?= base_url('pedidos/adicionar?cliente_id=' . $cliente->id) ?>" class="btn btn-sm btn-outline-success" title="Novo Pedido">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                            <a href="<?= base_url('clientes/editar/' . $cliente->id) ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= base_url('clientes/excluir/' . $cliente->id) ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $pager->links('grupoClientes', 'default_full') ?>

<?php $this->endSection(); ?>