$(function(){
    const columnData = [
        {"data":"id_practica"},
        {"data":"ced_nom_ape_al"},
        {"data":"ruc_nom_ape_pr_em"},
        {"data":"fecha_inicio"},
        {"data":"fecha_fin"},
        {"data":"tipo_practica"},
    ]

    const columnDefs = [
        {
            targets:[5],
            orderable:false,
            render:function(data,type,row){
                console.log(row.tipo_practica)
            }
        }
    ]

    const tableAlumno = configDataTables('.tablePracticas',base_url+"practicas-pre-profesionales/getPracticaspreprofesionales",columnData,columnDefs);

    searchAlumno();
    searchProfesor();
    searchEmpresas();
    const configValid = configToValidate();
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
        $('#cedula_temp_al').val(data.cedula);
        $('#nombre_apellido_al').val(data.text);
        $('#carrera').val(data.carrera);
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
        $('#cedula_temp_pr').val(data.cedula);
        $('#nombre_apellido_pr').val(data.text);
        $('#id_alumnos_re').val(data.id);
        $('#campus').val(data.campus);
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
        placeholder:"Buscar empresa por ruc / nombre empresa",
        templateResult: formatRepoEp,
    }).on('select2:select',function(e){
        e.preventDefault();
        let data = e.params.data;
        $('#nombre_empresa_ep').val(data.text);
        $('#nombre_representante_ep').val(data.nombre);
        $('#telefono_ep').val(data.telefono);
    });
}


