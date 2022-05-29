$(document).ready(function () {
    $('#btn-login').click(function () { 
        // Get input values
        var username = $('#username').val();
        var password = $('#password').val();
        // Check if values are empty
        if (username == '' || password == '') {
            // Show error message
            swal("Cảnh báo!", "Không thể để trống các ô!", "error");
            return
        }
        // Send post to ./api/login
        $.post('./api/login', {
            username: username,
            password: password
        }, function (data) {
            data = JSON.parse(data);
            // Check if login success
            if (data.status == 'success') {
                // Redirect to home page
                window.location.href = './';
            } else {
                // Show error message
                swal("Cảnh báo!", data.message, "error");
            }
        });
    });
});