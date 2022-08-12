<?php

if ($type_id) {
    $sql = "SELECT * FROM type_detail WHERE `product_id` = ? AND `type_id` = ?";
    $focus_product = pdo_query_once($sql, [$product_id, $type_id]);
}

if (isset($_POST['checkout']) || isset($_POST['add'])) {
    if (!get_username()) {
        alert("Bạn cần phải đăng nhập để sử dụng chức năng này!");
    } else {
        alert("Thêm vào giỏ hàng thành công!");
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $added_product = $_SESSION['cart'][$cart_id] ?? false;
        // nếu đã có trong giỏ hàng thì + thêm số lượng
        if ($added_product) {
            if ($type_id <= 334) {
                $_SESSION['cart'][$cart_id]['quantity']++;
            }
        } else {
            $_SESSION['cart'][$cart_id] = [
                "id" => $product_id,
                "status" => "pending",
                "quantity" => 1,
                "type_id" => $type_id ?? get_type_data($product_id, $type_id)[0],
            ];
        }
        if ($_POST['checkout'] ?? false) {
            redirect("cart");
        } else {
            redirect("detail?id=$product_id&type=$type_id");
        }
    }
}


//add view
if (!$user) {
    add_view($product_id);
}

if (isset($_POST['comment'])) {
    if (!$user) {
        alert("Bạn phải đăng nhập để bình luận!");
    } else {
        add_comment($user, $product_id, $_POST['content']);
        redirect('detail?id=' . $product_id . '&category=' . $category_id . '#comment');
    }
}

?>

<div class="container">
    <a href="/" class="return">
        <i class="fas fa-chevron-left">&nbsp;</i>
        <span>Trở về</span>
    </a>
    <main class="product-hero grid mx-auto">
        <div class="product-hero__wrapper">
            <div class="product-hero__image">

                <a href="#">
                    <img src="<?= $product['image'] ?>">
                </a>
            </div>
        </div>
        <div class="product-hero__info">
            <span class="product-hero__author"><?= $product['author'] ?></span>
            <h1><?= $product['name'] ?></h1></span>
            <div class="product-hero__info__badges flex">
                <div class="product__badges product-rating">
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <i class="fas fa-star"></i>
                    <?php } ?>
                    <span class="disabled">&nbsp;<?= 4.2 ?></span>
                </div>
                <div class="product__badges product-view">
                    <i class="fas fa-eye"></i>
                    <span class="disabled">&nbsp;<?= $product['view'] ?></span>
                </div>
                <div class="product__badges product-id">
                    <i class="fas fa-id-card"></i>
                    <span class="disabled">&nbsp;<?= $product['product_id'] ?></span>
                </div>
            </div>
            <div class="switch-variant">
                <div class="switch-variant__item">
                    <div class="switch-variant__item__content flex">
                        <?php foreach ($types as $type) { ?>
                            <a class="switch-variant__item__content__item variant-btn flex" href="<?= 'detail?id=' . $product_id . '&category=' . $category_id . '&type_id=' . $type['type_id']; ?>">
                                <span class="variant-name" name="type_id"><?= get_type_name($type['type_id']) ?></span>
                                <span class="variant-price"><?= asvnd($type['price']) ?></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p class="product-hero__desc"><?= $product['description'] ?></p>
            <div class="form-wrapper">
                <form method="POST" class="product-hero__info__button">
                    <button type="submit" name="add" value="true" class="btn btn--primary">
                        <span>Thêm vào giỏ hàng</span>
                    </button>
                    <button type="submit" name="checkout" value="true" class="btn btn--primary">
                        <span>Mua ngay</span>
                    </button>
                </form>
            </div>
        </div>
    </main>
    <section class="product-type-details">
        <div class="title">
            <h2>Chi tiết sản phẩm</h2>
        </div>
        <?php if ($focus_product) : ?>
            <ul class="product-type-details__content flex">
                <li class="product-type-details__content__item flex flex">
                    <span class="block">Giá</span>
                    <i class="fas fa-tag"></i>
                    <span class="block type-detail"><?= asvnd($focus_product['price']) ?></span>
                </li>
                <?php if ($focus_product['sale'] != 0) : ?>
                    <li class="product-type-details__content__item flex">
                        <span class="block">Giảm giá</span>
                        <i class="fas fa-percentage"></i>
                        <span class="block type-detail">-<?= $focus_product['sale'] * 100 ?>%</span>
                    </li>
                <?php endif; ?>
                <?php if ($focus_product['quantity']) : ?>
                    <li class="product-type-details__content__item flex">
                        <span class="block">Số lượng</span>
                        <i class="fas fa-print"></i>
                        <span class="block type-detail"><?= $focus_product['quantity'] ?></span>
                    </li>
                <?php endif; ?>
                <?php if ($focus_product['pages']) : ?>
                    <li class="product-type-details__content__item flex">
                        <span class="block">Số trang</span>
                        <i class="fas fa-layer-group"></i>
                        <span class="block type-detail"><?= $focus_product['pages'] ?></span>
                    </li>
                <?php endif; ?>
                <?php if ($product['publish_date']) : ?>
                    <li class="product-type-details__content__item flex">
                        <span class="block">Ngày xuất bản</span>
                        <i class="fas fa-calendar"></i>
                        <span class="block type-detail"><?= $product['publish_date'] ?></span>
                    </li>
                <?php endif; ?>
                <?php if ($focus_product['dimensions'] ?? $focus_product['file_size']) : ?>
                    <li class="product-type-details__content__item flex">
                        <span class="block">Kích cỡ</span>
                        <i class="fas fa-th-large"></i>
                        <span class="block type-detail"><?= $focus_product['dimensions'] ?? $focus_product['file_size'] ?></span>
                    </li>
                <?php endif; ?>

            </ul>
        <?php endif; ?>
    </section>
    <aside class="other-section grid mx-auto" id="#comment">
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
    </aside>
</div>