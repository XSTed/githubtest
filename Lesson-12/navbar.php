<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="images/logo.jpg" class="img-fluid rounded-circle" alt="電商藥粧"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        //讀取後台購物車內產品數量
        $SQLstring="SELECT * FROM cart WHERE orderid IS NULL AND ip='".$_SERVER['REMOTE_ADDR']."'";
        $cart_rs=$link->query($SQLstring);
        ?>
        <?php
        // 列出產品類別第一層
        $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
        $pyclass01 = $link->query($SQLstring);
        ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        產品資訊
                    </a>
                    <ul class="dropdown-menu">
                        <?php while ($pyclass01_Rows = $pyclass01->fetch()) { ?>

                            <li class="nav-item dropend">
                                <a class="dropdown-item dropdown-toggle" href="#"><i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-lg fa-fw"></i><?php echo $pyclass01_Rows['cname']; ?></a>
                                <?php
                                // 列出產品類別第二層
                                $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 and uplink=%d order by sort", $pyclass01_Rows['classid']);
                                $pyclass02 = $link->query($SQLstring);
                                ?>
                                <ul class="dropdown-menu">
                                    <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                                        <li><a href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>" class="dropdown-item">
                                                <em class="fas <?php echo $pyclass02_Rows['fonticon']; ?> fa-fw"></em><?php echo $pyclass02_Rows['cname']; ?>
                                            <?php } ?>
                                            </a>
                                        </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">會員註冊</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">會員登入</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">會員中心</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">最新活動</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">查訂單</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">折價券</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">購物車<span class="badge text-bg-info"><?php echo ($cart_rs) ? $cart_rs->rowCount() : ''; ?></span></a>
                </li>

                <!-- 使用PHP函數外加類別功能 -->
                <?php multiList01(); ?>
            </ul>
        </div>
    </div>
</nav>
<?php
function multiList01()
{
    global $link;
    // 列出產品類別第一層
    $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
    $pyclass01 = $link->query($SQLstring);
?>
    <?php while ($pyclass01_Rows = $pyclass01->fetch()) { ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $pyclass01_Rows['cname']; ?></a>
            <ul class="dropdown-menu">
                <?php
                // 列出產品類別第二層
                $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 and uplink=%d order by sort", $pyclass01_Rows['classid']);
                $pyclass02 = $link->query($SQLstring);
                ?>
                <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                    <li><a class="dropdown-item" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>">
                            <em class="fas <?php echo $pyclass02_Rows['fonticon']; ?>"></em><?php echo $pyclass02_Rows['cname']; ?>
                        </a></li>
                <?php } ?>

            </ul>
        </li>
    <?php } ?>
<?php } ?>