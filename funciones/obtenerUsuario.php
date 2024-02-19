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
$id_usuario = $_REQUEST['id_usuario'];
    $sql = "SELECT * FROM `usuarios` WHERE `id_usuario` =$id_usuario";
    // echo $sql;
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    
if ($row['id_usuario']!='') {
    $datos = $row['id_empleado'].'|'.$row['tipo_admin'].'|'.$row['usuario'].'|'.$row['password'];
    echo $datos;
}else{
    echo false;
}
$con->close();
?>
              