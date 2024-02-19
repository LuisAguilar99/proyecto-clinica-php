<?php
require "./conecta.php";
session_start();
if (!$_SESSION['idUsuario']||$_SESSION['tipoAdmin']>1) {
    header("Location: login.php");
} else {    
    $idUsuarioIndex = $_SESSION['idUsuario'];
    $empleadoIndex = $_SESSION['idEmpleado'];
    $usuarioIndex = $_SESSION['usuario'];
    $tipoAdminIndex = $_SESSION['tipoAdmin'];
    $dadoBajaIndex = $_SESSION['dadoBaja'];
}

$con = conecta();
$id_empleado = $_REQUEST['id_empleado'];
$fecha_inicio = $_REQUEST['fecha_inicio'];
$fecha_fin = $_REQUEST['fecha_fin'];
    $sql = "SELECT * FROM `citas` WHERE `terapeuta` =$id_empleado";
    // echo $sql;
    $contador_citas = 0;
    $contador_citas_pareja = 0;
    $contador_citas_ninos = 0;
    $result = $con->query($sql);
    while ($row = $result->fetch_assoc()) {
        if( $row["fecha_inicio"] > $fecha_inicio && $row["fecha_fin"] < $fecha_fin){
            $contador_citas = $contador_citas + 1;
            if($row["tipo_sesion"] == 2){
                $contador_citas_pareja = $contador_citas_pareja + 1;
            }
            if($row["tipo_sesion"] == 1){
                $contador_citas_ninos = $contador_citas_ninos + 1;
            }
        }
    }
    $result->close();
    $con->next_result();

if ($contador_citas > 0) {
    echo $contador_citas.'|'.$contador_citas_pareja.'|'.$contador_citas_ninos;
}else{
    echo '0';
}
$con->close();
?>
              