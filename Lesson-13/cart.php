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
    <style type="text/css">
        /* 輸入有錯誤時，顯示紅框 */
        table input:invalid {
            border: solid red 3px;
        }
    </style>
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

                    <!-- 購物車內容模組 -->
                    <?php require_once("cart_content.php");
                    ?>

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
    <?php require_once("jsfile.php"); ?>
    <script type="text/javascript">
        //將變更的數量寫入後臺資料庫
        $("input").change(function() {
            let qty = $(this).val();
            const cartid = $(this).attr("cartid");
            if (qty <= 0 || qty >= 50) {
                alert("更改數量需大於0以上，以及小於50以下。");
                return false;
            }
            $.ajax({
                url: 'change_qty.php',
                type: 'post',
                dataType: 'json',
                data: {
                    cartid: cartid,
                    qty: qty,
                },
                success: function(data) {
                    if (data.c == true) {
                        // alert(data.m);
                        window.location.reload();
                    } else {
                        alert(data.m);
                    }
                },
                error: function(data) {
                    alert("系統目前無法連接到後台資料庫。");
                }
            });
        });
    </script>
</body>

</html>