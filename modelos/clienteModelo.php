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
    /*--------- Eliminar cliente modelo ----------*/
        protected static function eliminar_cliente_modelo($id){
        $sql=mainModel::conectar()->prepare("DELETE FROM cliente WHERE cliente_id=:ID");
        $sql->bindParam(":ID",$id);
        $sql->execute();
        return $sql;
    }
    /*Modelo datos cliente*/
    protected static function datos_cliente_modelo($tipo,$id){
        if($tipo=="Unico"){
            $sql=mainModel::conectar()->prepare("SELECT * FROM cliente WHERE cliente_id=:ID");
            $sql->bindParam(":ID",$id);
        }elseif($tipo=="Conteo"){
            $sql=mainModel::conectar()->prepare("SELECT cliente_id FROM cliente");
        }
        $sql->execute();
        return $sql;
    }
    /*Actualizar cliente*/
    protected static function actualizar_cliente_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE cliente SET cliente_dni=:DNI, cliente_nombre=:NOMBRE, cliente_apellido=:APELLIDO, cliente_telefono=:TELEFONO, cliente_direccion=:DIRECCION, cliente_ficha=:FICHA, cliente_programa_academico=:PROGRAMA WHERE cliente_id=:ID");
        $sql->bindParam(":DNI",$datos['DNI']);
        $sql->bindParam(":NOMBRE",$datos['NOMBRE']);
        $sql->bindParam(":APELLIDO",$datos['APELLIDO']);
        $sql->bindParam(":TELEFONO",$datos['TELEFONO']);
        $sql->bindParam(":DIRECCION",$datos['DIRECCION']);
        $sql->bindParam(":FICHA",$datos['FICHA']);
        $sql->bindParam(":PROGRAMA",$datos['PROGRAMA']);
        $sql->bindParam(":ID",$datos['ID']);
        $sql->execute();
        return $sql;
    }
}

