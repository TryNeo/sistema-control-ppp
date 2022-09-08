$(function(){

    const fieldsToValidate = ['password','password_confirm']


    let validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",

    });

    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=password]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'El campo contraseña es obligatorio';
            }

            if (!validateUser(value)){
                return 'La contraseña ingresada no es apto';
            }
        }

        
        if($(el).is('[name=password_confirm]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'El campo contraseña es obligatorio';
            }

            if (!validateUser(value)){
                return 'La contraseña ingresada no es apto';
            }

        }
    }


    sendingDataServerSideResetpasword('#fntResetpassword',validatorServerSide,fieldsToValidate);

    setTimeout(function(){
        Swal.fire({
            icon: 'warning',
            title: "Error",
            text: 'El tiempo de espera para cambiar la contraseña ha expirado',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    }, 5 * 60 * 1000);
});


function sendingDataServerSideResetpasword(idForm,validatorServerSide,fieldsToValidate){
    if(data.status){
        let url = $(idForm).attr("action");
        $(idForm).on('submit',function (e) {
            e.preventDefault();
            let password = document.querySelector('#password').value;
            let password_confirm = document.querySelector('#password_confirm').value;
            if(password === password_confirm){
                if(validatorServerSide.checkAll('.needs-validation') === 0){
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: url,
                        type: $(idForm).attr("method"),
                        data: formData,
                        dataType: 'json'
                    }).done(function (data) {
                        if(data.status){
                            mensaje('success','Exitoso',data.msg);
                            setTimeout(function(){
                                $.LoadingOverlay("show");
                            },1000);
                            setTimeout(function(){
                                window.location = data.url;
                                document.getElementById("fntResetpassword").reset();
                            },5000);
                        }else{
                            if (!jQuery.isEmptyObject(data.formErrors)){
                                console.log(data.formErrors)
                                fieldsToValidate.forEach((value,index) => {
                                    if (data.formErrors.hasOwnProperty(fieldsToValidate[index])){
                                        validatorServerSide.errorTrigger($('[name='+fieldsToValidate[index]+']'), data.formErrors[''+fieldsToValidate[index]+'']);
                                    }
                                });
                            }else{
                                $("*", "#fntForgotpassword").prop('disabled',true);
                                mensaje("error","Error",data.msg);
                            }
                        }
                    }).fail(function (error) {
                        mensaje("error","Error",'Hubo problemas con el servidor, intentelo nuevamente')
                    })
                }else{
                    console.log("error")
                }
            }else{
                mensaje("error","Error",'Las contraseñas no coinciden, verifique que estén escritas bien');
            }
        })
    }else{
        Swal.fire({
            icon: 'warning',
            title: "Error",
            text: data.msg,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                $("*", "#fntForgotpassword").prop('disabled',true);
            }
        });

    }
}