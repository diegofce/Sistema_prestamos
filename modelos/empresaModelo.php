<?php

    require_once "mainModel.php";
    class empresaModelo extends mainModel
    {
        //Obtener datos de la empresa
        protected static function datos_empresa_modelo(){
            $sql=mainModel::conectar()->prepare("SELECT * FROM empresa WHERE empresa_id=1");
            $sql->execute();
            return $sql;
        }
    } 
    