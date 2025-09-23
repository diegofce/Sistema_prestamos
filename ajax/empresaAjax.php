<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['empresa_nombre_reg']) || isset($_POST['empresa_id_up'])){

        /*--------- Instancia al controlador ----------*/
        require_once "../controladores/empresaControlador.php";
        $ins_empresa=new empresaControlador();

        /*--------- Agregar una empresa ----------*/
        if(isset($_POST['empresa_nombre_reg'])){
            echo $ins_empresa->agregar_empresa_controlador();
        } 
        /*--------- Actualizar una empresa ----------*/
        if(isset($_POST['empresa_id_up'])){
            echo $ins_empresa->actualizar_empresa_controlador();
        }
    }
    else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }