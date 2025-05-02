// app.js
document.addEventListener('DOMContentLoaded', () => {

    // Función para mostrar alertas con SweetAlert
    function mostrarAlerta(mensaje, icono = 'success', confirmButtonText = 'OK') {
      Swal.fire({
        title: mensaje,
        icon: icono,
        confirmButtonText: confirmButtonText
      });
    }
  
    // Función para confirmar una acción
    function confirmarAccion(mensaje) {
      return Swal.fire({
        title: '¿Estás seguro?',
        text: mensaje,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡adelante!',
        cancelButtonText: 'No, cancelar'
      }).then((result) => {
        return result.isConfirmed;
      });
    }
  
    // Validación para Crear Tarea
    const formularioCrearTarea = document.querySelector('form[action="guardar_tarea.php"]');
    if (formularioCrearTarea) {
      formularioCrearTarea.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevenir el envío inmediato
        if (validarFormularioTarea(formularioCrearTarea)) {
          confirmarAccion('¿Guardar esta tarea?').then((confirmado) => {
            if (confirmado) {
              formularioCrearTarea.submit(); // Enviar el formulario si se confirma
            }
          });
        }
      });
    }
  
    // Validación para Editar Tarea
    const formularioEditarTarea = document.querySelector('form[action="actualizar_tarea.php"]');
    if (formularioEditarTarea) {
      formularioEditarTarea.addEventListener('submit', (e) => {
        e.preventDefault();
        if (validarFormularioTarea(formularioEditarTarea)) {
          confirmarAccion('¿Actualizar esta tarea?').then((confirmado) => {
            if (confirmado) {
              formularioEditarTarea.submit();
            }
          });
        }
      });
    }
  
    // Validación de Formulario (común para crear y editar)
    /*function validarFormularioTarea(form) {
        const titulo = form.querySelector('#titulo').value.trim();
        if (titulo === '') {
            mostrarAlerta('El título es obligatorio.', 'error');
            return false;
        }
        return true;
    }
  */
    function validarFormularioTarea(form) {
      let valido = true;
      const titulo = form.querySelector('#titulo').value.trim();
      const descripcion = form.querySelector('#descripcion').value.trim();
      const fecha_limite = form.querySelector('#fecha_limite').value.trim();
      const estado = form.querySelector('#estado').value.trim();
  
      if (titulo === '') {
        mostrarAlerta('El título es obligatorio.', 'error');
        valido = false;
      }
      if (descripcion === '') {
        mostrarAlerta('La descripción es obligatoria.', 'error');
        valido = false;
      }
      if (fecha_limite === '') {
        mostrarAlerta('La fecha límite es obligatoria.', 'error');
        valido = false;
      }
      if (estado === '') {
        mostrarAlerta('El estado es obligatorio.', 'error');
        valido = false;
      }
  
      return valido;
    }
    // Confirmar eliminación de Tarea
    const botonesEliminar = document.querySelectorAll('.btn-eliminar'); // Clase para los botones de eliminar
    botonesEliminar.forEach(boton => {
      boton.addEventListener('click', (e) => {
        e.preventDefault();
        const urlEliminar = boton.getAttribute('href'); // Obtener la URL del botón
        confirmarAccion('¿Eliminar esta tarea?').then((confirmado) => {
          if (confirmado) {
            window.location.href = urlEliminar; // Redirigir para eliminar
          }
        });
      });
    });
  
    // Manejo de Mensajes de la URL (éxito/error desde PHP)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('mensaje')) {
      const mensaje = urlParams.get('mensaje');
      if (mensaje === 'tarea_creada') {
        mostrarAlerta('Tarea creada con éxito.', 'success');
      } else if (mensaje === 'tarea_actualizada') {
        mostrarAlerta('Tarea actualizada con éxito.', 'success');
      } else if (mensaje === 'tarea_eliminada') {
        mostrarAlerta('Tarea eliminada con éxito.', 'success');
      }
    } else if (urlParams.has('error')) {
      const error = urlParams.get('error');
      if (error === 'guardar_tarea') {
        mostrarAlerta('Error al guardar la tarea.', 'error');
      } else if (error === 'actualizar_tarea') {
        mostrarAlerta('Error al actualizar la tarea.', 'error');
      } else if (error === 'eliminar_tarea') {
        mostrarAlerta('Error al eliminar la tarea.', 'error');
      } else if (error === 'actualizar_estado') {
        mostrarAlerta('Error al actualizar el estado.', 'error');
      }
    }
  });

  document.addEventListener('DOMContentLoaded', () => {

    // Código para "En Progreso"
    const botonesAgregarNota = document.querySelectorAll('.btn-agregar-nota');

    botonesAgregarNota.forEach(boton => {
        boton.addEventListener('click', () => {
            const idTarea = boton.getAttribute('data-id');

            Swal.fire({
                title: 'Ingrese Nota de Progreso',
                input: 'textarea',
                inputPlaceholder: '¿Qué estás haciendo en esta tarea?',
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const nota = result.value;
                    if (nota) {
                        // Enviar la nota al servidor usando fetch o AJAX
                        fetch('guardar_proceso_nota.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id=${idTarea}&nota=${encodeURIComponent(nota)}`
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data === 'success') {
                                Swal.fire('Nota guardada', '', 'success').then(() => {
                                    location.reload(); // Recargar la página para mostrar la nota
                                });
                            } else {
                                Swal.fire('Error al guardar la nota', '', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error de conexión', '', 'error');
                        });
                    } else {
                        Swal.fire('La nota no puede estar vacía', '', 'warning');
                    }
                }
            });
        });
    });
});