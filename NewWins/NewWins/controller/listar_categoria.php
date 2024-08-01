<?php
require_once '../model/conexion.php';
function aa(){
    $conexion = ConexionBD::obtenerConexion();
    $salida = "";
    $sql = "SELECT * FROM categorias";
    $result = $conexion->query($sql);
    while($fila= $result->fetch_assoc()){
        $salida .= "<option value='".$fila['id']. "'>" . $fila['nombre'] . "</option>";
    }

    return $salida; 

}   