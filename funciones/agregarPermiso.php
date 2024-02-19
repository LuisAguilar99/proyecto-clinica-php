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
  
$idEmpleadoPermiso = $_REQUEST['idEmpleadoPermiso'];
$motivoPermiso = $_REQUEST['motivoPermiso'];
$fechaPermiso = $_REQUEST['fechaPermiso'];

if($idEmpleadoPermiso){
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO permisos VALUES (NULL,$idEmpleadoPermiso,'$fechaPermiso','$motivoPermiso')";
echo $sql;
$result = $con->query($sql);

$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario agrego un permiso para: $idEmpleadoPermiso','$date')";
$result = $con->query($sql);
// echo $result;
$con->close();
echo true;
}else{
    echo false;
}
?>