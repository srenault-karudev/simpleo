function automatOne() {
    var $e = $("#erreur_form_number_one");
    var $b = $("#erreur_form_number_two");
    var $mytva=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
    let $myqtt=$("#action_buy_quantity").val();
    let $my_action_buy_unit_amount=$("#action_buy_unit_amount").val();
    console.log($mytva);
    console.log($myqtt);
    console.log($my_action_buy_unit_amount);
    var $test=testIsNotANumber($my_action_buy_unit_amount);
    if($test==true){
        $e.text("attention ce n'est pas un nombre").show();
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
    var $b = $("#erreur_form_number_two");
    var $mytvatwo=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
    let $myqtttwo=$("#action_buy_quantity").val();
    let $my_action_buy_tva_amount_two= $("#action_buy_tva_amount").val();
    console.log($mytvatwo);
    console.log($myqtttwo);
    console.log($my_action_buy_tva_amount_two);
    var $test=testIsNotANumber($my_action_buy_tva_amount_two);
    if($test==true){
        $b.text("attention ce n'est pas un nombre").show();
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
    $registre=$('input[type=radio][name="action_buy[record_id]"]:checked').attr('value');
    $tva=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
    if(($registre==undefined) || ($tva==undefined) || ($qtt=='') || ($action_buy_unit_amount=='') ||($action_buy_tva_amount=='') || (testIsNotANumber($action_buy_unit_amount)) || (testIsNotANumber($action_buy_tva_amount))){
        $b.text("! ERREUR, Nous rappelons que tous les champs sont obligatoires").show();
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
    $registre=$('input[type=radio][name="action_buy[record_id]"]:checked').attr('value');
    $tva=$('input[type=radio][name="action_buy[tva]"]:checked').attr('value');
    var data=new Array();
    data.push($registre);
    data.push($tva);
    data.push($qtt);
    data.push($action_buy_unit_amount);
    data.push($action_buy_tva_amount);
    console.log(data);
    if(validation()){
        var path ="{{ path('ajaxInvoiceBuyRoute') }}";
        $.ajax({
            url:path,
            type: "POST",
            dataType: "json",
            data: {
                data
            },
            async: true,
            success: function ()
            {
                console.log("success")
            }
        })
    }
});