window.onload = (() => {



    $('#record_paiement').hide();



    $('input[type=radio][name="invoice_buy[paid]"]').change(
        function () {
            var valeur  =  $(this).attr('value');

            if(valeur == 'oui'){
                $('#record_paiement').show();
            }
            else if (valeur == 'non' || valeur == undefined){
                $('#record_paiement').hide();
            }

        });

    // $('input[type=radio][name="invoice_buy[paid]"]').trigger("change");



    function automatOne() {
        var $e = $("#erreur_form_number_one");
        var $b = $("#erreur_form_number_two");
        var $mytva = $('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        let $myqtt = $("#action_buy_quantity").val();
        let $my_action_buy_unit_amount = $("#action_buy_unit_amount").val();
        var $test = testIsNotANumber($my_action_buy_unit_amount);
        if ($test == true) {
            $e.text("Attention, ce n'est pas un nombre.").show();
        } else if ($my_action_buy_unit_amount < 0) {
            $test = true;
            $e.text("Attention, la valeur doit être supérieure à 0.").show();
        } else {
            $e.hide();
            $b.hide();
        }
        if (($mytva != undefined) && ($myqtt != '') && ($my_action_buy_unit_amount != '') && ($test == false)) {
            $myres = $myqtt * $my_action_buy_unit_amount * $mytva / 100;
            $("#action_buy_tva_amount").val($myres.toFixed(2));
        }
    }

    function automatTwo() {
        var $e = $("#erreur_form_number_one");
        var $b = $("#erreur_form_number_two ");
        var $mytvatwo = $('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        let $myqtttwo = $("#action_buy_quantity").val();
        let $my_action_buy_tva_amount_two = $("#action_buy_tva_amount").val();
        var $test = testIsNotANumber($my_action_buy_tva_amount_two);
        if ($test == true) {
            $b.text("Attention, ce n'est pas un nombre.").show();
        } else if ($my_action_buy_tva_amount_two < 0) {
            $test = true;
            $b.text("Attention, la valeur doit être supérieure à 0.").show();
        } else {
            $e.hide();
            $b.hide();
        }
        if (($mytvatwo != undefined) && ($myqtttwo != '') && ($my_action_buy_tva_amount_two != '') && ($test == false)) {
            var $myrestwo = $my_action_buy_tva_amount_two / $myqtttwo * $mytvatwo;
            $("#action_buy_unit_amount").val($myrestwo.toFixed(2));
        }
    }


    function testIsNotANumber($var) {
        if (isNaN($var) == true) {
            return true;
        } else {
            return false;
        }
    }

    function changeAllValue() {
        automatOne();
    }


    $("#action_buy_quantity").change(function () {
        changeAllValue();
    });

    $('input[type=radio][name="action_buy[tva]"]').change(function () {
        changeAllValue();
    });

    $("#action_buy_unit_amount").keyup(function () {
        automatOne();
    }).keyup();


    $("#action_buy_tva_amount").keyup(function () {
        automatTwo()
    }).keyup();

    function validation() {
        var $b = $("#erreur_form");
        $qtt = $("#action_buy_quantity").val();
        $action_buy_unit_amount = $("#action_buy_unit_amount").val();
        $action_buy_tva_amount = $("#action_buy_tva_amount").val();
        $registre = $('input[type=radio][name="action_buy[record_id]"]:checked').attr('value');
        $tva = $('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        var article = $('#action_buy_article').val();


        if (($registre == undefined) || ($tva == undefined) || (article == '')||  ($qtt == '') || ($action_buy_unit_amount == '') || ($action_buy_tva_amount == '') || (testIsNotANumber($action_buy_unit_amount)) || (testIsNotANumber($action_buy_tva_amount)) || ($action_buy_tva_amount < 0) || ($action_buy_unit_amount < 0)) {

            $b.text("/!\\ Erreur dans le formulaire. Nous rappelons que tous les champs sont obligatoires").show();
            return false
        } else {
            $b.hide();
            return true
        }

    }


    $('.confirmation_action_button').click(function () {

        $registre = $('input[type=radio][name="action_buy[record_id]"]:checked').attr('value');
        //console.log('registre :' +$registre);
        $qtt = $("#action_buy_quantity").val();
        $action_buy_unit_amount = $("#action_buy_unit_amount").val();
        $action_buy_tva_amount = $("#action_buy_tva_amount").val();
        //$registre=$('#recordsId').val();
        $tva = $('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        var article = $('#action_buy_article').val();
        var data = new Array();
        data.push($registre);
        data.push($tva);
        data.push($qtt);
        data.push($action_buy_tva_amount);
        data.push($action_buy_unit_amount);
        data.push(article);
        console.log(data);
        if (validation()) {
            setDataRight(data);
        }
    });


    function setDataRight(data) {
        var tr = document.createElement("tr");
        tr.innerHTML = "<td class='registre'>" + data['0'] + "</td>"
            + "<td class='article'>" + data['5'] + "</td>"
            + "<td class='taux-tva'>" + data['1'] + "</td>"
            + "<td class='qtt-achat'>" + data['2'] + "</td>"
            + "<td class='mont-tva'>" + data['3'] + "</td>"
            + "<td class='mont-unit'>" + data['4'] + "</td>"
            + "<td id='delete'>&#10060</td>";
        document
            .querySelector(".table-right tbody")
            .appendChild(tr);
        $(".form-horizontal").trigger("reset"); //efface les  données dans le formulaire après validation
    }

    window
        .document
        .querySelector(".table-right tbody")
        .onclick = function (ev) {
        if (window.confirm("Êtes vous sûr(e) de supprimer cette dépense ?"))
            this.removeChild(ev
                .target
                .parentNode
            );
    };


    $('.confirmation_Def_action_button').click(function () {



       var etatPaiement =  $('input[type=radio][name="invoice_buy[paid]"]:checked').attr('value');

        var actions = new Array();
        $('.table-right tbody > tr').each(function () {
            $ligne = new Array();
            $ligne.push($(this).find(".registre").html());
            $ligne.push($(this).find(".article").html());
            $ligne.push($(this).find(".taux-tva").html());
            $ligne.push($(this).find(".qtt-achat").html());
            $ligne.push($(this).find(".mont-tva").html());
            $ligne.push($(this).find(".mont-unit").html());
            actions.push($ligne);
        });

        var date = new Date();
         date = date.getFullYear();


        $paiement = $('input[type=radio][name="invoice_buy[record_id]"]:checked').attr('value');
        $client = $('input[type=radio][name="invoice_buy[person_id]"]:checked').attr('value');
        $date = $('#invoice_buy_invoice_date').val();
        $file = $("#invoice_buy_imageFile").val();
        $etat =  $('input[type=radio][name="invoice_buy[paid]"]:checked').attr('value');

        var data2 = new Array();
        data2.push(actions);
        if(etatPaiement == 'oui'){
            data2.push($paiement);
        }else {
            data2.push("");
        }

        data2.push($client);
        data2.push($date);
        data2.push($file);
        data2.push($etat);

        console.log(data2);


        if (validation2(data2)) {

            console.log("ok");

            $.ajax({

                url: Routing.generate(
                    'ajaxInvoiceRouteBuy',
                    {

                        'data': data2
                    }),
                type: 'GET',
                dataType: 'json',
            }).success(function (data) {
                window.location = Routing.generate('index_journal_facture_achat');
            });

        }


    });


    function validation2(data) {
        var $b = $("#erreur_form_two");
        if ((data[2] == undefined) || (data[3] == "") || (data[6] == 'oui' && data[1] == undefined) ) {
            $b.text("Nous rappelons que tous les champs sont obligatoires.").show();
            return false
        } else if (data[0].length == 0) {
            $b.text("Attention, vous n'avez entré aucun achat").show();
            return false
        } else {
            $b.text("Nous rappelons que tous les champs sont obligatoires.").hide();
            return true;
        }

    }

    $('.tva_button').click(function () {
        var test = prompt("Nouvelle TVA", "");
        $num = parseInt(test, 10);
        if (test != null) {
            if (isNaN($num)) {
                alert("Attention, ce n'est pas un nombre.");
            } else {
                $('.asupprimer').remove();
                var radio = document.createElement("div");
                var lab = document.createElement("label");
                lab.setAttribute("for", "action_buy_tva_5");
                lab.className = "required";
                radio.className = "funkyradio-warning asupprimer";
                radio.innerHTML = "<input type='radio'  id='action_buy_tva_5' name='action_buy[tva]' required='required' value='" + $num + "'>";
                lab.innerHTML = "" + $num + "";
                document
                    .querySelector(".taux-tva-div")
                    .appendChild(radio)
                    .appendChild(lab);
            }
        }
    });


    $("#search").keyup(function () {
        var myvar = $("#search").val().toUpperCase();
        regexp = new RegExp(myvar, "g");
        $('.records .funkyradio-warning > label ').each(function () {
            if ($(this).text().toUpperCase().match(regexp)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }).keyup();

    $("#search-two").keyup(function () {
        var myvartwo = $("#search-two").val().toUpperCase();
        regexp = new RegExp(myvartwo, "g");
        $('.interlocutor .funkyradio-warning-2 > label ').each(function () {
            if ($(this).text().toUpperCase().match(regexp)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }).keyup();




});

