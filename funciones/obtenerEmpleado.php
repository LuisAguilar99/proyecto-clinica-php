<?php
require "./conecta.php";
session_start();
if (!$_SESSION['idUsuario']||$_SESSION['tipoAdmin']>1) {
    header("Location: login.php");
} else {    
    $idUsuarioIndex = $_SESSION['idUsuario'];
    $empleadoIndex = $_SESSION['idEmpleado'];
    $usuarioIndex = $_SESSION['usuario'];
    $tipoAdminIndex = $_SESSION['tipoAdmin'];
    $dadoBajaIndex = $_SESSION['dadoBaja'];
}

$con = conecta();
$id_empleado = $_REQUEST['id_empleado_act'];
    $sql = "SELECT * FROM `empleados` WHERE `id_empleado` =$id_empleado";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
if ($row['id_empleado']!='') {
    $datos = $row['nombre'].'|'.$row['apellido'].'|'.$row['rfc_empleado'].'|'.$row['tipo_puesto'].'|'.$row['fecha_laborar'].'|'.$row['sueldo_empleado'].'|'.$row['con_titulo'].'|'.$row['con_cedula'];
    echo $datos;
}else{
    echo false;
}
$con->close();
?>
              