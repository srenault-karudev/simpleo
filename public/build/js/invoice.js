window.onload=(()=>{

    $paiement= $('#invoice_buy_record_id option:selected').val();
    console.log($paiement);

    function automatOne() {
        var $e = $("#erreur_form_number_one");
        var $b = $("#erreur_form_number_two");
        var $mytva=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        let $myqtt=$("#action_buy_quantity").val();
        let $my_action_buy_unit_amount=$("#action_buy_unit_amount").val();
        var $test=testIsNotANumber($my_action_buy_unit_amount);
        if($test==true){
            $e.text("attention ce n'est pas un nombre").show();
        }else if( $my_action_buy_unit_amount < 0){
            $test=true;
            $e.text("attention la valeur doit être supérieur à 0").show();
        }else{
            $e.hide();
            $b.hide();
        }
        if(($mytva!=undefined) && ($myqtt!='') && ($my_action_buy_unit_amount!='') && ($test==false)){
            $myres=$myqtt*$my_action_buy_unit_amount*$mytva/100;
            $("#action_buy_tva_amount").val($myres.toFixed(2));
        }
    }

    function automatTwo() {
        var $e = $("#erreur_form_number_one");
        var $b = $("#erreur_form_number_two ");
        var $mytvatwo=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        let $myqtttwo=$("#action_buy_quantity").val();
        let $my_action_buy_tva_amount_two= $("#action_buy_tva_amount").val();
        var $test=testIsNotANumber($my_action_buy_tva_amount_two);
        if($test==true){
            $b.text("attention ce n'est pas un nombre").show();
        }else if($my_action_buy_tva_amount_two<0){
            $test=true;
            $b.text("attention la valeur doit être supérieur à 0").show();
        }else{
            $e.hide();
            $b.hide();
        }
        if(($mytvatwo!=undefined) && ($myqtttwo!='') && ($my_action_buy_tva_amount_two!='') && ($test==false)){
            var $myrestwo=$my_action_buy_tva_amount_two/$myqtttwo*$mytvatwo;
            $("#action_buy_unit_amount").val($myrestwo.toFixed(2));
        }
    }


    function testIsNotANumber($var){
        if(isNaN($var ) == true){
            return true;
        }else{
            return false;
        }
    }

    function changeAllValue() {
        automatOne();
    }


    $("#action_buy_quantity").change(function() {
        changeAllValue();
    });

    $('input[type=radio][name="action_buy[tva]"]').change(function() {
        changeAllValue();
    });

    $("#action_buy_unit_amount").keyup(function() {
        var $t = $(this);
        if (!$t.val()) {
        } else {
            automatOne();
        }
    }).keyup();


    $("#action_buy_tva_amount").keyup(function() {
        var $t = $(this);
        if (!$t.val()) {
        } else {
            automatTwo()
        }
    }).keyup();

    function validation(){
        var $b = $("#erreur_form");
        $qtt=$("#action_buy_quantity").val();
        $action_buy_unit_amount=$("#action_buy_unit_amount").val();
        $action_buy_tva_amount=$("#action_buy_tva_amount").val();
        $registre=$('#recordsId').val();
        $tva=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        if(($registre==undefined) || ($tva==undefined) || ($qtt=='') || ($action_buy_unit_amount=='') || ($action_buy_tva_amount=='') || (testIsNotANumber($action_buy_unit_amount)) || (testIsNotANumber($action_buy_tva_amount)) || ($action_buy_tva_amount<0) || ($action_buy_unit_amount<0) ){
            $b.text("! ERREUR DANS LE FORMULAIRE, Nous rappelons que tous les champs sont obligatoires").show();
            return false
        }else{
            $b.hide();
            return true
        }

    }


    $('.confirmation_action_button').click( function(){
        $qtt=$("#action_buy_quantity").val();
        $action_buy_unit_amount=$("#action_buy_unit_amount").val();
        $action_buy_tva_amount=$("#action_buy_tva_amount").val();
        $registre=$('#recordsId').val();
        $tva=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
        var data=new Array();
        data.push($registre);
        data.push($tva);
        data.push($qtt);
        data.push($action_buy_tva_amount);
        data.push($action_buy_unit_amount);
        console.log(data);
        if(validation()){
            setDataRight(data);
        }
    });



    function setDataRight(data){
        var tr = document.createElement("tr");
        tr.innerHTML = "<td class='registre'>"+data['0']+"</td>"
            +"<td class='taux-tva'>"+data['1']+"</td>"
            +"<td class='qtt-achat'>"+data['2']+"</td>"
            +"<td class='mont-tva'>"+data['3']+"</td>"
            +"<td class='mont-unit'>"+data['4']+"</td>"
            +"<td id='delete'>&#10060</td>";
        document
            .querySelector(".table-right tbody")
            .appendChild(tr);
        $(".form-horizontal").trigger("reset"); //efface les  données dans le formulaire après validation
    }

    window
        .document
        .querySelector(".table-right tbody")
        .onclick= function(ev) {
        if (window.confirm("Etes vous sur de supprimer cette dépense ?"))
            this.removeChild(ev
                .target
                .parentNode
            );
    };




    $('.confirmation_Def_action_button').click( function(){
        var actions=new Array();
        $('.table-right tbody > tr').each(function(){
            $ligne=new Array();
           $ligne.push($(this).find(".registre").html());
           $ligne.push($(this).find(".taux-tva").html());
           $ligne.push($(this).find(".qtt-achat").html());
           $ligne.push($(this).find(".mont-tva").html());
           $ligne.push($(this).find(".mont-unit").html());
           actions.push($ligne);
        });
        $paiement=$('#invoice_buy_record_id option:selected').val();

        $client=$('input[type=radio][name="invoice_buy[person_id]"]:checked').attr('value');
        $date=$('#invoice_buy_invoice_date').val();
        var data2=new Array();
        data2.push(actions);
        data2.push($paiement);
        data2.push($client);
        data2.push($date);
        console.log(data2);

        if (validation2(data2)){
            console.log("ok");
        }

    });


    function validation2(data){
        var $b = $("#erreur_form_two");
        if((data[2]==undefined) || (data[3]=="")){
            $b.text("Nous rappelons que tous les champs sont obligatoires").show();
            return false
        }else if(data[0].length==0){
            $b.text("Attention vous n'avez entré aucun achats").show();
            return false
        }else{
            return true;
        }

    }

});

