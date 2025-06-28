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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

    .login-container {
      background-color: #fff;
      border-radius: 30px;
      padding: 40px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }

    .login-container h2 {
      font-size: 28px;
      color: #845ec2;
      margin: 12px 0;
    }

    .login-container p {
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

    .mensaje.exito {
      color: #28a745;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="iconos">
    <span>⭐</span>
    <span>🧮</span>
    <span>❤️</span>
    <span>✨</span>
  </div>
  <h2>MateMáticos</h2>
  <p>¡Bienvenido! Inicia sesión para continuar.</p>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?= $mensaje ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">🔐 ¡Iniciar sesión!</button>
  </form>

  <a class="link" href="registro.php">¿No tienes cuenta? ¡Regístrate aquí!</a>
</div>

</body>
</html>
