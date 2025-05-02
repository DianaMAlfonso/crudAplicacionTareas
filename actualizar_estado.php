<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $estado = isset($_POST['completada']) ? 'Completada' : 'Pendiente'; // Puedes ajustar esto según tus necesidades

    $stmt = $conexion->prepare("UPDATE crud_pruebas SET estado = :estado WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        header('Location: index.php?error=actualizar_estado');
    }
} else {
    header('Location: index.php');
    exit();
}
?>