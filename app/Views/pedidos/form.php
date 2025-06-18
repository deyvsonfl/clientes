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

    <form method="post" action="<?= isset($pedido) ? base_url('pedidos/atualizar/' . $pedido->id) : base_url('pedidos/salvar') ?>">
        <div class="mb-3">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cli): ?>
                    <option value="<?= esc($cli->id) ?>" <?= old('cliente_id', $pedido->cliente_id ?? '') == $cli->id ? 'selected' : '' ?>>
                        <?= esc($cli->nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="form-text">
                <a href="<?= base_url('clientes/criar') ?>">Novo cliente? Clique aqui</a>
            </div>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Valor do Pedido:</label>
            <input type="text" name="total" id="total" class="form-control" value="<?= old('total', $pedido->total ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data do Pedido:</label>
            <?php
            $dataPedido = isset($pedido->data_compra) ? date('Y-m-d', strtotime($pedido->data_compra)) : '';
            ?>
            <input type="date" name="data" id="data" class="form-control" value="<?= old('data', $dataPedido) ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea name="descricao" id="descricao" class="form-control"><?= old('descricao', $pedido->descricao ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status do Pedido:</label>
            <select name="status" id="status" class="form-select" required>
                <?php
                $statusOptions = ['aberto', 'em produção', 'entregue', 'cancelado'];
                $statusAtual = old('status', $pedido->status ?? '');
                foreach ($statusOptions as $opcao):
                ?>
                    <option value="<?= esc($opcao) ?>" <?= $statusAtual === $opcao ? 'selected' : '' ?>>
                        <?= ucfirst($opcao) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="forma_pagamento" class="form-label">Forma de Pagamento:</label>
            <select name="forma_pagamento" id="forma_pagamento" class="form-select" required>
                <?php
                $formas = ['pix', 'dinheiro', 'cartão', 'boleto'];
                $formaAtual = old('forma_pagamento', $pedido->forma_pagamento ?? 'pix');
                foreach ($formas as $forma):
                ?>
                    <option value="<?= esc($forma) ?>" <?= $formaAtual === $forma ? 'selected' : '' ?>>
                        <?= ucfirst($forma) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<?php $this->endSection(); ?>