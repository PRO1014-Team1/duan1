<input type="checkbox" id="nav-toggle">
<header id="header">
    <div class="admin-sidebar">
        <div class="sidebar-logo">
            <a href="home">
                <img src="public/img/logo.png" alt="Logo" class="img-fluid" />
            </a>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="sidebar__item">
                    <a href="dashboard" class="sidebar__card" id="dashboard" data-active='false'>
                        <i class="fas fa-clipboard">&nbsp;</i>
                        <span>Dashboard</span>
                    </a>
                <li class="sidebar__item">
                    <div class="divider"></div>
                </li>
                <li class="sidebar__item">
                    <a href="product" class="sidebar__card" id="product" data-active='false'>
                        <i class="fa fa-shopping-bag">&nbsp;</i>
                        <span>Hàng Hóa</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="category" class="sidebar__card" id="category" data-active='false'>
                        <i class="fas fa-boxes">&nbsp;</i>
                        <span>Loại Hàng</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="customer" class="sidebar__card" id="customer" data-active='false'>
                        <i class="fa fa-users">&nbsp;</i>
                        <span>Khách Hàng</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="comment" class="sidebar__card" id="comment" data-active='false'>
                        <i class="fa fa-comments">&nbsp;</i>
                        <span>Bình Luận</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="order" class="sidebar__card" id="order" data-active='false'>
                        <i class="fas fa-file-invoice">&nbsp;</i>
                        <span>Đơn Hàng</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <nav class="nav">
        <div class="mx-auto grid nav__container pos-r my-2">
            <div class="page-title-container flex">
                <label for="nav-toggle">
                    <!-- <i class="fas fa-bars nav__btn__icon"></i> -->
                    <div class="con">
                        <div class="bar arrow-top-r"></div>
                        <div class="bar arrow-middle-r"></div>
                        <div class="bar arrow-bottom-r"></div>
                    </div>
                </label>
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
                </div>
            </div>
        </div>
    </nav>

</header>