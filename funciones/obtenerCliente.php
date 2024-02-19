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
$id_cliente = $_REQUEST['id_cliente'];
    $sql = "SELECT * FROM `clientes` WHERE `id_cliente` =$id_cliente";
    // echo $sql;
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    
if ($row['id_cliente']!='') {
    $datos = $row['nombre'].'|'.$row['apellido'].'|'.$row['telefono'].'|'.$row['correo'].'|'.$row['edad'].'|'.$row['id_cliente'];
    echo $datos;
}else{
    echo '0';
}
$con->close();
?>
              