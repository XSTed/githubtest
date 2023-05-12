(function ($) {
    $("body").append("<img id='goTopButton' style='display: none; z-index: 5; cursor: pointer;top: 100px;right: 100px; position: fixed;' title='回到頂端'/>");

    var img = "gotop01.png",
        location = 0.75,
        right = 15,
        opacity = 0.6,
        speed = 300,
        $button = $("#goTopButton"),
        $body = $(document),
        $win = $(window);

    $button.attr("src", img);

    window.goTopMove = function () {
        var scrollH = $body.scrollTop(),
            winH = $win.height(),
            css = {
                top: winH * location + "px",
                position: "fixed",
                right: right,
                opacity: opacity
            };
        // console.log("這是scrolltop值" + scrollH);
        if (scrollH > 20) {
            $button.css(css);
            $button.fadeIn("slow");
        } else {
            css = {
                transform: "none",
                transition: "none"
            };
            $button.css(css);
            $button.fadeOut("slow");
        }
    };

    $win.on({
        scroll: function () {
            goTopMove();
            console.log("這是scroll功能");
        },
        resize: function () {
            goTopMove();
            console.log("這是resize功能");
        }
    });

    $button.on({
        mouseover: function () {
            $button.css("opacity", 1);
        },
        mouseout: function () {
            $button.css("opacity", opacity);
        },
        click: function () {
            var randomNum = (min, max) => {
                return Math.floor(Math.random() * (max - min) + min);
            };

            var con = document.querySelectorAll(".container");
            var aniGroup = ["ani-1", "ani-2", "ani-3", "ani-4"];

            for (var i = 0; i < 10; i++) {
                $("#goTopButton").remove();
            }

            for (var i = 0; i < 10; i++) {
                $("body").append("<img id='goTopButton' style='z-index: 5; cursor: pointer;top: 100px;right: 100px; position: fixed;' title='回到頂端'/>");
                $button.attr("src", "gotop01.png");
                $button.addClass(aniGroup[randomNum(0, aniGroup.length)]);
                $button.css("animationDelay", randomNum(200, 1000) + "ms");
            }
            $("html, body").animate({
                scrollTop: 0
            }, speed);
        }
    });

})(jQuery);
