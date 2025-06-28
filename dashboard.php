<?php
session_start();
require_once 'db/conexion.php';
require_once 'db/generator.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

if(generateExcercices($user_id, $conn)){
    print('passed');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <h1>welcome dashboard</h1>
        </div>
    </div>

</body>

</html>