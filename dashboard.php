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
    resetExercises($user_id, $conn);
    generateExcercices($user_id, $conn);
    header("Location: dashboard.php");
    exit();
}

// Obtener solo ejercicios (resueltos y no resueltos)
$stmt = $conn->prepare("SELECT * FROM exercises WHERE user_id = ? ORDER BY id ASC LIMIT 8");
$stmt->execute([$user_id]);
$ejercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular progreso
$stmtTotal = $conn->prepare("SELECT COUNT(*) FROM exercises WHERE user_id = ?");
$stmtTotal->execute([$user_id]);
$total = $stmtTotal->fetchColumn();

$stmtCompletados = $conn->prepare("SELECT COUNT(*) FROM exercises WHERE user_id = ? AND completed = 1");
$stmtCompletados->execute([$user_id]);
$progreso = $stmtCompletados->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>MateMáticos - Ejercicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #ffe6e6, #fff4d6);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-xl font-bold text-pink-600">📚 MateMáticos</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm md:text-base font-medium text-gray-800">¡Hola, <?= htmlspecialchars($nombre) ?>!</span>
                <a href="dashboard.php?reiniciar=1" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-semibold">🔁 Nuevos Ejercicios</a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Cerrar sesión</a>
            </div>
        </div>
    </header>

    <section class="bg-white shadow rounded-xl p-4 max-w-xl mx-auto mt-6 flex items-center justify-center gap-3">
        <span class="bg-green-200 text-green-700 font-bold px-3 py-1 rounded-full"><?= $progreso ?></span>
        <span class="text-lg font-semibold text-gray-700">Progreso actual: <span class="text-green-700"><?= $progreso ?>/<?= $total ?></span></span>
    </section>

    <main class="flex-grow px-6 py-10">
        <div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
            <?php foreach ($ejercicios as $e):
                $completado = $e['completed'] == 1;
            ?>
                <div id="card-<?= $e['id'] ?>" class="bg-white rounded-2xl shadow-md p-4 border-4 transition-all <?= $completado ? 'border-green-300 opacity-50 pointer-events-none' : 'border-pink-100 hover:ring-4 hover:ring-pink-300 cursor-pointer' ?>" onclick="<?= $completado ? '' : "abrirModal({$e['id']}, '{$e['numero_mayor']}', '{$e['numero_menor']}', '{$e['result']}')" ?>">
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
                    <div class="flex justify-center gap-1 mt-2 items-center">
                        <?php for ($i = 0; $i < strlen((string)$e['result']); $i++): ?>
                            <span class="inline-block w-6 h-6 border-b-2 border-gray-400"></span>
                        <?php endfor; ?>
                        <?php if ($completado): ?>
                            <span class="text-green-500 text-xl ml-2">
                                <div class="ml-2 w-6 h-6 flex items-center justify-center rounded-full border-2 border-green-500 bg-green-100">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-4 text-center text-sm text-gray-600">
        © 2025 MateMáticos · Con cariño para mentes brillantes
    </footer>

    <div id="modalEjercicio" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50 p-4 sm:p-6">
        <div class="bg-white rounded-3xl shadow-xl p-6 w-full max-w-4xl relative">
            <button onclick="cerrarModal()" class="absolute top-2 right-3 text-red-500 font-bold text-2xl">×</button>
            <h2 class="text-2xl font-bold text-center text-pink-600 mb-4">Resuelve el ejercicio</h2>
            <div id="operacion" class="text-right font-mono text-2xl mb-4"></div>
            <div id="inputsWrapper" class="flex justify-end gap-[4px] font-mono text-2xl mb-4"></div>
            <div class="text-center">
                <button onclick="verificarRespuesta()" class="mt-2 bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-semibold">Verificar</button>
            </div>
        </div>
    </div>

    <script>
        let idActual = null;
        let resultado = '';
        let respuesta = [];

        function abrirModal(id, mayor, menor, res) {
            document.getElementById('cardsContainer').classList.add('hidden');

            idActual = id;
            resultado = res;
            const len = Math.max(mayor.length, menor.length, res.length);
            respuesta = Array(len).fill(0);


            const container = document.getElementById('operacion');
            const wrapper = document.getElementById('inputsWrapper');

            const digitosMayor = [...mayor];
            const digitosMenor = [...menor];

            container.innerHTML = `
  <div class="flex justify-end gap-[13px] mb-1 fila-llevadas text-xs text-blue-600 font-bold"></div>
  <div class="flex justify-end gap-[13px] mb-1 fila-mayor"></div>
  <div class="flex justify-end gap-[13px] mb-1 fila-menor text-pink-600 font-bold">-</div>
  <hr class="border-t-2 border-black my-2">
`;

            const filaLlevadas = container.querySelector('.fila-llevadas');
            const filaMayor = container.querySelector('.fila-mayor');
            const filaMenor = container.querySelector('.fila-menor');

            const spansLlevadas = [];
            const spansMayor = [];
            const spansMenor = [];

            // Array para registrar llevadas manuales
            const llevando = Array(len).fill(false);

            for (let i = 0; i < len; i++) {
                // Llevadas
                const spanL = document.createElement('span');
                spanL.className = 'w-6 text-center';
                spanL.textContent = '';
                spansLlevadas.push(spanL);
                filaLlevadas.appendChild(spanL);

                // Mayor (click para prestar)
                const spanM = document.createElement('span');
                spanM.className = 'w-6 text-center cursor-pointer font-semibold';
                spanM.textContent = digitosMayor[i];
                spanM.dataset.index = i;

                spanM.onclick = () => {
                    const idx = parseInt(spanM.dataset.index);
                    if (idx < len - 1) {
                        llevando[idx + 1] = true;
                        spansLlevadas[idx + 1].textContent = '1';
                        spansLlevadas[idx + 1].classList.add('text-blue-600');
                        spanM.classList.add('bg-yellow-200', 'rounded');
                    }
                };

                spansMayor.push(spanM);
                filaMayor.appendChild(spanM);

                // Menor
                const spanN = document.createElement('span');
                spanN.className = 'w-6 text-center';
                spanN.textContent = digitosMenor[i];
                spansMenor.push(spanN);
                filaMenor.appendChild(spanN);
            }

            // Inputs
            wrapper.innerHTML = '';
            respuesta.forEach((_, i) => {
                const btn = document.createElement('div');
                btn.className = 'digit-clickable w-8 h-10 text-center text-xl rounded-md border border-gray-300 bg-white hover:bg-pink-100 cursor-pointer';
                btn.textContent = '0';
                btn.dataset.index = i;

                btn.onclick = () => {
                    respuesta[i] = (respuesta[i] + 1) % 10;
                    btn.textContent = respuesta[i];
                };

                wrapper.appendChild(btn);
            });

            document.getElementById('modalEjercicio').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modalEjercicio').classList.add('hidden');
            document.getElementById('cardsContainer').classList.remove('hidden');
        }

        function verificarRespuesta() {
            const respuestaFinal = respuesta.join('');
            if (respuestaFinal === resultado) {
                Swal.fire({
                    title: '¡Buen trabajo!',
                    text: '¡Resolviste el ejercicio correctamente!',
                    icon: 'success',
                    confirmButtonText: '¡Seguir jugando!',
                    background: '#fff8e7',
                    color: '#d63384',
                    customClass: {
                        popup: 'rounded-3xl shadow-xl border-2 border-pink-200',
                        title: 'text-3xl font-bold text-pink-600',
                        htmlContainer: 'text-lg text-gray-700 font-semibold',
                        confirmButton: 'bg-pink-500 text-white px-6 py-2 rounded-xl hover:bg-pink-600 transition-all'
                    },
                    didOpen: () => {
                        const duration = 1.5 * 1000;
                        const end = Date.now() + duration;
                        (function frame() {
                            confetti({
                                particleCount: 5,
                                angle: 60,
                                spread: 55,
                                origin: {
                                    x: 0
                                }
                            });
                            confetti({
                                particleCount: 5,
                                angle: 120,
                                spread: 55,
                                origin: {
                                    x: 1
                                }
                            });
                            if (Date.now() < end) requestAnimationFrame(frame);
                        })();
                    }
                }).then(() => {
                    fetch(`controller/resolver.php?id=${idActual}&completo=1`)
                        .then(() => {
                            cerrarModal();
                            marcarEjercicioResuelto(idActual);
                            location.reload()
                        });
                });
            } else {
                const card = document.querySelector(`[onclick*="abrirModal(${idActual},"]`);
                if (card) {
                    card.classList.add('border-red-400', 'ring-2', 'ring-red-300');
                    setTimeout(() => {
                        card.classList.remove('border-red-400', 'ring-2', 'ring-red-300');
                    }, 1500);
                }

                Swal.fire({
                    title: '¡Ups!',
                    text: '¡Inténtalo de nuevo!',
                    icon: 'error',
                    confirmButtonText: 'Reintentar',
                    background: '#fff1f2',
                    color: '#be123c',
                    customClass: {
                        popup: 'rounded-3xl shadow-xl border border-red-200',
                        title: 'text-2xl font-bold text-red-600',
                        confirmButton: 'bg-red-500 text-white px-5 py-2 rounded-xl hover:bg-red-600 transition-all'
                    }
                });
            }
        }

        function marcarEjercicioResuelto(id) {
            const card = document.getElementById('card-' + id);
            if (!card) return;

            card.removeAttribute('onclick');
            card.classList.remove('hover:ring-4', 'hover:ring-pink-300', 'cursor-pointer');
            card.classList.add('opacity-50', 'pointer-events-none', 'border-green-300');

            const check = document.createElement('div');
            check.innerHTML = `
      <div class="ml-2 w-6 h-6 flex items-center justify-center rounded-full border-2 border-green-500 bg-green-100">
        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
      </div>
    `;

            const resultContainer = card.querySelector('.flex.justify-center');
            if (resultContainer) {
                resultContainer.appendChild(check);
            }
        }
    </script>
</body>

</html>