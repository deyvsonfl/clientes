<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<h1><?= isset($pedido) ? 'Editar Pedido' : 'Adicionar Pedido' ?></h1>

<form method="post" action="<?= isset($pedido) ? base_url('pedidos/atualizar/' . $pedido['id']) : base_url('pedidos/salvar') ?>">
    <?php if (!isset($pedido)): ?>
        <label for="cliente">Nome do Cliente:</label>
        <input type="text" name="cliente" id="cliente" value="<?= esc($cliente['nome'] ?? '') ?>" required>
    <?php else: ?>
        <p><strong>Cliente:</strong> <?= esc($cliente['nome']) ?></p>
    <?php endif; ?>

    <label for="valor">Valor do Pedido:</label>
    <input type="text" name="valor" id="valor" value="<?= isset($pedido['valor']) ? esc(number_format((float)$pedido['valor'], 2, ',', '.')) : '' ?>" required>

    <label for="data">Data do Pedido:</label>
    <input type="date" name="data" id="data" value="<?= esc($pedido['data_compra'] ?? '') ?>" required>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" id="descricao"><?= esc($pedido['descricao'] ?? '') ?></textarea>

    <br><br>
    <button type="submit">Salvar</button>
    <a href="<?= base_url('clientes') ?>">Cancelar</a>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.2/imask.min.js"></script>
<script>
    const valorInput = document.getElementById('valor');
    if (valorInput) {
        IMask(valorInput, {
            mask: 'R$ num',
            blocks: {
                num: {
                    // Aceita até 2 casas decimais
                    mask: Number,
                    thousandsSeparator: '.',
                    radix: ',',
                    mapToRadix: ['.'],
                    scale: 2,
                    signed: false
                }
            }
        });
    }
</script>


<?php $this->endSection(); ?>
