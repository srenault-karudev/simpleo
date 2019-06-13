$(document).ready(function () {

    $('button[name="state[id]"]').click(

        function () {

            var devisId =  $(this).attr('value');
            console.log(devisId);

            var state = prompt('Pour modifier l\'état de la facture, \n ' +
                'veuillez renseigner le numéro qui correspond à un des états suivants : \n' +
                '  1 : Validé \n ' +
                ' 2 : En attente \n ' +
                ' 3 : Refusé',
                "Exemple : 1");

            console.log(state);

            if (state != '1' && state != '2' && state != '3') {
                alert('Attention, le numéro entré ne correspond à aucun état.');
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