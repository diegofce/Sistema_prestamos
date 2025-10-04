<script>
    /*--------- Buscar cliente ----------*/
    function buscar_cliente(){
        let input_cliente=document.querySelector('#input_cliente').value;
        input_cliente=input_cliente.trim();

        if(input_cliente!=""){
            let datos = new FormData();
            datos.append("buscar_cliente",input_cliente);
            fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php",{
                method:"POST",
                body:datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                let tabla_clientes=document.querySelector('#tabla_clientes');
                tabla_clientes.innerHTML=respuesta;
            });
        }else{
            Swal.fire({
                title: 'Ocurrio un error',
                text: "Debe ingresar un nombre o CC para realizar la busqueda",
                type: 'error',
                confirmButtonText: 'Aceptar',
            });
        }
    }
    /*--------- Agregar cliente ----------*/
    function agregar_cliente(id){
        $('#ModalCliente').modal('hide');
        Swal.fire({
            title: '¿Quieres agregar este usuario?',
            text: "se agregara este usuario para realizar un prestamo",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let datos = new FormData();
                datos.append("id_agregar_cliente",id);
                fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php",{
                    method:"POST",
                    body:datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    return alertas_ajax(respuesta);
                });
            }else{
                $('#ModalCliente').modal('show');
            }
        });
    }
    /*--------- Buscar item ----------*/
    function buscar_item(){
        let input_item=document.querySelector('#input_item').value;
        input_item=input_item.trim();

        if(input_item!=""){
            let datos = new FormData();
            datos.append("buscar_item",input_item);

            fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php",{
                method:"POST",
                body:datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                let tabla_items=document.querySelector('#tabla_items');
                tabla_items.innerHTML=respuesta;
            });
        }else{
            Swal.fire({
                title: 'Ocurrio un error',
                text: "Debe ingresar un nombre o código del ITEM para realizar la busqueda",
                type: 'error',
                confirmButtonText: 'Aceptar',
            });
        }
    }

    /*--------- Modal item ----------*/
    function modal_agregar_item(id){
        $('#ModalItem').modal('hide');
        $('#ModalAgregarItem').modal('show');
        document.querySelector('#id_agregar_item').setAttribute("value", id);
    }

/*--------- Duracion prestamo */
    document.addEventListener("DOMContentLoaded", function(){
        const fechaInicio = document.getElementById("prestamo_fecha_inicio");
        const horaInicio  = document.getElementById("prestamo_hora_inicio");
        const fechaFin    = document.getElementById("prestamo_fecha_final");
        const horaFin     = document.getElementById("prestamo_hora_final");
        const inputTotal  = document.getElementById("prestamo_total");

        function calcularDuracion(){
            let datos = new FormData();
            datos.append("prestamo_fecha_inicio_reg", fechaInicio.value);
            datos.append("prestamo_hora_inicio_reg", horaInicio.value);
            datos.append("prestamo_fecha_final_reg", fechaFin.value);
            datos.append("prestamo_hora_final_reg", horaFin.value);
            datos.append("accion", "calcular_duracion");

            fetch("<?php echo SERVERURL; ?>ajax/prestamoAjax.php", {
                method: "POST",
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(duracion => {
                inputTotal.value = duracion; // actualizar campo
            });
        }

        // Detectar cambios
        fechaInicio.addEventListener("change", calcularDuracion);
        horaInicio.addEventListener("change", calcularDuracion);
        fechaFin.addEventListener("change", calcularDuracion);
        horaFin.addEventListener("change", calcularDuracion);
    });



</script>