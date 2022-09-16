
$(function(){
    
    const fieldsToValidate = ['email','password']

    let validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=email]')){
            let value= $(el).val()

                        
            if (!validateEmptyField(value)){
                return 'El campo email es obligatorio';
            }


            if (!validaEmail(value)){
                return 'El email '+value +' ingresado no es apto';
            }
        }

        if($(el).is('[name=password]')){
            let value= $(el).val()

            if (!validateEmptyField(value)){
                return 'El campo contraseña es obligatorio';
            }

            if (!validateUser(value)){
                return 'La contraseña ingresada no es apto';
            }
        }
    }

    $('#remember-me').on('change', function(){
        $('#remember-me').removeClass('is-valid');
        this.value = this.checked ? 1 : 0;}).change();
    sendingDataServerSideLogin('#fntLogin',validatorServerSide,fieldsToValidate);
});


function sendingDataServerSideLogin(idForm,validatorServerSide,fieldsToValidate){
    let url = $(idForm).attr("action");
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
                url: url,
                type: $(idForm).attr("method"),
                data: formData,
                dataType: 'json'
            }).done(function (data) {
                if(data.status){
                    setTimeout(function(){
                        $.LoadingOverlay("hide");
                        mensaje('success','Exitoso',data.msg);
                        window.location = data.url;
                    }, 4000);
                }else{
                    if (!jQuery.isEmptyObject(data.formErrors)){
                        fieldsToValidate.forEach((value,index) => {
                            if (data.formErrors.hasOwnProperty(fieldsToValidate[index])){
                                validatorServerSide.errorTrigger($('[name='+fieldsToValidate[index]+']'), data.formErrors[''+fieldsToValidate[index]+'']);
                            }
                        });
                    }else{
                        $.LoadingOverlay("hide");
                        mensaje("error","Error",data.msg);
                    }
    
                }
            }).fail(function (error) {
                console.log(error)
                $.LoadingOverlay("hide");
                mensaje("error","Error",'Hubo problemas con el servidor, intentelo nuevamente')
            })
        }else{
            $.LoadingOverlay("hide");
            console.log("error")
        }
    })
}
