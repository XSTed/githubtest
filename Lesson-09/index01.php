<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>林肯運動鞋專賣店-電子商店</title>
    <link rel="stylesheet" href="bootstrap-5.2.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="website01.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="morphext.css">
</head>

<body>
    <div class="container-fluid">
        <div class="video-background">
            <iframe id="player" src="https://www.youtube.com/embed/LjUXm0Zy_dk?controls=0&showinfo=0&rel=0&autoplay=1&loop=1&mute=1&playlist=LjUXm0Zy_dk" frameborder="0" allowfullscreen></iframe>
            <!-- <div id="player"></div> -->
        </div>
    </div>

    <div class="video-caption text-center">
        <div class="wow wobble" data-wow-offset="1" data-wow-delay="1s">
            <h1>
                <span id="js-rotating">
                    全台最專業運動鞋購物平台,不出門也能盡享購物樂趣，多款跑鞋低價超值折扣,型男美女必買商品!多款知名品牌運動鞋隨你挑,全館激殺價，千萬別錯過,加入會員首次購物拿500,12H速達早上訂下午到貨
                </span>
            </h1>
        </div>
        <div class="wow bounceInUp" data-wow-offset="0" data-wow-delay="1s">
            <div class="margintop-30">
                <a href="main.php" class="btn btn-warning">
                    Start here
                </a>
            </div>
        </div>
    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap-5.2.3-dist/js/bootstrap.bundle.js"></script>
    <script src="wow.js"></script>
    <script src="morphext.js"></script>
    <script src="text_ctrl.js"></script>
    <script>
        // 2. This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // 3. This function creates an <iframe> (and YouTube player)
        //    after the API code downloads.
        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                width: '100%',
                videoId: 'LjUXm0Zy_dk',
                playerVars: {
                    'autoplay': 1,
                    'playsinline': 1
                },
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        // 4. The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event.target.mute();
            event.target.playVideo();
        }
    </script>
</body>

</html>