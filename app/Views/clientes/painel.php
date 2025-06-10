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

<?= $this->endSection() ?>