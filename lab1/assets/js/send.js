$(document).ready(function () { // wait until loading of document
    $.post({
        url: "php/hit-check.php",
        data: { init: true },
        success: showTable
    })

    // get table init
    $(".r-button").click(function (event){
        $(".r-button").removeClass("active");
        $(this).addClass("active");
        $("#r").val($(this).text());
    })

    // click first radius
    $(".r-button")[0].click()


    $("#point-form").submit(function (event) { // on sending form
        event.preventDefault(); // do not reload page

        // check radius > 0
        let r = $("#r")[0];
        if (r.value < 0) {
            r.value = 0;
            return;
        }

        $("#time-offset").val(-(new Date().getTimezoneOffset())); // set user's date-time

        formData = $(this).serialize(); // get form data for ajax

        console.log(formData);

        $.post({
            url: "php/hit-check.php",
            data: formData,
            success: showTable
        });
    });
});

function showTable(response) {
    $("#response").html(response);
}