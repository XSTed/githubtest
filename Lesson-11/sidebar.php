<div class="sidebar">
    <form name="search" id="search" action="" method="get">
        <div class="input-group">
            <input type="text" name="search_name" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <i class="fas fa-search fa-lg"></i>
                </button>
            </span>
        </div>
    </form>
</div>
<?php
// 列出產品類別第一層
$SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
$pyclass01 = $link->query($SQLstring);
$i = 1; //控制編號順序
?>
<div class="accordion" id="accordionExample">
    <?php while ($pyclass01_Rows = $pyclass01->fetch()) { ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                    <i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-lg fa-fw"></i><?php echo $pyclass01_Rows['cname']; ?>
                </button>
            </h2>
            <?php
            // 列出產品類別第二層
            $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 and uplink=%d order by sort", $pyclass01_Rows['classid']);
            $pyclass02 = $link->query($SQLstring);
            ?>
            <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == 1) ? 'show' : ''; ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table">
                        <tbody>
                            <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                                <tr>
                                    <td><em class="fas <?php echo $pyclass02_Rows['fonticon']; ?>"></em><a href="#"><?php echo $pyclass02_Rows['cname']; ?></a></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php $i++;
    } ?>
</div>