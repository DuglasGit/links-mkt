<script>
    let btn_salir = document.querySelector(".logout");
    btn_salir.addEventListener("click", function(e) {
        e.preventDefault();
        Swal.fire({
            title: "¿Quiere salir del Sistema?",
            text: "La sesión actual se cerrará y saldrá del sistema",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let url = '<?php echo SERVERURL; ?>ajax/loginAjax.php';
                let token = '<?php echo $login_controlador->encryption($_SESSION['token_lmr']); ?>';
                let usuario = '<?php echo $login_controlador->encryption($_SESSION['usuario_lmr']); ?>';

                let datos = new FormData();
                datos.append("token", token);
                datos.append("usuario", usuario);


                fetch(url, {
                        method: "POST",
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        return alertas_ajax(respuesta);
                    });
            }
        });
    })
</script>