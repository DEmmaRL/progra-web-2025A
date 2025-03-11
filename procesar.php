<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["nombre"])         ? $_POST["nombre"] : "";
    $correo = isset($_POST["correo"])         ? $_POST["correo"] : "";
    $sexo = isset($_POST["sexo"])             ? $_POST["sexo"] : "";
    
    $boletin = isset($_POST["boletin"])       ? "Sí" : "No";

    $comentario = isset($_POST["comentario"]) ? $_POST["comentario"] : "";
    $carrera_id = isset($_POST["carrera"])    ? $_POST["carrera"] : "";
    $password = isset($_POST["pasw"])         ? $_POST["pasw"] : "";
    $promedio = isset($_POST["promedio"])     ? $_POST["promedio"] : "";
    $fecha = isset($_POST["fecha"])           ? $_POST["fecha"] : "";
    
    $carrera = "";
    switch ($carrera_id) {
        case "1":
            $carrera = "Ing. Informática";
            break;
        case "2":
            $carrera = "Ing. Computación";
            break;
        default:
            $carrera = "ERRLOR";
    }
    
    $genero = ($sexo == "F") ? "Femenino" : "Masculino";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Recibidos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Datos Recibidos</h1>
        
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="space-y-4">
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Nombre:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($nombre); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Correo:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($correo); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Género:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($genero); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Recibir Boletín:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($boletin); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Comentario:</p>
                    <p class="font-medium"><?php echo nl2br(htmlspecialchars($comentario)); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Carrera:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($carrera); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Contraseña:</p>
                    <p class="font-medium">********</p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Promedio:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($promedio); ?></p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm text-gray-500">Fecha de Nacimiento:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($fecha); ?></p>
                </div>
            </div>
            
            <div class="mt-6">
                <a href="index.php" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center focus:outline-none focus:shadow-outline transition duration-150">
                    Volver al formulario
                </a>
            </div>
        <?php else: ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p>No se han recibido datos del formulario.</p>
                <p class="mt-2">
                    <a href="index.php" class="font-medium underline">Volver al formulario</a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

