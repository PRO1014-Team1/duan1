<?php
// get this month's orders
[$orders_prev_order, $orders_cur_order] = get_order_range($_POST['orders-order-by'] ?? 'week');
[$users_prev_order, $users_cur_order] = get_customer_range($_POST['users-order-by'] ?? 'week');
[$products_prev_order, $products_cur_order] = get_product_range($_POST['products-order-by'] ?? 'week');
[$income_prev_order, $income_cur_order] = get_order_detail_range($_POST['income-order-by'] ?? 'week');

?>
<script>
    const income_data_cur = <?= json_encode($income_cur_order) ?>;
    const income_time = <?= json_encode($_POST['income-order-by'] ?? 'week') ?>;
</script>
<div class="container">
    <h1 class="title">
        Dashboard
    </h1>
    <div class="top-cards grid">
        <div class="card order-card">
            <div class="card-body">
                <h5 class="card-title">Đơn đặt hàng</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= count($orders_cur_order) ?>&nbsp;<i class="fas fa-clipboard-list"></i></span></h6>
                <div class="card-body__wrapper flex">
                    <?php if (($order_percentage = (count($orders_cur_order) ?? 1 / count($orders_prev_order) ?? 1) * 100) > 0) : ?>
                        <p class="card-text text-success">
                            <i class="fas fa-caret-up"></i>
                            <?= round($order_percentage, 2) ?>%
                        </p>
                    <?php else : ?>
                        <p class="card-text text-danger">
                            <i class="fas fa-caret-down"></i>
                            &nbsp;<?= round($order_percentage, 2) ?>%
                        </p>
                    <?php endif; ?>
                    <form method="POST" class="orders-order-by">
                        <input type="hidden" name="order_percent" class="order-percent" value="<?= $order_percentage ?>">
                        <div class="form-group">
                            <select class="form-control" id="order_by" name="orders-order-by" onchange="submit()">
                                <option value="week" <?= isset($_POST['orders-order-by']) && $_POST['orders-order-by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                                <option value="month" <?= isset($_POST['orders-order-by']) && $_POST['orders-order-by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                                <option value="year" <?= isset($_POST['orders-order-by']) && $_POST['orders-order-by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                                <option value="all" <?= isset($_POST['orders-order-by']) && $_POST['orders-order-by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card user-card">
            <div class="card-body">
                <h5 class="card-title">Người dùng mới</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= count($users_cur_order) ?>&nbsp;<i class="fas fa-users"></i></span></h6>
                <div class="card-body__wrapper flex">
                    <?php if (($user_percentage = (count($users_cur_order) ?? 1 / count($users_prev_order) ?? 1) * 100) > 0) : ?>
                        <p class="card-text text-success">
                            <i class="fas fa-caret-up"></i>
                            <?= round($user_percentage, 2) ?>%
                        </p>
                    <?php else : ?>
                        <p class="card-text text-danger">
                            <i class="fas fa-caret-down"></i>
                            &nbsp;<?= round($user_percentage, 2) ?>%
                        </p>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="order_percent" class="order-percent" value="<?= $user_percentage ?>">
                        <select class="form-control" id="order_by" name="users-order-by" onchange="submit()">
                            <option value="week" <?= isset($_POST['users-order-by']) && $_POST['users-order-by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                            <option value="month" <?= isset($_POST['users-order-by']) && $_POST['users-order-by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                            <option value="year" <?= isset($_POST['users-order-by']) && $_POST['users-order-by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                            <option value="all" <?= isset($_POST['users-order-by']) && $_POST['users-order-by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="card product-card">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm mới</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= count($products_cur_order) ?>&nbsp;<i class="fas fa-boxes"></i></i></span></h6>
                <div class="card-body__wrapper flex">
                    <?php if (($product_percentage = (count($products_cur_order) ?? 1 / count($products_prev_order) ?? 1) * 100) > 0) : ?>
                        <p class="card-text text-success">
                            <i class="fas fa-caret-up"></i>
                            <?= round($product_percentage, 2) ?>%
                        </p>
                    <?php else : ?>
                        <p class="card-text text-danger">
                            <i class="fas fa-caret-down"></i>
                            &nbsp;<?= round($product_percentage, 2) ?>%
                        </p>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="order_percent" class="order-percent" value="<?= $product_percentage ?>">
                        <!-- switch case order_by -->
                        <select class="form-control" id="order_by" name="products-order-by" onchange="submit()">
                            <option value="week" <?= isset($_POST['products-order-by']) && $_POST['products-order-by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                            <option value="month" <?= isset($_POST['products-order-by']) && $_POST['products-order-by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                            <option value="year" <?= isset($_POST['products-order-by']) && $_POST['products-order-by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                            <option value="all" <?= isset($_POST['products-order-by']) && $_POST['products-order-by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mid-cards">
        <div class="mid-cards__wrapper grid">
            <div class="card">
                <form method="POST" class="sale-order-by flex">
                    <h5 class="card-title">Thống kê doanh thu
                        <select class="form-control" id="order_by" name="income-order-by" onchange="submit()">
                            <option value="week" <?= isset($_POST['income-order-by']) && $_POST['income-order-by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                            <option value="month" <?= isset($_POST['income-order-by']) && $_POST['income-order-by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                            <option value="year" <?= isset($_POST['income-order-by']) && $_POST['income-order-by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                            <option value="all" <?= isset($_POST['income-order-by']) && $_POST['income-order-by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                        </select>
                    </h5>
                    <span class="total">
                        <!-- <?= asvnd(array_sum(array_flatten($products))) ?> -->
                    </span>
                </form>
                <div class="chart">
                    <canvas id="sale-chart"></canvas>
                </div>
            </div>
            <div class="card">
                <form method="POST" class="variant-order-by flex">
                    <h5 class="card-title">Loại hàng bán chạy
                        <!-- switch case order_by -->
                        <select class="form-control" id="order_by" name="order_by" onchange="submit()">
                            <option value="week" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                            <option value="month" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                            <option value="year" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                            <option value="all" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                        </select>
                    </h5>
                </form>
                <div class="chart">
                    <canvas id="variant-chart"></canvas>
                </div>
                <div class="card-info theme--dark">
                    <div class="card-info__wrapper flex">
                        <!-- top selling category -->
                        <div class="card-info__item">
                            <h6 class="card-info__title">Danh mục ưa chuộng:</h6>
                        </div>
                        <p class="card-text">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-cards">
        <div class="bottom-cards__wrapper grid">
            <div class="card">
                <h5 class="card-title">Sản phẩm bán chạy</h5>
                <div class="chart">
                    <canvas id="product-chart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>