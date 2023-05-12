<?php
//建立熱銷商品資料查詢
$SQLstring = "SELECT * FROM hot,product,product_img WHERE hot.p_id=product_img.p_id AND hot.p_id=product.p_id AND product_img.sort=1 ORDER BY h_sort";
$hot = $link->query($SQLstring);
?>
<div class="card text-center mt-3" style="border: none;">
    <div class="card-body">
        <h3 class="card-title">站長推薦，熱銷商品</h3>
    </div>
    <?php while ($data = $hot->fetch()) { ?>
        <a href="goods.php?p_id=<?php echo $data['p_id']; ?>">
            <img src="product_img/<?php echo $data['img_file']; ?>" class="card-img-top" alt="HOT<?php echo $data['h_sort']; ?>" title="<?php echo $data['p_name']; ?>">
        </a>
    <?php } ?>
</div>