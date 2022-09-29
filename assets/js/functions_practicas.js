$(function(){
    const columnData = [
        {"data":"id_practica"},
        {"data":"ced_nom_ape_al"},
        {"data":"ruc_nom_ape_pr_em"},
        {"data":"fecha_inicio"},
        {"data":"fecha_fin"},
        {"data":"tipo_practica"},
        {"data":"opciones"},
    ]

    const columnDefs = [
        {
            targets:[5],
            orderable:false,
            render:function(data,type,row){
                if (row.tipo_practica === "1"){
                    return '<button type="button" class="btn btn-primary btn-icon icon-left">'+
                            '<i class="fas fa-business-time"></i> EMPRESARIAL'+
                            '</button>'
                }else{
                    return '<button type="button" class="btn btn-info btn-icon icon-left">'+
                            '<i class="fas fa-poll-h"></i> SERVICIO A LA COMUNIDAD'+
                            '</button>'
                }
            }
        }
    ]

    const tablePracticas = configDataTables('.tablePracticas',base_url+"practicas-pre-profesionales/getPracticaspreprofesionales",columnData,columnDefs);

    searchAlumno();
    searchProfesor();
    searchEmpresas();
    const configValid = configToValidate();
    sendingDataServerSidePr('#fntPracticas',configValid,"practicas-pre-profesionales/setPracticaspreprofesionales");

})

function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){
        if($(el).is('[name=id_alumno]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }
        
        if($(el).is('[name=id_profesor]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        
        if($(el).is('[name=id_empresa]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

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

setInterval(function(){ $(".tablePracticas").DataTable().ajax.reload(); },10000);


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
        $('#cedula_temp_al').val(data.cedula);
        $('#nombre_apellido_al').val(data.text);
        $('#carrera').val(data.carrera);

        $.get("getSelectEmpresarialServiciosAlacomunidad/"+data.id, function(data){
            let data_gen = JSON.parse(data);
            if(data_gen.status){
                $('#total_emp').val(data_gen.total_horas_emp.total_horas);
                $('#total_serv').val(data_gen.total_horas_ser.total_horas);
            }else{
                mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema')
            }
        });



        $.get("getSelectTotalHorasppp/"+data.id, function(data){
            let data_horas_ppp = JSON.parse(data);
            if(data_horas_ppp.status){
                if (data_horas_ppp.msg.total_horas >= 400){
                    $('#total_ppp').addClass('is-invalid');
                    $('#total_ppp').val(0);
                    mensaje('warning',"Advertencia de horas",'El alumno ya ha completado las 400 horas de practicas pre profesionales');
                    $('#fntPracticas').trigger("reset");
                    $('#id_alumno').val('');
                    $('#id_alumno').trigger('change.select2');
                }else{
                    $('#total_ppp').val(0);
                    let total_horas = parseInt($('#total_ppp').val())+parseInt(data_horas_ppp.msg.total_horas)
                    $('#total_ppp').val(total_horas);
                    $('#total_ppp').removeClass('is-invalid');
                }
            }else{
                mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema')
            }
        });

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
        $('#nombre_apellido_pr').val(data.text);
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
        $('#nombre_empresa_ep').val(data.text);
        $('#nombre_representante_ep').val(data.nombre);
        $('#telefono_ep').val(data.telefono);
    });
}


function sendingDataServerSidePr(idForm,validatorServerSide,urlMethod){
    $(idForm).on('submit',function (e) {
        e.preventDefault();
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
                    mensaje('success','Exitoso',data.msg);
                    setTimeout(function (
                    ) {
                        location.href = base_url+'practicas-pre-profesionales'
                    }
                    ,3000);
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
