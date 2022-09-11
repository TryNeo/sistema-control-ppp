$(function(){
    const columnData = [
        {"data":"ruc_empresa"},
        {"data":"nombre_empresa"},
        {"data":"correo_empresa"},
        {"data":"nombre_representante"},
        {"data":"telefono_representante"},
        {"data":"estado"},
        {"data":"opciones"}
        ,
    ]

    const tableEmpresa = configDataTables('.tableEmpresa',base_url+"empresas/getEmpresas",columnData);

    const listCamps =  ["#id_empresa","#ruc_empresa","#nombre_empresa","#direccion_empresa","#correo_empresa","#telefono_empresa",
                            "#cedula_representante","#nombre_representante","#telefono_representante","#descripcion_empresa"];

    const fieldsToValidate = ["ruc_empresa","nombre_empresa","direccion_empresa","correo_empresa","telefono_empresa",
                                    "cedula_representante","nombre_representante","telefono_representante","descripcion_empresa"];

    const configValid = configToValidate();

    clickModal("#modalEmpresa","Crear | Empresa","#fntEmpresa");
    sendingDataServerSide('#fntEmpresa',configValid,fieldsToValidate,listCamps,tableEmpresa,"empresas/setEmpresa","#modalEmpresa");

})

setInterval(function(){ $(".tableEmpresa").DataTable().ajax.reload(); },10000);



function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=ruc_empresa]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
            
            if(!validaNumber(value)){
                return 'El campo ruc debe ser numerico';
            }

            if(!verificarRuc(value)){ return 'El ruc '+value+' no es valido'; }
        }

        if($(el).is('[name=nombre_empresa]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
            if(!validateStringLength(value,5)){
                return 'El nombre de la empresa debe tener mas de 5 caracteres';
            }
        }

        if($(el).is('[name=direccion_empresa]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
            if(!validateStringLength(value,10)){
                return 'La direccion de la empresa debe tener mas de 5 caracteres';
            }

        }           

        if($(el).is('[name=telefono_empresa]')){
            let value= $(el).val()

            if (!validaTelefono(value)){
                return 'El telefono de la empresa '+value+' es invalido';
            }

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }
        }

        if($(el).is('[name=correo_empresa]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validaEmail(value)){
                return 'El correo de la empresa '+value+' es invalido';
            }
        }

        if($(el).is('[name=cedula_representante]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validateCedula(value)){
                return 'La cedula del representante '+value+' es invalido';
            }

        }

        if($(el).is('[name=nombre_representante]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validateStringLength(value,5)){
                return 'El nombre del representante debe tener mas de 5 caracteres';
            }
            
            if(!validString(value)){
                return 'El nombre del representante '+value+' es invalido';
            }

        }

        if($(el).is('[name=telefono_representante]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validaTelefono(value)){
                return 'El telefono del representante '+value+' es invalido';
            }

        }

    }
    return validatorServerSide
}