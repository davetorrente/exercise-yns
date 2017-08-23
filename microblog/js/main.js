$(document).ready(function(){
    var sectionMessage =  $('.sectionUser').find('#alertMessage');
    var user_id = $('input[name=hidden_id]');
    $('#tweet').keyup(function () {
        var maxLength = 140;
        var text = $(this).val();
        var textLength = text.length;
        if (textLength > maxLength) {
            $(this).val(text.substring(0, (maxLength)));
            sectionMessage.addClass('alert-danger');
            sectionMessage.html("Sorry, only " + maxLength + " characters are allowed").fadeIn().delay(2500).fadeOut('slow');
        }

    });
    $('#createTweet').on('click','#btnAdd',function(e){
        e.preventDefault();
        var $this = $(this);
        var addTweet = $('textarea[name=tweet]');

        var result = '';
        if(addTweet.val()===''){
            addTweet.parent().addClass('has-error');
            sectionMessage.removeClass('alert-success');
            sectionMessage.addClass('alert-danger');
            sectionMessage.html('Tweet cannot be empty').fadeIn().delay(2500).fadeOut('slow');
        }
        else if(addTweet.val().length > 140){
            addTweet.parent().addClass('has-error');
            sectionMessage.removeClass('alert-success');
            sectionMessage.addClass('alert-danger');
            sectionMessage.html('Tweet cannot be more than 140 characters').fadeIn().delay(2500).fadeOut('slow');
        }
        else{
            addTweet.parent().removeClass('has-error');
            sectionMessage.removeClass('alert-success');
            sectionMessage.removeClass('alert-danger');
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
                                    '<div class="alert alert-edit" id="alertMessage" style="display: none;"></div>'+
                                    '<div class="info postByUser">'+
                                        '<div class="row">'+
                                            '<div class="col-md-2">'+
                                                '<a href="micro-profile.php?username='+query[index].username+'"><img class=" postImage" src="'+query[index].upload+'"></a>'+
                                            '</div>'+
                                            '<div class="col-md-6 userName">'+
                                            '<h4>'+query[index].username+'</h4>'+
                                            '<p>'+"Posted on "+query[index].modified+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<p class="contentPost">'+query[index].tweet+'</p>'+
                                    '<div class="clearfix"></div>'+
                                    ' <div class="interaction tweet-interact" user_id="'+user_id.val()+'" tweet_id="'+query[index].id+'">'+
                                        ' <a href="javascript:;" class="tweet-edit">Edit | </a>'+
                                        '<a href="javascript:;" class="tweet-delete">Delete |</a>'+
                                    '</div>'+
                                '</article>';
                        });
                        sectionMessage.removeClass('alert-danger');
                        sectionMessage.addClass('alert-success');
                        sectionMessage.html('Tweet Successfully Added!').fadeIn().delay(1500).fadeOut('slow');

                        $('#showdata').prepend(html);

                    }else{
                        sectionMessage.removeClass('alert-success');
                        sectionMessage.addClass('alert-danger');
                        sectionMessage.html('Could not add data!').fadeIn().delay(1500).fadeOut('slow');
                    }
                },
                error: function(){
                    sectionMessage.removeClass('alert-success');
                    sectionMessage.addClass('alert-danger');
                    sectionMessage.html('Could not add data!').fadeIn().delay(1500).fadeOut('slow');
                }
            });
        }
    });

    $(document).on('click', '.tweet-delete', function(event){
        event.preventDefault();
        var $this = $(this);
        var id = $this.parent().attr('tweet_id');

        $('#deleteModal').modal('show');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(event){
            event.preventDefault();
            $.ajax({
                method: 'POST',
                url: 'micro-delete.php',
                data: {id: id},
                dataType: 'json',
                success: function(response){
                    if(response.message.success) {
                        $('#deleteModal').modal('hide');
                        sectionMessage.removeClass('alert-success');
                        sectionMessage.addClass('alert-danger');
                        sectionMessage.html('Tweet Deleted successfully').fadeIn().delay(1500).fadeOut('slow');
                        $this.parent().parent().remove();
                        if(Object.keys(response.parentTweet).length > 0){

                            // console.log(response.parentTweet[0].parent_tweet);
                            var parentDivRetweet = $('#showdata').find('article.post').find('.tweet-interact[user_id="' + response.parentTweet[0].user_id + '"][tweet_id="' + response.parentTweet[0].id + '"]');
                            console.log(parentDivRetweet.children().children().css("color", ""));
                        }
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

    $(document).on('click', '.tweet-edit', function(event){
        event.preventDefault();
        var sectionTweet =  $(this).parent().parent().find('#alertMessage');
        var $this = $(this);
        var id = $this.parent().attr('tweet_id');
        var tweetElement = $(this).parent().parent().find('.contentPost');
        var modifiedDate = $(this).parent().parent().find('.postByUser').children().find('.userName p');
        var postBody = tweetElement.html();
        var editTweet = $('#tweet-edit');
        var result = '';
        editTweet.val(postBody);
        $('#editModal').modal('show');
        $('#editModal').find('.modal-title').text('Edit Tweet');
        $('#btnSave').unbind().click(function(){
            if(editTweet.val()===''){
                editTweet.parent().addClass('has-error');
                $(this).parent().parent().find('#alertMessage').removeClass('alert-success');
                $(this).parent().parent().find('#alertMessage').addClass('alert-danger');
                $(this).parent().parent().find('#alertMessage').html('Tweet cannot be empty').fadeIn().delay(1500).fadeOut('slow');
            }
            else if(editTweet.val().length > 140){
                editTweet.parent().addClass('has-error');
                $(this).parent().parent().find('#alertMessage').removeClass('alert-success');
                $(this).parent().parent().find('#alertMessage').addClass('alert-danger');
                $(this).parent().parent().find('#alertMessage').html('Tweet cannot be more than 140 characters').fadeIn().delay(1500).fadeOut('slow');
            }
            else{
                editTweet.parent().removeClass('has-error');
                $(this).parent().parent().find('#alertMessage').removeClass('alert-danger');
                result +='1';
            }
            if(result==='1') {
                $.ajax({
                    method: 'POST',
                    url: 'micro-edit.php',
                    data: {id: id, status: editTweet.val()},
                    dataType: 'json'
                }).done(function(response)
                {
                    if(response.message.success)
                    {
                        $('#editModal').modal('hide');
                        editTweet.val('');
                        $this.parent().parent().find('#alertMessage').removeClass('alert-danger');
                        $this.parent().parent().find('#alertMessage').addClass('alert-success');
                        $this.parent().parent().find('#alertMessage').html('Tweet successfully Edited!').fadeIn().delay(2500).fadeOut('slow');
                        $(tweetElement).text(response.tweet);
                        $(modifiedDate).html("Posted on "+response.date);
                    }
                });
            }
        });
    });

    //retweet
    $(document).on("click",".retweet",function(event){
        event.preventDefault();
        var $this = $(this);
        var tweetElement = $(this).parent().parent().find('.contentPost').html();
        $this.parent().find('.comment-interact');
        var userId = $this.parent().attr("user_id");
        var tweetId =  $this.parent().attr("tweet_id");
        $('#retweetModal').modal('show');
        if($this.children().css("color")==="rgb(35, 82, 124)"){
            $('#retweetModal').find('.modal-body').text(' Are you sure you want to Retweet this Tweet?');
            $('#btnRetweet').unbind().click(function() {
                $.ajax({
                    method: 'POST',
                    url: 'micro-retweet.php',
                    data:{
                        type: 'forRetweet',
                        user_id: userId,
                        tweet_id: tweetId,
                        tweet: tweetElement
                    },
                    dataType: 'json'
                }).done(function(response){
                    var html = '';
                    if(response.message.isRetweet) {
                        var query = response.query;
                        $.each(query, function (index) {
                            if (query)
                                html +=
                                    '<article class="post">' +
                                    '<div class="alert alert-edit" id="alertMessage" style="display: none;"></div>' +
                                    '<div class="info postByUser">' +
                                    '<div class="row">' +
                                    '<div class="col-md-2">' +
                                    '<a href="micro-profile.php?username=' + query[index].username + '"><img class=" postImage" src="' + query[index].upload + '"></a>' +
                                    '</div>' +
                                    '<div class="col-md-6 userName">' +
                                    '<h4>' + query[index].username + '</h4>' +
                                    '<p>' + "Posted on " + query[index].modified + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<p class="contentPost">' + query[index].tweet + '</p>' +
                                    '<div class="clearfix"></div>' +
                                    ' <div class="interaction tweet-interact" user_id="' + user_id.val() + '" tweet_id="' + query[index].id + '">' +
                                    ' <a href="javascript:;" class="tweet-edit">Edit | </a>' +
                                    '<a href="javascript:;" class="tweet-delete">Delete |</a>' +
                                    '</div>' +
                                    '</article>';
                        });
                        $('#showdata').prepend(html);
                        $this.children().css("color", "green");
                        $('#retweetModal').modal('hide');
                    }
                });
            });
        }
        if($this.children().css("color")==="rgb(0, 128, 0)"){
            $('#retweetModal').find('.modal-body').text('Are you sure you want to undo the Retweet?');
            $('#btnRetweet').unbind().click(function() {
                $.ajax({
                    method: 'POST',
                    url: 'micro-retweet.php',
                    data:{
                        type: 'forDelete',
                        user_id: userId,
                        tweet_id: tweetId,
                    },
                    dataType: 'json'
                }).done(function(response){
                    if(response.message.success){
                        $('#retweetModal').modal('hide');
                        $this.children().css("color", "");
                        var parentDivRetweet = $('#showdata').find('article.post').find('.tweet-interact[user_id="' + response.userID + '"][tweet_id="'+response.findTweet[0]['id']+'"]');
                        parentDivRetweet.parent().remove();
                    }
                    else{
                        alert('Error deleting');
                    }
                });
            });
        }
    });

    //add follower
    $('#addFollow').on('click', function(event) {
        event.preventDefault();
        var follow_id = $('.hiddenFollow').val();
        $.ajax({
            method: 'POST',
            url: 'micro-follow.php',
            data:{
                follow_id: follow_id
            },
            dataType: 'json'
        }).done(function(res){
            console.log(res);
            if(res.isFollow)
            {
                $('#addFollow').html("Unfollow");
            }
            else{
                $('#addFollow').html("Follow");
            }
        });
    });
});