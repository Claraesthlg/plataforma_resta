<?php
session_start();
require_once 'db/conexion.php';
require_once 'db/generator.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nombre = $_SESSION['nombre'] ?? 'Usuario';

if (isset($_GET['reiniciar']) && $_GET['reiniciar'] === '1') {
    generateExcercices($user_id, $conn);
    header("Location: dashboard.php");
    exit();
}

// Obtener ejercicios
$stmt = $conn->prepare("SELECT * FROM exercises WHERE user_id = ? ORDER BY id ASC");
$stmt->execute([$user_id]);
$ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular progreso
$completados = array_filter($ejercicios, fn($e) => $e['completed'] == 1);
$progreso = count($completados);
$total = count($ejercicios);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MateMáticos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-green-300 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-xl font-bold text-pink-600">📚 MateMáticos</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm md:text-base font-medium text-gray-800">¡Hola, <?= htmlspecialchars($nombre) ?>! 🎉</span>
                <a href="dashboard.php?reiniciar=1" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Nuevos Ejercicios</a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Cerrar sesión</a>
            </div>
        </div>
    </header>

    <!-- Progreso -->
    <section class="bg-white shadow rounded-xl p-4 max-w-xl mx-auto mt-6 flex items-center justify-center gap-3">
        <span class="bg-green-200 text-green-700 font-bold px-3 py-1 rounded-full"><?= $progreso ?></span>
        <span class="text-lg font-semibold text-gray-700">Progreso actual: <span class="text-green-700"><?= $progreso ?>/<?= $total ?></span></span>
    </section>

    <!-- Ejercicios -->
    <main class="flex-grow px-6 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
            <?php foreach ($ejercicios as $e): ?>
                <a href="resolver.php?id=<?= $e['id'] ?>" class="bg-white rounded-xl shadow-md p-4 hover:ring-4 hover:ring-pink-200 transition-all">
                    <div class="text-right font-mono text-xl tracking-widest">
                        <?php foreach (str_split($e['numero_mayor']) as $digit): ?>
                            <span><?= $digit ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-right font-mono text-xl tracking-widest">
                        <span class="text-pink-600 font-bold">−</span>
                        <?php foreach (str_split($e['numero_menor']) as $digit): ?>
                            <span><?= $digit ?></span>
                        <?php endforeach; ?>
                    </div>
                    <hr class="my-2 border-t-2 border-black">
                    <div class="text-center mt-2 space-x-2">
                        <?php
                        $resLength = strlen((string)$e['result']);
                        for ($i = 0; $i < $resLength; $i++): ?>
                            <span class="inline-block w-5 h-5 <?= $e['completed'] ? 'bg-green-400' : 'border-b-2 border-gray-400' ?>"></span>
                        <?php endfor; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-sm text-gray-600">
        © 2025 MateMáticos · Con cariño para mentes brillantes 💖
    </footer>

</body>
</html>
