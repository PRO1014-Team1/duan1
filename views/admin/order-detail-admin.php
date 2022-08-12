<?php

[$pageno, $total_pages, $display_items] = pagination($_POST['pageno'] ?? 1, $_POST['search'] ?? "", get_product());
$selected = $_POST['selected'] ?? null;

?>
<div class="container">
    <form method="post" class="ta-center table-form">
        <table class="table table-striped mx-auto">
            <thead>
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
                <?php foreach ($orders as $order) : ?>
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
            <div class="row mx-auto">
                <div class="col table-tools__container">
                    <div class="flex non-btn-tools">
                        <div class="col flex">
                            <div class="pagination">
                                <form method="post">
                                    <button type="submit" name="pageno" value=<?= $pageno - 1 ?>><i class="fas fa-chevron-left"></i></button>
                                    <button type="submit" disabled class="pagination__link btn btn--primary-o" name="pageno" value=<?= $pageno ?>> <?= $pageno ?> </button>
                                    <button type="submit" name="pageno" value=<?= $pageno + 1 ?>><i class="fas fa-chevron-right"></i></button>
                                </form>
                                <a href="order" class="btn btn--primary-o">
                                    <i class="fas fa-arrow-left">&nbsp;</i>
                                    Trở về
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </table>
    </form>
</div>