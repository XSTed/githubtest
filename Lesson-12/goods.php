<!-- 資料庫連線程式 -->
<?php require_once('Connections/conn_db.php'); ?>
<!-- 如果SESSION沒有啟動，則啟動SESSION功能，這是跨網頁變數存取 -->
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<!-- 載入共用PHP函數庫 -->
<?php require_once("php_lib.php") ?>
<!doctype html>
<html lang="zh-TW">

<head>
    <!-- 引入網頁的標頭 -->
    <?php require_once("headfile.php"); ?>
    <link rel="stylesheet" href="fancybox-2.1.7/source/jquery.fancybox.css">
</head>

<body>
    <section id="header">
        <!-- 引入網頁的導覽列 -->
        <?php require_once("navbar.php"); ?>
    </section>
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 引入網頁的sidebar -->
                    <?php require_once("sidebar.php"); ?>

                    <!-- 引入網頁的本月熱銷 -->
                    <?php require_once("hotsales.php"); ?>

                </div>
            </div>
            <div class="col-md-10">
                <!-- 建立類別分項 -->
                <?php require_once("breadcrumb.php"); ?>
                <!-- 引入網頁的商品 -->
                <?php //require_once("product.php"); 
                ?>
                <!-- 產品詳細資訊 -->
                <?php require_once("goods_content.php"); 
                ?>
                
                <?php //require_once('drop-box.php'); ?>
            </div>
    </section>
    <section id="scontent">
        <div class="container-fluid">
            <!-- 引入網頁的關於我 -->
            <?php require_once("aboutme.php"); ?>
        </div>
    </section>
    <section id="footer">
        <div class="container-fluid">
            <!-- 引入網頁的lastdata -->
            <?php require_once("lastdata.php"); ?>
        </div>
    </section>

    <!-- javascript模組 -->
    <?php require_once("jsfile.php"); ?>
    <script type="text/javascript" src="fancybox-2.1.7/source/jquery.fancybox.js"></script>
    <script type="text/javascript">
        $(function() {
            //定義在滑鼠滑過圖片 檔名填入主圖src中
            $(".card .row.mt-2 .col-md-4 a").mouseover(function() {
                let imgSrc = $(this).children("img").attr("src");
                $("#showGoods").attr({
                    "src": imgSrc
                });
            });
            //將子圖放到lightbox展示
            $(".fancybox").fancybox();
        });
        
    </script>
</body>

</html>