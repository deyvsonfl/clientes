<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .card:hover {
        transform: scale(1.02);
        transition: transform 0.2s ease-in-out;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
    }

    .dropdown.show .dropdown-menu {
        display: block;
    }

    .fab-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
    }

    .table-responsive {
        overflow: visible !important;
        position: relative;
        z-index: 0;
    }

    td {
        position: relative;
        z-index: 2;
    }

    .dropdown-menu {
        z-index: 1060 !important;
        display: none;
    }

    .dropdown {
        position: relative;
    }


    .table-wrapper {
        position: relative;
        padding-bottom: 150px;
        /* Espaço extra para dropdown */
    }

    .table-wrapper::after {
        content: "";
        display: block;
        height: 120px;
    }
</style>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<h1 class="h4 mb-4 text-center text-md-start">Painel do Cliente: <?= esc($cliente->nome) ?></h1>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    <div class="col">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="text-muted">Total de Pedidos</h6>
                <p class="fs-4 fw-bold text-primary"><i class="bi bi-cart-check me-1"></i> <?= $totalPedidos ?></p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-success shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="text-muted">Total Gasto</h6>
                <p class="fs-4 fw-bold text-success"><i class="bi bi-currency-dollar me-1"></i> <?= number_format($somaTotal, 2, ',', '.') ?></p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-warning shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="text-muted">Valor Médio</h6>
                <p class="fs-4 fw-bold text-warning"><i class="bi bi-graph-up me-1"></i> <?= number_format($valorMedio, 2, ',', '.') ?></p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-info shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="text-muted">Última Compra</h6>
                <p class="fs-5 mb-0"><i class="bi bi-calendar-event me-1"></i> <?= $ultimaCompra ? date('d/m/Y', strtotime($ultimaCompra)) : '—' ?></p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between">
    <a href="<?= base_url('/clientes') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Voltar à Lista
    </a>
</div>

<a href="<?= base_url("/pedidos/adicionar?cliente_id={$cliente->id}") ?>" class="btn btn-primary rounded-circle shadow fab-button" title="Novo Pedido">
    <i class="bi bi-plus-lg"></i>
</a>

<hr class="my-4">

<h5 class="mb-3">📦 Histórico de Pedidos</h5>

<form method="get" class="row g-3 mb-4">
    <div class="col-md-3">
        <label for="data_inicio" class="form-label">Data Inicial</label>
        <input type="date" id="data_inicio" name="data_inicio" value="<?= esc($filtros['data_inicio'] ?? '') ?>" class="form-control">
    </div>
    <div class="col-md-3">
        <label for="data_fim" class="form-label">Data Final</label>
        <input type="date" id="data_fim" name="data_fim" value="<?= esc($filtros['data_fim'] ?? '') ?>" class="form-control">
    </div>
    <div class="col-md-2">
        <label for="valor_min" class="form-label">Valor Mínimo</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="text" id="valor_min" name="valor_min" value="<?= esc($filtros['valor_min'] ?? '') ?>" class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <label for="valor_max" class="form-label">Valor Máximo</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="text" id="valor_max" name="valor_max" value="<?= esc($filtros['valor_max'] ?? '') ?>" class="form-control">
        </div>
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">
            <i class="bi bi-search"></i>
        </button>
    </div>
    <div class="col-md-1 d-flex align-items-end">
        <a href="<?= current_url() ?>" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-clockwise"></i>
        </a>
    </div>
</form>

<?php if (empty($pedidos)): ?>
    <div class="alert alert-info">Este cliente ainda não possui pedidos registrados.</div>
<?php else: ?>
    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= formatar_data_br($pedido->data_compra) ?></td>
                            <td><?= formatar_real($pedido->valor) ?></td>
                            <td><?= esc($pedido->descricao) ?></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('pedidos/editar/' . $pedido->id) ?>">
                                                <i class="bi bi-pencil-square me-2"></i>Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="<?= base_url('pedidos/excluir/' . $pedido->id) ?>" onclick="return confirm('Deseja excluir este pedido?')">
                                                <i class="bi bi-trash me-2"></i>Excluir</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<!-- Máscara de moeda para campos de valor -->
<script>
    function formatCurrencyInput(input) {
        input.addEventListener('input', function() {
            let value = input.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2) + '';
            value = value.replace('.', ',');
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            input.value = value;
        });
    }

    document.querySelectorAll('#valor_min, #valor_max').forEach(formatCurrencyInput);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM totalmente carregado");

        const dropdowns = document.querySelectorAll('.dropdown-toggle');
        console.log(`Dropdowns encontrados: ${dropdowns.length}`);

        dropdowns.forEach(dd => {
            dd.addEventListener('click', () => {
                console.log("Dropdown clicado:", dd);
            });
        });
    });
</script>

<?= $this->endSection() ?>