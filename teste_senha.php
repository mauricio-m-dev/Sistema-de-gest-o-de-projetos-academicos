<?php
// Este arquivo serve apenas para criar usuários de teste válidos
$senha = '123456';
$hash = password_hash($senha, PASSWORD_DEFAULT);

echo "<h3>Copie e rode o SQL abaixo no seu banco de dados:</h3>";
echo "<textarea rows='5' cols='80'>";
echo "INSERT INTO user (name, email, password, userType) VALUES ('Coordenador Teste', 'Coordenador@teste.com', '$hash', 'Coordenador');";
echo "</textarea>";
?>