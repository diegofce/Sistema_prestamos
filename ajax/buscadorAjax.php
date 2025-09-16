<?php
    session_start(['name'=>'SPM']);
    require_once "../config/APP.php";

    if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) || isset($_POST['fecha_inicio']) && isset($_POST['fecha_final'])){

        $data_url = [
            "usuario"=>"user-search",
            "cliente"=>"client-search",
            "item"=>"item-search",
            "prestamo"=>"reservation-search"
        ];
        if(isset($_POST['modulo'])){
            $modulo=$_POST['modulo'];
            if(!isset($data_url[$modulo])){

                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se pudo realizar la búsqueda, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
                

            }

        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"No se pudo realizar la búsqueda, por favor intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();

        }
        if($modulo=="prestamo"){
            $fecha_inicio = "fecha_inicio_".$modulo;
            $fecha_final = "fecha_final_".$modulo;
            //Iniciar busqueda
            if(isset($_POST['fecha_inicio']) ||isset($_POST['fecha_final'])){
                if($_POST['fecha_inicio']=="" || $_POST['fecha_final']==""){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Para realizar una búsqueda por fechas es necesario que ingrese ambas fechas",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $_SESSION[$fecha_inicio]= $_POST['fecha_inicio'];
                $_SESSION[$fecha_final]= $_POST['fecha_final'];
            
            }
            //Eliminar busqueda
            if(isset($_POST['eliminar_busqueda'])){
                unset($_SESSION[$fecha_inicio]);
                unset($_SESSION[$fecha_final]);
            }
        }else{
            $name_var="busqueda_".$modulo;
            //Iniciar busqueda
            if(isset($_POST['busqueda_inicial'])){
                if ($_POST['busqueda_inicial']==""){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrido un error inesperado",
                        "Texto"=>"Por favor ingrese un término de búsqueda",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $_SESSION[$name_var]= $_POST['busqueda_inicial'];
            }
            //Eliminar busqueda
            if(isset($_POST['eliminar_busqueda'])){
                unset($_SESSION[$name_var]);
            }
        }
        // Redireccionar
        $url=$data_url[$modulo];
        $alerta=[
            "Alerta"=>"redireccionar",
            "URL"=>SERVERURL.$url."/"
        ]; 
        echo json_encode($alerta);

    }else{
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }