$(document).ready(function () {


    $('input[type=checkbox][name="paiment[id]"]').change(
        function () {
            var idInvoice = $(this).attr('value');
            var etat = $(this).prop('checked');
            var date = new Date();
            // date = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear()

            if (etat == true) {

                alert("En cochant cette case, vous confirmez avoir payé la facutre " + idInvoice + '.')

            } else {
                alert("En décochant cette case, vous confirmez ne pas avoir payé la facutre " + idInvoice + ".")
            }

            $.ajax({
                url: Routing.generate(
                    'indexAjaxAction',
                    {
                        'invoiceId': idInvoice,
                        "etat": etat
                    }),
                type: 'GET',
                dataType: 'json'

            }).success(function (data) {
                console.log("envoyé")
            });

            console.log(idInvoice);
            console.log(etat);
        });


});