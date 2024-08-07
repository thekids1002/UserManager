$(function () {
    $('#login-form').validate({
        onfocusin: function (element) {
            $('.alert-danger').hide();
        },
        rules: {
            email: {
                required: true,
                checkValidEmailRFC: true,
            },
            password: {
                required: true,
            },
        },
    });
});
