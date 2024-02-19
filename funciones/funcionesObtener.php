<?php
require "./conecta.php";
// require "./conecta.php";
$con = conecta();
$id_empleado = $_REQUEST['id_empleado'];
$datos_permisos = '';
$datos_incapacidad = '';
// --------- PERMISOS
$sql = "SELECT * FROM `permisos` WHERE id_empleado=$id_empleado";
// Check for errors
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}
$result = $con->query($sql);


    while ($row = $result->fetch_assoc()) {
        if ($row['id_permiso']!='') {
            $datos_permisos = $datos_permisos.$row['dia_permiso'].'+'.$row['motivo'].'/';
        }else{
            $datos_permisos = '0pp';
        }
    }
    $result->close();
    $con->next_result();
     
// ---------- PERMISOS
// ---------- INCAPACIDAD
$sql = "SELECT * FROM `incapacidades` WHERE id_empleado=$id_empleado";
// Check for errors
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}
$result = $con->query($sql);
    while ($row = $result->fetch_assoc()) {
        if ($row['id_incapacidad']!='') {
            $datos_incapacidad = $datos_incapacidad.$row['fecha_inicio_inca'].'+'.$row['fecha_fin_inca'].'+'.$row['motivo'].'/';
        }else{
            $datos_incapacidad = '0ii';
        }
    }
    $result->close();
    $con->next_result();
// ---------- INCAPACIDAD
$sql = "SELECT * FROM `empleados` WHERE `id_empleado` =$id_empleado";
    // echo $sql;
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
if ($row['id_empleado']!='') {
    $datos = $row['nombre'].' '.$row['apellido'].'+'.$row['rfc_empleado'].'+'.$row['sueldo_empleado'].'+'.$row['fecha_laborar'].'+'.$row['fecha_laborar_fin'].'+'.$row['tipo_puesto'].'|'.substr($datos_permisos, 0, -1).'|'.substr($datos_incapacidad, 0, -1);
    echo $datos;
}else{
    echo '0';
}
$con->close();
?>