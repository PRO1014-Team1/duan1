<?php

$user = get_username();
$orders = get_user_order($user);

if (!isset($_SESSION['readable'])) {
    $_SESSION['readable'] = [];
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
<div id="container">
    <div class="container-fluid my-5 p-5 d-flex justify-content-center">
        <div class="w-75">
            <div class="media flex-sm-row flex-column-reverse justify-content-between">
                <div class="col my-auto">
                    <h1 class="mb-5 fs-2"> Lịch sử thanh toán</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table-borderless table">
                        <thead class="fw-bold border-bottom border-secondary">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tên người nhận</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thông tin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?= $order['order_id'] ?></td>
                                    <td><?= $order['created_date'] ?></td>
                                    <td><?= $order['first_name'] ?></td>
                                    <td><?= asvnd($order['total_price']) ?></td>
                                    <td class="<?= status_colorcode($order['order_status']) ?> fw-bold"><?= translate_status($order['order_status']) ?></td>
                                    <td>
                                        <a href="order_detail?order_id=<?= $order['order_id'] ?>" class="link-primary opacity-75 text-capitalize text-decoration-none">Chi tiết <i class="fas fa-info-circle"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row m-4">
                        <div class="col">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <a href="/" class="btn btn-outline-secondary ">
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                        Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>