<?php

[$pageno, $total_pages, $display_items] = pagination($_POST['pageno'] ?? 1, $_POST['search'] ?? "", $product);

if ($delete_one = $_POST['delete_one'] ?? false) {
    delete_product($delete_one);
}
if ($delete_selected = $_POST['delete_selected'] ?? false) {
    delete_product($selected);
}

?>

<div class="container">
    <!-- product table -->
    <form action="" method="post" class="ta-center table-form">
        <table class="table table-striped mx-auto">
            <thead>
                <tr>
                    <th>Tên Hàng</th>
                    <th>Số Binh Luận</th>
                    <th>Mới nhất</th>
                    <th>Cũ nhất</th>
                    <th class="ta-center"></th>
                    <!-- search bar -->
                    <th>
                        <form method="post">
                            <div class="form-filter flex">
                                <button>
                                    <i class="fas fa-search"></i>
                                </button>
                                <input type="text" name="search" class="form-control search-bar">
                            </div>
                        </form>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($display_items as $product) { ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><?= count(get_comment($product['product_id']))   ?></td>
                        <td><?= get_comment_time($product['product_id'], 'DESC') ?></td>
                        <td><?= get_comment_time($product['product_id'], 'ASC') ?></td>
                        <td></td>
                        <!-- add checkbox -->
                        <td class="ta-center">
                            <a href="comment-detail&id=<?= $product['product_id'] ?>" class="btn btn--primary">Xem Chi Tiết</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
    <div class="pagination">
        <form method="post">
            <button type="submit" name="pageno" value=<?= $pageno - 1 ?>><i class="fas fa-chevron-left"></i></button>
            <button type="submit" disabled class="pagination__link btn btn--primary-o" name="pageno" value=<?= $pageno ?>> <?= $pageno ?> </button>
            <button type="submit" name="pageno" value=<?= $pageno + 1 ?>><i class="fas fa-chevron-right"></i></button>
        </form>
    </div>

</div>