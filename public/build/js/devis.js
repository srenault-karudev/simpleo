window.onload= function() {

    $('.action_button').click( function(){
        var tmp=new Array();
        var $article=$("#devis_action_article").val();
        var $record=$("#devis_action_record").val();
        var $recordTexte=$("#devis_action_record option:selected").text();
        var $qtte=$("#devis_action_qtte").val();
        var $prixHT=$("#devis_action_prixHT").val();
        var $tauxTVA=$("#devis_action_tauxTVA").val();
        var $remise=$("#devis_action_remise").val();
        var $montantTTC=$("#devis_action_montantTTC").val();

        tmp.push($article, $recordTexte, $qtte, $prixHT, $tauxTVA, $remise, $montantTTC, $record);

        if(validationAction()){
            setData(tmp);
            devisIsNotNull(tmp);
        }
    });


    $('.confirmation_devis_action_button').click( function(){
        var actions=new Array();
        var tabFinal = new Array();

        var $client=$("#devis_client").val();
        var $dateCreation=$("#devis_dateCreation").val();
        var $dateExpiration=$("#devis_dateExpiration").val();
        var $reference=$("#devis_reference").val();

        tabFinal.push($client, $dateCreation, $dateExpiration, $reference);


        $('.table-right tbody > tr').each(function(){
            $ligne=new Array();
            $ligne.push($(this).find(".article").html());
            $ligne.push($(this).find(".typeProduit").html());
            $ligne.push($(this).find(".quantite").html());
            $ligne.push($(this).find(".prixHT").html());
            $ligne.push($(this).find(".tauxTVA").html());
            $ligne.push($(this).find(".remise").html());
            $ligne.push($(this).find(".montantTTC").html());
            actions.push($ligne);

        });

        tabFinal.push(actions);
        console.log(actions);
        console.log(tabFinal);

        if(validation() && devisIsNotNull(tabFinal)){
            console.log("OK");

            $.ajax({

                url: Routing.generate(
                    'ajaxDevis',
                    {

                        'data': tabFinal
                    }),
                type: 'GET',
                dataType: 'json',
            }).success(function (data) {
                window.location = Routing.generate('index_devis');
            });

        }

    });

    $("#devis_action_qtte").change(function () {
        changeAllValue();
    });
    $("#devis_action_prixHT").change(function () {
        changeAllValue();
    });
    $("#devis_action_tauxTVA").change(function () {
        changeAllValue();
    });
    $("#devis_action_remise").change(function () {
        changeAllValue();
    });

    function testIsNotANumber($var) {
        if (isNaN($var) == true) {
            return true;
        } else {
            return false;
        }
    }

    function changeAllValue() {
        var $e = $("#erreur_form_2");
        var $tauxTVA=$("#devis_action_tauxTVA").val();
        var $qtte=$("#devis_action_qtte").val();
        var $prixHT=$("#devis_action_prixHT").val();
        var $remise=$("#devis_action_remise").val();
        var $test = testIsNotANumber($tauxTVA);
        var $test2 = testIsNotANumber($qtte);
        var $test3 = testIsNotANumber($prixHT);
        var $test4 = testIsNotANumber($remise);
        if (($test == true) || ($test2 == true) || ($test3 == true) || ($test4 == true) ){
            $e.text("Un des champs contient une erreur. Veuillez vérifier.").show();
        } else if (($tauxTVA < 0) || ($qtte < 0) || ($prixHT < 0) || ($remise < 0)){
            $test = true;
            $test2 = true;
            $test3 = true;
            $test4 = true;
            $e.text("Veuillez entrer des valeurs positives.").show();
        } else {
            $e.hide();
        }
        if (($tauxTVA != '') && ($qtte != '') && ($prixHT != '') && ($test == false) && ($test2 == false) && ($test3 == false) && ($test4 == false)) {
            $myres = $qtte * $prixHT;
            $myres2 = $myres + $myres*($tauxTVA / 100);
            $myres3 = $myres2 - $myres2*($remise/100);
            $("#devis_action_montantTTC").val($myres3.toFixed(2));
        }
    }


    function setData(tmp){
        var tr = document.createElement("tr");
        tr.innerHTML = "<td class='article'>"+tmp['0']+"</td>"
            +"<td style='display: none' class='typeProduit'>"+tmp['7']+"</td>"
            +"<td class='typeProduitTexte'>"+tmp['1']+"</td>"
            +"<td class='quantite'>"+tmp['2']+"</td>"
            +"<td class='prixHT'>"+tmp['3']+"</td>"
            +"<td class='tauxTVA'>"+tmp['4']+"</td>"
            +"<td class='remise'>"+tmp['5']+"</td>"
            +"<td class='montantTTC'>"+tmp['6']+"</td>"
            +"<td id='delete'>X</td>";
        document
            .querySelector("#RecapDevis tbody")
            .appendChild(tr);
        $(".form2").trigger("reset"); //efface les données du formulaire après validation

    }



    document
        .querySelector("#RecapDevis tbody")
        .onclick=function(ev) {
            if (window.confirm("Voulez vous vraiment supprimer ce produit ?"))
            this.removeChild(ev
                .target
                .parentNode
                );
        };



    function validation(){
        var $erreur = $("#erreur_form1");

        var $client=$("#devis_client option:selected").val();
        var $dateCreation=$("#devis_dateCreation").val();
        var $dateExpiration=$("#devis_dateExpiration").val();
        var $reference=$("#devis_reference").val();


        if(($client=='') || ($dateCreation=='') || ($dateExpiration == '') || ($reference=='')){
            $erreur.text("/!\\ Erreur : Nous rappelons que tous les champs sont obligatoires").show();
            return false
        }

        else{
            $erreur.hide();
            return true
        }

    }

    function validationAction(){
        var $erreur = $("#erreur_form2");

        var $article=$("#devis_action_article").val();
        var $record=$("#devis_action_record").val();
        var $qtte=$("#devis_action_qtte").val();
        var $prixHT=$("#devis_action_prixHT").val();
        var $tauxTVA=$("#devis_action_tauxTVA").val();
        var $remise=$("#devis_action_remise").val();
        var $montantTTC=$("#devis_action_montantTTC").val();

        if(($article=='') || ($record=='') || ($qtte=='') || ($prixHT=='') ||($tauxTVA=='') || ($remise=='') || ($montantTTC=='')){
            $erreur.text("/!\\ Erreur : Nous rappelons que tous les champs sont obligatoires").show();
            return false
        }
        else if (($qtte<0) || ($prixHT<0) || ($tauxTVA<0) || ($remise<0) || ($montantTTC<0)) {
            $erreur.text("/!\\ Erreur : Les valeurs négatives ne sont pas autorisées.").show();
            return false
        }
        else{
            $erreur.hide();
            return true
        }

    }

    function devisIsNotNull(tab){
        var $erreur = $("#erreur_form_null");

        if(tab.length==0){
            $erreur.text("/!\\ Erreur : Aucun produit n\'a été ajouté").show();
            return false
        }
        else if(tab[4].length==0){
            $erreur.text("/!\\ Erreur : Aucun produit n\'a été ajouté").show();
            return false
        }
        else{
            $erreur.hide();
            return true
        }

    }

};

$('.generation_pdf').click( function(){
    console.log("test");
});


/* function clique(ev){
    if (window.confirm("Voulez vous vraiment supprimer ce produit ?"))
        this.removeChild(ev
            .target
            .parentNode
        );
};

onclick='clique(this)' */


