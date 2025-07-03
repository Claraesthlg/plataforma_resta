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
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
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
  <a href="index.php" class="absolute top-5 left-5 flex items-center space-x-2 bg-white/80 text-pink-600 hover:text-pink-800 font-semibold px-4 py-2 rounded-xl shadow-md backdrop-blur transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L4.414 9H16a1 1 0 110 2H4.414l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
    </svg>
    <span>Volver</span>
  </a>


  <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md text-center relative">
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

      <div class="relative">
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Contraseña"
          required
          class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
        <button type="button" onclick="togglePassword('password', this)" class="absolute top-3 right-4 text-gray-500 hover:text-pink-500 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
            <circle cx="12" cy="12" r="3" />
          </svg>
        </button>
      </div>

      <button
        type="submit"
        class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-green-400 hover:to-teal-400 text-white font-bold py-3 rounded-xl shadow-lg transition-all">
        ¡Iniciar sesión!
      </button>
    </form>

    <a href="registro.php" class="block mt-6 text-sm text-blue-600 hover:underline">¿No tienes cuenta? ¡Regístrate aquí!</a>
  </div>

  <script>
    function togglePassword(id, btn) {
      const input = document.getElementById(id);
      const isVisible = input.type === "text";
      input.type = isVisible ? "password" : "text";

      const svg = btn.querySelector("svg");
      svg.innerHTML = isVisible ?
        `<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
           <circle cx="12" cy="12" r="3" />` :
        `<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a20.06 20.06 0 0 1 5.06-5.94M3 3l18 18" />
           <path d="M15 9.34a4 4 0 0 1-5.66 5.66" />`;
    }
  </script>
  <footer class="absolute bottom-4 w-full text-center text-sm text-gray-500">
    © 2025 <span class="font-semibold text-pink-600">MateMáticos</span> · Todos los derechos reservados.
  </footer>
</body>

</html>