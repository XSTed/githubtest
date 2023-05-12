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
                <div class="col-md-10">
                    <!-- 引入網頁的輪播 -->
                    <?php require_once("carousel.php"); ?>
    
                    <hr>
                    <!-- 引入網頁的商品 -->
                    <?php require_once("product.php"); ?>
                </div>
            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="gotop.js"></script>
</body>

</html>