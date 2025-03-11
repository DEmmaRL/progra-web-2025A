<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>A11</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function recibe() {
      const nombre = document.getElementById('nombre').value;
      const correo = document.getElementById('correo').value;
      const sexo = document.querySelector('input[name="sexo"]:checked');
      const comentario = document.getElementById('comentario').value;
      const carrera = document.getElementById('carrera').value;
      const password = document.getElementById('pasw').value;
      const promedio = document.getElementById('promedio').value;
      const fecha = document.getElementById('fecha').value;
      
      if (!nombre || !correo || !sexo || !comentario || carrera === "0" || !password || !promedio || !fecha) {
        alert("Faltan campos por llenar");
        return false;
      }
      
      document.getElementById('forma01').submit();
      return true;
    }
  </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Formulario de Registro</h1>
    
    <form id="forma01" name="forma01" action="procesar.php" method="POST" class="space-y-4">
      <div class="space-y-2">
        <label class="block text-gray-700">
          Nombre:
          <input id="nombre" type="text" name="nombre" placeholder="Escribe tu nombre" required
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </label>
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700">
          Correo:
          <input id="correo" type="email" name="correo" value="@udg.mx"
                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </label>
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700">Género:</label>
        <div class="flex space-x-4">
          <label class="inline-flex items-center">
            <input type="radio" name="sexo" value="F" class="text-blue-600 focus:ring-blue-500">
            <span class="ml-2">Femenino</span>
          </label>
          <label class="inline-flex items-center">
            <input type="radio" name="sexo" value="M" class="text-blue-600 focus:ring-blue-500">
            <span class="ml-2">Masculino</span>
          </label>
        </div>
      </div>
      
      <div class="space-y-2">
        <label class="inline-flex items-center">
          <input type="checkbox" name="boletin" value="1" checked class="text-blue-600 focus:ring-blue-500">
          <span class="ml-2">Recibir Boletín</span>
        </label>
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700" for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" cols="30" rows="5"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700" for="carrera">Carrera:</label>
        <select id="carrera" name="carrera"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
          <option value="0" selected>Selecciona</option>
          <option value="1">Ing. Informática</option>
          <option value="2">Ing. Computación</option>
        </select>
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700" for="pasw">Contraseña:</label>
        <input id="pasw" type="password" name="pasw"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700" for="promedio">Promedio:</label>
        <input id="promedio" type="number" name="promedio" min="60" max="100"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
      </div>
      
      <div class="space-y-2">
        <label class="block text-gray-700" for="fecha">Fecha nacimiento:</label>
        <input id="fecha" type="date" name="fecha"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
      </div>
      
      <div class="pt-4">
        <button onClick="recibe(); return false;" type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
          Enviar
        </button>
      </div>
    </form>
  </div>
</body>
</html>

