<?php

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

/* CRUD */
switch ($method) {
    
    case 'GET':
        if ($action == 'listar') {
            getEmpleados();

        } elseif ($action == 'detalle' && isset($_GET['id'])) {
            getEmpleadoById($_GET['id']);
        
        } else {
            jsonResponse(['success' => false, 'message' => 'Acción no válida']);
        
        }
        break;
    
    case 'POST':
        if ($action == 'crear')
            crearEmpleado($_POST);
        
        elseif ($action == 'eliminar' && isset($_POST['id'])) {
            eliminarEmpleado($_POST['id']);
        
        } elseif ($action == 'actualizar' && isset($_POST['id'])) {
            actualizarEmpleado($_POST);
        
        } else {
            jsonResponse(['success' => false, 'message' => 'Acción no válida']);
        
        }
        break;
    
    default:
        jsonResponse(['success' => false, 'message' => 'Método no permitido']);
        break;
}

function getEmpleados() {
    try {
        $conn = getConnection();
        $sql = "SELECT id, nombre, apellidos, correo, rol FROM empleados WHERE eliminado = 0";
        $empleados = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        if ($empleados) {
            jsonResponse(['success' => true, 'data' =>$empleados]);
        } else {
            jsonResponse(['success' => true, 'data' => []]);
        }
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' =>'Error al obtener empleados: '. $e->getMessage()]);
    }
}

function getEmpleadoById($id) {
    try {
        $conn = getConnection();
        $sql = "SELECT id, nombre, apellidos, correo, rol FROM empleados WHERE eliminado = 0 AND id = $id";
        $empleados = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        if ($empleados) {
            jsonResponse(['success' => true, 'data' => $empleados]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Empleado no encontrado']);
        }
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Error al obtener el empleado: ' . $e->getMessage()]);
    }
}

function crearEmpleado($data) {
    // Validar datos requeridos
    if (!isset($data['nombre']) || !isset($data['apellidos']) || !isset($data['correo']) || !isset($data['pass']) || !isset($data['rol'])) {
        jsonResponse(['success' => false, 'message' => 'Faltan datos requeridos']);
    }
    
    try {
        $conn = getConnection();
        $archivo_nombre = isset($data['archivo_nombre']) ? $data['archivo_nombre'] : '';
        $archivo_file = isset($data['archivo_file']) ? $data['archivo_file'] : '';
        $sql = "INSERT INTO empleados (nombre, apellidos, correo, pass, rol, archivo_nombre, archivo_file) 
            VALUES ('{$data['nombre']}', '{$data['apellidos']}', '{$data['correo']}', '{$data['pass']}', {$data['rol']}, '$archivo_nombre', '$archivo_file')";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        
        jsonResponse(['success' => true, 'message' => 'Empleado creado correctamente', 'id' => $id]);
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Error al crear empleado: ' . $e->getMessage()]);
    }
}

function actualizarEmpleado($data) {

    if (!isset($data['id'])) {
        jsonResponse(['success' => false, 'message' => 'ID no proporcionado']);
    }
    
    try {
        $conn = getConnection();

        $sql = "UPDATE empleados SET ";
        $params = [];
        
        $campos = ['nombre', 'apellidos', 'correo', 'pass', 'rol', 'archivo_nombre', 'archivo_file'];
        
        $actualizaciones = [];
        foreach ($campos as $campo) {
            if (isset($data[$campo])) {
                $actualizaciones[] = "$campo = :$campo";
                $params[":$campo"] = $data[$campo];
            }
        }
        
        if (empty($actualizaciones)) {
            jsonResponse(['success' => false, 'message' => 'No se proporcionaron campos para actualizar']);
        }
        
        $sql .= implode(", ", $actualizaciones) . " WHERE id = :id";
        $params[':id'] = $data['id'];

        $res = $conn->prepare($sql);
        $res->execute($params);

        if ($res->rowCount() > 0) {
            jsonResponse(['success' => true, 'message' => 'Empleado actualizado correctamente']);
        } else {
            jsonResponse(['success' => false, 'message' => 'No se encontró el empleado o no se realizaron cambios']);
        }
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Error al actualizar empleado: ' . $e->getMessage()]);
    }
}

function eliminarEmpleado($id) {
    try {
        $conn = getConnection();
        $sql = "UPDATE empleados SET eliminado = 1 WHERE id = $id";
        $result = $conn->exec($sql);

        if ($result > 0) {
            jsonResponse(['success' => true, 'message' => 'Empleado eliminado correctamente']);
        } else {
            jsonResponse(['success' => false, 'message' => 'No se encontró el empleado o ya estaba eliminado']);
        }
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Error al eliminar empleado: ' . $e->getMessage()]);
    }
}
?>
