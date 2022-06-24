
$(document).ready(function() {

    $("#morefilelink").click(function() {
        $("#morefiles").show("fast");
        $("#morefilelink").hide("fast");
    });

    for(c = 1; c < 6; c++) {
        en = '#riskref' + c;
        $(en).click(function() {
            eb = $(this).attr('value');
            $(eb).show();
            $(this).hide();
        });
        en = '#hazref' + c;
        $(en).click(function() {
            eb = $(this).attr('value');
            $(eb).show();
            $(this).hide();
        });
    }

    $("#coshhform").validate();
});

