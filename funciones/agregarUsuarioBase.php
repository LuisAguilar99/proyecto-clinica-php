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
  
$id_empleado = $_REQUEST['id_empleado'];
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];
$tipo_admin = $_REQUEST['tipo_admin'];
if($id_empleado!=''){
$sql = "INSERT INTO usuarios VALUES (NULL,$id_empleado,'$usuario','$password',$tipo_admin,0)";
$result = $con->query($sql);
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario agrego el usuario: $usuario de empleado id: $id_empleado','$date')";
$result = $con->query($sql);
$con->close();
echo true;
}else{
    echo false;
}
?>
