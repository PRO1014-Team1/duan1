<?php

[$pageno, $total_pages, $orders] = pagination($_POST['pageno'] ?? 1, $_POST['search'] ?? "", $orders);
$selected = $_POST['selected'] ?? null;
if ($_POST['detail'] ?? false) {
    redirect("order_detail?id={$_POST['detail']}");
}

if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $order['order_status'] = $status;
    $order['updated_date'] = date('Y-m-d H:i:s');
    order_update($id, $order);

    if ($_POST['status'] == 3) {
        $order_detail = get_order_detail($id);
        $order_info = get_user_order(null, $id)[0];
        $user = get_user($order_info['username']);
        foreach ($order_detail as $detail) {
            $product = get_product($detail['product_id']);
            $library_detail = get_library($user['library_id'], $product['product_id'], $detail  ['type_id']);
            if (empty($library_detail)) {
                set_library($user['library_id'], $product['product_id'], $detail['type_id']);
            }
        }
    }
    redirect("order");
}

function status_colorcode($status)
{
    switch ($status) {
        case 0;
            return "text-secondary";
        case 1;
            return "text-warning";
        case 2;
            return "text-info";
        case 3;
            return "text-success";
        case 4;
            return "text-danger";
        default;
            return "text-dark";
    }
}


?>
<div class="container">
    <?php if (isset($_POST['edit'])) : ?>
        <?php
        $order = get_user_order(null, $_POST['edit'])[0];
        ?>
        <form method="post" class="ta-center status-form">
            <input type="hidden" name="id" value="<?= $order['order_id'] ?>">
            <div class="form-group">
                <p>SKU: <?= $order['order_id'] ?></p>
                <label class="block status-label" for="status">Trạng thái đơn hàng :</label>
                <select class="form-control" id="status" name="status">
                    <option value="0" <?= $order['order_status'] == 0 ? "selected" : "" ?>>Chờ xử lý</option>
                    <option value="1" <?= $order['order_status'] == 1 ? "selected" : "" ?>>Đang xử lý</option>
                    <option value="2" <?= $order['order_status'] == 2 ? "selected" : "" ?>>Đang giao hàng</option>
                    <option value="3" <?= $order['order_status'] == 3 ? "selected" : "" ?>>Đã giao hàng</option>
                    <option value="4" <?= $order['order_status'] == 4 ? "selected" : "" ?>>Đã hủy</option>
                </select>
            </div>
            <button type="submit" name="action" value="edit" class="btn btn--primary">Cập nhật</button>
            <button name="action" value="return">
                <a href="order" class="btn btn--primary-o">
                    <i class="fas fa-times">
                        &nbsp;
                    </i>
                    Hủy
                </a>
            </button>
        </form>
    <?php else : ?>
        <main class="table-container">
            <h1 class="title"> Lịch sử thanh toán</h1>
            <form method="post" class="ta-center table-form">
                <table class="table table-striped mx-auto">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Ngày cập nhật</th>
                            <th>Tên người nhận</th>
                            <th>Tên người dùng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th class="ta-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= $order['created_date'] ?></td>
                                <td><?= $order['updated_date'] ?></td>
                                <td><?= $order['first_name'] ?></td>
                                <td><?= $order['username'] ?></td>
                                <td><?= asvnd($order['total_price']) ?></td>
                                <td class="<?= status_colorcode($order['order_status']) ?> fw-bold"><?= translate_status($order['order_status']) ?></td>
                                <td class="ta-center extras">
                                    <div class="wrapper">
                                        <button data-collapse-toggle="mobile-menu" type="button" class="table__options_btn btn btn--primary-a" aria-controls="mobile-menu" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="table__options_dropdown fadeIn ts-2 hidden">
                                            <ul class="flex">
                                                <li>
                                                    <a class="btn btn--primary" href="order-detail-admin?id=<?= $order['order_id'] ?>">Xem</a>
                                                </li>
                                                <li>
                                                    <button type="submit" name="edit" value="<?= $order['order_id'] ?>" class="btn btn--primary">Duyệt</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <div class="row mx-auto">
                        <div class="col table-tools__container">
                            <!-- giấu đi vì nếu xóa sẽ ảnh hưởng tới btn khác? -->
                            <div class="flex btn-tools hidden">
                                <button class="btn btn--primary select_all" name="select_all" value="true" onclick="return false;">Chọn tất cả</button>
                                <button class="btn btn--outline deselect_all" name="select_all" value="false" onclick="return false;">Bỏ chọn tất cả</button>
                                <button name="delete_selected" value="true" class="btn btn--danger" onClick="javascript:return confirm('Bạn có muốn xóa các sản phẩm đã chọn?');">Xóa đã chọn</button>
                                <a href="add-product" class="btn btn--success">Thêm mới</a>
                            </div>
                            <div class="flex non-btn-tools">
                                <form method="post">
                                    <div class="form-filter flex">
                                        <button class="search-btn">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <input type="text" name="search" class="form-control search-bar" placeholder="Tìm Kiếm">
                                    </div>
                                </form>
                                <div class="col">
                                    <div class="pagination flex mx-auto">
                                        <form method="post">
                                            <button type="submit" name="pageno" value=<?= $pageno - 1 ?>><i class="fas fa-chevron-left"></i></button>
                                            <button type="submit" disabled class="pagination__link btn btn--primary-o" name="pageno" value=<?= $pageno ?>> <?= $pageno ?> </button>
                                            <button type="submit" name="pageno" value=<?= $pageno + 1 ?>><i class="fas fa-chevron-right"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </form>
        </main>
    <?php endif ?>
</div>