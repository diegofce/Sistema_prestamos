<?php

    require_once "mainModel.php";

    class clienteModelo extends mainModel
    {
        //Agregar cliente
        protected static function agregar_cliente_modelo($datos){
            $sql=mainModel::conectar()->prepare("INSERT INTO cliente(cliente_dni, cliente_nombre, cliente_apellido, cliente_telefono, cliente_direccion, cliente_ficha, cliente_programa_academico) VALUES(:DNI, :NOMBRE, :APELLIDO, :TELEFONO, :DIRECCION,:FICHA, :PROGRAMA)");
            $sql->bindParam(":DNI",$datos['DNI']);
            $sql->bindParam(":NOMBRE",$datos['NOMBRE']);
            $sql->bindParam(":APELLIDO",$datos['APELLIDO']);
            $sql->bindParam(":TELEFONO",$datos['TELEFONO']);
            $sql->bindParam(":DIRECCION",$datos['DIRECCION']);
            $sql->bindParam(":FICHA",$datos['FICHA']);
            $sql->bindParam(":PROGRAMA",$datos['PROGRAMA']);
            
            $sql->execute();
            return $sql;
        }
        // Obtener todos los clientes
    protected static function obtener_clientes_modelo(){
        $sql = mainModel::conectar()->prepare("SELECT * FROM cliente ORDER BY cliente_id DESC");
        $sql->execute();
        return $sql;
    }
}
    