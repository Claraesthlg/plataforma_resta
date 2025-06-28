<?php
require_once 'db/conexion.php';
session_start();
$mensaje = null;

if (isset($_SESSION['mensaje'])) {
  unset($_SESSION['mensaje']);
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = trim($_POST["nombre"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{7,}$/', $password)) {
    $mensaje = "La contraseña debe tener al menos 7 caracteres, una letra y un número.";
  } else {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $verificar = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $verificar->execute([$email]);

    if ($verificar->rowCount() > 0) {
      $mensaje = "Este correo ya está registrado.";
    } else {
      $sql = "INSERT INTO users (nombre, email, password_hash) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      if ($stmt->execute([$nombre, $email, $password_hash])) {
        $_SESSION["user_id"] = $conn->lastInsertId();
        $_SESSION["nombre"] = $nombre;
        header("Location: dashboard.php");
        exit;
      } else {
        $mensaje = "❌ Error al registrar. Intenta nuevamente.";
      }
    }
  }

  if ($mensaje) {
    $_SESSION['mensaje'] = $mensaje;
  }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  $mensaje = '';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro - MateMáticos</title>
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
    <p class="text-gray-700 mb-6">¡Crea tu cuenta para empezar!</p>

    <?php if ($mensaje): ?>
      <div class="mb-4 text-sm font-semibold text-red-500 bg-red-100 py-2 px-4 rounded-xl">
        <?= $mensaje ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4 text-left" onsubmit="return validarFormulario()">
      <input
        type="text"
        name="nombre"
        placeholder="Escribe tu nombre completo"
        required
        class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">

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
          placeholder="Escribe tu contraseña"
          required
          pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{7,}$"
          title="Debe tener al menos 7 caracteres, una letra y un número."
          class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
        <span onclick="togglePassword('password')" class="absolute top-3 right-4 cursor-pointer text-gray-500 text-xl">👁️</span>
      </div>

      <div class="relative">
        <input
          type="password"
          id="confirmar"
          placeholder="Confirmar contraseña"
          required
          class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 transition">
        <span onclick="togglePassword('confirmar')" class="absolute top-3 right-4 cursor-pointer text-gray-500 text-xl">👁️</span>
      </div>

      <!-- ⚠️ Mensaje visual si no coinciden -->
      <div id="mensajeError" class="text-red-500 text-sm font-semibold hidden">
        Las contraseñas no coinciden.
      </div>

      <button
        type="submit"
        class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-green-400 hover:to-teal-400 text-white font-bold py-3 rounded-xl shadow-lg transition-all">
        ¡Crear cuenta!
      </button>
    </form>

    <a href="login.php" class="block mt-6 text-sm text-blue-600 hover:underline">¿Ya tienes cuenta? ¡Inicia sesión!</a>
  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === "password" ? "text" : "password";
    }

    function validarFormulario() {
      const pass = document.getElementById("password").value;
      const confirm = document.getElementById("confirmar").value;
      const mensaje = document.getElementById("mensajeError");

      if (pass !== confirm) {
        mensaje.classList.remove("hidden");
        return false;
      } else {
        mensaje.classList.add("hidden");
        return true;
      }
    }
  </script>

</body>

</html>