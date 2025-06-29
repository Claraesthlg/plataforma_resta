<?php
require_once '../db/conexion.php';

session_start();
$exercise_id = $_GET['id'];
$completed = $_GET['completo'];
try {
    $stmt = $conn->prepare("UPDATE exercises SET completed=? WHERE id=?");
    $stmt->execute([$completed, $exercise_id]);
    return true;
} catch (PDOException $err) {
    throw $err;
}
