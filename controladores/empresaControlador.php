<?php
    if($peticionAjax){
        require_once "../modelos/empresaModelo.php";
    }else{
        require_once "./modelos/empresaModelo.php";
    }
    class empresaControlador extends empresaModelo
    {
        //Controlador para obtener los datos de la empresa
        public function datos_empresa_controlador(){
            return empresaModelo::datos_empresa_modelo();
        }
    }