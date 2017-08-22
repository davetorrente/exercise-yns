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
                method: 'post',
                url: 'micro-add.php',
                data: {tweet: addTweet.val(), user_id: user_id.val()},
                dataType: 'json',
                success: function(response){
                    addTweet.val('');
                    var html = '';
                    if(response.message)
                    {
                        var query = response.query;
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
                                    ' <div class="interaction tweet-interact">'+
                                        '<a href="javascript:;" class="retweet">Retweet | </a>'+
                                        ' <a href="javascript:;" class="tweet-edit">Edit | </a>'+
                                        '<a href="javascript:;" class="tweet-delete" data="'+query[index].id+'">Delete |</a>'+
                                    '</div>'+
                                '</article>';
                        });
                        $('#alertMessage').addClass('alert-success');
                        $('#alertMessage').html('Tweet Successfully Added!').fadeIn().delay(2500).fadeOut('slow');

                        $('#showdata').prepend(html);

                    }else{
                        $('#alertMessage').addClass('alert-danger');
                        $('#alertMessage').html('Could not add data!').fadeIn().delay(2500).fadeOut('slow');
                    }
                },
                error: function(){
                    $('#alertMessage').addClass('alert-danger');
                    $('#alertMessage').html('Could not add data!').fadeIn().delay(2500).fadeOut('slow');
                }
            });
        }

    });

    $(document).on('click', '.tweet-delete', function(event){
        event.preventDefault();
        $('#deleteModal').modal('show');
        $('#deleteModal').find('.modal-body').text('Do you want to delete this Tweet?');
        var id = $(this).attr('data');
        var $this = $(this);
        $('#deleteModal').modal('show');
        $('#deleteModal').find('.modal-body').text('Are you sure you want to delete this comment?');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(event){
            event.preventDefault();
            $.ajax({
                method: 'POST',
                url: 'micro-delete.php',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#deleteModal').modal('hide');
                        $('.alert-success').html('Tweet Deleted successfully').fadeIn().delay(2500).fadeOut('slow');
                        $this.parent().parent().remove();

                    }else{
                        alert('Error');
                    }
                },
                error: function(){
                    alert('Error deleting');
                }
            });
        });
    });



});