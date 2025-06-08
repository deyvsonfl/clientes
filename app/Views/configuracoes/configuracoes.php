<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Configurações do Sistema</h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('/configuracoes/salvar') ?>" class="row g-3">

    <div class="col-md-6">
        <label for="nome_sistema" class="form-label">Nome do sistema:</label>
        <input type="text" class="form-control" name="nome_sistema" id="nome_sistema" 
               value="<?= esc($configuracoes['nome_sistema'] ?? 'Sistema') ?>" required>
    </div>

    <div class="col-md-6">
        <label for="dias_inatividade" class="form-label">Dias sem compra para considerar inativo:</label>
        <input type="number" class="form-control" name="dias_inatividade" id="dias_inatividade" 
               value="<?= esc($configuracoes['dias_inatividade'] ?? 60) ?>" min="1" required>
    </div>

    <div class="col-md-12">
        <label class="form-label">Colunas visíveis na listagem de clientes:</label>
        <?php 
            $colunas = explode(',', $configuracoes['mostrar_colunas'] ?? '');
            $opcoes = ['instagram', 'data_ultima_compra', 'total_gasto', 'status', 'recorrente'];
        ?>
        <div class="form-check">
            <?php foreach ($opcoes as $opcao): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="mostrar_colunas[]" 
                        value="<?= $opcao ?>" id="col_<?= $opcao ?>"
                        <?= in_array($opcao, $colunas) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="col_<?= $opcao ?>"><?= ucfirst($opcao) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-md-12">
        <label for="nichos" class="form-label">Nichos de Atuação (um por linha):</label>
        <textarea name="nichos" id="nichos" rows="4" class="form-control"><?= esc($configuracoes['nichos'] ?? '') ?></textarea>
        <div class="form-text">Esses nichos aparecerão como opções no cadastro de cliente.</div>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Salvar configurações</button>
        <button type="button" class="btn btn-danger" onclick="confirmarLimpeza()">⚠️ Limpar dados de teste</button>
    </div>
</form>

<script>
function confirmarLimpeza() {
    if (confirm("Tem certeza que deseja apagar todos os dados de teste? Esta ação não poderá ser desfeita.")) {
        window.location.href = "<?= base_url('/configuracoes/limpar-teste') ?>";
    }
}
</script>

<?= $this->endSection() ?>
