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
$nombre = $_REQUEST['nombreCliente'];
$apellido = $_REQUEST['apellidoCliente'];
$edad = $_REQUEST['edadCliente'];
$telefono = $_REQUEST['telefonoCliente'];
$correo = $_REQUEST['correoCliente'];
if($nombre){
$sql = "INSERT INTO clientes VALUES (NULL,0,'$nombre','$apellido','$telefono',0,'$correo','$edad',0)";
// echo $sql;
$result = $con->query($sql);
// ACTUA
$sql = "SELECT * FROM `clientes` WHERE `nombre` = '$nombre' AND `apellido`='$apellido' AND `telefono`=$telefono AND `correo`='$correo'";
// echo $sql;
$result = $con->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();                
                $id_clientefrom = $row["id_cliente"];
                $nodecitas = $row["no_citas"];
            }
// ACTUA
$nodecitas = $nodecitas + 1;
// actuaexp
$sql = "UPDATE clientes set id_expediente=$id_clientefrom,no_citas=$nodecitas WHERE id_cliente=$id_clientefrom";
// echo $sql;
$result = $con->query($sql);
$date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario agrego cliente con id: $id_clientefrom','$date')";

$result = $con->query($sql);
// actuaexpe
$sql = "INSERT INTO expediente VALUES (NULL, $id_clientefrom,'Sin comentario','$date')";
// echo $sql;
$result = $con->query($sql);
// echo $result;
$con->close();
echo true;
}else{
    echo false;
}
?>
