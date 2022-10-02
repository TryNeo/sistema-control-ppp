$(function(){
    
    searchAlumno();
    searchProfesor();
    searchEmpresas();

    const configValid = configToValidate();

    sendingDataServerSidePrEdit('#fntPracticas',configValid,"practicas-pre-profesionales/setPracticaspreprofesionales");
});


function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=id_alcance_proyecto]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=id_tipo_practica]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=id_nivel_pasantias]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=departamento_ep]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=fecha_ini]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
        }


        if($(el).is('[name=fecha_fin]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=total_horas]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (value == 0){
                return 'Este campo no puede quedar en cero';
            }


            if (value < 0 ){
                return 'Este campo no puede ser negativo';
            }

            if (value >= 400 ){
                return 'Las horas no deben de pasar de 400';
            }
        }

    }

    return validatorServerSide
}


function formatRepo (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var option = $(
        '<div class="wrapper container">'+
            '<div class="row">'
                +'<div class="col-lg-8">'
                +'<p style="margin-bottom:0;">'
                    +'<b>Cedula: </b>'+repo.cedula+'<br>'
                    +'<b>Nombre y Apellido: </b>'+repo.text+'<br>'
                    +'<b>Carrera: </b>'+repo.carrera+'<br>'
                +'</p>'
                +'</div>'
            +'</div>'
        +'</div>'
    )

    return option;
}

function formatRepoPr (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var option = $(
        '<div class="wrapper container">'+
            '<div class="row">'
                +'<div class="col-lg-8">'
                +'<p style="margin-bottom:0;">'
                    +'<b>Cedula: </b>'+repo.cedula+'<br>'
                    +'<b>Nombre y Apellido: </b>'+repo.text+'<br>'
                    +'<b>Campus: </b>'+repo.campus+'<br>'
                +'</p>'
                +'</div>'
            +'</div>'
        +'</div>'
    )

    return option;
}

function formatRepoEp (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var option = $(
        '<div class="wrapper container">'+
            '<div class="row">'
                +'<div class="col-lg-8">'
                +'<p style="margin-bottom:0;">'
                    +'<b>Empresa: </b>'+repo.text+'<br>'
                    +'<b>Represante legal: </b>'+repo.nombre+'<br>'
                    +'<b>Telefono: </b>'+repo.telefono+'<br>'
                +'</p>'
                +'</div>'
            +'</div>'
        +'</div>'
    )

    return option;
}

function searchAlumno(){
    $('#id_alumno').select2({
        theme: "bootstrap4",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"practicas-pre-profesionales/getSelectAlumnos",
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
        placeholder:"Buscar alumno por cedula / nombre / apellido",
        templateResult: formatRepo,
    }).on('select2:select',function(e){
        e.preventDefault();
        let data = e.params.data;

        $('#id_alumno_ppp').val(data.id);
        $('#cedula_temp_al').val(data.cedula);
        $('#nombre_apellido_al').val(data.text);
        $('#carrera').val(data.carrera);
        
        $('#id_alumno').val('');
        $('#id_alumno').trigger('change.select2');

    });
}


function searchProfesor(){
    $('#id_profesor').select2({
        theme: "bootstrap4",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"practicas-pre-profesionales/getSelectProfesor",
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
        placeholder:"Buscar tutor docente por cedula / nombre / apellido",
        templateResult: formatRepoPr,
    }).on('select2:select',function(e){
        e.preventDefault();
        let data = e.params.data;
        $('#id_profesor_ppp').val(data.id);
        $('#nombre_apellido_pr').val(data.text);
        $('#id_profesor').val('');
        $('#id_profesor').trigger('change.select2');
    });
}

function searchEmpresas(){
    $('#id_empresa').select2({
        theme: "bootstrap4",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"practicas-pre-profesionales/getSelectEmpresas",
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
        placeholder:"Buscar empresa por ruc / nombre empresa / representante legal",
        templateResult: formatRepoEp,
    }).on('select2:select',function(e){
        e.preventDefault();
        let data = e.params.data;
        $('#id_empresa_ppp').val(data.id);
        $('#nombre_empresa_ep').val(data.text);
        $('#nombre_representante_ep').val(data.nombre);
        $('#telefono_ep').val(data.telefono);
        $('#id_empresa').val('');
        $('#id_empresa').trigger('change.select2');
    });
}

function sendingDataServerSidePrEdit(idForm,validatorServerSide,urlMethod){
    $(idForm).on('submit',function (e) {
        e.preventDefault();

        hiddenValidate();
        
        if($('#id_alumno_ppp').val() === '' || $('#id_profesor_ppp').val() === '' || $('#id_empresa_ppp').val() === ''){
            if($('#id_alumno_ppp').val() === ''){
                iziToast.warning({
                    title: 'Advertencia',
                    message: '<b>Debe seleccionar un Alumno mediante el campo de busqueda</b>',
                    position: 'topCenter'
                });
            }

            if($('#id_profesor_ppp').val() === ''){
                iziToast.warning({
                    title: 'Advertencia',
                    message: '<b>Debe seleccionar un Docente mediante el campo de busqueda</b>',
                    position: 'topCenter'
                });
            }

            if($('#id_empresa_ppp').val() === ''){
                iziToast.warning({
                    title: 'Advertencia',
                    message: '<b>Debe seleccionar un Empresa mediante el campo de busqueda</b>',
                    position: 'topCenter'
                });
            }

            return false;
        }

        if(validatorServerSide.checkAll('.needs-validation') === 0){
            let formData = $(this).serializeArray();
            $.LoadingOverlaySetup({
                image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                imageColor      : "#ffcc00",
                imageAnimation  : "pulse 2.5s",
                imageAutoResize         : true,
            });
            $.LoadingOverlay("show");
            $.ajax({
                url: base_url+urlMethod,
                type: $(idForm).attr("method"),
                data: formData,
                dataType: 'json'
            }).done(function (data) {
                if(data.status){
                    mensaje('success','Éxito',data.msg);
                    setTimeout(function () {
                        location.href = base_url+'practicas-pre-profesionales'
                    },2000)
                }else{
                    $.LoadingOverlay("hide");
                    mensaje('error','Error',data.msg);
                }
                $.LoadingOverlay("hide");
            }).fail(function (error) {
                $.LoadingOverlay("hide");
                mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema');
            })
        }
    })
}

function hiddenValidate(){
    $('.select2-container--bootstrap4 .select2-selection').css("border-color","#d8d8d8");
    $('#cedula_temp_al').removeClass('is-valid');
    $('#nombre_apellido_al').removeClass('is-valid');
    $('#carrera').removeClass('is-valid');
    $('#nombre_apellido_pr').removeClass('is-valid');
    $('#nombre_empresa_ep').removeClass('is-valid');
    $('#nombre_representante_ep').removeClass('is-valid');
    $('#telefono_ep').removeClass('is-valid');
}

