<?php
function resetExercises($user_id, $conn)
{
    try {
        $stmt = $conn->prepare("DELETE FROM exercises WHERE user_id = ?");
        $stmt->execute([$user_id]);
    } catch (PDOException $err) {
        throw $err;
    }
}

function generateExcercices($user_id, $conn)
{
    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE exercises set completed = 0 WHERE user_id = ?");
        $stmt->execute([$user_id]);
        for ($i = 0; $i < 8; $i++) {
            $num1 = rand(100000, 999999);
            $num2 = rand(100000, 999999);
            $num_mayor = $num1;
            $num_menor = $num2;
            if ($num1 < $num2) {
                $num_mayor = $num2;
                $num_menor = $num1;
            }
            $result = $num_mayor - $num_menor;
            $stmt = $conn->prepare("
                INSERT INTO exercises
                (user_id, numero_mayor, numero_menor, result, completed)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id,
                $num_mayor,
                $num_menor,
                $result,
                0,
            ]);
        }

        $conn->commit();
        return true;
    } catch (PDOException $e) {
        $conn->rollBack();
        die("Error al generar ejercicios: " . $e->getMessage());
    }
}
