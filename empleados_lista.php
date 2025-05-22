<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empleados</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Listado de empleados (<span id="contador-empleados">0</span>)</h1>
            <a href="empleados_alta.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300">Crear nuevo registro</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 text-left font-semibold text-gray-700">ID</th>
                        <th class="py-3 px-4 text-left font-semibold text-gray-700">Nombre completo</th>
                        <th class="py-3 px-4 text-left font-semibold text-gray-700">Correo</th>
                        <th class="py-3 px-4 text-left font-semibold text-gray-700">Rol</th>
                        <th class="py-3 px-4 text-center font-semibold text-gray-700">Ver detalle</th>
                        <th class="py-3 px-4 text-center font-semibold text-gray-700">Editar</th>
                        <th class="py-3 px-4 text-center font-semibold text-gray-700">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="tabla-empleados">
                    <!-- Los datos de los empleados se cargarán aquí dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Cargar la lista de empleados al cargar la página
            cargarEmpleados();
        });
        
        // Función para cargar los empleados desde la API
        function cargarEmpleados() {
            $.ajax({
                url: 'api/empleados.php?action=listar',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        mostrarEmpleados(response.data);
                    } else {
                        alert('Error al cargar empleados: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud: ' + error);
                }
            });
        }
        
        // Función para mostrar los empleados en la tabla
        function mostrarEmpleados(empleados) {
            let tabla = $('#tabla-empleados');
            tabla.empty();
            
            // Actualizar contador
            $('#contador-empleados').text(empleados.length);
            
            // Si no hay empleados
            if (empleados.length === 0) {
                tabla.append('<tr><td colspan="7" class="py-4 px-4 text-center text-gray-500">No hay empleados registrados</td></tr>');
                return;
            }
            
            // Mostrar cada empleado
            $.each(empleados, function(index, empleado) {
                let nombreCompleto = empleado.nombre + ' ' + empleado.apellidos;
                let rol = empleado.rol == 1 ? 'Gerente' : 'Ejecutivo';
                
                let fila = `
                    <tr id="fila-${empleado.id}" class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4">${empleado.id}</td>
                        <td class="py-3 px-4">${nombreCompleto}</td>
                        <td class="py-3 px-4">${empleado.correo}</td>
                        <td class="py-3 px-4">${rol}</td>
                        <td class="py-3 px-4 text-center">
                            <a href="empleados_detalle.php?id=${empleado.id}" class="text-blue-600 hover:text-blue-800 font-medium">Ver</a>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="empleados_editar.php?id=${empleado.id}" class="text-yellow-600 hover:text-yellow-800 font-medium">Editar</a>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <button onclick="eliminarEmpleado(${empleado.id})" class="text-red-600 hover:text-red-800 font-medium">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
                
                tabla.append(fila);
            });
        }
        
        // Función para eliminar un empleado
        function eliminarEmpleado(id) {
            // Confirmación antes de eliminar
            if (confirm('¿Está seguro que desea eliminar este empleado?')) {
                // Realizar la petición AJAX para eliminar el empleado
                $.ajax({
                    url: 'api/empleados.php?action=eliminar',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Eliminar la fila de la tabla usando jQuery
                            $('#fila-' + id).fadeOut('slow', function() {
                                $(this).remove();
                                
                                // Actualizar el contador de empleados
                                let contadorActual = parseInt($('#contador-empleados').text());
                                $('#contador-empleados').text(contadorActual - 1);
                                
                                // Mostrar mensaje de éxito
                                alert('Empleado eliminado correctamente');
                            });
                        } else {
                            // Mostrar mensaje de error
                            alert('Error al eliminar el empleado: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error en la solicitud: ' + error);
                    }
                });
            }
        }
    </script>
</body>
</html>
