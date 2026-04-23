<?php
// Renderiza a agenda de um curso (substitui os 10 arquivos *_agenda.php).
// Uso: $curso_slug = 'formacao_brigadista'; include 'partials/curso_agenda.php';
//
// Usa prepared statement (mysqli direto) em vez do shim legado com concatenacao.

if (empty($curso_slug) || !is_string($curso_slug)) {
    return;
}

// Reaproveita credenciais validadas por conexao.php
$DB_HOST = getenv('DB_HOST');
$DB_USER = getenv('DB_USER');
$DB_PASS = getenv('DB_PASS');
$DB_NAME = getenv('DB_NAME');

// Silencia exceptions do mysqli (PHP 8+) e warnings (PHP 7.4).
// Se algo falhar, apenas nao renderiza turmas.
if (function_exists('mysqli_report')) {
    @mysqli_report(MYSQLI_REPORT_OFF);
}

$meses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Marco', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro',
];

$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    echo '<p class="agenda-empty">Agenda temporariamente indisponivel.</p>';
    return;
}
@$mysqli->set_charset('utf8mb4');

$turmas_por_mes = array_fill_keys(array_keys($meses), []);

$stmt = @$mysqli->prepare(
    'SELECT data_inicio, data_fim, turno, hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma, mes_curso '
    . 'FROM agenda WHERE curso = ? ORDER BY ABS(mes_curso), ABS(data_inicio)'
);
if ($stmt) {
    $stmt->bind_param('s', $curso_slug);
    if (@$stmt->execute()) {
        $res = $stmt->get_result();
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $m = (int)$row['mes_curso'];
                if (isset($turmas_por_mes[$m])) $turmas_por_mes[$m][] = $row;
            }
        }
    }
    $stmt->close();
}
$mysqli->close();

$total = 0;
foreach ($turmas_por_mes as $arr) $total += count($arr);
?>

<div class="curso-agenda">
  <h3>Proximas turmas</h3>
  <?php if ($total === 0): ?>
    <p class="agenda-empty">Sem turmas agendadas no momento. <a href="contato.php">Entre em contato</a> para turmas in-company ou lista de espera.</p>
  <?php else: foreach ($turmas_por_mes as $mes_num => $turmas): ?>
    <?php if (!$turmas) continue; ?>
    <section class="agenda-mes">
      <h4><?= h($meses[$mes_num]) ?></h4>
      <ul>
        <?php foreach ($turmas as $t):
          $hi = str_pad($t['hora_inicioh'], 2, '0', STR_PAD_LEFT) . ':' . str_pad($t['hora_iniciom'], 2, '0', STR_PAD_LEFT);
          $hf = str_pad($t['hora_fimh'], 2, '0', STR_PAD_LEFT) . ':' . str_pad($t['hora_fimm'], 2, '0', STR_PAD_LEFT);
          $tipo = $t['turma'] === 'fds' ? 'Final de semana' : 'Regular';
        ?>
          <li>
            <span class="agenda-periodo"><?= h($t['data_inicio']) ?> a <?= h($t['data_fim']) ?></span>
            <span class="agenda-turno"><?= h($t['turno']) ?></span>
            <span class="agenda-horario"><?= h($hi) ?> &ndash; <?= h($hf) ?></span>
            <span class="agenda-tipo <?= $t['turma'] === 'fds' ? 'fds' : 'reg' ?>"><?= h($tipo) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
  <?php endforeach; endif; ?>
</div>
