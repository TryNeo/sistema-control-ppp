$(function(){
    const columnData = [
        {"data":"cedula"},
        {"data":"nombre"},
        {"data":"apellido"},
        {"data":"usuario"},
        {"data":"email_personal"},
        {"data":"email_institucional"},
        {"data":"estado"},
        {"data":"opciones"},
    ]

    const tableProfesor = configDataTables('.tableProfesores',base_url+"profesores/getProfesores",columnData);
    const listCamps =  ["#id_profesor","#cedula","#email_personal","#nombre","#apellido","#telefono","#sexo","#id_campus","#id_usuario"];
    const fieldsToValidate = ["cedula","email_personal","nombre","apellido","telefono","sexo","id_campus","id_usuario"];
    const configValid = configToValidate();

    clickModal("#modalProfesor","Crear | Docente","#fntProfesor","#id_profesor","#id_usuario",['#sexo','#id_campus']);
    fetchSelect(base_url+"profesores/getSelectCampus","#id_campus","Selecciona un campus")
    sendingDataServerSide('#fntProfesor',configValid,fieldsToValidate,listCamps,tableProfesor,"profesores/setProfesor","#modalProfesor");
    searchUsuarioP();
})


setInterval(function(){ $(".tableProfesores").DataTable().ajax.reload(); },10000);


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
            
            if(!validaNumber(value)){
                return 'El campo cedula solo debe contener numeros';
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

        if($(el).is('[name=id_campus]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=sexo]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=id_usuario]')){
            let value= $(el).val()
            if (!validateSelect(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=telefono]')){
            let value= $(el).val()

            if (!validaTelefono(value)){
                return 'El telefono '+value+' es invalido';
            }

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
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


function searchUsuarioP(){
    $('#id_usuario').select2({
        theme: "bootstrap-5",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"profesores/getSelectUsuarios",
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
        usuarioAl = data.text;
    });
}


function clickModalEditingPr(urlData,modalName,nameSelectorId,listCamps,nameSelectorModal,isSelect =false,
    listSelect = [],isSelect2=false,nameSelect2='') {
$(nameSelectorModal).modal("show");
$('form').removeClass('was-validated');
$("input").removeClass("is-valid");
$("input").removeClass("is-invalid");
$("textarea").removeClass("is-valid");
$("textarea").removeClass("is-invalid");
$("select").removeClass("is-valid");
$("select").removeClass("is-invalid");

document.querySelector('#modalTitle').innerHTML = modalName;
document.querySelector('.changeText').innerHTML = " Actualizar registro ";
(async () => {
    try {
        let options = { method: "GET"}
        let response = await fetch(urlData,options);
        if (response.ok) {
            let data = await response.json();
            
            document.querySelector('#'+nameSelectorId).value = data.msg[nameSelectorId];
            listCamps.forEach(function(element,index){
                document.querySelector('#'+element).value = data.msg[element];
                $('#'+element).removeClass('is-invalid');
                $('#'+element).addClass('is-valid');
            })

            if(isSelect){
                listSelect.forEach(function(element,index){
                    document.querySelector('#'+element).value = data.msg[element];
                    $('#'+element).removeClass('is-invalid');
                    $('#'+element).addClass('is-valid');
                })
            }

            if(isSelect2){
                $(nameSelect2).attr('disabled','disabled');
                $(nameSelect2).addClass('hidden-data');
                $(nameSelect2).removeClass('is-invalid');
                $('select').toggleSelect2(false);
            }

        }else {
            mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema');
        }
    } catch (err) {
        console.log(err)
    }
})();
}