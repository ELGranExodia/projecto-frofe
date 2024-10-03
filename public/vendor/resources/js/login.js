// Verificamos si todos los elementos del DOM ya fueron cargados
$(function() {
    // Reseteamos el formulario
    $('#formLogin')[0].reset();

    // Colocamos el enfoque en el campo user
    $('[name=user]').focus();

    // Enviamos los valores del formulario via AJAX al método verify
    // para comprobar si las credenciales son correctas
    $('#formLogin').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'login/verify',
            type: 'POST',
            dataType: 'json',
            data: $('#formLogin').serialize(),
            success: function(data) {
                if(!data.res) {
                    if(data.erruser)
                        $('[name=user]').addClass('is-invalid');
                    if(data.errpass)
                        $('[name=password]').addClass('is-invalid');
                } else
                    location.href = 'dashboard';
            }

        });
    })

    // Ocultamos el mensaje de error del nombre del usuario
    $('[name=user]').focusin(function() {
        $(this).removeClass('is-invalid');
    })

    // Ocultamos el mensaje de error de la contraseña
    $('[name=password]').focusin(function() {
        $(this).removeClass('is-invalid');
    })

});