<?php

$user = get_username();
$order_id = $_GET['order_id'];
$order_info = get_user_order($user, $order_id);
$order_detail = get_order_detail($order_id);
// kiểm tra order_id có hợp lệ và thuộc về user không
if (empty($order_info)) {
    redirect('/404');
}


?>
<div id="container">
    <div class="container-fluid my-5 p-5 d-flex justify-content-center">
        <div class="w-75">
            <div class="media flex-sm-row flex-column-reverse justify-content-between">
                <div class="col my-auto">
                    <h1 class="mb-5 fs-2">Đơn hàng: <?= $order_id ?> </h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table-borderless table">
                        <thead class="fw-bold border-bottom border-secondary">
                            <tr>
                                <th>Tên sách</th>
                                <th>Số lượng</th>
                                <th>Giá thành</th>
                                <th>Tổng tiền</th>
                                <th>Loại sách</th>
                                <th>Thông tin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_detail as $order) : ?>
                                <?php
                                $product = get_product($order['product_id']);
                                $type = get_type_data($order['type_id']);
                                ?>
                                <tr>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td><?= asvnd($order['price']) ?></td>
                                    <td><?= asvnd($order['total']) ?></td>
                                    <td><?= get_type_name($order['type_id']) ?></td>
                                    <td>
                                        <a href="detail?id=<?= $order['product_id'] ?>&type_id=<?= $order['type_id'] ?>" class="link-primary opacity-75 text-capitalize text-decoration-none">Chi tiết sách <i class="fas fa-info-circle"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row m-4">
                        <div class="col">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <a href="order_history" class="btn btn-outline-secondary ">
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