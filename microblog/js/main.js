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
            sectionMessage.html("Sorry, only " + maxLength + " characters are allowed").fadeIn().delay(500).fadeOut('slow');
        }
    });
    $('#createTweet').on('click','#btnAdd',function(e){
        e.preventDefault();
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
                dataType: 'json'
            }).done(function(response){
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
                                    '<div class="interaction tweet-interact" user_id="'+user_id.val()+'" tweet_id="'+query[index].id+'">'+
                                        '<a href="javascript:;" class="tweet-edit">Edit | </a>'+
                                        '<a href="javascript:;" class="tweet-delete" id="delete-item">Delete |</a>'+
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
            });
        }
    });

    $(document).on('click', '#delete-item', function(event){
        event.preventDefault();
        var $this = $(this);
        var type = $this.attr('class');
        var id = $this.parent().attr('tweet_id');
        $('#deleteModal').modal('show');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(event){
            event.preventDefault();
            $.ajax({
                method: 'POST',
                url: 'micro-delete.php',
                data: { type:type, id: id},
                dataType: 'json'
            }).done(function(response){
                if(response.message.success) {
                    $('#deleteModal').modal('hide');
                    sectionMessage.removeClass('alert-success');
                    sectionMessage.addClass('alert-danger');
                    sectionMessage.html('Tweet Deleted successfully').fadeIn().delay(1500).fadeOut('slow');
                    $this.parent().parent().remove();
                    console.log(response.tweetParent);
                    if(Object.keys(response.tweetParent).length > 0){
                        var parentDivRetweet = $('#showdata').find('article.post').find('.tweet-interact[user_id="' + response.tweetParent[0].user_id + '"][tweet_id="' + response.tweetParent[0].id + '"]');
                        parentDivRetweet.children().children().css("color", "");
                    }
                }else{
                    alert('Error');
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
                        var userTweet = response.userTweet;
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
                                    '<p>' + "Retweeted from " + '<a href="micro-profile.php?username=' + userTweet[index].username + '">'+userTweet[index].username+'</a>' + ' on ' + query[index].created + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<p class="contentPost">' + query[index].tweet + '</p>' +
                                    '<div class="clearfix"></div>' +
                                    ' <div class="interaction tweet-interact" user_id="' + user_id.val() + '" tweet_id="' + query[index].id + '">' +
                                    '<a href="javascript:;" class="retweet-delete" id="delete-item">Delete |</a>' +
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

    //search
    $("#search").keyup(function() {
        //Assigning search box value to javascript variable named as "name".
        var name = $('#search').val();
        var menu =   $("#menuItem");
        //Validating, if "name" is empty.
        if (name === "") {
            //Assigning empty value to "display" div in "search.php" file.
            menu.html("");
            menu.css("display","none");
        }
        //If name is not empty.
        else {
            //AJAX is called.
            $.ajax({
                //AJAX type is "Post".
                type: "POST",
                //Data will be sent to "ajax.php".
                url: "micro-search.php",
                //Data, that will be sent to "ajax.php".
                data: {
                    //Assigning value of "name" into "search" variable.
                    search: name
                },
                dataType: 'json',
                //If result found, this funtion will be called.
                success: function(res) {
                    var query = res.query;
                    var output = '<ul>';
                    console.log(res.query);
                    if(res.query.length == 0)
                    {
                        menu.html("");
                        output='';

                    }else{
                        $.each(query, function (index) {

                            output += '<li onclick="fill('+query[index].username+')">'+
                                '<a href="micro-profile.php?username='+query[index].username+'">'+query[index].username+'</a>'+
                                '</li>';

                        });
                        menu.css("display","block");
                    }
                    menu.html(output);
                    //Assigning result to "display" div in "search.php" file.
                }
            });
        }
    });
    $('.userfollowers').on('click', function(){
        $('#profileModal').modal('show');
        $.ajax({
            method: 'POST',
            url: 'micro-.php',
            data: {user_id: user_id.val()},
            dataType: 'json'
        }).done(function(res){
            console.log(res);

        });


    });


});