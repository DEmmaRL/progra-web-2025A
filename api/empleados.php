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
        
        } elseif ($action == 'validar_correo' && isset($_POST['correo'])) {
            validarCorreo($_POST['correo']);
            
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
    if (!isset($data['nombre']) || !isset($data['apellidos']) 
        || !isset($data['correo']) || !isset($data['pass']) 
        || !isset($data['rol'])) {
        
            jsonResponse(['success' => false, 'message' => 'Faltan datos requeridos']);
    }
    
    try {
        $conn = getConnection();

        $sql = $conn->prepare("SELECT COUNT(*) FROM empleados WHERE correo = ? AND eliminado = 0");
        $sql->execute([$data['correo']]);

        if ($sql->fetchColumn() > 0) {
            jsonResponse(['success' => false, 'message' => 'El correo ya existe en la base de datos']);
        }
        
        $password_encriptada = md5($data['pass']);
        
        // No sé si debíamos ncluir protección contra inyecciones SQL
        $sql = $conn->prepare("INSERT INTO empleados (nombre, apellidos, correo, pass, rol, archivo_nombre, archivo_file) 
                               VALUES (:nombre, :apellidos, :correo, :pass, :rol, :archivo_nombre, :archivo_file)");
        
        $archivo_nombre = isset($data['archivo_nombre']) ? $data['archivo_nombre'] : '';
        $archivo_file = isset($data['archivo_file']) ? $data['archivo_file'] : '';
        
        $sql->bindParam(':nombre', $data['nombre']);
        $sql->bindParam(':apellidos', $data['apellidos']);
        $sql->bindParam(':correo', $data['correo']);
        $sql->bindParam(':pass', $password_encriptada);
        $sql->bindParam(':rol', $data['rol']);
        $sql->bindParam(':archivo_nombre', $archivo_nombre);
        $sql->bindParam(':archivo_file', $archivo_file);
        
        $sql->execute();
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
        $sql = $conn->prepare("UPDATE empleados SET eliminado = 1 WHERE id = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            jsonResponse(['success' => true, 'message' => 'Empleado eliminado correctamente']);
        } else {
            jsonResponse(['success' => false, 'message' => 'No se encontró el empleado o ya estaba eliminado']);
        }
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Error al eliminar empleado: ' . $e->getMessage()]);
    }
}

function validarCorreo($correo) {
    try {
        $conn = getConnection();
        $sql = $conn->prepare("SELECT COUNT(*) FROM empleados WHERE correo = ? AND eliminado = 0");
        $sql->execute([$correo]);
        $existe = ($sql->fetchColumn() > 0);
        jsonResponse(['disponible' => !$existe]);
    } catch(PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Error al validar correo: ' . $e->getMessage()]);
    }
}
?>
