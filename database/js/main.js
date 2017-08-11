$(document).ready(function() {
    var uniqueUser;
    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight: function(element) {
            $(element)
                .closest('.form-group')
                .addClass('has-error');
        },
        unhighlight: function(element) {
            $(element)
                .closest('.form-group')
                .removeClass('has-error');
        },
        errorPlacement: function (error, element) {
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $.validator.addMethod('strongPassword', function(value, element) {
        return this.optional(element)
            || value.length >= 6
            && /\d/.test(value)
            && /[a-z]/i.test(value);
    }, 'Your password must be at least 6 characters long and contain at least one number and one char\'.');
    $('#registerForm').validate({
        rules: {
            username: {
                required: true,
                nowhitespace: true,
                alphanumeric: true
            },
            email: {
                required: true,
                email: true
            },
            password:{
                required: true,
                strongPassword: true
            },
            password2: {
                required: true,
                equalTo: "#password"
            },
            upload: {
                required: true
            }
        },
        messages: {
            email: {
                required: 'Please enter an email address',
                email: 'Please enter a <em>valid</em> email address.'
            }
        },
        submitHandler: submitForm
    });
    function submitForm()
    {
        $.ajax({
            type : 'POST',
            url  : 'register.php',
            data: new FormData($("#registerForm")[0]),
            async: false,
            contentType:false,
            processData:false,
            success :  function(data)
            {
                var res = JSON.parse(data);
                if(res.success)
                {
                    $('.alert-success').html('User successfully created. You can now login').fadeIn().delay(4000).fadeOut('slow');
                }
            }
        });
        return false;
    }

    $('#loginForm').submit(function(event){
        event.preventDefault();
        $.ajax({
            url: 'login.php',
            data: $(this).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(result){
                // console.log(result.username);
                // alert(result);
                // if (result.success){
                //     window.location = "logged.php";
                //     return false;
                // };
            },
            error: function(e){console.log("Could not retrieve login information")}
        });
    });

});

