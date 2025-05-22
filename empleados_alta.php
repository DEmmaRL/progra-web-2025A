<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Empleados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-5">

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            
            <h1 class="text-2xl font-bold text-gray-800">Alta de Empleados</h1>
            <a href="empleados_lista.php" class="text-blue-600 hover:text-blue-800 font-medium">Regresar al listado</a>
        
        </div>
        
        <form id="formEmpleado" class="space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="relative">
                <label for="correo" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div id="correo-error" class="hidden absolute right-0 top-0 mt-8 mr-2 text-red-600 text-sm"></div>
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select id="rol" name="rol" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un rol</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Guardar Empleado
                </button>
            </div>
            
            <div id="form-error" class="hidden p-4 bg-red-100 text-red-700 rounded-md text-center"></div>
        </form>
    </div>

    <script>
        $(document).ready(function() {

            $('#correo').blur(function() {
                let correo = $(this).val().trim();
                if (correo !== '') {
                    validarCorreo(correo);

                }
            });
            
            $('#formEmpleado').submit(function(e) {
                e.preventDefault();
                
                if (validarFormulario()) {
                    guardarEmpleado();

                }
            });
        });
        
        function validarCorreo(correo) {
            $.ajax({

                url: 'api/empleados.php?action=validar_correo',
                type: 'POST',
                data: { correo: correo },
                dataType: 'json',

                success: function(response) {

                    if (!response.disponible) {
                        $('#correo-error').text('El correo ' + correo + ' ya existe.').removeClass('hidden');

                        setTimeout(function() {
                            $('#correo-error').addClass('hidden');
                        }, 5000);

                    } else {
                        $('#correo-error').addClass('hidden');

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al validar correo:', error);
                }
            });
        }
        
        function validarFormulario() {
            let nombre = $('#nombre').val().trim();
            let apellidos = $('#apellidos').val().trim();
            let correo = $('#correo').val().trim();
            let password = $('#password').val().trim();
            let rol = $('#rol').val();
            
            if (nombre === '' || apellidos === '' || correo === '' || password === '' || rol === '') {

                $('#form-error').text('Faltan campos por llenar').removeClass('hidden');
                

                setTimeout(function() {
                    $('#form-error').addClass('hidden');
                }, 5000);
                
                return false;
            }
            
            return true;
        }
        
        function guardarEmpleado() {
            $.ajax({
                url: 'api/empleados.php?action=crear',
                type: 'POST',

                data: {
                    nombre: $('#nombre').val().trim(),
                    apellidos: $('#apellidos').val().trim(),
                    correo: $('#correo').val().trim(),
                    pass: $('#password').val().trim(),
                    rol: $('#rol').val()
                },

                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = 'empleados_lista.php';
                    } else {
                        $('#form-error').text('Error al guardar: ' + response.message).removeClass('hidden');
                        
                        setTimeout(function() {
                            $('#form-error').addClass('hidden');
                        }, 5000);
                    }
                },
                error: function(xhr, status, error) {
                    $('#form-error').text('Error en la solicitud: ' + error).removeClass('hidden');
                    
                    setTimeout(function() {
                        $('#form-error').addClass('hidden');
                    }, 5000);
                }
            });
        }
    </script>
</body>
</html>
