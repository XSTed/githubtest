(function ($) {
    // 使用JQUERY將IMG插入到BODY中
    $("body").append("<img id='goTopButton' style='display: none; z-index: 5; cursor: pointer;top: 100px;right: 100px; position: fixed;' title='回到頂端'/>");
    var img = "gotop01.png",        //  宣告變數設定圖檔名稱
      location = 0.75,             //  按鈕出現在螢幕的高度
      right = 15,                   //  距離右邊px值
      opacity = 0.6,                //  預設透明度
      speed = 300,                  //  返回TOP捲動速度
      $button = $("#goTopButton"),  //  定義JQUERY呼叫ID
      $body = $(document),          //  定義JQUERY網頁
      $win = $(window);             //  定義JQUERY瀏覽器
    $button.attr("src", img);
    window.goTopMove = function () {
      var scrollH = $body.scrollTop(),
        winH = $win.height(),
        css = { "top": winH * location + "px", "position": "fixed", "right": right, "opacity": opacity };
        console.log("這是scrolltop值"+scrollH);
      if (scrollH > 20) {
        $button.css(css);
        $button.fadeIn("slow");
      } else {
        css = { "transform": "none", "transition": "none" };
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
      mouseover: function () { $button.css("opacity", 1); },
      mouseout: function () { $button.css("opacity", opacity); },
      click: function () {
        css = { "transform": "scale(2.5)", "transition": "transform 1s ease 0s" };
        $button.css(css);
        $("html, body").animate({ scrollTop: 0 }, speed);
      }
    });

  })(jQuery);
  