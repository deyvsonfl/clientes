<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<h1><?= isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' ?></h1>

<form method="post" action="<?= isset($cliente) ? base_url('/clientes/atualizar/' . $cliente['id']) : base_url('/clientes/salvar') ?>">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" id="nome" value="<?= esc($cliente['nome'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" class="form-control" name="telefone" id="telefone" value="<?= esc($cliente['telefone'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
            <label for="instagram" class="form-label">Instagram:</label>
            <input type="text" class="form-control" name="instagram" id="instagram" value="<?= esc($cliente['instagram'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="cep" class="form-label">CEP:</label>
            <input type="text" class="form-control" name="cep" id="cep" value="<?= esc($cliente['cep'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="estado" class="form-label">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" value="<?= esc($cliente['estado'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="cidade" class="form-label">Cidade:</label>
            <input type="text" class="form-control" name="cidade" id="cidade" value="<?= esc($cliente['cidade'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="bairro" class="form-label">Bairro:</label>
            <input type="text" class="form-control" name="bairro" id="bairro" value="<?= esc($cliente['bairro'] ?? '') ?>">
        </div>

        <div class="col-md-12">
            <label for="endereco" class="form-label">Endereço:</label>
            <input type="text" class="form-control" name="endereco" id="endereco" value="<?= esc($cliente['endereco'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="nicho" class="form-label">Nicho de atuação:</label>
            <input type="text" class="form-control" name="nicho" id="nicho" value="<?= esc($cliente['nicho'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="valor" class="form-label">Valor Inicial (se houver):</label>
            <input type="number" step="0.01" class="form-control" name="total_gasto" id="total_gasto" value="<?= esc($cliente['total_gasto'] ?? '') ?>">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?= base_url('/clientes') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>

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
