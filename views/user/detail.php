<?php
$types = get_type_data($_GET['id']);
//add view
if ($username = get_username()) {
    add_view($_GET['id']);
}
if (isset($_POST['comment'])) {
    if ($username) {
        echo '<script>alert("Bạn phải đăng nhập để bình luận!");</script>';
    } else {
        $content = $_POST['content'];
        $date = date('Y-m-d H:i:s');
        $username = $_SESSION['username'];
        $product_id = $_GET['id'];
        pdo_execute("INSERT INTO `comment` (`content`, `date`, `username`, `product_id`) VALUES (?, ?, ?, ?)", [$content, $date, $username, $product_id]);
        redirect('detail?id=' . $product_id . '&category=' . $_GET['category']);
    }
}

?>

<div class="container">
    <a href="/" class="return">
        <i class="fas fa-chevron-left">&nbsp;</i>
        <span>Trở về</span>
    </a>
    <main class="product-hero grid mx-auto">
        <div class="product-hero__image">
            <img class="" src="<?php echo $product['image'] ?>" alt="">
        </div>
        <div class="product-hero__info">
            <span class="product-hero__author"><?= $product['author'] ?></span>
            <h1><?= $product['name'] ?></h1></span>
            <div class="product-hero__info__badges flex">
                <div class="product__badges product-rating">
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <i class="fas fa-star"></i>
                    <?php } ?>
                    <span class="disabled">&nbsp;(<?= number_shorten(12042) ?>)</span>
                </div>
                <div class="product__badges product-view">
                    <i class="fas fa-eye"></i>
                    <span class="disabled">&nbsp;(<?= $product['view'] ?>)</span>
                </div>
                <div class="product__badges product-view">
                    <i class="fas fa-comment-alt"></i>
                    <span class="disabled">&nbsp;(<?= $comment_count ?>)</span>
                </div>
            </div>
            <div class="switch-variant">
                <div class="switch-variant__item">
                    <div class="switch-variant__item__content flex">
                        <?php foreach ($types as $type) { ?>
                            <div class="switch-variant__item__content__item variant-btn flex">
                                <input type="button" class="variant-name" name="color" id="<?= $type['type_id'] ?>" value="<?= get_type_name($type['type_id']) ?>">
                                <span class="variant-price"><?= asvnd($type['price']) ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p class="product-hero__desc"><?= $product['description'] ?></p>

        </div>
</div>
</main>
<div class="other-section grid mx-auto">
    <div class="col comment-section">
        <div class="title"> Bình luận: <span class="comment-count">(<?= number_shorten($comment_count) ?>)</span> </div>
        <div class="commit-section__content">
            <form action="" METHOD="POST" class="commit-section__content__form grid mx-auto">
                <input type="hidden" name="comment" value="true">
                <div class="commit-section__content__avatar">
                    <img class="img-fluid" src="<?= $_SESSION['avatar'] ?>" alt="">
                </div>
                <div class="form-group">
                    <textarea name="content" id="" class="form-control border border--line form-comment" placeholder="Nhập nội dung"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn--primary form-comment__submit">Gửi</button>
                </div>
            </form>
            <div class="divider"></div>
            <div class="product-comment">
                <?php foreach ($comments as $cmt) {
                    $user_avatar = pdo_query("SELECT `avatar` FROM `users` WHERE `username` = ?", [$cmt['username']]);
                ?>
                    <div class="product-comment__item grid">
                        <div class="product-comment__item-avatar">
                            <img class="img-fluid" src="<?= $user_avatar[0]['avatar'] ?>" alt="">
                        </div>
                        <div class="product-comment__item-content">
                            <p class="product-comment__item-name"><?= $cmt['username'] ?> <span class="product-comment__item-date"> · <?= $cmt['date'] ?></span></p>

                            <div class="product-comment__item-comment"><?= $cmt['content'] ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="top-9-prod">
            <h2 class="title">Sản phẩm tương tự</h2>
            <div class="top-9-prod__list col-3-3 grid">
                <?php foreach ($top_9_prod as $product) { ?>
                    <div class="top-9-prod__item">
                        <a href="detail&id=<?= $product["product_id"] ?>&category=<?= $product["category_id"] ?>" class="hover-mask" data-content="<?= $product["name"] ?>">
                            <img class="img-fluid top-9-prod__img" src="<?= $product["image"] ?>" alt="<?= $product["name"] ?>" />
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</aside>
</div>