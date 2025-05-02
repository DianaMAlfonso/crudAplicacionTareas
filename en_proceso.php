<?php
require_once 'cabecera.php';
require 'config.php';

// Obtener todas las tareas "En proceso"
$stmt = $conexion->prepare("SELECT * FROM crud_pruebas WHERE estado = 'En proceso'");
$stmt->execute();
$tareasEnProgreso = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1>Tareas En Proceso</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha Límite</th>
                <th>Nota de Progreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($tareasEnProgreso) > 0): ?>
                <?php foreach ($tareasEnProgreso as $tarea): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tarea['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($tarea['fecha_limite']); ?></td>
                        <td><?php echo htmlspecialchars($tarea['progreso_nota']); ?></td>
                        <td>
                            <button class="btn btn-info btn-sm btn-agregar-nota" data-id="<?php echo $tarea['id']; ?>">Agregar Nota</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay tareas en proceso.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php 
require_once 'footer.php'; 
?>