<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDeDatos = "crudprueba";

try {
  $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos", $usuario, $password);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Conexión exitosa a la base de datos $baseDeDatos.";
} catch(PDOException $e) {
  //echo "Error de conexión: " . $e->getMessage();
}