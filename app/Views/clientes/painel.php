<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Painel de Cliente</h4>

<!-- Dados do Cliente -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex justify-content-between flex-wrap">
        <div>
            <h5 class="mb-1"><?= esc($cliente->nome) ?></h5>
            <p class="mb-0 text-muted">
                <i class="bi bi-envelope"></i> <?= esc($cliente->email) ?> <br>
                <i class="bi bi-telephone"></i> <?= esc($cliente->telefone) ?>
            </p>
        </div>
        <div class="text-end">
            <a href="<?= base_url('/clientes/editar/' . $cliente->id) ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-pencil"></i> Editar Cliente
            </a>
        </div>
    </div>
</div>

<!-- Métricas do Cliente -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-bag-check fs-2 text-primary me-3"></i>
                <div>
                    <h6 class="mb-0">Total de Pedidos</h6>
                    <h5 class="mb-0"><?= esc($totalPedidos ?? '0') ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-currency-dollar fs-2 text-success me-3"></i>
                <div>
                    <h6 class="mb-0">Ticket Médio</h6>
                    <h5 class="mb-0">R$ <?= esc($ticketMedio ?? '0,00') ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-wallet2 fs-2 text-info me-3"></i>
                <div>
                    <h6 class="mb-0">Valor Total</h6>
                    <h5 class="mb-0">R$ <?= number_format($valorTotal ?? 0, 2, ',', '.') ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-calendar-check fs-2 text-warning me-3"></i>
                <div>
                    <h6 class="mb-0">Último Pedido</h6>
                    <h5 class="mb-0"><?= esc($dataUltimoPedido ?? 'N/A') ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Pedidos -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Histórico de Pedidos</h6>
        <a href="<?= base_url('/pedidos/adicionar?cliente_id=' . $cliente->id) ?>" class="btn btn-sm btn-outline-primary">
            Novo Pedido
        </a>
    </div>
    <div class="card-body table-responsive">
        <form method="get" class="row g-2 align-items-end mb-3">
            <input type="hidden" name="id" value="<?= $cliente->id ?>">

            <div class="col-md-3">
                <label for="data_inicial" class="form-label small mb-1">De:</label>
                <input type="date" name="data_inicial" id="data_inicial" class="form-control form-control-sm"
                    value="<?= esc($dataInicial ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label for="data_final" class="form-label small mb-1">Até:</label>
                <input type="date" name="data_final" id="data_final" class="form-control form-control-sm"
                    value="<?= esc($dataFinal ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label small mb-1">Status:</label>
                <select name="status" id="status" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <?php foreach (['aberto', 'em produção', 'entregue', 'cancelado'] as $opcao): ?>
                        <option value="<?= $opcao ?>" <?= ($statusSelecionado ?? '') === $opcao ? 'selected' : '' ?>>
                            <?= ucfirst($opcao) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-outline-dark w-50">Filtrar</button>
                <a href="<?= base_url('/clientes/painel/' . $cliente->id) ?>" class="btn btn-sm btn-link w-50 text-muted">
                    Limpar
                </a>
            </div>
        </form>
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Produto</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= esc($pedido->id) ?></td>
                            <td><?= isset($pedido->data_compra) ? date('d/m/Y', strtotime($pedido->data_compra)) : '-' ?></td>
                            <td><?= esc($pedido->descricao) ?></td>
                            <td>R$ <?= number_format($pedido->total, 2, ',', '.') ?></td>
                            <td><?= esc($pedido->status) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('/pedidos/' . $pedido->id) ?>" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= base_url('/pedidos/editar/' . $pedido->id) ?>" class="btn btn-sm btn-outline-secondary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhum pedido encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>