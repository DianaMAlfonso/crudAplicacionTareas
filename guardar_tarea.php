<?php //logica tarea
require 'config.php';
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_limite = $_POST['fecha_limite'];
    $estado = $_POST['estado'];
    //despues de insert into va el nombre de la tabla de la base de datos
    $stmt = $conexion->prepare("INSERT INTO crud_pruebas (titulo, descripcion, fecha_limite, estado) VALUES (:titulo, :descripcion, :fecha_limite, :estado)");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha_limite', $fecha_limite);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        header('Location: index.php?mensaje=tarea_creada');
    } else {
        header('Location: crear_tarea.php?error=guardar_tarea');
    }
} else {
    header('Location: index.php');
    exit();
}
*/

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_limite = $_POST['fecha_limite'];
    $estado = $_POST['estado'];

    // Validación en PHP
    if (empty($titulo) || empty($descripcion) || empty($fecha_limite) || empty($estado)) {
        header('Location: crear_tarea.php?error=campos_vacios');
        exit(); // Importante: detener la ejecución si hay errores
    }

    $stmt = $conexion->prepare("INSERT INTO crud_pruebas (titulo, descripcion, fecha_limite, estado) VALUES (:titulo, :descripcion, :fecha_limite, :estado)");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha_limite', $fecha_limite);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        header('Location: index.php?mensaje=tarea_creada');
    } else {
        header('Location: crear_tarea.php?error=guardar_tarea');
    }
} else {
    header('Location: index.php');
    exit();
}
?>
