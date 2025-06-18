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
        <form class="d-flex" method="get" action="">
          <div class="input-group">
            <input class="form-control" type="search" name="q" placeholder="Buscar por cliente ou descrição…">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
          </div>
        </form>
      </div>
    </div>

    <div class="card mb-3 border-0">
      <div class="card-body py-3">
        <form class="row row-cols-lg-auto g-2 align-items-end" method="get">
          <div class="col">
            <label for="status" class="form-label mb-0">Status</label>
            <select class="form-select" id="status" name="status">
              <option value="">Todos</option>
              <option value="em_aberto" <?= ($status ?? '') === 'em_aberto' ? 'selected' : '' ?>>Em aberto</option>
              <option value="em_producao" <?= ($status ?? '') === 'em_producao' ? 'selected' : '' ?>>Em produção</option>
              <option value="entregue" <?= ($status ?? '') === 'entregue' ? 'selected' : '' ?>>Entregue</option>
              <option value="cancelado" <?= ($status ?? '') === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
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
              <th class="col-id">#</th>
              <th>Cliente</th>
              <th>Descrição</th>
              <th>Status</th>
              <th>Forma Pagto</th>
              <th>Entrega</th>
              <th class="col-total text-end">Total (R$)</th>
              <th>Criado em</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($pedidos): foreach ($pedidos as $p): ?>
                <tr>
                  <td class="text-center fw-bold"><?= esc($p->id) ?></td>
                  <td><?= esc($p->cliente) ?></td>
                  <td><?= esc($p->descricao) ?></td>
                  <td class="text-center">
                    <?php
                    $map = [
                      'em_aberto' => ['secondary', 'Em aberto'],
                      'em_producao' => ['warning', 'Em produção'],
                      'entregue' => ['success', 'Entregue'],
                      'cancelado' => ['danger', 'Cancelado']
                    ];
                    [$clr, $lbl] = $map[$p->status] ?? ['dark', '-'];
                    ?>
                    <span class="badge bg-<?= $clr ?>"><?= $lbl ?></span>
                  </td>
                  <td><?= $p->forma_pagamento ? esc(ucfirst($p->forma_pagamento)) : '-' ?></td>
                  <td><?= $p->data_entrega ? esc(date('d/m/Y', strtotime($p->data_entrega))) : '-' ?></td>
                  <td class="text-end fw-semibold"><?= number_format($p->total, 2, ',', '.') ?></td>
                  <td><?= $p->created_at ? esc(date('d/m/Y H:i', strtotime($p->created_at))) : '-' ?></td>
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