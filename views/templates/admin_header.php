<?php 
    $_SESSION['admin-page'] = $_GET[0];
?>
<link rel="stylesheet" type="text/css" href="./content/css/admin_header.css" />
<input type="checkbox" id="nav-toggle">
<header id="header">
    <div class="admin-sidebar">
        <div class="sidebar-logo">
            <a href="?page=home">
                <img src="./content/img/logo.png" alt="Xshop Logo" />
            </a>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="sidebar__item">
                    <a href="?page=product" class="sidebar__card" id="product" data-active='true'>Hàng Hóa</a>
                </li>
                <li class="sidebar__item">
                    <a href="?page=category" class="sidebar__card" id="category" data-active='false'>Loại Hàng</a>
                </li>
                <li class="sidebar__item">
                    <a href="?page=customer" class="sidebar__card" id="customer" data-active='false'>Khách Hàng</a>
                </li>
                <li class="sidebar__item">
                    <a href="?page=comment" class="sidebar__card" id="comment" data-active='false'>Bình Luận</a>
                </li>
                <li class="sidebar__item">
                    <a href="?page=statistic" class="sidebar__card" id="statistic" data-active='false'>Thống Kê</a>
                </li>
            </ul>
        </div>
    </div>
    <nav class="nav">
        <div class="mx-auto grid nav__container pos-r my-2">
            <div class="page-title-container flex">
                <label for="nav-toggle">
                    <i class="fas fa-bars nav__btn__icon"></i>
                </label>              
                <span class="page-title">Hàng Hóa</span>
            </div>
            <div class="nav__menu flex">
                <div class="wrapper">
                    <button data-collapse-toggle="mobile-menu" type="button" class="nav__btn btn btn--primary-a" aria-controls="mobile-menu" aria-expanded="false">
                        <i class="fas fa-user nav__btn__icon"></i>
                    </button>                    
                    <div class="nav__dropdown fadeIn ts-2 hidden" id="dd-2">
                        <ul class="nav__list">
                            <div class="nav__menu__user__avatar">
                                <img src="<?= $_SESSION['avatar'] ?? './content/img/default-' . rand(1, 4) . '.webp' ?>" class="img-fluid user-avatar" alt="User Avatar" />
                            </div>
                            <div class="nav__menu__user__name">
                                <p><?= $_SESSION['username'] ?></p>
                            </div>
                            <li class="nav__item">
                                <a href="?page=profile" class="nav__link nav__link--main block">Cập nhật tài khoản</a>
                            </li>
                            <li class="nav__item">
                                <a href="?page=product" class="nav__link nav__link--main block">Quản trị website</a>
                            </li>
                            <li class="nav__item t-center">
                                <a href="?page=logout" class="nav__link nav__link--main block theme--dark">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>                 
                </div>
            </div>
        </div>
    </nav>

</header>

