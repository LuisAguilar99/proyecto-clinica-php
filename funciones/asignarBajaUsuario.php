<?php
session_start();
if (!$_SESSION['idUsuario']) {
    header("Location: ./login.php");
} else {    
    $idUsuarioIndex = $_SESSION['idUsuario'];
    $empleadoIndex = $_SESSION['idEmpleado'];
    $usuarioIndex = $_SESSION['usuario'];
    $tipoAdminIndex = $_SESSION['tipoAdmin'];
    $dadoBajaIndex = $_SESSION['dadoBaja'];
}
require "./conecta.php";
$con = conecta();
$id_usuario = $_REQUEST['id_usuario'];
if($id_usuario != ''){
$sql = "UPDATE usuarios set dado_baja=1 WHERE id_usuario=$id_usuario";
$result = $con->query($sql);
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario dio de baja a usuario con id: $id_usuario','$date')";
$result = $con->query($sql);
$con->close();
echo true;
}else{
echo false;
}
?>
