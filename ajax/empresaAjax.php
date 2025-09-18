<?php
    $peticionAjax=true;
    require_once "..config/APP.php";
    if(isset($_POST['empresa_nombre_reg']) || isset($_POST['empresa_telefono_reg']) || isset($_POST['empresa_email_reg']) || isset($_POST['empresa_direccion_reg']) || isset($_POST['empresa_mision_reg']) || isset($_POST['empresa_vision_reg']) || isset($_POST['empresa_valores_reg'])){
        /*--------- Instancia al controlador ----------*/
        require_once "../controladores/empresaControlador.php";
        $ins_empresa=new empresaControlador();

        /*--------- Agregar una empresa ----------*/
        if(isset($_POST['empresa_nombre_reg']) && isset($_POST['empresa_telefono_reg']) && isset($_POST['empresa_email_reg']) && isset($_POST['empresa_direccion_reg']) && isset($_POST['empresa_mision_reg']) && isset($_POST['empresa_vision_reg']) && isset($_POST['empresa_valores_reg'])){
           ;
        }
    }
    else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }