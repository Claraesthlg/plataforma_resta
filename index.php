<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MateMáticos</title>
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .animate-spin-slow {
      animation: spin 12s linear infinite;
    }

    .animate-bounce-slow {
      animation: bounce 4s infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body class="bg-gradient-to-br from-yellow-100 via-pink-100 to-yellow-50 text-gray-800">
  <!-- HEADER -->
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
      <div class="text-2xl font-bold text-pink-600">📚 MateMáticos</div>
      <nav class="hidden md:flex space-x-6 font-semibold">
        <a href="#inicio" class="hover:text-pink-600">Inicio</a>
        <a href="#quienes" class="hover:text-pink-600">¿Quiénes somos?</a>
        <a href="#beneficios" class="hover:text-pink-600">Beneficios</a>
        <a href="#logros" class="hover:text-pink-600">Logros</a>
        <a href="#relevante" class="hover:text-pink-600">Importante</a>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section id="inicio"
    class="relative overflow-hidden px-6 py-20 md:py-28 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-12">
    <!-- FONDO ANIMADO -->
    <div class="absolute inset-0 -z-10 opacity-20 pointer-events-none select-none">
      <div class="absolute text-5xl animate-bounce top-10 left-10">➕</div>
      <div class="absolute text-5xl animate-ping bottom-20 left-1/3">➖</div>
      <div class="absolute text-6xl animate-spin-slow top-1/2 right-10">✖️</div>
      <div class="absolute text-5xl animate-bounce top-5 right-1/2">📐</div>
      <div class="absolute text-6xl animate-bounce-slow bottom-5 right-10">➗</div>
    </div>

    <!-- TEXTO -->
    <div class="max-w-2xl text-center md:text-left">
      <h1 class="text-5xl md:text-6xl font-extrabold text-pink-700 leading-tight drop-shadow-md">
        ¡Aprende a restar<br><span class="text-yellow-500">jugando y soñando!</span>
      </h1>
      <p class="text-lg md:text-xl text-gray-700 mt-6">
        MateMáticos es más que una plataforma: es una aventura educativa que combina diversión, tecnología y amor por
        las matemáticas.
      </p>
      <div class="mt-8 flex flex-col sm:flex-row justify-center md:justify-start gap-4">
        <a href="registro.php"
          class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all">¡Empezar
          ahora!</a>
        <a href="login.php"
          class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all">Ya
          soy miembro</a>
      </div>
    </div>

    <!-- ILUSTRACIÓN CREATIVA -->
    <div class="hidden md:flex items-center justify-center w-full max-w-sm">
      <div
        class="relative w-full h-64 bg-gradient-to-br from-pink-200 to-yellow-100 rounded-[1rem] shadow-2xl border-4 border-white flex flex-col justify-center items-center text-7xl transition-all duration-500 hover:scale-105 hover:rotate-1 hover:shadow-pink-300/50">
        <div class="absolute top-3 left-5 text-sm text-gray-700 font-bold bg-white/60 px-2 py-1 rounded-full shadow-md">
          10 🍬
        </div>
        <div class="text-6xl">🧮</div>
        <div
          class="absolute bottom-3 right-5 text-xl text-gray-700 font-bold bg-white/60 px-2 py-1 rounded-full shadow-md">
          -3
        </div>
      </div>
    </div>
  </section>

  <!-- QUIÉNES SOMOS -->
  <section id="quienes" class="bg-white py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-pink-600 mb-6">¿Quiénes somos?</h2>
      <p class="text-lg text-gray-700">
        Somos un equipo de programadores y creativos apasionados por la enseñanza matemática infantil.
        Creamos herramientas que despiertan la curiosidad y motivan el aprendizaje desde casa o el aula.
      </p>
    </div>
  </section>

  <!-- BENEFICIOS -->
  <section id="beneficios" class="py-16 px-6 bg-yellow-50">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-3xl font-bold text-center text-pink-600 mb-12">Beneficios de usar MateMáticos</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl p-8 shadow-md text-center">
          <div class="text-4xl mb-4">🧠</div>
          <h3 class="text-xl font-semibold mb-2">Aprendizaje activo</h3>
          <p>Interacción visual que estimula la mente y facilita la comprensión de la resta.</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-md text-center">
          <div class="text-4xl mb-4">🎮</div>
          <h3 class="text-xl font-semibold mb-2">Modo juego</h3>
          <p>¡Aprender jugando es más divertido! Sistema de puntos y logros para motivar.</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-md text-center">
          <div class="text-4xl mb-4">👨‍👩‍👧‍👦</div>
          <h3 class="text-xl font-semibold mb-2">Familiar y seguro</h3>
          <p>Diseñado para que padres y docentes acompañen el proceso educativo con tranquilidad.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- LOGROS -->
  <section id="logros" class="py-16 px-6 bg-white">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-3xl font-bold text-center text-pink-600 mb-12">Nuestros logros 📈</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <div>
          <div class="text-4xl font-bold text-blue-500">+12K</div>
          <p class="text-gray-700 mt-2">Usuarios activos</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-green-500">+150K</div>
          <p class="text-gray-700 mt-2">Ejercicios resueltos</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-yellow-500">+98%</div>
          <p class="text-gray-700 mt-2">Satisfacción</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-pink-500">+300</div>
          <p class="text-gray-700 mt-2">Escuelas registradas</p>
        </div>
      </div>
    </div>
  </section>

  <!-- RELEVANTE -->
  <section id="relevante" class="py-20 px-6 bg-pink-50">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-pink-700 mb-6">¿Por qué aprender a restar con nosotros?</h2>
      <p class="text-lg text-gray-700 mb-4">Porque lo hacemos visual, interactivo y amigable. Aquí no hay errores que
        duelen: ¡solo aprendizaje y diversión!</p>
      <p class="text-lg text-gray-700">Nuestro enfoque se adapta a diferentes edades y habilidades, asegurando que cada
        niño aprenda a su ritmo. </p>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-white border-t border-gray-200 py-6">
    <div class="max-w-6xl mx-auto text-center text-sm text-gray-600">
      © 2025 MateMáticos · Todos los derechos reservados.
    </div>
  </footer>
</body>

</html>