window.onload = (() => {


    $('.selectchoice').change(
        function () {
            var valeur  =  $(this).val();
            console.log(valeur);
            if(valeur == '1'){
                $('.affiche').show();
            }
            else{
                $('.affiche').hide();
            }

        });

});