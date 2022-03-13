$(document).ready(function () {
    $('.updateApplication').click(function () {
        let id = $(this).data('id');
        console.log(id);
        document.querySelector('.update_application_id').value = id;
        $.ajax({
            url: 'http://localhost:8000/api/application/' + id,
            type: "GET",
            success: function (data) {
                document.querySelector('.date_start_value').value = data['date_start'];
                document.querySelector('.date_finish_value').value = data['date_finish'];
                document.querySelector('.comment').value = data['comment'];
                console.log(data);
            }
        });
    });
    $('.refuse').click(function () {
        let id = $(this).data('id');
        document.querySelector('.refuse_app_id').value = id;
    });
    $('.confirm').click(function () {
        let id = $(this).data('id');
        document.querySelector('.confirm_app_id').value = id;
    });
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
});

