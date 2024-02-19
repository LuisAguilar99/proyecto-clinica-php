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
  
$nombre = $_REQUEST['nombre_agr'];
$apellidos = $_REQUEST['apellidos_agr'];
$rfc_correo = $_REQUEST['rfc_correo_agr'];
$tipo_admin = $_REQUEST['tipo_admin_agr'];
$con_cedula = $_REQUEST['con_cedula_agr'];
$con_titulo = $_REQUEST['con_titulo_agr'];
$fecha_laborar = $_REQUEST['fecha_laborar_agr'];
$sueldo_empleado = $_REQUEST['sueldo_empleado_agr'];

if($con_cedula=='on'){
    $con_cedula = 1;
}else{
    $con_cedula = 0;
}
if($con_titulo=='on'){
    $con_titulo = 1;
}else{
    $con_titulo = 0;
}
if($nombre!=''){
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO empleados VALUES (NULL,'$nombre','$apellidos',$tipo_admin,'$date','$fecha_laborar','','$rfc_correo',$sueldo_empleado,$con_titulo,$con_cedula,0)";
echo $sql;
$result = $con->query($sql);
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario agrego el empleado con rfc o correo: $rfc_correo','$date')";
$result = $con->query($sql);
$con->close();
echo true;
}else{
    echo false;
}
?>
