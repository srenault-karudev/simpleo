$(document).ready(function() {

    $('form').submit(function(e){
        var startDate = $('#company_startDateSocialYear').val();
        var endDate = $('#company_endDateSocialYear').val();


        if(startDate > endDate){
            alert('La date du début de votre exercice social doit être inférieur à celle de la date de fin.');
        }

        if(startDate == endDate){
            alert('La date du début de votre exercice social ne doit pas être idientique à celle de la date de fin.');
        }
    });

});