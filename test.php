<?php
require_once "config/SERVER.php";

try {
    $conexion = new PDO(SGBD, USER, PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión exitosa a la base de datos '".DB."'";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
