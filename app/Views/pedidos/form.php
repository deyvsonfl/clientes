<?php
// app/Views/pedidos/form.php
?>

<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<div class="container mt-4">
    <h2><?= isset($pedido) ? 'Editar Pedido' : 'Adicionar Pedido' ?></h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $erro): ?>
                    <li><?= esc($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= isset($pedido) ? base_url('pedidos/atualizar/' . $pedido['id']) : base_url('pedidos/salvar') ?>">
        <div class="mb-3">
            <label for="cliente" class="form-label">Nome do Cliente:</label>
            <select name="cliente" id="cliente" class="form-select" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cli): ?>
                    <option value="<?= esc($cli['nome']) ?>" <?= (isset($cliente) && $cliente['nome'] == $cli['nome']) ? 'selected' : '' ?>>
                        <?= esc($cli['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="form-text">
                <a href="<?= base_url('clientes/criar') ?>">Novo cliente? Clique aqui</a>
            </div>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor do Pedido:</label>
            <input type="text" name="valor" id="valor" class="form-control" value="<?= esc($pedido['valor'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data do Pedido:</label>
            <input type="date" name="data" id="data" class="form-control" value="<?= esc($pedido['data_compra'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea name="descricao" id="descricao" class="form-control"><?= esc($pedido['descricao'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<?php $this->endSection(); ?>
