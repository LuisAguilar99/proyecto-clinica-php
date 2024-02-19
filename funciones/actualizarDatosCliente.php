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
$nombre = $_REQUEST['nombreClienteAct'];
$apellido = $_REQUEST['apellidoClienteAct'];
$id_cliente = $_REQUEST['idClienteAct'];
$edad = $_REQUEST['edadClienteAct'];
$telefono = $_REQUEST['telefonoClienteAct'];
$correo = $_REQUEST['correoClienteAct'];

if($id_cliente){
$sql = "UPDATE clientes SET `nombre`='$nombre',`apellido`='$apellido',`edad`='$edad',`telefono`='$telefono',`correo`='$correo' WHERE `id_cliente`=$id_cliente";
$result = $con->query($sql);
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario actualizo el registro del cliente con id: $id_cliente','$date')";
$result = $con->query($sql);
$con->close();
echo true;
}else{
    echo false;
}

?>
