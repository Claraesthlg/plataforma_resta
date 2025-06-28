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
        // FUNCTION TO CONTINUE THE FLOW

        $_SESSION["user_id"] = $usuario["id"];
        $_SESSION["nombre"] = $usuario["nombre"];
        header("Location: dashboard.php");
        exit;
      } else {
        $mensaje = "❌ Error al registrar. Intenta nuevamente.";
      }
    }
  }

  if($mensaje) {
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
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> -->
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #fce4ec, #e3f2fd);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .registro-container {
      background-color: #fff;
      border-radius: 30px;
      padding: 40px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      width: 400px;
      text-align: center;
    }

    .iconos {
      font-size: 24px;
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 25px;
      animation: flotar 3s infinite ease-in-out;
    }

    @keyframes flotar {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-5px);
      }
    }

    .registro-container h2 {
      font-size: 28px;
      color: #845ec2;
      margin: 12px 0;
    }

    .registro-container p {
      font-size: 15px;
      color: #333;
      margin-bottom: 30px;
    }

    input {
      width: 100%;
      padding: 14px;
      margin-bottom: 18px;
      border-radius: 15px;
      border: 1px solid #ccc;
      font-size: 16px;
      box-sizing: border-box;
    }

    form {
      padding-bottom: 15px;
    }

    button {
      width: 100%;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 15px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-sizing: border-box;
    }

    button:hover {
      background: linear-gradient(to right, #43e97b, #38f9d7);
    }

    .link {
      margin-top: 15px;
      font-size: 14px;
      display: block;
      color: #007bff;
    }

    .mensaje {
      margin-bottom: 15px;
      font-weight: bold;
      color: #d9534f;
    }

  </style>
</head>

<body>

  <div class="registro-container">
    <div class="iconos">
      <span>⭐</span>
      <span>🧮</span>
      <span>❤️</span>
      <span>✨</span>
    </div>
    <h2>MateMáticos</h2>
    <p>¡Crea tu cuenta para empezar!</p>

    <?php if ($mensaje): ?>
      <div class="mensaje <?= str_contains($mensaje, 'exitoso') ? 'exito' : '' ?>"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="nombre" placeholder="Escribe tu nombre" required>
      <input type="email" name="email" placeholder="Correo electrónico" required>
      <input type="password" name="password"
        placeholder="Escribe tu contraseña"
        required
        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{7,}$"
        title="Debe tener al menos 7 caracteres, una letra y un número.">
      <button type="submit">👤 ¡Crear cuenta!</button>
    </form>

    <a class="link" href="login.php">¿Ya tienes cuenta? ¡Inicia sesión!</a>
  </div>

</body>

</html>