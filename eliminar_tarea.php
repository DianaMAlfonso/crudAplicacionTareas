<?php
require 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("DELETE FROM crud_pruebas WHERE id = :id"); // despues de delete from va el nombre de la tabla que se creo en la base de datos
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: index.php?mensaje=tarea_eliminada');
    } else {
        header('Location: index.php?error=eliminar_tarea');
    }
} else {
    header('Location: index.php');
    exit();
}
?>