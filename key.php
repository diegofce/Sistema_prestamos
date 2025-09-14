<?php
require_once "./config/SERVER.php";
require_once "./modelos/mainModel.php";

// Crear instancia de mainModel
$model = new mainModel();

// Clave en texto plano que quieres usar
$clave_plana = "admin123"; 

// Encriptar
$clave_encriptada = $model->encryption($clave_plana);

echo "Clave en texto plano: " . $clave_plana . "<br>";
echo "Clave encriptada: " . $clave_encriptada . "<br>";
