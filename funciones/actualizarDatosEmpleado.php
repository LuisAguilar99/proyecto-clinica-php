<?php
session_start();
if (!$_SESSION['idUsuario']) {
    header("Location: login.php");
} else {    
    $idUsuarioIndex = $_SESSION['idUsuario'];
    $empleadoIndex = $_SESSION['idEmpleado'];
    $usuarioIndex = $_SESSION['usuario'];
    $tipoAdminIndex = $_SESSION['tipoAdmin'];
    $dadoBajaIndex = $_SESSION['dadoBaja'];
}
require "./conecta.php";
$con = conecta();
// echo $id_cliente;

$id_empleado = $_REQUEST['id_empleado_act'];
$nombre = $_REQUEST['nombre_act'];
$apellidos = $_REQUEST['apellidos_act'];
$rfc_correo = $_REQUEST['rfc_correo_act'];
$tipo_admin = $_REQUEST['tipo_admin_act'];
$con_cedula = $_REQUEST['con_cedula_act'];
$con_titulo = $_REQUEST['con_titulo_act'];
$fecha_laborar = $_REQUEST['fecha_laborar_act'];
$sueldo_empleado = $_REQUEST['sueldo_empleado_act'];
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
if($id_empleado){
$sql = "UPDATE empleados SET sueldo_empleado=$sueldo_empleado,`fecha_laborar`='$fecha_laborar',`nombre`='$nombre',`apellido`='$apellidos',`rfc_empleado`='$rfc_correo',`tipo_puesto`=$tipo_admin,`con_cedula`=$con_cedula,`con_titulo`=$con_titulo WHERE `id_empleado`=$id_empleado";
$result = $con->query($sql);
// echo $result;
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario actualizo los datos de empleado con id: $id_empleado','$date')";
$result = $con->query($sql);
$con->close();
echo true;
}else{
    echo false;
}
?>
