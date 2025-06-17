<?php
$senhaDigitada = 'bieladm'; // coloque aqui a senha que você está digitando no login
$hashDoBanco = '$2y$10$kOKxWTYxQWwKTFLasxjBd.gRy6XYM5zYOmhEWW6Pb3uH0OdczhJmO'; // cole aqui o hash da senha do admin

if (password_verify($senhaDigitada, $hashDoBanco)) {
    echo "Senha correta!";
} else {
    echo "Senha incorreta!";
}
?>
