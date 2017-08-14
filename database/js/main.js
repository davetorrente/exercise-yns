$(document).ready(function() {

    $('#registerForm').submit(function(event){
        event.preventDefault();
        $.ajax({
            url: 'database-3-6-register.php',
            type: 'POST',
            success: function(result){
                alert(result);
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

