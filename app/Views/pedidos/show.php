<h2>Detalhes do Pedido</h2>

<p><strong>Cliente:</strong> <?= esc($cliente->nome) ?></p>
<p><strong>Valor:</strong> R$ <?= number_format($pedido->valor, 2, ',', '.') ?></p>
<p><strong>Data da Compra:</strong> <?= date('d/m/Y', strtotime($pedido->data_compra)) ?></p>
<p><strong>Descrição:</strong> <?= esc($pedido->descricao) ?></p>
<p><strong>Status:</strong> <?= esc($pedido->status) ?></p>

<a href="/clientes/historico/<?= $cliente->id ?>">⬅ Voltar para o histórico</a>