<?php
ob_start();
session_start();
require 'db.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Salva dados individuais na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['tipo'] = strtolower(trim($usuario['tipo']));

        if ($_SESSION['tipo'] === 'admin') {
            header("Location: imoveis_listar.php");
            exit();
        } else {
            header("Location: index.html");
            exit();
        }
    } else {
        $erro = "Email ou senha incorretos!";
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Login</title>
<style>
  /* Reset básico */
  * {
    box-sizing: border-box;
  }
  body, html {
    margin: 0; padding: 0; height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  body {
    /* imagem de fundo escurecida */
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
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #0d6efd;
    outline: none;
  }
  button {
    width: 100%;
    background-color:#0d6efd;
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
    background-color: #0a58ca;
  }
  p.error {
    color: #dc3545;
    margin-bottom: 18px;
    font-weight: 600;
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
  // Anima fade out antes de mudar de página
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
  <h2>Faça login</h2>
  <?php if ($erro): ?>
    <p class="error"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>
  <form method="POST" novalidate>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" required autocomplete="username" />
    
    <label for="senha">Senha</label>
    <input id="senha" type="password" name="senha" required autocomplete="current-password" />
    
    <button type="submit">Entrar</button>
  </form>
  <p class="link">Ainda não tem cadastro? <a href="cadastro.php">Cadastre-se aqui</a></p>
</div>
</body>
</html>
