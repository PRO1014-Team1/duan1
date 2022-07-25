<?php


if ($cart = $_POST['cart-id'] ?? false) {
    if (!isset($_SESSION['username'])) {
        alert("Bạn cần phải đăng nhập để sử dụng chức năng này!");
    } else {
        alert("Thêm vào giỏ hàng thành công!");
        $added_product = $_SESSION['cart'][$cart] ?? false;
        //nếu đã có trong giỏ hàng thì + thêm số lượng
        if ($added_product) {
            $_SESSION['cart'][$cart]['quantity']++;
        } else {
            $_SESSION['cart'][$cart] = [
                "id" => $_POST['cart-id'],
                "user" => $_SESSION['username'],
                "status" => "pending",
                "quantity" => 1,
            ];
        }
        redirect("home");
    }
}

if ($sort) {
    [$sortBy, $order] = explode(" ", $sort);
    $products = item_sort($products, $sortBy, $order);
}
if (strcmp($category_filter, "all")) {
    $products = item_filter($products, "category_id", $category_filter);
}
[$pageno, $total_pages, $display_items] = pagination($_POST['pageno'] ?? 1, $search, $products);
?>
<div class="container">
    <div class="banner-container">
        <div class="row grid mx-auto">
            <div class="col col-10-6 grid m-2">
                <!-- banner -->
                <div class="slider">
                    <div class="slide">
                        <img class="img-fluid slide__img" src="public/img/bna.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img class="img-fluid slide__img" src="public/img/bne.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img class="img-fluid slide__img" src="public/img/bnc.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img class="img-fluid slide__img" src="public/img/bnd.jpg" alt="" />
                    </div>


                    <div class="slide__indicator">
                        <ul class="flex indicator-list">
                            <li class="slide__indicator__item"></li>
                            <li class="slide__indicator__item"></li>
                            <li class="slide__indicator__item"></li>
                            <li class="slide__indicator__item"></li>
                        </ul>
                    </div>
                </div>
                <!-- end banner -->
            </div>
            <div class="col col-2-2 grid">
                <!-- top 4 products -->
                <?php foreach ($popular_products_top_4 as $top_4_product) { ?>
                    <div class="top-4-prod">
                        <a href="detail?id=<?= $top_4_product["product_id"] ?>&category=<?= $top_4_product["category_id"] ?>" class="hover-mask" data-content="<?= $top_4_product["name"] ?>">
                            <img class="img-fluid top-4-prod__img" src="<?= $top_4_product["image"] ?>" alt="<?= $top_4_product["name"] ?>" />
                        </a>
                    </div>
                <?php } ?>
                <!-- end top 4 products -->
            </div>
        </div>
    </div>
    <main class="main-container">
        <div class="row grid mx-auto">
            <aside class="col side-menu">
                <!-- category list -->
                <div class="category">
                    <h2 class="title">Danh mục</h2>

                    <!-- dùng form radio làm danh sách danh mục -->
                    <form action="" method="GET" class="category-list">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="all" value="all" onclick="javascript: submit()" <?php echo $category_filter     == "all" ? "checked" : ""; ?>>
                            <label class="form-check-label" for="all">Tất cả - <span><?= $product_count ?></span></label>
                        </div>
                        <?php foreach ($categories as $category) { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id=<?= $category["id"] ?> value=<?= $category["id"] ?> onclick="javascript: submit()" <?php echo $category_filter == $category["id"] ? "checked" : ""; ?>>
                                <label class="form-check-label" for=<?= $category["id"] ?>><?= $category["name"] ?> - <span><?= $category["count"] ?></span></label>
                            </div>
                        <?php } ?>
                        <div class="divider divider-50"></div>
                        <div class="form-filter grid">
                            <input type="hidden" id="refreshed" value="no">
                            <button>
                                <i class="fas fa-search"></i>
                            </button>
                            <input type="text" name="search" class="form-control form-filter__input" placeholder="Tìm kiếm sản phẩm">
                        </div>
                        <div class="form-filter grid">
                            <button>
                                <i class="fas fa-sort"></i>
                            </button>
                            <select name="sort" id="sort" class="form-control form-filter__input form-sort" onchange="javascript: submit()">
                                <option value=""></option>
                                <option value="price 1">Giá cao đến thấp</option>
                                <option value="price 0">Giá thấp đến cao</option>
                            </select>
                        </div>
                    </form>
                </div>
                <!-- end category list -->

                <!-- top 10 product list -->
                <div class="top-10-prod">
                    <h2 class="title">Top 10 ưa chuộng</h2>
                    <div class="top-10-prod__list col-2-2 grid ">
                        <?php foreach ($popular_products_top_10 as $top_10_product) { ?>
                            <div class="top-10-prod__item">
                                <a href="detail?id=<?= $top_10_product["product_id"] ?>&category=<?= $top_10_product["category_id"] ?>" class="hover-mask" data-content="<?= $top_10_product["name"] ?>">
                                    <img class="img-fluid top-10-prod__img" src="<?= $top_10_product["image"] ?>" alt="<?= $top_10_product["name"] ?>" />
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- end top 10 product list -->
            </aside>
            <section class="col">
                <div class="title prod-showcase__title">
                    <h1>
                        Sản phẩm
                    </h1>
                </div>
                <div class="prod-showcase grid">
                    <!-- main product showcase  -->
                    <?php foreach ($display_items as $prod) { ?>
                        <?php
                        $view = get_view($prod["product_id"]);
                        $type_arr = get_type_data($prod["product_id"]);
                        $comment = get_comment_count("`product_id` = {$prod['product_id']}");

                        if ($type_arr) {
                            $type_data = $type_arr[0];
                            $price = $type_data["price"];
                            $discount = discount($type_data["price"], $type_data['sale']);
                            $quantity = $type_data["quantity"];
                        }


                        ?>
                        <div class="prod-item">
                            <a href="detail?id=<?= $prod['product_id'] ?>&category=<?= $prod['category_id'] ?>" class="prod-link">
                                <div class="text-wrapper theme--dark">
                                    <h3 class="prod-item__name truncate"><?= $prod["name"] ?></h3>
                                </div>
                                <div class="prod-item__img-wrapper">
                                    <img class="img-fluid prod-item__img" src="<?= $prod["image"] ?>" alt="" />
                                    <?php if (isset($type_data)) : ?>
                                        <span class="prod-item__price <?= $discount ? 'scratched' : '' ?> "><?= asvnd($price) ?></span>
                                        <?php if ($discount) : ?>
                                            <span class="prod-item__discount"><?= asvnd($discount) ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="widget">
                                        <form method="POST" class="cart-submit">
                                            <input type="hidden" name="cart-id" value="<?= $prod['product_id'] ?>">
                                            <button class="cart-action"><i class="fas fa-shopping-cart prod-item__cart prod-item__icon"></i></button>
                                            <button class="cart-action__confirm hidden"></button>
                                        </form>
                                        <i class="fas fa-eye prod-item__view prod-item__icon">
                                            <span><?= $view; ?></span>
                                        </i>
                                        <i class="fas fa-comment prod-item__comment prod-item__icon">
                                            <span><?= $comment; ?></span>
                                        </i>
                                        <i class="fas fa-star prod-item__rating prod-item__icon">
                                            <span>1</span>
                                        </i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <!-- end main product showcase -->
                <div class="pagination flex mx-auto">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <form action="" method="POST" class="pagination-form">
                            <input type="hidden" name="pageno" value="<?= $i ?>">
                            <button type="submit" class="pagination__link btn btn--primary-o <?= $i == $pageno ? "pagination__link--active" : "" ?> ">
                                <?= $i ?>
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>
</div>