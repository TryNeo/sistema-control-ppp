const regex_string = '^[a-zA-ZáéíóñÁÉÍÓÚÑ ]+$';
const regex_numbers = '^[0-9]+$';
const regex_fechas = new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
const regex_username_password = '^[a-zA-Z0-9_-]{4,18}$';
const regex_email = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
const regex_image = '[^\\s]+(.*?)\\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$';
const regex_telefono='^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$';
const regex_hora = /^(0?[1-9]|1[0-2]):([0-5]\d)\s?((?:A|P)\.?M\.?)$/i;


function validateUser(value){
    if(value.match(regex_username_password) === null){
        return false;
    }
    return true;
}


function validString(value){
    if (value.match(regex_string) === null){
        return false;
    }
    return true;
}

function validateStringLength(value,MaxStringlength){
    if(value.length >= MaxStringlength){
        return true;
    }
    return false;
}


function validateEmptyField(value){
    if(value === ""){
        return false;
    }
    return true;
}

function validateImage(value){
    if (value.match(regex_image) === null){
        return false;
    }
    return true;
}

function validateFecha(value){
    if (value.match(regex_fechas) === null){
        return false;
    }
    return true;
}

function validateHora(value){
    if (value.match(regex_hora) === null){
        return false;
    }
    return true;
}

function validaNumber(value){
    if (value.match(regex_numbers) === null){
        return false;
    }
    return true;
}


function validaEmail(value){
    if (value.match(regex_email) === null){
        return false;
    }
    return true;
}

function validaTelefono(value){
    if (value.match(regex_telefono) === null){
        return false;
    }
    return true;
}




/**
 * Funcion validateCedula - valida que la cedula ingresa sea valida.
 * @param  {string} cedula -recibe  un string con una cantidad de numeros de 10 digitos
 * @return {boolean} - retornara true o false , si algo esta correcto o incorrecto . 
 */
function validateCedula(cedula){
    const validRegEx = /[0-9]{0,10}/;
    if (cedula.match(validRegEx) === null){
        return false;
    }else{
        let validado = [...cedula].map( x => x == 0 ? 0 : (parseInt(x) || x));
        let ultimo_numero = parseInt(validado.splice(9,1));
        let cedula_impar = validado.filter((x,c)=> {if (c%2==1){return validado[c]}});
        let cedula_pares = validado.filter((x,c)=> {if (c%2==0){return validado[c]}}).map((x)=>x+=x);

        let totales = cedula_pares.filter(
            (x,c) => {if (cedula_pares[c] <= 9){return cedula_pares[c]
            }}).concat(cedula_pares.filter((x,c) => {if (cedula_pares[c] >= 9){ 
                return cedula_pares[c]
                }
            }
            ).map(x => x-9))

        let total_a = totales.reduce((acum,total)=> acum+total)+cedula_impar.reduce((acum,total)=> acum+total);
    
        let total = (parseInt(String(total_a).charAt(0))+1)*10
        if (total == 10){
            total = 0
        }

        if((total - (total_a)) == ultimo_numero  ){
            return true
        }else{
            return false
        }
    
    }
}
