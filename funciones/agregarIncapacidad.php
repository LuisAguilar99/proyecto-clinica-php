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
  
$idEmpleadoIncapacidad = $_REQUEST['idEmpleadoIncapacidad'];
$motivoIncapacidad = $_REQUEST['motivoIncapacidad'];
$fechaInicioIncapacidad = $_REQUEST['fechaInicioIncapacidad'];
$fechaFinIncapacidad = $_REQUEST['fechaFinIncapacidad'];

if($idEmpleadoIncapacidad){
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO incapacidades VALUES (NULL,$idEmpleadoIncapacidad,'$fechaInicioIncapacidad','$fechaFinIncapacidad','$motivoIncapacidad')";
echo $sql;
$result = $con->query($sql);

$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario agrego una incapacidad para: $idEmpleadoIncapacidad','$date')";
$result = $con->query($sql);
// echo $result;
$con->close();
echo true;
}else{
    echo false;
}
?>