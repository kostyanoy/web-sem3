$(document).ready(function () {
    $("#point-form").submit(function (event) {
        event.preventDefault();

        let r = $("#r")[0];
        console.log(r);
        console.log(r.value);

        if (r.value < 0) {
            r.value = 0;
            return;
        }

        $("#time-offset").val(-(new Date().getTimezoneOffset()));

        console.log("HELP");
        let formData = $(this);
        formData[0]["timezoneOffsetMinutes"] = -(new Date().getTimezoneOffset());
        console.log(formData);
        formData = formData.serialize();

        console.log(formData);


        $.post({
            url: "php/hit-check.php",
            method: "POST",
            data: formData,
            success: function (response) {
                $("#response").html(response);
            }
        });

    });
});