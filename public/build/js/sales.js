window.onload=(()=>{




    function automatOne() {
        var $e = $("#erreur_form_number_one");
        var $b = $("#erreur_form_number_two");
        var $mytva=$('input[type=radio][name="action_sale[tva]"]:checked').attr('value');
        let $myqtt=$("#action_sale_quantity").val();
        let $my_action_sale_unit_amount=$("#action_sale_unit_amount").val();
        var $test=testIsNotANumber($my_action_sale_unit_amount);
        if($test==true){
            $e.text("attention ce n'est pas un nombre").show();
        }else if( $my_action_sale_unit_amount < 0){
            $test=true;
            $e.text("attention la valeur doit être supérieur à 0").show();
        }else{
            $e.hide();
            $b.hide();
        }
        if(($mytva!=undefined) && ($myqtt!='') && ($my_action_sale_unit_amount!='') && ($test==false)){
            $myres=$myqtt*$my_action_sale_unit_amount*$mytva/100;
            $("#action_sale_tva_amount").val($myres.toFixed(2));
        }
    }

    function automatTwo() {
        var $e = $("#erreur_form_number_one");
        var $b = $("#erreur_form_number_two ");
        var $mytvatwo=$('input[type=radio][name="action_sale[tva]"]:checked').attr('value');
        let $myqtttwo=$("#action_sale_quantity").val();
        let $my_action_sale_tva_amount_two= $("#action_sale_tva_amount").val();
        var $test=testIsNotANumber($my_action_sale_tva_amount_two);
        if($test==true){
            $b.text("attention ce n'est pas un nombre").show();
        }else if($my_action_sale_tva_amount_two<0){
            $test=true;
            $b.text("attention la valeur doit être supérieur à 0").show();
        }else{
            $e.hide();
            $b.hide();
        }
        if(($mytvatwo!=undefined) && ($myqtttwo!='') && ($my_action_sale_tva_amount_two!='') && ($test==false)){
            var $myrestwo=$my_action_sale_tva_amount_two/$myqtttwo*$mytvatwo;
            $("#action_sale_unit_amount").val($myrestwo.toFixed(2));
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


    $("#action_sale_quantity").change(function() {
        changeAllValue();
    });

    $('input[type=radio][name="action_sale[tva]"]').change(function() {
        changeAllValue();
    });

    $("#action_sale_unit_amount").keyup(function() {
        var $t = $(this);
        if (!$t.val()) {
        } else {
            automatOne();
        }
    }).keyup();


    $("#action_sale_tva_amount").keyup(function() {
        var $t = $(this);
        if (!$t.val()) {
        } else {
            automatTwo()
        }
    }).keyup();

    function validation(){
        var $b = $("#erreur_form");
        $qtt=$("#action_sale_quantity").val();
        $action_sale_unit_amount=$("#action_sale_unit_amount").val();
        $action_sale_tva_amount=$("#action_sale_tva_amount").val();
       // $registre=$('#action_sale_record_id option:selected').val();
       $registre=$('#tags').val();
        var reg =new RegExp("^6");
       console.log($registre.match(reg));


        $tva=$('input[type=radio][name="action_sale[tva]"]:checked').attr('value');
        if(($registre=="") || ($registre==undefined) || ($tva==undefined) || ($qtt=='') || ($action_sale_unit_amount=='') || ($action_sale_tva_amount=='') || (testIsNotANumber($action_sale_unit_amount)) || (testIsNotANumber($action_sale_tva_amount)) || ($action_sale_tva_amount<0) || ($action_sale_unit_amount<0) ){
            $b.text("! ERREUR DANS LE FORMULAIRE, Nous rappelons que tous les champs sont obligatoires").show();
            return false
        }else{
            $b.hide();
            return true
        }

    }


    $('.confirmation_action_button_sale').click( function(){

        $qtt=$("#action_sale_quantity").val();
        $action_sale_unit_amount=$("#action_sale_unit_amount").val();
        $action_sale_tva_amount=$("#action_sale_tva_amount").val();
        $registre=$('#action_sale_record_id option:selected').val();
        /// $registre=$('#recordsId').val();

        $tva=$('input[type=radio][name="action_sale[tva]"]:checked').attr('value');
        var data=new Array();
        data.push($registre);
        data.push($tva);
        data.push($qtt);
        data.push($action_sale_tva_amount);
        data.push($action_sale_unit_amount);
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
        if (window.confirm("Etes vous sur de supprimer cette vente ?"))
            this.removeChild(ev
                .target
                .parentNode
            );
    };




    $('.confirmation_Def_action_button_sale').click( function(){
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
        $client=$('input[type=radio][name="invoice_sale[person_id]"]:checked').attr('value');
        $date=$('#invoice_sale_invoice_date').val();
        var data2=new Array();
        data2.push(actions);
        data2.push($client);
        data2.push($date);
        console.log(data2);

        if (validation2(data2)){
            console.log("ok");

            $.ajax({

                url: Routing.generate(
                    'ajaxInvoiceRouteSale',
                    {

                        'data': data2
                    }),
                type : 'GET',
                dataType : 'json',
            }).success(function (data) {
                console.log(data);
                    window.location = Routing.generate('index_journal_facture_vente');
            });

        }

    });


    function validation2(data){
        var $b = $("#erreur_form_two");
        if((data[2]==undefined) || (data[1]==undefined)){
            $b.text("Nous rappelons que tous les champs sont obligatoires").show();
            return false
        }else if(data[0].length == 0){
            $b.text("Attention vous n'avez entré aucune ventes").show();
            return false
        }else{
            return true;
        }

    }


    $('.tva_button').click( function(){
        var person = prompt("Nouvelle TVA", "");
        $num=parseInt(person, 10);
        if (person != null) {
            if(isNaN($num)){
                alert("attention ce n'est pas un nombre");
            }else{
                $('.asupprimer').remove();
                var radio = document.createElement("div");
                var lab =document.createElement("label");
                lab.setAttribute("for", "action_sale_tva_5");
                lab.className="required";
                radio.className="funkyradio-warning asupprimer";
                radio.innerHTML = "<input type='radio'  id='action_sale_tva_5' name='action_sale[tva]' required='required' value='"+$num+"'>";
                lab.innerHTML=""+$num+"";
                document
                    .querySelector(".funkyradio")
                    .appendChild(radio)
                    .appendChild(lab);
            }
        }
    });
});

