<!DOCTYPE html>
<html lang="en">

<head>
    <title>Triplemaza</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="login/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="login/css/style.css" />
</head>

<body>

    <div class="wrapper login_bg" id="wrapper">

        <div class="plus-amusement">
            <img class="img-responsive" src="login/images/+18_Icon.png" />

        </div>
        <div class="download-wrapper">
            <div class="login-inner-div">
                <div class="logo-img">
                    <img class="img-responsive" src="login/images/Logo.png" />
                </div>
                <div class="download-div">
                    <div class="download-img">
                        &nbsp;
                    </div>
                    <div class="playnow-img" onclick="window.location.href='login.php'">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="login/js/jquery.min.js"></script>
    <script src="login/js/bootstrap.min.js"></script>
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
        
        $('a[data-href]').on('click', function(e) {
            e.preventDefault();
            window.location.href = $(this).data('href');
        });
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
    </script>
</body>

</html>