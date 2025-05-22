<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Empleado</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detalle del Empleado</h1>
            <a href="empleados_lista.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                Regresar al listado
            </a>
        </div>
        
        <div id="empleado-detalle" class="space-y-6">
            <div class="flex justify-center items-center h-40">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            
            if (id) {
                cargarDetalleEmpleado(id);
            } else {
                mostrarError('No se proporcionó un ID de empleado válido');
            }
        });
        
        function cargarDetalleEmpleado(id) {

            $.ajax({
                
                url: 'api/empleados.php?action=detalle&id=' + id,
                type: 'GET',
                dataType: 'json',

                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        mostrarDetalleEmpleado(response.data[0]);
                    } else {
                        mostrarError('No se encontró información del empleado');
                    }
                },
                error: function(xhr, status, error) {
                    mostrarError('Error al cargar los datos: ' + error);
                }
            });
        }
        
        function mostrarDetalleEmpleado(empleado) {

            const rol = empleado.rol == 1 ? 'Gerente' : 'Ejecutivo';
            const estado = empleado.eliminado == 0 ? 'Activo' : 'Inactivo';
            const estadoClass = empleado.eliminado == 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            
            const detalleHTML = `
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Información Personal</h2>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Nombre Completo</span>
                                    <span class="block text-base text-gray-900">${empleado.nombre} ${empleado.apellidos}</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Correo Electrónico</span>
                                    <span class="block text-base text-gray-900">${empleado.correo}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Información Laboral</h2>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Rol</span>
                                    <span class="block text-base text-gray-900">${rol}</span>
                                </div>
                                <div>
                                <span class="block text-sm font-medium text-gray-500">Estado</span>
                                <span class="inline-block px-3 py-1 my-3 text-sm font-semibold rounded-full ${estadoClass}">
                                    ${estado}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#empleado-detalle').html(detalleHTML);
        }
        
        function mostrarError(mensaje) {
            const errorHTML = `
                <div class="bg-red-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Error</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>${mensaje}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#empleado-detalle').html(errorHTML);
        }
    </script>
</body>
</html>
