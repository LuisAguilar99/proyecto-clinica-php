<?php
require "./conecta.php";
$con = conecta();
// echo $id_cliente;
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];


$sql = "SELECT * FROM usuarios WHERE `usuario`='$usuario' AND `password`='$password' AND `dado_baja`=0";
// echo $sql;
$result = $con->query($sql);
$row = $result->fetch_assoc();
$getIdUsuario = $row["id_usuario"];
$getIdEmpleado = $row["id_empleado"];
$getUsuario = $row["usuario"];
$getPassword = $row["password"];
$getTipoAdmin = $row["tipo_admin"];
$getDadoBaja = $row["dado_baja"];
// echo $existe;
if($getUsuario==$usuario&&$getPassword==$password){
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO logs VALUES (NULL,1,'El usuario: $usuario','El usuario inicio sesión','$date')";
    $result = $con->query($sql);
//     $sql = "SELECT * FROM empleados WHERE `id_empleado`=$getIdEmpleado";
//     $result = $con->query($sql);
//     $row = $result->fetch_assoc();
//     $getNombreEmpleado = $row["nombre"].' '.$row["apellido"];
    //inciiar sesion
        session_start();
        $_SESSION['idUsuario'] = $getIdUsuario;
        $_SESSION['idEmpleado'] = $getIdEmpleado;
        $_SESSION['usuario'] = $getUsuario;
        $_SESSION['tipoAdmin'] = $getTipoAdmin;
        $_SESSION['dadoBaja'] = $getDadoBaja;
        // $_SESSION['nombreEmpleado'] = $getNombreEmpleado;
    // iniciar sesion
    $con->close();
    header ("Location: ../index.php");
}else{
    $con->close();
    header ("Location: ../login.php");
}


?>
