<?php
require_once '/db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = intval($_POST['user_id']);
    $numero_mayor = intval($_POST['numero_mayor']);
    $numero_menor = intval($_POST['numero_menor']);
    $resultado_correcto = intval($_POST['resultado_correcto']);
    $correcto = $_POST['correcto'] === 'true' ? 1 : 0;

    // Verifica si ya existe el ejercicio exacto
    $query = "SELECT id FROM exercises WHERE numero_mayor = ? AND numero_menor = ? AND resultado_correcto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $numero_mayor, $numero_menor, $resultado_correcto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ejercicio_id = $row['id'];
    } else {
        // Insertar nuevo ejercicio si no existe
        $insert_exercise = "INSERT INTO exercises (numero_mayor, numero_menor, resultado_correcto) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_exercise);
        $stmt_insert->bind_param("iii", $numero_mayor, $numero_menor, $resultado_correcto);
        $stmt_insert->execute();
        $ejercicio_id = $stmt_insert->insert_id;
    }

    // Insertar resultado del usuario
    $insert_user_ex = "INSERT INTO user_exercises (user_id, ejercicio_id, correcto) VALUES (?, ?, ?)";
    $stmt_user = $conn->prepare($insert_user_ex);
    $stmt_user->bind_param("iii", $user_id, $ejercicio_id, $correcto);
    $stmt_user->execute();

    echo "OK";
}
?>
