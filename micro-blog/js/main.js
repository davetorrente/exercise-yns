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
                    var html = '';
                    if(data.message)
                    {
                        var query = data.query;
                        console.log(query);
                        $.each(query, function(index){
                            html +=
                                '<article class="post">'+
                                    '<div class="info postByUser">'+
                                        '<div class="row">'+
                                            '<div class="col-md-2">'+
                                                '<a href="/profile/'+query[index].username+'"><img class=" postImage" src="'+query[index].upload+'"></a>'+
                                            '</div>'+
                                            '<div class="col-md-6 userName">'+
                                            '<h4>'+query[index].username+'</h4>'+
                                            '<p>'+"Posted on "+query[index].created+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<p class="contentPost">'+query[index].tweet+'</p>'+
                                    '<div class="clearfix"></div>'+
                                '</article>';
                            //
                        });
                        $('#alertMessage').addClass('alert-success');
                        $('#alertMessage').html('Tweet Successfully Added!').fadeIn().delay(2500).fadeOut('slow');

                        $('#showdata').prepend(html);

                    }
                },
                error: function(){
                    alert('Could not add data');
                }
            });
        }

    });
});