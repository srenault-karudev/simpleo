$(document).ready(function () {

    $('button[name="state[id]"]').click(

        function () {

            var devisId =  $(this).attr('value');
            console.log(devisId);

            var state = prompt('Pour modifier l\'état de la facture, \n ' +
                'veuillez renseigner le numéro associé a un état : \n' +
                '  1 : validé \n ' +
                ' 2 : en attente \n ' +
                ' 3 : refusé',
                "exemple : 1");

            console.log(state);

            if (state != '1' && state != '2' && state != '3') {
                alert('Attention le numero associé a un état est incorrect.');
            }
            else {

                $.ajax({
                    url: Routing.generate(
                        'indexDevisAjaxAction',
                        {
                            'devisId': devisId,
                            "state": state
                        }),
                    type: 'GET',
                    dataType: 'json'

                }).success(function (data) {
                    console.log("envoyé")
                });

            }

            window.location = Routing.generate('index_devis');

            console.log(devisId);
            console.log(etat);
        }
    );

});