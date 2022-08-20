$(function(){
    const columnData = [
        {"data":"id_rol"},
        {"data":"nombre_rol"},
        {"data":"descripcion"},
        {"data":"estado"},
        {"data":"opciones"}]

    const tableRoles =  configDataTables('.tableRol',base_url+"roles/getRoles",columnData)

    const listCamps =  ["#id_rol","#nombre_rol","#descripcion"];
    
    
    const fieldsToValidate = ['nombre_rol','descripcion']
    const configValid = configToValidate()

    clickModal("#modalRol","Crear | Rol","#fntRol");
    sendingDataServerSide('#fntRol',configValid,fieldsToValidate,listCamps,tableRoles,"roles/setRol","#modalRol");
})





function configToValidate(){

    const validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=nombre_rol]')){
            let value= $(el).val()
            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }

            if (!validString(value)){
                return 'El nombre '+value+' contiene numeros o caracteres especiales';
            }
            
        }
        
        if($(el).is('[name=descripcion]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'Este campo es obligatorio';
            }


            if (!validateStringLength(value,20)){
                return 'La descripcion '+value+' debe ser mas larga';
            }

            
            if (!validString(value)){
                return 'La descripcion '+value+' contiene numeros o caracteres especiales';
            }
            
        }
        
    }

    return validatorServerSide
}


