<?php
// ============================================================
//  CONFIGURAÇÕES — edite apenas aqui
// ============================================================
$config = [
    'site_name'      => 'DWD Street',
    'site_url'       => '../../index.php',
    'dpo_email'      => 'privacidade@dwdstreet.com',
    'last_update'    => '2026-06-10',
    'copyright_year' => date('Y'),
];

// Força encoding correto (resolve problema com pastas com acento no Apache/Win)
header('Content-Type: text/html; charset=UTF-8');

// Formata data em português
$ultima_atualizacao = '';
if ($config['last_update']) {
    $ts = strtotime($config['last_update']);
    $meses = [
        1=>'janeiro',2=>'fevereiro',3=>'março',4=>'abril',
        5=>'maio',6=>'junho',7=>'julho',8=>'agosto',
        9=>'setembro',10=>'outubro',11=>'novembro',12=>'dezembro'
    ];
    $ultima_atualizacao = date('d',$ts).' de '.$meses[(int)date('m',$ts)].' de '.date('Y',$ts);
}

// Tabela de cookies — adicione/remova linhas aqui
$cookies_table = [
    ['nome'=>'PHPSESSID', 'provedor'=>'Próprio',          'tipo'=>'Necessário', 'finalidade'=>'Mantém a sessão do usuário ativa.',                          'validade'=>'Sessão'],
    ['nome'=>'_ga',       'provedor'=>'Google Analytics',  'tipo'=>'Analítico',  'finalidade'=>'Identifica usuários únicos para estatísticas de acesso.',     'validade'=>'2 anos'],
    ['nome'=>'_fbp',      'provedor'=>'Meta / Facebook',   'tipo'=>'Marketing',  'finalidade'=>'Rastreia conversões de anúncios na rede social.',             'validade'=>'3 meses'],
];

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

$badge_map = [
    'necessario'=>'badge-necessario','necessário'=>'badge-necessario',
    'analitico' =>'badge-analitico', 'analítico' =>'badge-analitico',
    'marketing' =>'badge-marketing',
    'funcional' =>'badge-funcional',
];
function badge(string $tipo, array $map): string {
    $k = mb_strtolower($tipo,'UTF-8');
    return $map[$k] ?? 'badge-necessario';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Política de Cookies — <?= e($config['site_name']) ?></title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg-main:#0a0a0a;--bg-card:#161616;
  --primary:#ff0000;--primary-dark:#cc0000;
  --text:#e5e5e5;--text-muted:#a3a3a3;--border:#262626;
}
body{
  font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
  line-height:1.7;color:var(--text);background:var(--bg-main);
  padding:120px 20px 40px;
}
/* ==========================================================================
           LOGO ATUALIZADO (Estilo Inclinado / Itálico)
           ========================================================================== */
        .logo {
            font-weight: 900;
            font-size: 1.8rem; /* Aumentei levemente para dar mais destaque */
            text-decoration: none;
            color: var(--text-primary); /* Mantém branco no dark e preto no light */
            letter-spacing: -1.5px; /* Deixa as letras bem juntas como na imagem */
            font-style: italic; /* Deixa a fonte inclinada */
            text-transform: uppercase;
            display: inline-block;
            /* transform: skewX(-5deg); Caso queira ainda mais inclinado, descomente esta linha */
        }

        .logo span {
            color: var(--accent); /* O vermelho padrão da marca */
        }
.logo:hover{transform:scale(1.05);opacity:.9}
.container{
  max-width:850px;margin:0 auto;background:var(--bg-card);
  padding:40px;border-radius:12px;border:1px solid var(--border);
  box-shadow:0 10px 30px rgba(0,0,0,.5);
}
h1{text-align:center;color:#fff;font-size:32px;margin-bottom:8px;font-weight:700}
.meta-date{text-align:center;font-style:italic;color:var(--text-muted);margin-bottom:40px;font-size:14px}
h2{color:#fff;font-size:22px;margin:35px 0 15px;display:flex;align-items:center}
h2::before{content:"";display:inline-block;width:4px;height:20px;background:var(--primary);margin-right:10px;border-radius:2px}
p{margin-bottom:20px}
ul{margin-bottom:25px;padding-left:20px;list-style:none}
li{margin-bottom:15px;position:relative;padding-left:15px}
li::before{content:"•";color:var(--primary);font-weight:bold;font-size:18px;position:absolute;left:0;top:-2px}
strong{color:#fff}
.table-responsive{width:100%;overflow-x:auto;margin:30px 0;border-radius:8px;border:1px solid var(--border)}
table{width:100%;border-collapse:collapse;text-align:left;font-size:14px;background:#1c1c1c}
th{background:#262626;color:#fff;font-weight:600;padding:14px;border-bottom:2px solid var(--primary);text-transform:uppercase;font-size:12px;letter-spacing:.5px}
td{padding:14px;border-bottom:1px solid var(--border)}
tr:last-child td{border-bottom:none}
tr:hover{background:#222}
code{background:#262626;color:var(--primary);padding:2px 6px;border-radius:4px;font-family:"Fira Code",Monaco,Consolas,monospace;font-size:13px}
.callout{background:rgba(255,0,0,.05);border-left:4px solid var(--primary);padding:18px;margin:30px 0;border-radius:0 8px 8px 0}
.callout p{margin:0;color:#ff4d4d;font-weight:500}
.container a{color:var(--primary);text-decoration:none;font-weight:500;transition:color .2s}
.container a:hover{color:var(--primary-dark);text-decoration:underline}
.badge{display:inline-block;padding:2px 8px;border-radius:999px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px}
.badge-necessario{background:rgba(34,197,94,.15);color:#4ade80}
.badge-analitico{background:rgba(59,130,246,.15);color:#60a5fa}
.badge-marketing{background:rgba(255,0,0,.15);color:#f87171}
.badge-funcional{background:rgba(234,179,8,.15);color:#facc15}
.footer{margin-top:50px;padding-top:20px;border-top:1px solid var(--border);font-size:13px;color:var(--text-muted);text-align:center}
@media(max-width:600px){
  body{padding:90px 10px 20px}
  .logo{top:25px;left:20px;font-size:20px}
  .container{padding:20px;border-radius:8px}
  h1{font-size:24px}h2{font-size:18px}
  td,th{padding:10px}
}
</style>
</head>
<body>

<a href="<?= e($config['site_url']) ?>" class="logo">DWD<span>STREET</span></a>

<div class="container">

  <h1>Política de Cookies</h1>
  <p class="meta-date">Última atualização: <?= e($ultima_atualizacao) ?></p>

  <p>Seja bem-vindo! Quando você visita o <strong><?= e($config['site_name']) ?></strong>, nós e empresas parceiras podemos armazenar ou recuperar informações no seu navegador, principalmente na forma de cookies.</p>
  <p>Essa política explica o que são essas tecnologias, como as usamos e os seus direitos de controle.</p>

  <h2>1. O que são Cookies?</h2>
  <p>Cookies são pequenos arquivos de texto salvos no seu computador ou celular quando você visita um site. Eles servem para fazer o site funcionar mais rápido, lembrar das suas preferências (como idioma) e nos ajudar a entender como você interage com a nossa página.</p>

  <h2>2. Que tipos de Cookies nós usamos?</h2>
  <p>Nós dividimos os cookies do nosso site em quatro categorias principais:</p>
  <ul>
    <li><strong>Cookies Estritamente Necessários (Essenciais):</strong> São obrigatórios para o site funcionar. Garantem a segurança da página e recursos básicos (como login e carrinho). <em>Esses não podem ser desligados.</em></li>
    <li><strong>Cookies de Desempenho e Analíticos:</strong> Nos ajudam a saber quais páginas são mais populares e como os visitantes navegam. Toda informação é anônima (ex: Google Analytics).</li>
    <li><strong>Cookies de Funcionalidade:</strong> Permitem que o site lembre de escolhas anteriores (como nome de usuário ou região) para uma experiência personalizada.</li>
    <li><strong>Cookies de Publicidade/Marketing:</strong> Definidos por nós ou parceiros (Facebook, Google) para mostrar anúncios relevantes para você em outros sites.</li>
  </ul>

  <h2>3. Tabela Resumo dos Cookies Utilizados</h2>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Nome do Cookie</th><th>Provedor / Origem</th><th>Tipo / Categoria</th><th>Finalidade</th><th>Validade</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($cookies_table as $c): ?>
        <tr>
          <td><code><?= e($c['nome']) ?></code></td>
          <td><?= e($c['provedor']) ?></td>
          <td><span class="badge <?= e(badge($c['tipo'],$badge_map)) ?>"><?= e($c['tipo']) ?></span></td>
          <td><?= e($c['finalidade']) ?></td>
          <td><?= e($c['validade']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <h2>4. Como você pode controlar os Cookies?</h2>
  <p>Você pode gerenciar ou desativar os cookies de três formas:</p>
  <ul>
    <li><strong>No nosso Banner de Cookies:</strong> Na sua primeira visita clique em "Configurações" no banner e escolha quais categorias aceita.</li>
    <li><strong>No seu Navegador:</strong> Configure Chrome, Firefox, Safari ou Edge em <em>Configurações &gt; Privacidade e Segurança &gt; Cookies</em>.</li>
    <li><strong>Links Úteis:</strong> Use o site <a href="https://www.youronlinechoices.com/" target="_blank" rel="noopener noreferrer">Your Online Choices</a> para desativar anúncios personalizados de várias redes.</li>
  </ul>

  <div class="callout">
    <p><strong>Importante:</strong> Bloquear todos os cookies pode fazer com que algumas partes do nosso site não funcionem corretamente.</p>
  </div>

  <h2>5. Dúvidas e Contato</h2>
  <p>Fale com nosso Encarregado de Dados (DPO) pelo e-mail:
    <a href="mailto:<?= e($config['dpo_email']) ?>"><?= e($config['dpo_email']) ?></a>.
  </p>

  <div class="footer">
    &copy; <?= e((string)$config['copyright_year']) ?> <?= e($config['site_name']) ?>. Todos os direitos reservados.
  </div>

</div>
</body>
</html>