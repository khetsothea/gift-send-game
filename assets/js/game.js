var Page = {

        lock: 0,
        userid: 0,
        username: 0,
        session: 0,

        start: function() {
            $('#preload').hide();
        },

        fb_connect: function() {


            FB.getLoginStatus(function(response) {

                if (response.status == 'connected') {

                    Page.logged(response);

                } else {

                    FB.login(function(response) {
                        if (response.authResponse) {

                            FB.api('/me', function(response) {

                                $('.fbName').html(response.name);

                                Page.logged(response);

                            });
                        } else {

                            console.log('not logged in');
                        }
                    }, {
                        scope: 'email,user_friends'
                    });

                }

            });

        },


        logged: function(response) {

            if (typeof response.id == 'undefined') {
                userid = response.authResponse.userID;
            } else {
                userid = response.id;
            }


            FB.api('/me', function(response) {

                $('.login').fadeOut('fast', function() {
                    $('.play').fadeIn();
                });
                $('.fbName').html(response.name);
                Page.username = response.name;

                $('.profileImg').attr('src', '//graph.facebook.com/' + userid + '/picture?width=150&height=150');

                var responseSuccess = function(response) {
                    $(".fbLogin").hide();
                    //console.log(response.send_status);
                    $('#send_status').html(response.send_status);
                    Page.session = response.session;

                    var setGifts = function(response) {
                        $('#preload').hide();

                        if (response != 0) {

                            for (var i = 0; i < response.length; i++) {
                                var expire = 7 - parseInt(response[i]['expire_day']);

                                $('.yourGifts').append('<div class="gift g' + response[i]['gift_type'] + ' "><span class="giftName">' + response[i]['sender_name'] + ' <br /> Expire at: <span>' + expire + '</span> day</span> </div>');

                            }
                        } else {
                            $('.yourGifts').append('You dont have any gift yet!');
                        }



                        FB.api('/me/friends', function(response) {

                            Page.lock = 0;
                            if (response.data.length == 0) {
                                $('.yourFriends').append('You dont have any friend for this game.');
                            }
                            for (var i = 0; i < response.data.length; i++) {

                                $('.yourFriends').append('<div class="friend"><img src="//graph.facebook.com/' + response.data[i].id + '/picture?width=50&height=50" class="profileimg"><span class="name">' + response.data[i].name + '</span><button class="sendGift gift1" data-rel="' + response.data[i].id + '"></button> <button class="sendGift gift2" data-rel="' + response.data[i].id + '"></button> <button  class="sendGift gift3" data-rel="' + response.data[i].id + '"></button></div>');
                            
							}
                        });


                    };

                    Page.lock = 0;
                    Page.service('getgifts', 'POST', {
                        'session': Page.session
                    }, setGifts, this.responseError);

                };

                Page.service('login', 'POST', response, responseSuccess, this.responseError);

            });

        },
        service: function(url, method, data, successFunction, errorFunction, responseDataType) {

            $('#preload').show();
            if (typeof responseDataType == 'undefined') {
                responseDataType = 'json';
            }

            if (!Page.lock) {
                Page.lock = 1;
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    dataType: responseDataType,
                    error: errorFunction,
                    success: successFunction
                });
            }
        },
        responseError: function(response) {

            console.log('error');

        },
        popupShow: function(text) {

            $('#popupText').html(text);
            $('#preload').hide();
            $('.popupMask').show();
            $('.popupContainer').show();
        },
        popupHide: function(text) {
            $('#preload').hide();
            $('.popupMask').hide();
            $('.popupContainer').hide();
        },



    }
    /*---------------------------------------------*/

$(function() {

    Page.start();


    $(document).on('click', '.sendGift', function() {

        var id = $(this).attr('data-rel');
        var gift = 0;

        if ($(this).hasClass("gift1")) gift = 1;
        if ($(this).hasClass("gift2")) gift = 2;
        if ($(this).hasClass("gift3")) gift = 3;

        var data = {
            'id': id,
            'session': Page.session,
            'gift': gift,
            'sender_name': Page.username
        }

        var giftSendSuccess = function(response) {
            var text;
            if (response == 1) {
                text = 'gift has been successfully sent';
				$('#send_status').html('0');
            } else {
                text = 'not posible to send another gift for today';
            }

            Page.lock = 0;
            Page.popupShow(text);

            //console.log(response);

        };

        Page.service('sendgift', 'POST', data, giftSendSuccess, Page.responseError);

    });

    $(document).on('click', '.popupClose, .popupMask', function() {

        Page.popupHide();

    });




});