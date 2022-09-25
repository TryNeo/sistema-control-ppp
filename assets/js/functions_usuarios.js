$(function(){
    const columnData = [
        {"data":"id_usuario"},
        {"data":"usuario"},
        {"data":"email_institucional"},
        {"data":"email_activo"},
        {"data":"ultimo_online"},
        {"data":"nombre_rol"},
        {"data":"estado"},
        {"data":"opciones"}
        ]

    const tableUsuarios =  configDataTables('.tableUsuarios',base_url+"usuarios/getUsuarios",columnData)

    const listCamps =  ["#id_usuario","#usuario","#email_institucional","#password","#id_rol"];

    const fieldsToValidate = ["usuario","email_institucional","id_rol"]

    const configValid = configToValidate()

    clickModal("#modalUsuario","Crear | Usuario","#fntUsuario","#id_usuario");
    fetchSelect(base_url+"roles/getSelectRoles","#id_rol","Selecciona un rol")
    sendingDataServerSide('#fntUsuario',configValid,fieldsToValidate,listCamps,tableUsuarios,"usuarios/setUsuario","#modalUsuario");

})

setInterval(function(){ $(".tableUsuarios").DataTable().ajax.reload(); },10000);


function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=usuario]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
            if (!validateUser(value)){
                return 'El usuario '+value+' no es valida';
            }
            
        }

        if($(el).is('[name=password]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            
            if (!validateUser(value)){
                return 'La contraseña '+value+' no es valida';
            }
            
            
        }


        if($(el).is('[name=email_institucional]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }


            if (!validaEmail(value)){
                return 'El email '+value+' es invalido';
            }
            
        }

        if($(el).is('[name=id_rol]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
            
        }

    }

    return validatorServerSide
}





