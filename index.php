<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>MateMáticos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/estilos.css">
  <link rel="stylesheet" href="css/landing.css">
  <style>
    body {
      background-color: linear-gradient(to right, #fce4ec, #e3f2fd);
      font-family: 'Arial Rounded MT Bold', sans-serif;
      margin: 0;
    }
    .menu {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .menu a {
      color: #333;
      text-decoration: none;
      margin-left: 20px;
      font-weight: bold;
    }
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 60px 40px;
      flex-wrap: wrap;
    }
    .hero-left {
      max-width: 600px;
    }
    .hero-left .papel {
      background: url('img/papel.png');
      background-size: cover;
      padding: 30px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .hero-right img {
      width: 300px;
      border: 6px solid white;
      box-shadow: 4px 4px 12px rgba(0,0,0,0.2);
      border-radius: 8px;
    }
    .section {
      background: white;
      border-radius: 20px;
      padding: 30px;
      margin: 40px auto;
      max-width: 800px;
      box-shadow: 0 0 20px rgba(0,0,0,0.08);
    }

  .tarjetas {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 40px auto;
  flex-wrap: wrap;
  max-width: 900px;
}

.tarjeta {
  background-color: #fff;
  border-radius: 20px;
  padding: 30px 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  text-align: center;
  width: 100%;
  max-width: 360px;      /* Más ancha */
  min-height: 240px;     /* Altura mínima */
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform 0.3s ease;
}

.tarjeta:hover {
  transform: scale(1.03);
}

.icono {
  font-size: 42px;
  margin-bottom: 16px;
}

.tarjeta h3 {
  font-size: 20px;
  margin: 0 0 12px;
  color: #1e293b;
}

.tarjeta p {
  font-size: 15px;
  color: #555;
  margin: 0;
  text-align: center;
  max-width: 320px;
  line-height: 1.4;
}

    .btn {
      display: inline-block;
      padding: 12px 24px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      margin: 10px;
    }
    .btn-empezar {
      background: #e53935;
      color: white;
    }
    .btn-miembro {
      background: #1e88e5;
      color: white;
    }
  </style>
</head>
<body>

<div class="menu">
  <div style="font-weight: bold;">📚 MateMáticos</div>
  <div>
    <a href="#inicio">Inicio</a>
    <a href="#explicacion">Explicación</a>
    <a href="#beneficios">Beneficios</a>
  </div>
</div>

<div class="hero" id="inicio">
  <div class="hero-left">
    <div class="papel">
      <h1 style="font-size: 3rem; margin: 0;">MateMáticos</h1>
    </div>
    <p>¡Aprende a restar de manera divertida!</p>
    <a href="registro.php" class="btn btn-empezar">¡Empezar ahora!</a>
    <a href="login.php" class="btn btn-miembro">Ya soy miembro</a>
  </div>
  <div class="hero-right">
    <img src="img/niño.png" alt="Niño aprendiendo">
  </div>
</div>

<div class="section" id="explicacion">
  <h2>¿Qué son las restas? 🤔</h2>
  <p>¡La resta es como quitar cosas! Si tienes <b style="color:blue;">10 dulces</b> y te comes <b style="color:red;">3</b>, te quedan <b style="color:green;">7 dulces</b>.</p>
  <pre style="font-size: 1.8rem; font-family: 'Courier New'; font-weight: bold; text-align: center; margin-top:20px;">
  123456
− 000078
 _______
  123378
  </pre>
</div>

<div class="tarjetas" id="beneficios">
  <div class="tarjeta">
    <div class="icono">🏆</div>
    <h3>Progreso</h3>
    <p>Ve tu progreso y gana puntos cada vez que resuelves correctamente</p>
  </div>
  <div class="tarjeta">
    <div class="icono">💖</div>
    <h3>Fácil de usar</h3>
    <p>Solo usa el mouse para tocar y resolver. ¡Súper fácil!</p>
  </div>
  <div class="tarjeta">
  <div class="icono">🚀</div>
    <h3>¡Comienza tu aventura matemática!</h3>
    <p>Únete a miles de niños que ya están aprendiendo y divirtiéndose con MateMáticos.</p>
  </div>
</div>

</body>
</html>
