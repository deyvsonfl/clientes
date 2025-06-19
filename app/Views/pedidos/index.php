<?php /* app/Views/pedidos/index.php – refino visual final */ ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pedidos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    tbody tr:hover {
      background: #f8f9fa
    }

    .col-id {
      width: 60px
    }

    .col-total {
      width: 110px
    }
  </style>
</head>

<body class="bg-light">
  <div class="container-xl py-4">
    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
      <h1 class="h3 fw-semibold mb-0"><i class="bi bi-card-checklist me-2"></i>Pedidos</h1>
      <div class="d-flex gap-2">
        <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
    </div>

    <div class="card mb-3 border-0">
      <div class="card-body py-3">
        <form class="row row-cols-lg-auto g-2 align-items-end" method="get">
          <div class="col">
            <label for="status" class="form-label mb-0">Status</label>
            <select class="form-select" id="status" name="status">
              <option value="">Todos</option>
              <?php foreach (\App\Models\PedidoModel::STATUS as $valor => $rotulo): ?>
                <option value="<?= $valor ?>" <?= ($status ?? '') === $valor ? 'selected' : '' ?>>
                  <?= $rotulo ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col">
            <label for="forma_pagamento" class="form-label mb-0">Pagamento</label>
            <select class="form-select" id="forma_pagamento" name="forma_pagamento">
              <option value="">Todos</option>
              <option value="pix" <?= ($forma_pagamento ?? '') === 'pix' ? 'selected' : '' ?>>Pix</option>
              <option value="boleto" <?= ($forma_pagamento ?? '') === 'boleto' ? 'selected' : '' ?>>Boleto</option>
              <option value="cartao" <?= ($forma_pagamento ?? '') === 'cartao' ? 'selected' : '' ?>>Cartão</option>
            </select>
          </div>
          <div class="col">
            <label for="data_inicial" class="form-label mb-0">De</label>
            <input type="date" name="data_inicial" id="data_inicial" class="form-control"
              value="<?= esc($dataInicial ?? '') ?>">
          </div>
          <div class="col">
            <label for="data_final" class="form-label mb-0">Até</label>
            <input type="date" name="data_final" id="data_final" class="form-control"
              value="<?= esc($dataFinal ?? '') ?>">
          </div>
          <div class="col">
            <label for="q" class="form-label mb-0">Busca</label>
            <input type="search" name="q" id="q" value="<?= esc($q ?? '') ?>" class="form-control" placeholder="Cliente ou descrição…">
          </div>
          <div class="col">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-filter"></i> Filtrar
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
          <thead class="table-secondary text-center">
            <tr>
              <th class="col-id text-center">#</th>
              <th class="text-center">Cliente</th>
              <th class="text-center">Descrição</th>
              <th class="text-center">Status</th>
              <th class="text-center">Forma Pagto</th>
              <th class="text-center">Entrega</th>
              <th class="col-total text-center">Total (R$)</th>
              <th class="text-center">Data do Pedido</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($pedidos): foreach ($pedidos as $p): ?>
                <tr>
                  <td class="text-center fw-bold"><?= esc($p->id) ?></td>
                  <td class="text-center"><?= esc($p->cliente) ?></td>
                  <td class="text-center"><?= esc($p->descricao) ?></td>
                  <td class="text-center">
                    <?php
                    $cores = [
                      'em_aberto'    => 'secondary',
                      'em_producao'  => 'warning',
                      'entregue'     => 'success',
                      'cancelado'    => 'danger',
                    ];
                    $rotulo = \App\Models\PedidoModel::STATUS[$p->status] ?? ucfirst($p->status);
                    $cor    = $cores[$p->status] ?? 'dark';
                    ?>
                    <span class="badge bg-<?= $cor ?>"><?= $rotulo ?></span>
                  </td>
                  <td class="text-center"><?= $p->forma_pagamento ? esc(ucfirst($p->forma_pagamento)) : '-' ?></td>
                  <td class="text-center"><?= $p->data_entrega ? esc(date('d/m/Y', strtotime($p->data_entrega))) : '-' ?></td>
                  <td class="text-center fw-semibold"><?= number_format($p->total, 2, ',', '.') ?></td>
                  <td class="text-center"><?= $p->data_compra ? esc(date('d/m/Y', strtotime($p->data_compra))) : '-' ?></td>
                </tr>
              <?php endforeach;
            else: ?>
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">Nenhum pedido encontrado.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white py-3">
        <nav class="d-flex justify-content-center">
          <?= $pager->links('default', 'default_full') ?>
        </nav>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>