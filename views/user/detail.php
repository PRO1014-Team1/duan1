<?php

//add view
if (isset($_SESSION['username'])) {
    add_view($_GET['id']);
}
if (isset($_POST['comment'])) {
    if (!isset($_SESSION['username'])) {
        echo '<script>alert("Bạn phải đăng nhập để bình luận!");</script>';
    } else {
        $content = $_POST['content'];
        $date = date('Y-m-d H:i:s');
        $username = $_SESSION['username'];
        $product_id = $_GET['id'];
        pdo_query_once("INSERT INTO `comment` (`content`, `date`, `username`, `product_id`) VALUES (?, ?, ?, ?)", [$content, $date, $username, $product_id]);
        redirect('detail?id=' . $product_id . '&category=' . $_GET['category']);
    }
}

?>

<div class="container">
    <main class="product-hero grid mx-auto">
        <div class="product-hero__image">
            <img class="img-fluid" src="<?php echo $product[0]['image'] ?>" alt="">
        </div>
        <div class="product-hero__info theme--primary">
            <h1><?= $product[0]['name'] ?></h1></span>
            <p class="product-hero__price">$<?= $product[0]['price'] ?></p>
            <p class="product-hero__id"> Mã: <?= $product[0]['product_id'] ?></p>
            <div class="product-hero__view">
                <div data-tooltip="Lượt xem" class="product-hero__view-item tooltip">
                    <span class="product-hero__view-item-icon">
                        <i class="fas fa-eye"></i>
                    </span>
                    <span class="product-hero__view-item-text">
                        <?= number_shorten($view) ?>
                    </span>
                </div>
                <div data-tooltip="Lượt bình luận" class="product-hero__view-item tooltip">
                    <span class="product-hero__view-item-icon">
                        <i class="fas fa-comment-alt"></i>
                    </span>
                    <span class="product-hero__view-item-text">
                        <?= number_shorten($comment_count) ?>
                    </span>
                </div>
            </div>
            <p class="product-hero__desc"><?= $product[0]['description'] ?></p>
            <div class="btn-back btn">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i>
                    <span>Trở về</span>
                </a>
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