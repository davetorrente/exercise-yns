$(document).ready(function(){

    $('#tweet').keyup(function () {
        var maxLength = 140;
        var text = $(this).val();
        var textLength = text.length;
        if (textLength > maxLength) {
            $(this).val(text.substring(0, (maxLength)));
            $('#alertMessage').addClass('alert-danger');
            $('#alertMessage').html("Sorry, only " + maxLength + " characters are allowed").fadeIn().delay(2500).fadeOut('slow');
        }

    });
    // $('#tweet').on('keyup', function(e) {
    //     var tweetCount = parseInt($('#tweetCount').html());
    //     // if($('#tweet').val() === '')
    //     // {
    //     //     if($(e.keyCode === 8)){
    //     //        alert(1);
    //     //     }
    //     // }
    //     $('#tweetCount').html(tweetCount-1);
    //
    //         // if(e.keyCode == 8) {
    //         //     $('#tweetCount').html(tweetCount+1);
    //         // }
    //
    //     // if($(e.keyCode === 8)){
    //     //
    //     //     return false;
    //     // }else{
    //     //
    //     // }
    //
    // });
    $('#createTweet').on('click','#btnAdd',function(e){
        e.preventDefault();
        var addTweet = $('textarea[name=tweet]');
        var user_id = $('input[name=hidden_id]');
        var result = '';
        if(addTweet.val()===''){
            addTweet.parent().addClass('has-error');
            $('#alertMessage').addClass('alert-danger');
            $('#alertMessage').html('Tweet cannot be empty').fadeIn().delay(2500).fadeOut('slow');
        }
        else if(addTweet.val().length > 140){
            addTweet.parent().addClass('has-error');
            $('#alertMessage').addClass('alert-danger');
            $('#alertMessage').html('Tweet cannot be more than 140 characters').fadeIn().delay(2500).fadeOut('slow');
        }
        else{
            addTweet.parent().removeClass('has-error');
            $('#alertMessage').removeClass('alert-danger');
            result +='1';
        }
        if(result==='1'){
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: 'microadd.php',
                data: {tweet: addTweet.val(), user_id: user_id.val()},
                dataType: 'json',
                success: function(data){
                    addTweet.val('');
                    $('#alertMessage').addClass('alert-success');
                    $('#alertMessage').html('Tweet Successfully Added!').fadeIn().delay(2500).fadeOut('slow');
                },
                error: function(){
                    alert('Could not add data');
                }
            });
        }

    });
});