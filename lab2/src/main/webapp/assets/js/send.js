$(document).ready(function () { // wait until loading of document
    // get table init
    $.get({
        url: "app",
        data: { init: true },
    })

    // checkboxes
    initInputs();

    $("#time-offset").val(-(new Date().getTimezoneOffset())); // set user's date-time

    loadFormData();

    let saved = false;
    $("#point-form").submit(function (event) {
        if (saved) {
            return;
        }
        event.preventDefault();
        saveFormData();
        saved = true;

        $(this).submit();
    });
});

function showTable(response) {
    $("#response-table").html(response);
}

function initInputs() {
    $("input[type=number]").on("input", function() {
        var maxLength = parseInt($(this).attr("maxlength"));
        var currentValue = $(this).val();

        if (currentValue.length > maxLength) {
            $(this).val(currentValue.slice(0, maxLength)); // Limit to maxLength characters
        }
    });

    $(".r-checkbox").click(function (event){
        $(".r-checkbox").prop('checked', false);;
        $(this).prop('checked', true);;
    })
    $(".x-checkbox").click(function (event){
        $(".x-checkbox").prop('checked', false);;
        $(this).prop('checked', true);;
    })

    $(".r-checkbox")[0].click()
    $(".x-checkbox")[0].click()
}

function saveFormData() {
    const formData = {};
    // Loop through form elements and save their values
    for (const element of $("#point-form")[0].elements) {
        if (element.type != "checkbox") {
            formData[element.name] = element.value;
        }
    }

    // Save the formData object as a JSON string in local storage
    localStorage.setItem("formData", JSON.stringify(formData));
}
function loadFormData() {
    const savedData = localStorage.getItem("formData");
    if (savedData) {
        const parsedData = JSON.parse(savedData);
        for (const element of $("#point-form")[0].elements) {
            if (element.name && parsedData[element.name]) {
                element.value = parsedData[element.name];
            }
        }
        redraw();
    }
}