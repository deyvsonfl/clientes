<ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link <?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">
      <i class="bi bi-graph-up"></i> Dashboard
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= url_is('clientes*') ? 'active' : '' ?>" href="<?= base_url('/clientes') ?>">
      <i class="bi bi-people-fill"></i> Clientes
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= url_is('pedidos/adicionar') ? 'active' : '' ?>" href="<?= base_url('/pedidos/adicionar') ?>">
      <i class="bi bi-plus-circle"></i> Novo Pedido
    </a>
  </li>
  <?php $uri = service('uri'); ?>
  <li class="nav-item">
    <a class="nav-link <?= $uri->getSegment(1) == 'pedidos' ? 'active' : '' ?>" href="<?= base_url('pedidos') ?>">
      <i class="bi bi-receipt-cutoff"></i> Pedidos
    </a>
  </li>
  <hr class="my-3">
  <li class="nav-item">
    <a class="nav-link <?= url_is('configuracoes') ? 'active' : '' ?>" href="<?= base_url('/configuracoes') ?>">
      <i class="bi bi-gear"></i> Configurações
    </a>
  </li>
</ul>