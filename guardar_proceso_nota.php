<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nota = $_POST['nota'];

    $stmt = $conexion->prepare("UPDATE crud_pruebas SET progreso_nota = :nota WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nota', $nota);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid request';
}
?>