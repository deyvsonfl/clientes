<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<h1><?= isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' ?></h1>

<form method="post" action="<?= isset($cliente['id']) ? base_url('clientes/atualizar/' . $cliente['id']) : base_url('clientes/salvar') ?>">

    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= esc($cliente['nome'] ?? '') ?>" required>
    <?php if (!empty(session('errors.nome'))): ?><div class="error"><?= esc(session('errors.nome')) ?></div><?php endif; ?>

    <label for="telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" class="telefone" value="<?= esc($cliente['telefone'] ?? '') ?>" required pattern="\(\d{2}\) \d{5}-\d{4}" title="Digite um telefone válido no formato (99) 99999-9999">
    <?php if (!empty(session('errors.telefone'))): ?><div class="error"><?= esc(session('errors.telefone')) ?></div><?php endif; ?>

    <label for="instagram">Instagram:</label>
    <input type="text" name="instagram" id="instagram" value="<?= esc($cliente['instagram'] ?? '') ?>">

    <label for="cep">CEP:</label>
    <input type="text" name="cep" id="cep" class="cep" maxlength="9" placeholder="Digite o CEP" value="<?= esc($cliente['cep'] ?? '') ?>" required pattern="\d{5}-\d{3}" title="Digite um CEP válido no formato 00000-000">
    <?php if (!empty(session('errors.cep'))): ?><div class="error"><?= esc(session('errors.cep')) ?></div><?php endif; ?>

    <label for="estado">Estado:</label>
    <input type="text" name="estado" id="estado" value="<?= esc($cliente['estado'] ?? '') ?>" required>

    <label for="cidade">Cidade:</label>
    <input type="text" name="cidade" id="cidade" value="<?= esc($cliente['cidade'] ?? '') ?>" required>

    <label for="bairro">Bairro:</label>
    <input type="text" name="bairro" id="bairro" value="<?= esc($cliente['bairro'] ?? '') ?>">

    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" id="endereco" value="<?= esc($cliente['endereco'] ?? '') ?>">

    <label for="data_ultima_compra">Data da Última Compra:</label>
    <input type="date" name="data_ultima_compra" id="data_ultima_compra" value="<?= esc($cliente['data_ultima_compra'] ?? '') ?>">

    <label for="total_gasto">Total Gasto:</label>
    <input type="text" name="total_gasto" id="total_gasto" class="total_gasto" value="<?= esc($cliente['total_gasto'] ?? '') ?>">

    <label for="status">Status:</label>
    <input type="text" name="status" id="status" value="<?= esc($cliente['status'] ?? '') ?>">

    <label for="recorrente">Recorrente:</label>
    <select name="recorrente" id="recorrente">
        <option value="0" <?= isset($cliente['recorrente']) && !$cliente['recorrente'] ? 'selected' : '' ?>>Não</option>
        <option value="1" <?= isset($cliente['recorrente']) && $cliente['recorrente'] ? 'selected' : '' ?>>Sim</option>
    </select>

    <label for="nicho">Nicho:</label>
    <input type="text" name="nicho" id="nicho" value="<?= esc($cliente['nicho'] ?? '') ?>">

    <button type="submit">Salvar</button>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
$(document).ready(function() {
    $('#telefone').inputmask('(99) 99999-9999');
    $('#cep').inputmask('99999-999');
    $('#total_gasto').inputmask('currency', {
        prefix: 'R$ ',
        groupSeparator: '.',
        radixPoint: ',',
        autoUnmask: true,
        removeMaskOnSubmit: true
    });

    $('#cep').on('blur', function() {
        const cep = $(this).val().replace(/\D/g, '');
        if (cep.length !== 8) return;

        $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
            if (!data.erro) {
                $('#estado').val(data.uf);
                $('#cidade').val(data.localidade);
                $('#bairro').val(data.bairro);
                $('#endereco').val(data.logradouro);
            }
        });
    });
});
</script>
<?php $this->endSection(); ?>
