$(function(){
    const columnData = [
        {"data":"id_usuario"},
        {"data":"foto"},
        {"data":"nombre_apellido"},
        {"data":"usuario"},
        {"data":"email"},
        {"data":"ultimo_online"},
        {"data":"nombre_rol"},
        {"data":"estado"},
        ]



    const tableUsuarios =  configDataTables('.tableUsuarios',base_url+"usuarios/getUsuarios",columnData)

    const listCamps =  ["#id_usuario","#nombre","#apellido","#usuario","#password","#email","#id_rol","#foto"];

    const fieldsToValidate = ['nombre','apellido',"usuario","email","id_rol","foto"]

    const configValid = configToValidate()

    clickModal("#modalUsuario","Crear | Usuario",listCamps);
    fetchSelect(base_url+"roles/getSelectRoles","#id_rol","Selecciona un rol")
    sendingDataServerSide('#fntUsuario',configValid,fieldsToValidate,listCamps,tableUsuarios,"usuarios/setUsuario","#modalUsuario");

})



setInterval(function(){
    $(".tableUsuarios").DataTable().ajax.reload();
},5000);


function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

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


        if($(el).is('[name=email]')){
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
        
        if($(el).is('[name=foto]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }


            if (!validateImage(value)){
                return 'La url '+value+' ingresada no es una imagen';
            }
            
        }
        
    }

    return validatorServerSide
}





