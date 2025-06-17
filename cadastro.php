<?php
require_once __DIR__ . '/db.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $tipo = 'cliente'; // só cliente por aqui

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash, $tipo]);
        $mensagem = "Cadastro realizado com sucesso! <a href='login.php'>Faça login</a>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $mensagem = "Email já cadastrado.";
        } else {
            $mensagem = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Cadastro</title>
<style>
  * {
    box-sizing: border-box;
  }
  body, html {
    margin: 0; padding: 0; height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  body {
    background: 
      linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
      url('https://aem-all.accor.com/content/dam/all/hubs/americas/latam/generic-images/all-magazine/melhores-praias-do-brasil-2024-1.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }
  .container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    width: 360px;
    padding: 35px 40px;
    text-align: center;
    color: #222;
    opacity: 1;
    transition: opacity 0.4s ease;
  }
  h2 {
    margin-bottom: 25px;
    font-weight: 700;
  }
  form label {
    display: block;
    text-align: left;
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 14px;
    color: #444;
  }
  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 11px 14px;
    margin-bottom: 22px;
    border: 1.6px solid #bbb;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #0d6efd;
    outline: none;
  }
  button {
    width: 100%;
    background-color: #0d6efd;
    border: none;
    color: white;
    padding: 13px 0;
    font-size: 16px;
    font-weight: 700;
    border-radius: 7px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  button:hover {
    background-color:rgb(9, 80, 187);
  }
  p.message {
    font-weight: 600;
    margin-bottom: 18px;
    color: #0d6efd;
  }
  p.message a {
    color: #0d6efd;
    text-decoration: none;
  }
  p.message a:hover {
    text-decoration: underline;
  }
  p.link {
    margin-top: 22px;
    font-size: 15px;
  }
  p.link a {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 600;
  }
  p.link a:hover {
    text-decoration: underline;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const links = document.querySelectorAll('p.link a');

    links.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        container.style.opacity = '0';
        setTimeout(() => {
          window.location.href = link.href;
        }, 400);
      });
    });
  });
</script>
</head>
<body>
<div class="container">
  <h2>Cadastre-se</h2>
  <?php if ($mensagem): ?>
    <p class="message"><?= $mensagem ?></p>
  <?php endif; ?>
  <form method="POST" novalidate>
    <label for="nome">Nome</label>
    <input id="nome" type="text" name="nome" required />

    <label for="email">Email</label>
    <input id="email" type="email" name="email" required />

    <label for="senha">Senha</label>
    <input id="senha" type="password" name="senha" required />

    <button type="submit">Cadastrar</button>
  </form>
  <p class="link">Já tem login? <a href="login.php">Entre aqui</a></p>
</div>
</body>
</html>
