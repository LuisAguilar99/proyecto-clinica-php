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
$id_cliente = $_REQUEST['id_cliente'];
//VERIFICA SI EXISTE 
$sql = "SELECT * FROM clientes WHERE id_cliente=$id_cliente";
$result = $con->query($sql);
$existe =  $result->fetch_assoc();
// VERIFIXA
if($existe){
$sql = "UPDATE clientes set deuda=1 WHERE id_cliente=$id_cliente";
// echo $sql;
$result = $con->query($sql);
// LOG
    $date = date('Y-m-d H:i:s');
$sql = "INSERT INTO logs VALUES (NULL,'$idUsuarioIndex','$usuarioIndex','El usuario agrego adeudo a cliente con id: $id_cliente','$date')";
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
