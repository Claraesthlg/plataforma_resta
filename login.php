<?php
session_start();
require_once 'db/conexion.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario && password_verify($password, $usuario["password_hash"])) {
    // Inicio de sesión exitoso
    $_SESSION["user_id"] = $usuario["id"];
    $_SESSION["nombre"] = $usuario["nombre"];
    header("Location: dashboard.php");
    exit;
  } else {
    $mensaje = "Correo o contraseña incorrectos.";
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión - MateMáticos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    @keyframes flotar {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-6px);
      }
    }

    .anim-float {
      animation: flotar 3s infinite ease-in-out;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-yellow-100 via-pink-100 to-yellow-50 px-4">

  <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md text-center relative">
    <!-- Emojis flotantes -->
    <div class="flex justify-center space-x-4 text-2xl mb-6 anim-float">
      <span>⭐</span><span>🧮</span><span>❤️</span><span>✨</span>
    </div>

    <h2 class="text-3xl font-bold text-pink-600 mb-2">MateMáticos</h2>
    <p class="text-gray-700 mb-6">¡Bienvenido! Inicia sesión para continuar.</p>

    <?php if ($mensaje): ?>
      <div class="mb-4 text-sm font-semibold text-red-500 bg-red-100 py-2 px-4 rounded-xl">
        <?= $mensaje ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4 text-left">
      <input
        type="email"
        name="email"
        placeholder="Correo electrónico"
        required
        class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
      <input
        type="password"
        name="password"
        placeholder="Contraseña"
        required
        class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
      <button
        type="submit"
        class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-green-400 hover:to-teal-400 text-white font-bold py-3 rounded-xl shadow-lg transition-all">
        ¡Iniciar sesión!
      </button>
    </form>

    <a href="registro.php" class="block mt-6 text-sm text-blue-600 hover:underline">¿No tienes cuenta? ¡Regístrate aquí!</a>
  </div>

</body>

</html>