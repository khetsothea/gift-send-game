<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Facebook invite game</title>
<meta content="game, facebook, invite" name="keywords">
<meta name="referrer" content="origin">
<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,user-scalable=no">

<link rel="stylesheet" href="assets/css/normalize.css">
<link rel="stylesheet" href="assets/css/style.css">
<link href='https://fonts.googleapis.com/css?family=Chewy' rel='stylesheet' type='text/css'>
	<script>
       var APPID = '<?php echo $data['APPID'];?>';
    </script>
</head>
<body>
<div id="preload">
	<div id="fountainG">
		<div id="fountainG_1" class="fountainG">
		</div>
		<div id="fountainG_2" class="fountainG">
		</div>
		<div id="fountainG_3" class="fountainG">
		</div>
		<div id="fountainG_4" class="fountainG">
		</div>
		<div id="fountainG_5" class="fountainG">
		</div>
		<div id="fountainG_6" class="fountainG">
		</div>
		<div id="fountainG_7" class="fountainG">
		</div>
		<div id="fountainG_8" class="fountainG">
		</div>
	</div>
</div>
<div id="game">
	<div class="login">
		<p>
			Awesome gift send game
		</p>
		<button onclick="Page.fb_connect()" class="fbLogin">Log in with Facebook</button>
	</div>
	<div class="play">
		<img src="" class="profileImg">
		<p>
			Welcome <span class="fbName"></span>
			<br/>
			<span class="textmin">You can send <span id="send_status"></span> more gift today</span>
		</p>
		<h1>Your Gifts</h1>
		<div class="yourGifts">
		</div>
		<h1>Send Gift</h1>
		<div class="yourFriends">
		</div>
	</div>
</div>
<div class="popupMask">
</div>
<div class="popupContainer">
	<div class="popup">
		<div class="popupClose">
			x
		</div>
		<p id="popupText">
		</p>
	</div>
</div>
<input type="hidden" value="0" id="session">
<!-- Begin Facebook SDK -->
<div id="fb-root">
</div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : APPID,
            xfbml      : true,
            version    : 'v2.4',
            cookie     : true
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- End Facebook SDK -->
<!-- External and third party libraries. -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/game.js"></script>
</body>
</html>