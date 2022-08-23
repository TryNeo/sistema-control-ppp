$(function(){

    const configValid = configToValidate()
    clickModal("#modalAlumno","Crear | Alumno","#fntAlumno");
    fetchSelect(base_url+"alumnos/getSelectCarreras","#id_carrera","Selecciona una carrera")
    searchUsuarioA();
})

function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=cedula]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if(!validateStringLength(value,10)){
                return 'El campo cedula debe tener 10 caracteres';
            }

            if (!validateCedula(value)){
                return 'La cedula '+value+' es incorrecta';
            }
            
        }
        
        if($(el).is('[name=email_personal]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validaEmail(value)){
                return 'El email '+value+' es invalido';
            }
            
        }

        if($(el).is('[name=nombre]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }


            if (!validString(value)){
                return 'El nombre '+value+' contiene numeros o caracteres especiales';
            }
            
        }
        
        if($(el).is('[name=apellido]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validString(value)){
                return 'El apellido '+value+' contiene numeros o caracteres especiales';
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
                    +'<b>Usuario: </b>'+repo.text+'<br>'
                    +'<b>Correo Institucional: </b>'+repo.descripcion+'<br>'
                    +'<b>Rol: </b>'+repo.rol
                +'</p>'
                +'</div>'
            +'</div>'
        +'</div>'
    )

    return option;
}


function searchUsuarioA(){
    $('#id_usuario').select2({
        theme: "bootstrap-5",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"alumnos/getSelectUsuarios",
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
        placeholder:"Selecionar usuario",
        templateResult: formatRepo,
    }).on('select2:select',function(e){
        e.preventDefault();
        let data = e.params.data;
        console.log(data);
    });
}