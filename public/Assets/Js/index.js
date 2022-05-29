$(document).ready(function () {
    $('#btn-update').click(function () { 
        var name = $('#name').val();
        var phone = $('#phone').val();
        var gender = $('#gender').val();
        var birth = $('#birth').val();

        if (name == "" || phone == "" || gender == "" || birth == "")
        {
            // Show error massage
            swal("Cảnh báo!", "Không thể để trống các ô!", "error");
            return;
        }

        $.post('./api/updateProfile', {
            name: name,
            phone: phone,
            gender: gender,
            birth: birth
        }, function (data) {
            data = JSON.parse(data);
            // Check if login success
            if (data.status == 'success') {
                // swal susccess message
                swal("Thông báo!", data.message, "success");
            } else {
                // Show error message
                swal("Cảnh báo!", data.message, "error");
            }
        });

    });
    
});