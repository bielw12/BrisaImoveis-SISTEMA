<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['tipo'] !== 'admin') {
    // Caso queira proteger só para admins
    header("Location: index.html");
    exit();
}
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $_POST['valor'] ?? '';
    $tamanho = $_POST['tamanho'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';
    $comodos = $_POST['comodos'] ?? '';
    $imagem_url = $_POST['imagem_url'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO imoveis (valor, tamanho, localizacao, comodos, imagem_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$valor, $tamanho, $localizacao, $comodos, $imagem_url]);
        $mensagem = "Imóvel adicionado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Adicionar Imóvel</title>
<style>
  * {
    box-sizing: border-box;
  }
  body {
    background: linear-gradient(135deg, #667eea 0%,#0a58ca 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 20px 15px 40px 15px;
    color: #333;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  nav {
    margin: 20px 0 35px;
    text-align: center;
    max-width: 960px;
    width: 100%;
  }
  nav a {
    background: #fff;
    color: #0a58ca;
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
    color: #4b297e;
    box-shadow: 0 6px 15px rgba(75, 41, 126, 0.6);
  }

  .container {
    background: #fff;
    padding: 35px 45px;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    width: 420px;
    max-width: 95%;
    text-align: center;
  }
  h2 {
    margin-bottom: 30px;
    color: #0a58ca;
    font-weight: 800;
    font-size: 2rem;
    text-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }
  p.message {
    font-weight: 700;
    color: #155724;
    background-color: #d4edda;
    border: 1.5px solid #c3e6cb;
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(21, 87, 36, 0.3);
  }

  form label {
    display: block;
    text-align: left;
    font-weight: 700;
    margin-bottom: 8px;
    color: #333;
    font-size: 0.95rem;
  }
  input[type="number"],
  input[type="text"],
  input[type="url"] {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 22px;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  input[type="number"]:focus,
  input[type="text"]:focus,
  input[type="url"]:focus {
    border-color: #764ba2;
    outline: none;
    box-shadow: 0 0 8px rgba(118, 75, 162, 0.5);
  }

  button {
    background-color: #0a58ca;
    border: none;
    color: white;
    padding: 14px 0;
    font-size: 18px;
    font-weight: 700;
    border-radius: 30px;
    width: 100%;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(118, 75, 162, 0.5);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    user-select: none;
  }
  button:hover,
  button:focus {
    background-color: #0a58ca;
    box-shadow: 0 8px 24px rgba(91, 58, 138, 0.8);
  }

  /* Responsividade */
  @media (max-width: 480px) {
    .container {
      padding: 25px 20px;
      width: 95%;
    }
    h2 {
      font-size: 1.6rem;
    }
    input[type="number"],
    input[type="text"],
    input[type="url"] {
      font-size: 14px;
    }
    button {
      font-size: 16px;
      padding: 12px 0;
    }
    nav a {
      padding: 10px 16px;
      margin: 0 6px;
      font-size: 14px;
    }
  }
</style>

</head>
<body>
<nav>
  <a href="imoveis_listar.php">Lista de Imóveis</a>
  <a href="index.php">Dashboard</a>
  <a href="logout.php">Logout</a>
</nav>
<div class="container">
  <h2>Adicionar Imóvel</h2>
  <?php if ($mensagem): ?>
    <p class="message"><?= htmlspecialchars($mensagem) ?></p>
  <?php endif; ?>
  <form method="POST" novalidate>
    <label for="valor">Valor (R$)</label>
    <input id="valor" type="number" step="0.01" name="valor" required />

    <label for="tamanho">Tamanho (m²)</label>
    <input id="tamanho" type="number" step="0.01" name="tamanho" required />

    <label for="localizacao">Localização</label>
    <input id="localizacao" type="text" name="localizacao" required />

    <label for="comodos">Cômodos</label>
    <input id="comodos" type="number" name="comodos" required />

    <label for="imagem_url">URL da Imagem</label>
    <input id="imagem_url" type="url" name="imagem_url" required />

    <button type="submit">Adicionar</button>
  </form>
</div>
</body>
</html>
