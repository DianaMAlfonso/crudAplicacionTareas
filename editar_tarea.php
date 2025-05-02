<?php
require_once 'cabecera.php';
?>
<div class="container mt-5">
    <h1>Editar Tarea</h1>
    <?php
    require 'config.php';

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conexion->prepare("SELECT * FROM crud_pruebas WHERE id = :id"); // despues de select from va el nombre de la tabla que se creo en la base de datos
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tarea) {
    ?>
            <form action="actualizar_tarea.php" method="post">
                <input type="hidden" name="id" value="<?php echo $tarea['id']; ?>">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título de la Tarea</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($tarea['titulo']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($tarea['descripcion']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="fecha_limite" class="form-label">Fecha Límite</label>
                    <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" value="<?php echo htmlspecialchars($tarea['fecha_limite']); ?>">
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="Pendiente" <?php if ($tarea['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                        <option value="En proceso" <?php if ($tarea['estado'] === 'En proceso') echo 'selected'; ?>>En proceso</option>
                        <option value="Completada" <?php if ($tarea['estado'] === 'Completada') echo 'selected'; ?>>Completada</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </form>
    <?php
        } else {
            echo '<div class="alert alert-danger">Tarea no encontrada.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">ID de tarea inválido.</div>';
    }
    ?>
</div>
<?php
require_once 'footer.php';
?>