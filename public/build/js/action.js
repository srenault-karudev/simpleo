


$(document).ready(function () {
    $(document).on('click', "#search", function () {
        $.ajax({

            url: Routing.generate(
                'new_invoice_buy', {}),
            type: "GET",
            dataType: "json",
            data: {
                "value": 'toto'
            },
        }).success(function (data) {
            console.log(data);
        });
    });
});