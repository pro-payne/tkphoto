$(function () {
    $("#auth-form").validate({
        rules:
        {
            password: {
                required: true,
                minlength: 5
            },
            email: {
                required: true,
                email: true
            }
        },
        messages:
        {
            password: {
                required: "Please enter password"
            },
            email: "Please enter email address"
        },
        submitHandler: loginForm
    });

    function loginForm() {
        let form = $('#auth-form'),
            _btn = form.find('button'),
            _error = form.find('.alert.error'),
            data = form.serialize();
        _error.text('').hide()

        $.ajax({
            url: './session',
            method: 'post',
            data: data,
            dataType: 'json',
            beforeSend: function () {
                _btn.attr('disabled', true).addClass('disabled');
            },
            error: function () {
                _btn.attr('disabled', false).removeClass('disabled');
            },
            success: function (r) {
                if (r.success) {
                    window.location.replace("./dashboard");
                } else {
                    _error.text(r.error).show()
                    _btn.attr('disabled', false).removeClass('disabled');
                }

            }
        });
    }

    $("#signup-form").validate({
        rules:
        {
            password: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: 'input[name="password"]'
            }
        },
        messages:
        {
            password: {
                required: "Please enter password"
            },
            confirm_password: {
                equalTo: 'Please repeat your password'
            },
            email: "Please enter email address",
            firstname: "Please enter your first name",
            lastname: "Please enter your last name"
        },
        submitHandler: singupForm
    });

    function singupForm() {
        let form = $('#signup-form'),
            _btn = form.find('button'),
            _error = form.find('.alert.error'),
            data = form.serialize();
        _error.text('').hide()

        $.ajax({
            url: './signup',
            method: 'post',
            data: data,
            dataType: 'json',
            beforeSend: function () {
                _btn.attr('disabled', true).addClass('disabled');
            },
            error: function () {
                _btn.attr('disabled', false).removeClass('disabled');
            },
            success: function (r) {
                if (r.success) {
                    window.location.replace("./login");
                } else {
                    _error.text(r.error).show()
                    _btn.attr('disabled', false).removeClass('disabled');
                }

            }
        });
    }

    $("#account-form").validate({
        rules:
        {
            email: {
                required: true,
                email: true
            },
            firstname: {
                required: true
            },
            lastname: {
                required: true
            }
        },
        messages:
        {
            email: "Please enter email address",
            firstname: "Please enter your first name",
            lastname: "Please enter your last name"
        },
        submitHandler: accountForm
    });

    function accountForm() {
        let form = $("#account-form"),
            _btn = form.find('button'),
            _data = form.serialize();
        $.ajax({
            url: './update',
            data: _data,
            method: 'post',
            dataType:'json',
            beforeSend: function(){
                _btn.attr('disabled', true).addClass('disabled');
            },
            error: function(){
                _btn.attr('disabled', false).removeClass('disabled');
            },
            success: function(r){
                if(r.success){
                    
                }
                _btn.attr('disabled', false).removeClass('disabled');
            }
        });

    }


});
