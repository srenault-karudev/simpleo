$(document).ready(function() {

    $('form').submit(function(e){
        var password = $('#fos_user_registration_form_plainPassword_first').val();
        var lenght = password.length;


        if(lenght < 8){
            alert('Votre mot de passe doit contenir au moins 8 chiffres');
        }


    });

});