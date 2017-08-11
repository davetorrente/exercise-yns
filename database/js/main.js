$(document).ready(function() {
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
        var data = $("#registerForm").serialize();
        // console.log(new FormData($("#registerForm")[0]));

        $.ajax({

            type : 'POST',
            url  : 'register.php',
            data: new FormData($("#registerForm")[0]),
            async: false,
            contentType:false,
            processData:false,
            success :  function(data)
            {
                console.log(data);

                // if(data==1){
                //
                //     $("#error").fadeIn(1000, function(){
                //
                //
                //         $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry email already taken !</div>');
                //
                //         $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');
                //
                //     });
                //
                // }
                // else if(data==="registered")
                // {
                //
                //     $("#btn-submit").html('Signing Up');
                //     setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("successreg.php"); }); ',5000);
                //
                // }
                // else{
                //
                //     $("#error").fadeIn(1000, function(){
                //
                //         $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                //
                //         $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');
                //
                //     });
                //
                // }
            }
        });
        return false;
    }

});

