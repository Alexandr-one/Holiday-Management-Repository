$('.updatePost').click(function () {
    let id = $(this).data('id');
    console.log(id);
    document.querySelector('.change_id').value = id;
});
$('.updateStatus').click(function () {
    let id = $(this).data('id');
    document.querySelector('.status_id').value = id;
});
$('.blockUser').click(function () {
    let id = $(this).data('id');
    document.querySelector('.user_block_id').value = id;
});
$('.confirmUpdating').click(function () {
    let id = $(this).data('id');
    //document.querySelector('.post_id_udpate').value = id;
    $.ajax({
        url: 'http://localhost:8000/api/admin/users/' + id,
        type: "GET",
        success: function (data) {
            document.querySelector('.post_id_update').value = data['id'];
            document.querySelector('.name').value = data['name'];
            document.querySelector('.name_parent_case').value = data['name_parent_case'];
            console.log(data);
        }
    });
});


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
