$(document).ready(function () {


    $('input[type=checkbox][name="paiment[id]"]').change(
        function () {
            var idInvoice = $(this).attr('value');
            var etat = $(this).prop('checked');
            var date = new Date();
            // date = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear()

            if (etat == true) {

                //alert("En cochant cette case, vous confirmez avoir payé la facutre " + idInvoice + '.')      ;
                var numRecord = prompt('Pour confirmer le paiement de la facture, \n' +
                    'veuillez renseigner le  numéro du registre de paiement : \n' +
                    '  455 : Associés - Comptes courants \n ' +
                    ' 512 : Banque \n ' +
                    ' 53 : caisse',
                    "exemple : 53");

                console.log(numRecord);

                if (numRecord != '455' && numRecord != '512' && numRecord != '53') {
                    alert('Attention le numero de registre de paiement est incorrect')
                    etat = false;

                } else {

                    $.ajax({
                        url: Routing.generate(
                            'indexAjaxAction',
                            {
                                'invoiceId': idInvoice,
                                "etat": etat,
                                "numRecord": numRecord
                            }),
                        type: 'GET',
                        dataType: 'json'

                    }).success(function (data) {
                        console.log("envoyé")
                    });


                }
                window.location = Routing.generate('index_journal_facture_achat');

                console.log(idInvoice);
                console.log(etat);

            }


        });


});