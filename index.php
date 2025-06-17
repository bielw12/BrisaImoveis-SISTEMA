<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Dashboard</title>
<style>
  body {
    background: #f4f7fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  header {
    background-color: #007bff;
    color: white;
    width: 100%;
    padding: 20px 0;
    text-align: center;
    font-size: 24px;
    font-weight: 700;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
  }
  main {
    margin-top: 50px;
    text-align: center;
  }
  nav a {
    background: #007bff;
    color: white;
    text-decoration: none;
    padding: 12px 22px;
    border-radius: 6px;
    font-weight: 600;
    margin: 0 10px;
    display: inline-block;
    transition: background-color 0.3s ease;
  }
  nav a:hover {
    background-color: #0056b3;
  }
  h2 {
    margin-bottom: 30px;
    color: #222;
  }
</style>
</head>
<body>
<header>Bem-vindo, <?= htmlspecialchars($nome) ?>!</header>
<main>
  <h2>Dashboard</h2>
  <nav>
    <a href="imoveis_listar.php">Listar Imóveis</a>
    <?php if ($tipo === 'admin'): ?>
      <a href="imoveis_adicionar.php">Adicionar Imóvel</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
  </nav>
</main>
</body>
</html>
