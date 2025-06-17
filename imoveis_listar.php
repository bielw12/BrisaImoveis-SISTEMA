<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$tipo = $_SESSION['tipo'];
$mensagem = '';

if ($tipo === 'admin' && isset($_GET['excluir'])) {
    $idExcluir = (int) $_GET['excluir'];
    $stmtDel = $pdo->prepare("DELETE FROM imoveis WHERE id = ?");
    $stmtDel->execute([$idExcluir]);
    $mensagem = "Imóvel excluído com sucesso!";
}

$stmt = $pdo->query("SELECT * FROM imoveis ORDER BY id DESC");
$imoveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Listagem de Imóveis</title>
<style>
  /* Reset básico */
  * {
    box-sizing: border-box;
  }
  body {
    background: linear-gradient(135deg, #667eea 0%,rgb(75, 152, 162) 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 20px 15px 40px 15px;
    color: #333;
    min-height: 100vh;
  }
  nav {
    max-width: 960px;
    margin: 0 auto 30px auto;
    text-align: center;
  }
  nav a {
    background: #fff;
    color:rgb(75, 95, 162);
    padding: 12px 25px;
    margin: 0 10px;
    border-radius: 30px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
    transition: all 0.3s ease;
    display: inline-block;
    user-select: none;
  }
  nav a:hover,
  nav a:focus {
    background: #f0e7ff;
    color: #0a58ca;
    box-shadow: 0 6px 15px rgba(75, 41, 126, 0.6);
  }
  h2 {
    max-width: 960px;
    margin: 0 auto 25px auto;
    font-size: 2.4rem;
    font-weight: 800;
    color: #fff;
    text-align: center;
    text-shadow: 0 2px 6px rgba(0,0,0,0.3);
  }
  .message {
    max-width: 960px;
    margin: 0 auto 25px auto;
    padding: 12px 20px;
    background-color: #d4edda;
    border: 1.5px solid #c3e6cb;
    color: #155724;
    font-weight: 700;
    border-radius: 6px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(21, 87, 36, 0.3);
  }
  .grid {
    max-width: 960px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 28px;
  }
  .card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 45px rgba(0, 0, 0, 0.15);
  }
  .card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-bottom: 3px solid #0a58ca;
    transition: transform 0.3s ease;
  }
  .card:hover img {
    transform: scale(1.05);
  }
  .card-content {
    padding: 18px 22px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }
  .card-content h3 {
    margin: 0 0 12px 0;
    font-size: 22px;
    color: #0a58ca;
    font-weight: 700;
    letter-spacing: 0.03em;
  }
  .card-content p {
    margin: 6px 0;
    font-size: 16px;
    color: #555;
    flex-grow: 1;
  }
  .card-content p strong {
    color: #333;
  }
  .card-actions {
    padding: 15px 22px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background: #fafafa;
  }
  .btn {
    background-color: #0a58ca;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    user-select: none;
    box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  .btn:hover,
  .btn:focus {
    background-color: #5b3a8a;
    box-shadow: 0 6px 18px rgba(91, 58, 138, 0.7);
  }
  .btn.delete {
    background-color: #dc3545;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
  }
  .btn.delete:hover,
  .btn.delete:focus {
    background-color: #a71d2a;
    box-shadow: 0 6px 18px rgba(167, 29, 42, 0.7);
  }

  /* Responsividade */
  @media (max-width: 480px) {
    nav a {
      padding: 10px 14px;
      margin: 5px 6px;
      font-size: 14px;
    }
    h2 {
      font-size: 1.8rem;
      padding: 0 10px;
    }
    .card-content h3 {
      font-size: 18px;
    }
    .card-content p {
      font-size: 14px;
    }
    .btn {
      padding: 8px 14px;
      font-size: 13px;
    }
  }
</style>

</head>
<body>
<nav>
  <a href="index.php">Dashboard</a>
  <?php if ($tipo === 'admin'): ?>
    <a href="imoveis_adicionar.php">Adicionar Imóvel</a>
  <?php endif; ?>
  <a href="logout.php">Logout</a>
</nav>

<h2>Listagem de Imóveis</h2>

<?php if ($mensagem): ?>
  <p class="message"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<div class="grid">
  <?php foreach ($imoveis as $imovel): ?>
    <div class="card">
      <img src="<?= htmlspecialchars($imovel['imagem_url']) ?>" alt="Imagem do imóvel" />
      <div class="card-content">
        <h3>R$ <?= number_format($imovel['valor'], 2, ',', '.') ?></h3>
        <p><strong>Tamanho:</strong> <?= htmlspecialchars($imovel['tamanho']) ?> m²</p>
        <p><strong>Localização:</strong> <?= htmlspecialchars($imovel['localizacao']) ?></p>
        <p><strong>Cômodos:</strong> <?= htmlspecialchars($imovel['comodos']) ?></p>
      </div>
      <?php if ($tipo === 'admin'): ?>
        <div class="card-actions">
          <a href="imoveis_listar.php?excluir=<?= $imovel['id'] ?>" class="btn delete" onclick="return confirm('Deseja realmente excluir este imóvel?');">Excluir</a>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>
