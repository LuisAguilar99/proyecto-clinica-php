<?php
date_default_timezone_set("America/Mexico_City");
define("HOST",'localhost');
define("BD",'id18231476_baseconsultorio');
define("USER_DB",'id18231476_root');
define("PASS_BD",'EX6<Eqv^N+]4>&2#');
function conecta(){
    if(!($con = mysqli_connect(HOST,USER_DB,PASS_BD))){
        echo "Error conectando al Servidor de BBDD";
        exit();
    }
    if(!mysqli_select_db($con,BD)){
        echo "Error Seleccionado BD";
        exit();
    }
    // echo "Conexión exitosa.";
    return $con;
}
?>