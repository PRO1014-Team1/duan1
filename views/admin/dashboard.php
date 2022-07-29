<?php
// get this month's orders
$prev_order = [];
$cur_order = [];
$order_by = $_POST['order_by'] ?? 'month';

switch ($order_by) {
    case 'week':
        $prev_order = get_order_by_date(date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime('-1 day')));
        $cur_order = get_order_by_date(date('Y-m-d', strtotime('-1 day')), date('Y-m-d'));
        break;
    case 'month':
        $cur_order = get_order_by_date(date('Y-m-01'));
        $prev_order = get_order_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
        break;
    case 'year':
        $cur_order = get_order_by_date(date('Y-01-01'), date('Y-12-31'));
        $prev_order = get_order_by_date(date('Y-01-01', strtotime('-1 year')), date('Y-12-31', strtotime('-1 year')));
        var_dump(count($prev_order));
        break;
    case 'all':
        $cur_order = get_order_by_date();
        $prev_order = get_order_by_date();
        break;
    default:
        $cur_order = get_order_by_date(date('Y-m-01'), date('Y-m-t'));
        $prev_order = get_order_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
        break;
}


?>
<div class="container">
    <h1 class="title">
        Dashboard
    </h1>
    <div class="top-cards grid">
        <div class="card order-card">
            <div class="card-body">
                <h5 class="card-title">Đơn đặt hàng</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= count($cur_order) ?>&nbsp;<i class="fas fa-clipboard-list"></i></span></h6>
                <div class="card-body__wrapper flex">
                    <?php if (($percent = (count($cur_order) ?? 1 / count($prev_order) ?? 1) * 100) > 0) : ?>
                        <p class="card-text text-success">
                            <i class="fas fa-caret-up"></i>
                            <?= round($percent, 2) ?>%
                        </p>
                    <?php else : ?>
                        <p class="card-text text-danger">
                            <i class="fas fa-caret-down"></i>
                            &nbsp;<?= round($percent, 2) ?>%
                        </p>
                        ?>
                    <?php endif; ?>
                    <form method="POST" class="orders-order-by">
                        <input type="hidden" name="order_percent" class="order-percent" value="<?= $percent ?>">
                        <!-- switch case order_by -->
                        <div class="form-group">
                            <select class="form-control" id="order_by" name="order_by" onchange="submit()">
                                <option value="week" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                                <option value="month" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                                <option value="year" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                                <option value="all" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card user-card">
            <div class="card-body">
                <h5 class="card-title">Người dùng mới</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= count($cur_order) ?>&nbsp;<i class="fas fa-users"></i></span></h6>
                <div class="card-body__wrapper flex">
                    <?php if (($percent = (count($cur_order) ?? 1 / count($prev_order) ?? 1) * 100) > 0) : ?>
                        <p class="card-text text-success">
                            <i class="fas fa-caret-up"></i>
                            <?= round($percent, 2) ?>%
                        </p>
                    <?php else : ?>
                        <p class="card-text text-danger">
                            <i class="fas fa-caret-down"></i>
                            &nbsp;<?= round($percent, 2) ?>%
                        </p>
                        ?>
                    <?php endif; ?>
                    <form method="POST" class="orders-order-by">
                        <input type="hidden" name="order_percent" class="order-percent" value="<?= $percent ?>">
                        <!-- switch case order_by -->
                        <div class="form-group">
                            <select class="form-control" id="order_by" name="order_by" onchange="submit()">
                                <option value="week" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                                <option value="month" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                                <option value="year" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                                <option value="all" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card product-card">
            <div class="card-body">
                <h5 class="card-title">Người dùng mới</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= count($cur_order) ?>&nbsp;<i class="fas fa-boxes"></i></i></span></h6>
                <div class="card-body__wrapper flex">
                    <?php if (($percent = (count($cur_order) ?? 1 / count($prev_order) ?? 1) * 100) > 0) : ?>
                        <p class="card-text text-success">
                            <i class="fas fa-caret-up"></i>
                            <?= round($percent, 2) ?>%
                        </p>
                    <?php else : ?>
                        <p class="card-text text-danger">
                            <i class="fas fa-caret-down"></i>
                            &nbsp;<?= round($percent, 2) ?>%
                        </p>
                        ?>
                    <?php endif; ?>
                    <form method="POST" class="orders-order-by">
                        <input type="hidden" name="order_percent" class="order-percent" value="<?= $percent ?>">
                        <!-- switch case order_by -->
                        <div class="form-group">
                            <select class="form-control" id="order_by" name="order_by" onchange="submit()">
                                <option value="week" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'week' ? 'selected' : '' ?>>trong tuần này</option>
                                <option value="month" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'month' ? 'selected' : '' ?>>trong tháng này</option>
                                <option value="year" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'year' ? 'selected' : '' ?>>trong năm nay</option>
                                <option value="all" <?= isset($_POST['order_by']) && $_POST['order_by'] == 'all' ? 'selected' : '' ?>>tổng</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mid-cards">
        <div class="mid-cards__wrapper grid">
            <div class="card">
                <h5 class="card-title">Thông kê lợi nhuận</h5>
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
            </div>
        </div>
    </div>