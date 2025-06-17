<?php
$pdo = new PDO("mysql:host=localhost;dbname=imobiliaria", "root", ""); // ajuste se necessário

$senhaHash = password_hash('123456', PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)";
$stmt = $pdo->prepare($sql);
$stmt->execute([':nome' => 'Administrador',':email' => 'admin@admin.com',':senha' => $senhaHash,':tipo' => 'admin']);

echo "Administrador criado!";
?>
