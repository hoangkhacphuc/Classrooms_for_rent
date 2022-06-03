$(document).ready(function () {
    $(document).on('click', '#btn-remove-account', function () {
        let id = $(this).attr('data-id');

        swal({
            title: "Bạn chắc chắn chứ?",
            text: "Khi xóa tài khoản, thông tin phòng tài khoản này đã thuê sẽ bị xóa!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $.post("./admin/api/deleteUser", {
                    id: id,
                }, function (data) {
                    data = JSON.parse(data);
                    if (data.status == "success") {
                        swal("Thông báo!", data.message, "success");
                        $('#row_'+id).remove();
                    } else {
                        swal("Cảnh báo!", data.message, "error");
                    }
                });
            } else {
              return;
            }
          });
    });

    $(document).on('click', '#createAccountSubmit', function () {
        // Get values 
        let username = $('#createAccountUsername').val();
        let password = $('#createAccountPassword').val();
        let repassword = $('#createAccountRePassword').val();
        let name = $('#createAccountName').val();
        let birthday = $('#createAccountBirthday').val();
        let phone = $('#createAccountPhone').val();
        let role = $('#createAccountRole').val();
        let gender = $('#createAccountGender').val();

        

        // post to api
        $.post('./admin/api/register', {
            username: username,
            password: password,
            repassword,
            name,
            birthday,
            phone,
            role,
            gender
        }, function (data) {
            data = JSON.parse(data);
            if (data.status == 'success') {
                swal("Thông báo!", data.message, "success");
                $('#createAccountModal').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 2500);
            } else {
                swal("Cảnh báo!", data.message, "error");
            }
        });


    });
});