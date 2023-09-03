$(document).ready(function () { // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Select/Deselect checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function () {
        if (this.checked) {
            checkbox.each(function () {
                this.checked = true;
            });
        } else {
            checkbox.each(function () {
                this.checked = false;
            });
        }
    });
    checkbox.click(function () {
        if (!this.checked) {
            $("#selectAll").prop("checked", false);
        }
    });

    const errorMessage = $("#error-message");

    if (errorMessage.length > 0) {
        setTimeout(function () {
            errorMessage.fadeOut("slow");
        }, 5000);
    }
});

const fetchDataById = (id) => {
    $.ajax({
        url: `/show/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#nameUpd').val(data.nombres);
            $('#surnameUpd').val(data.apellidos);
            $('#yoUpd').val(data.edad);
            $('#commentsUpd').val(data.comentarios);

            const fullDate = data.fecha_ingreso;
            const splitDate = fullDate.split(' ');
            const date = splitDate[0];
            console.log(date);
            $('#dateUpd').val(date);

            $('#updateForm').attr('action', `/update/${data.id}`);

        },
        error: function (xhr, status, error) {
            console.log('xhr', xhr, 'status', status, 'error', error);
        }
    });
}

const deleteDataById = (id) => {
    $('#deleteForm').attr('action', `/delete/${id}`);
}