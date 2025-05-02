<?php
require_once 'cabecera.php';
?>
<div class="container mt-5">
    <h1 class="text-center mb-3">Administrador de Tareas</h1>

    <?php
    require 'config.php';
    
    // Leer tareas y mostrar la tabla
    $stmt = $conexion->query("SELECT * FROM crud_pruebas ORDER BY estado");//despues select from va el nombre de la tabla
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h4 class="mb-3 text-center text-primary">Lista de Tareas</h4>';
    echo '<table class="table table-striped table-bordered">';
    echo '<thead class="text-center table-secondary"><tr><th>Id</th><th>Título</th><th>Descripción</th><th>Fecha Límite</th><th>Estado</th><th>Acciones</th></tr></thead>';
    echo '<tbody>';

    $contador = ['Pendiente' => 0, 'En proceso' => 0, 'Completada' => 0];

    foreach ($tareas as $tarea) {
        echo '<tr>';
        echo '<td class = "text-center">' . htmlspecialchars($tarea['id']) . '</td>';
        echo '<td>' . htmlspecialchars($tarea['titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($tarea['descripcion']) . '</td>';
        echo '<td class = "text-center">' . htmlspecialchars($tarea['fecha_limite']) . '</td>';
        echo '<td>';
        echo '<form method="post" action="actualizar_estado.php" class="d-inline">';
        echo '<input type="hidden" name="id" value="' . $tarea['id'] . '">';
        echo '<div class="form-check text-center">';
        echo '<input type="checkbox" class="form-check-input" name="completada" value="Completada" ' . ($tarea['estado'] === 'Completada' ? 'checked' : '') . ' onchange="this.form.submit()">';
        echo '<label class="form-check-label">' . htmlspecialchars($tarea['estado']) . '</label>';
        echo '</div>';
        echo '</form>';
        echo '</td>';
        echo '<td class = "text-center">';
        echo '<a href="editar_tarea.php?id=' . $tarea['id'] . '" class="btn btn-sm btn-primary">Editar</a> ';
        echo '<a href="eliminar_tarea.php?id=' . $tarea['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Estás seguro de eliminar esta tarea?\')">Eliminar</a>';
        echo '</td>';
        echo '</tr>';
        $contador[$tarea['estado']]++;
    }

    echo '</tbody></table>';
    echo "<br>";
    echo '<div class="mt-3 text-center">';
    echo '<strong>Contador de Tareas por Estado:</strong><br>';
    foreach ($contador as $estado => $cantidad) {
        echo htmlspecialchars($estado) . ': ' . $cantidad . '<br>';
    }
    echo '</div>';
    ?>
</div>
<?php
require_once 'footer.php';
?>