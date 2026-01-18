<?php
// Bloqueia acesso direto
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit("Método não permitido");
}

// Verifica se veio email
if (!isset($_POST["email"])) {
  exit("Email não enviado");
}

// Valida email
$email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
if (!$email) {
  exit("Email inválido");
}

// Arquivo onde os emails serão salvos
$file = __DIR__ . "/emails.txt";

// Evita duplicados
if (file_exists($file)) {
  $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if (in_array($email, $emails)) {
    exit("Esse email já está cadastrado 😉");
  }
}

// Salva
file_put_contents($file, $email . PHP_EOL, FILE_APPEND);

// Redireciona de volta
header("Location: index.html?sucesso=1");
exit;
