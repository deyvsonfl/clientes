<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<?php $diasInatividade = $configuracoes['dias_inatividade'] ?? 60; ?>

<div class="container mt-4">
    <h1 class="mb-4">Dashboard - <?= esc($configuracoes['nome_sistema'] ?? 'Sistema') ?></h1>
    <p class="text-muted">Bem-vindo ao painel de controle. Aqui estão os principais indicadores de desempenho dos seus clientes.</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <div class="col">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total de Clientes</h5>
                    <p class="card-text fs-4 fw-bold"><?= esc($totalClientes) ?></p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Clientes Recorrentes</h5>
                    <p class="card-text fs-4 fw-bold"><?= esc($clientesRecorrentes) ?></p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Clientes Inativos (&gt;<?= $diasInatividade ?> dias)</h5>
                    <p class="card-text fs-4 fw-bold"><?= esc($clientesInativos) ?></p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-warning shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Ticket Médio</h5>
                    <p class="card-text fs-4 fw-bold">R$ <?= number_format($ticketMedio, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-info shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Cidade com mais Clientes</h5>
                    <p class="card-text fs-4 fw-bold"><?= esc($cidadeTop) ?></p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-dark shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Investido</h5>
                    <p class="card-text fs-4 fw-bold">R$ <?= number_format($totalGasto, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>