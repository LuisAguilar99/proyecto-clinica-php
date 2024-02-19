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
$date = date('Y-m-d H:i:s');
$date_fin = date('Y-m-d');
$id_empleado = $_REQUEST['id_empleado'];
// VERIFIXA
if($id_empleado){
$sql = "UPDATE empleados set dado_baja=1,fecha_laborar_fin = '$date_fin' WHERE id_empleado=$id_empleado";
// echo $sql;
$result = $con->query($sql);
// LOG
    
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario dio de baja a empleado con id: $id_empleado','$date')";
$result = $con->query($sql);


// /LOG
// echo $result;
$con->close();
}
// header ("Location: lista_administradores.php");
// header ("Location: ../eliminarCliente.php");
echo $result;
// header ("Location: ../eliminarCliente.php");
?>
