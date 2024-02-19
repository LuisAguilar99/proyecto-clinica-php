<?php
require "./conecta.php";
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
$con = conecta();
$id_usuario = $_REQUEST['id_usuario'];
$id_empleado = $_REQUEST['id_empleado'];
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];
$tipo_admin = $_REQUEST['tipo_admin'];

if($id_usuario){
$sql = "UPDATE usuarios SET `id_empleado`=$id_empleado,`usuario`='$usuario',`password`='$password',`tipo_admin`=$tipo_admin WHERE `id_usuario`=$id_usuario";
$result = $con->query($sql);
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario actualizo los datos de usuario con id: $id_usuario','$date')";
$result = $con->query($sql);
$con->close();
echo true;
}else{
    echo false;
}
?>
