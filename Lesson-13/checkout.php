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
                    <?php //require_once("carousel.php"); 
                    ?>
                    <!-- 建立購物車資料查詢 -->
                    <?php
                    $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
                    $cart_rs = $link->query($SQLstring);
                    $ptotal = 0; //設定累加的變數，初始為0
                    ?>
                    <h3>電商藥粧：會員結帳作業</h3>
                    <div class="row">
                        <div class="card" style="width: 30rem;">
                            <h4 class="card-header" style="color:#007bff;"><i class="fas fa-truck fa-flip-horizontal me-1"></i>配送資訊</h4>
                            <div class="card-body pl-3 pt-2 pb-2">
                                <h4 class="card-title">收件人資訊：</h4>
                                <h5 class="card-title">姓名：李小明</h5>
                                <p class="card-text">電話：0912345678</p>
                                <p class="card-text">郵遞區號：407台中市西屯區</p>
                                <p class="card-text">地址：中正路1號</p>
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#staticBackdrop">選擇其他收件人</button>
                            </div>
                        </div>

                        <div class="card ms-3" style="width: 50rem;">
                            <h4 class="card-header" style="color:#000;"><i class="far fa-credit-card me-1"></i>付款方式訊</h4>
                            <div class="card-body pl-3 pt-2 pb-2">
                                <h4 class="card-title">收件人資訊：</h4>
                                <h5 class="card-title">姓名：李小明</h5>
                                <p class="card-text">電話：0912345678</p>
                                <p class="card-text">郵遞區號：407台中市西屯區</p>
                                <p class="card-text">地址：中正路1號</p>
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#staticBackdrop">選擇其他收件人</button>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive-md" style="width: 80%;">
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr class="bg-primary" style="color: white;">
                                    <td width="10%">產品編號</td>
                                    <td width="10%">圖片</td>
                                    <td width="30%">名稱</td>
                                    <td width="15%">價格</td>
                                    <td width="15%">數量</td>
                                    <td width="20%">小計</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($cart_data = $cart_rs->fetch()) { ?>
                                    <tr>
                                        <td><?php echo $cart_data['p_id']; ?></td>
                                        <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                                        <td><?php echo $cart_data['p_name']; ?></td>
                                        <td>
                                            <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price']; ?></h4>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="qty[]" id="qty[]" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>" required>
                                            </div>
                                        </td>
                                        <td>
                                            <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                        </td>
                                    </tr>
                                <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                                } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">累計：<?php echo $ptotal; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7">運費:100</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="color_red">總計：<?php echo $ptotal + 100; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <button type="button" id="btn-04" name="btn-04" class="btn btn-danger">
                                            <i class="fas fa-cart-arrow-down pr-2"></i>確認結帳
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>

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