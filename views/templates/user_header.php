<link rel="stylesheet" type="text/css" href="./public/css/header.css" />
<header id="header">
    <nav class="nav">
        <div class="mx-auto grid nav__container w-100">
            <a href="home" class="nav__logo block">
                <img src="./public/img/logo.png" class="img-fluid" alt="Xshop Logo" />
            </a>
            <div class="nav__menu flex">
                <div class="wrapper">
                    <button data-collapse-toggle="mobile-menu" type="button" class="nav__btn btn" aria-controls="mobile-menu" aria-expanded="false">
                        <i class="fas fa-user nav__btn__icon text-dark"></i>
                    </button>
                    <!-- if user logged in, display a different menu -->
                    <?php if (get_role() == 0) : ?>
                        <div class="nav__dropdown fadeIn ts-2 hidden" id="dd-2">
                            <ul class="nav__list">
                                <div class="nav__menu__user__avatar">
                                    <img src="<?= $_SESSION['avatar'] ?>" class="img-fluid user-avatar" alt="User Avatar" />
                                </div>
                                <div class="nav__menu__user__name">
                                    <p class="text-dark"><?= get_username() ?></p>
                                </div>
                                <li class="nav__item">
                                    <a href="profile" class="nav__link nav__link--main block link-dark text-dark">Cập nhật tài khoản</a>
                                </li>
                                <li class="nav__item t-center">
                                    <a href="logout" class="nav__link nav__link--main block theme--dark">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                        <!-- admin -->
                    <?php elseif (get_role() == 1) : ?>
                        <div class="nav__dropdown fadeIn ts-2 hidden" id="dd-2">
                            <ul class="nav__list">
                                <div class="nav__menu__user__avatar">
                                    <img src="<?= $_SESSION['avatar'] ?? './public/img/default-' . rand(1, 4) . '.webp' ?>" class="img-fluid user-avatar" alt="User Avatar" />
                                </div>
                                <div class="nav__menu__user__name">
                                    <p><?= get_username() ?></p>
                                </div>
                                <li class="nav__item">
                                    <a href="profile" class="nav__link nav__link--main block">Cập nhật tài khoản</a>
                                </li>
                                <li class="nav__item">
                                    <a href="product" class="nav__link nav__link--main block">Quản trị website</a>
                                </li>
                                <li class="nav__item t-center">
                                    <a href="logout" class="nav__link nav__link--main block theme--dark">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                        <!-- menu mặc định -->
                    <?php else : ?>
                        <div class="nav__dropdown fadeIn ts-2 hidden" id="dd-2">
                            <ul class="nav__list">
                                <li class="nav__item">
                                    <a href="#" class="nav__link nav__link--main block">Quên mật khẩu</a>
                                </li>
                                <li class="nav__item">
                                    <a href="register" class="nav__link nav__link--main block">Đăng ký tài khoản</a>
                                </li>
                                <li class="nav__item t-center">
                                    <a href="login" class="nav__link nav__link--main block theme--dark">Đăng nhập</a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Giỏ hàng -->
                <div class="wrapper">
                    <?php
                    $cart_total = count($_SESSION['cart'] ?? []);
                    ?>
                    <!-- giấu icon giỏ hàng nếu không phải là user -->
                    <?php if (get_role() == 0) : ?>
                        <button data-collapse-toggle="mobile-menu" type="button" class="nav__btn btn" aria-controls="mobile-menu" aria-expanded="false">
                            <i class="fas fa-shopping-cart nav__btn__icon text-dark"><span class="amount"><?= $cart_total ?></span></i>
                        </button>
                    <?php endif; ?>
                    <div class="nav__dropdown fadeIn ts-2 hidden" id="dd-1">
                        <ul class="nav__list">
                            <?php if ($cart_total) : ?>
                                <?php foreach ($_SESSION['cart'] as $cart_item) : ?>
                                    <?php
                                    $product = get_product($cart_item['id'])[0];
                                    $type = get_type_data($product['product_id']);
                                    ?>
                                    <li class="nav__item">
                                        <div class="nav__link nav__link--main flex">
                                            <img class="thumbnail" src="<?= $product['image'] ?>">
                                            <div class="nav__link__wrapper">
                                                <span>x <?= $cart_item['quantity'] ?></span>
                                                <p><?= $product['name'] ?></p>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <li class="nav__link nav__link--main cart-detail bg-dark">
                                <a href="cart" class="link-light text-light">
                                    Xem chi tiết giỏ hàng &nbsp;<i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="wrapper">
                    <button data-collapse-toggle="mobile-menu" type="button" class="nav__btn btn" aria-controls="mobile-menu" aria-expanded="false">
                        <i class="fas fa-bars nav__btn__icon text-dark"></i>
                    </button>
                    <div class="nav__dropdown fadeIn ts-2 hidden" id="dd-3">
                        <ul class="nav__list">
                            <li class="nav__item">
                                <a href="home" class="nav__link nav__link--main block text-dark">Trang Chủ</a>
                            </li>
                            <li class="nav__item">
                                <a href="new    s" class="nav__link nav__link--main block text-dark">Tin Tức</a>
                            </li>
                            <li class="nav__item">
                                <a href="#" class="nav__link nav__link--main block text-dark">Giới Thiệu</a>
                            </li>
                            <li class="nav__item">
                                <a href="#" class="nav__link nav__link--main block text-dark">Liên Hệ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>