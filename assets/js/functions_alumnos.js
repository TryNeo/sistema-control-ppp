$(function(){



    clickModal("#modalAlumno","Crear | Alumno","#fntAlumno");
    fetchSelect(base_url+"alumnos/getSelectCarreras","#id_carrera","Selecciona una carrera")
    SearchUsuarioA();
})



function formatRepo (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var option = $(
        '<div class="wrapper container">'+
            '<div class="row">'
                +'<div class="col-lg-8">'
                +'<p style="margin-bottom:0;">'
                    +'<b>Usuario: </b>'+repo.usuario+'<br>'
                    +'<b>Correo institucional: </b>'+repo.email_institucional+'<br>'
                    +'<b>Rol: </b>'+repo.nombre_rol+'<br>'
                +'</p>'
                +'</div>'
            +'</div>'
        +'</div>'
    )

    return option;
}


function SearchUsuarioA(){
    $('#id_usuario').select2({
        theme: "bootstrap-5",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+'alumnos/getSelectUsuarios',
            type: "POST",
            dataType: 'json',
            delay:250,
            data: function (params) {
                let queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder:"Seleccione un usuario",
        dropdownParent: $('#modalAlumno'),
        templateResult: formatRepo,
    }).on('select2:selecting', function(e) {
        console.log('Selecting: ' , e.params.args.data);
    });
}