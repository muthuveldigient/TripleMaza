<?php
/* session_start();
  if ( isset( $_SESSION[SESSION_USERID])){
  header('Location: home.php');
  }
  error_reporting(0); */
?>
<head>
    <title>Triplemaza</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="login/js/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="login/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="login/css/style.css" />
</head>
<body>
<div class="wrapper login_bg" id="wrapper">
    <div class="plus-amusement">
        <img class="img-responsive" src="login/images/+18_Icon.png" />
    </div>
    <div class="login-wrapper">
        <form name="frmLogin" id="frmLogin" action="index.php" method="post">
        <div class="login-inner-div">
            <div class="logo-img">
                <img class="img-responsive" src="login/images/Logo.png" />
            </div>
            <div class='notification alert alert-danger' style="display: none" id="log_msg"></div>
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="username" id="username" size="60"  maxlength="30" autofocus tabindex="1" /> <br />
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="password" id="password" size="60" maxlength="30" tabindex="2" autocomplete='new-password'/><br />
            </div>
            <div class="form-group">
                <button class="login-btn" id="submit_btn" name="submit">&nbsp;</button>
                <div class="" style="width: 100%;text-align: center;"><img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="log_loader" src="login/images/loader.gif"></div>
                <!--<input name="submit" class="login-btn" type="submit" id="submit_btn" value="LOGIN" />
                <div class="" style="width: 100%;text-align: center;"><img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="log_loader" src="login/images/loader.gif"></div>-->
            </div>
        </div>
        </form>
    </div>
</div>

<script src="login/js/bootstrap.min.js"></script>
<script src="login/js/jquery.validate.min.js"></script>
<script src="login/js/md5.js"></script>
<script type="text/javascript">
        var preloadeOnResize = function(e) {
            //alert("dsfds");
            var elWidth = 1920;
            var elHeight = 1080;
            var scale;
            var bodyWidth = window.innerWidth || document.documentElement.clientWidth ||
                document.body.clientWidth || document.body.offsetWidth;
            var bodyHeight = window.innerHeight || document.documentElement.clientHeight ||
                document.body.clientHeight || document.body.offsetHeight;
            scale = Math.min(
                bodyWidth / elWidth,
                bodyHeight / elHeight
            );
            document.getElementById("wrapper").style.transform = "translate(-50%, -50%) scale(" + scale + ")";

        };
        preloadeOnResize(null);
        window.addEventListener("resize", preloadeOnResize);
        // $(document).ready(function(){

        //$(".ticket").hover(function(){
        //$('.ticket_points').css({'height':'100%'});
        // $('.ticket_points').slideToggle();
        //});

        //});
    </script>

    <script src="login/js/TweenMax.min.js"></script>
    <script>
        var container = $(".result_container"),
            div1 = $(".div1"),
            tweenForward, tweenBack;

        TweenMax.set(container, {
            transformStyle: 'preserve-3d'
        });

        $.each(div1, function(index, element) {
            TweenMax.to(element, 0, {
                rotationX: (36 * index),
                transformOrigin: '100% 100% -500px'
            });
        });

        var tweenComplete = function() {
            createNumTween();
        }

        var createNumTween = function() {
            TweenLite.to(container, 0.25, {
                rotationX: '-=500',
                transformOrigin: '100% 100% -500px',
                //delay: 0.01,
                //ease: Power3.easeInOut,
                onComplete: tweenComplete
            });
        };

        // start the whole thing
        TweenLite.delayedCall(0.25, createNumTween);
   
        $(document).ready(function () {
            /**  inspect and right click not working */
            document.addEventListener('contextmenu', event => event.preventDefault());
            $(document).keydown(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                //$("#keydownCode").val(keycode);
                //alert(keycode);
                if (keycode == 32 || (keycode >= 112 && keycode <= 123)) {
                    event.preventDefault();
                }

                if (keycode == 123) { //F12 Result
                    return false;
                }
            });


            $('#frmLogin').validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    username: {
                        required: "Please enter your username",
                    },
                    password: {
                        required: "Please enter your password"
                                //minlength : "Your password must be at least 7 characters long"
                    }
                },
                submitHandler: function (form) {
                    $("#log_msg").html('');
                    $("#submit_btn").hide();
                    $("#log_loader").show();
                    $.post("processlogin.php", $("#frmLogin").serialize(), function (response) {
                        if (response == 1) {
                            window.location.href = "web/index.php";
                        } else if (response == 2) {
                            $("#log_msg").show().html('Invalid Login.Please try again.');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        } else if (response == 3) {
                            $("#log_msg").show().html('UnAuthenticated User.Please try again.');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        } else if (response == 4) {
                            $("#log_msg").show().html('Invalid Captcha Please try again.');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        } else {
                            $("#log_msg").show().html('Username or Password invalid');
                            $("#log_loader").hide();
                            $("#submit_btn").show();
                            clear_form();
                        }
                        //$(".imgcaptcha").attr("src","captcha.php?_="+((new Date()).getTime()));
                        setTimeout(function () {
                            $("#log_msg").hide();
                        }, 4000);

                    }).fail(function(xhr, status, error) {
							$("#log_msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
							location.reload();
						if (xhr.readyState == 4) {
							// HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
							//$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
						} else if (xhr.readyState == 0) {
							// Network error (i.e. connection refused, access denied due to CORS, etc.)
							$("#log_msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
							location.reload();

						}
						// error handling
					});
                    return false;
                    // form.submit();
                }
            });
            clear_form();
        });
        function clear_form() {
            $("#username").val('');
            $("#password").val('');
            $('#username').attr("autocomplete", "off");
            $('#Password').attr("autocomplete", "off");

        }

        /* function onshow(){
         document.name.username.focus();
         } */

        function txtBlur(id) {
            document.getElementById(id).innerHTML = '';
        }

        $("#username").focus();
        clear_form();
</script>
</body>
</html>