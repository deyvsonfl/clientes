<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<h1><?= isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' ?></h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= isset($cliente) ? base_url('/clientes/atualizar/' . $cliente['id']) : base_url('/clientes/salvar') ?>">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" id="nome" value="<?= old('nome', $cliente['nome'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" class="form-control" name="telefone" id="telefone" value="<?= old('telefone', $cliente['telefone'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
            <label for="instagram" class="form-label">Instagram:</label>
            <input type="text" class="form-control" name="instagram" id="instagram" value="<?= old('instagram', $cliente['instagram'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="cep" class="form-label">CEP:</label>
            <input type="text" class="form-control" name="cep" id="cep" value="<?= old('cep', $cliente['cep'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="estado" class="form-label">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" value="<?= old('estado', $cliente['estado'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="cidade" class="form-label">Cidade:</label>
            <input type="text" class="form-control" name="cidade" id="cidade" value="<?= old('cidade', $cliente['cidade'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="bairro" class="form-label">Bairro:</label>
            <input type="text" class="form-control" name="bairro" id="bairro" value="<?= old('bairro', $cliente['bairro'] ?? '') ?>">
        </div>

        <div class="col-md-12">
            <label for="endereco" class="form-label">Endereço:</label>
            <input type="text" class="form-control" name="endereco" id="endereco" value="<?= old('endereco', $cliente['endereco'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="nicho" class="form-label">Nicho de atuação:</label>
            <input type="text" class="form-control" name="nicho" id="nicho" value="<?= old('nicho', $cliente['nicho'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="total_gasto" class="form-label">Valor Inicial (se houver):</label>
            <input type="number" step="0.01" class="form-control" name="total_gasto" id="total_gasto" value="<?= old('total_gasto', $cliente['total_gasto'] ?? '') ?>">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?= base_url('/clientes') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>

<script>
document.getElementById('cep').addEventListener('input', function () {
    let cep = this.value.replace(/\D/g, '');
    if (cep.length > 5) {
        this.value = cep.substring(0, 5) + '-' + cep.substring(5, 8);
    } else {
        this.value = cep;
    }
});
</script>

<script>
document.getElementById('cep').addEventListener('blur', function () {
    let cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('estado').value = data.uf;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('endereco').value = data.logradouro;
                }
            })
            .catch(error => console.error('Erro ao consultar o CEP:', error));
    }
});
</script>

<?php $this->endSection(); ?>
