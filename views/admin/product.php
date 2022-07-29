<?php

[$pageno, $total_pages, $display_items] = pagination($_POST['pageno'] ?? 1, $_POST['search'] ?? "", get_product());
$selected = $_POST['selected'] ?? null;

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
                    <th>Mã hàng</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Loại hàng</th>
                    <th>Số lượt xem</th>
                    <th>Số bình luận</th>
                    <th>Ngày nhập</th>
                    <th class="ta-center"></th>
                    <th class="ta-center"></th>                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($display_items as $product) { ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= get_category($product['category_id'])[0]['name'] ?></td>
                        <td class="ta-center"><?= $product['view'] ?></td>
                        <td class="ta-center"><?= count(get_comment($product['product_id'])) ?></td>
                        <td><?= $product['import_date'] ?></td>
                        <!-- add checkbox -->
                        <td class="extras">
                            <input <?= in_array($product['product_id'], $selected ?? []) ? 'checked' : '' ?> type="checkbox" name="selected[]" class="selected" value="<?= $product['product_id'] ?>" onClick=" javascript:return submit()">
                        </td>
                        <td class="ta-center extras">
                            <div class="wrapper">
                                <button data-collapse-toggle="mobile-menu" type="button" class="table__options_btn btn btn--primary-a" aria-controls="mobile-menu" aria-expanded="false">                                    
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="table__options_dropdown fadeIn ts-2 hidden">
                                    <ul class="flex">
                                        <li>
                                            <a href="detail&id=<?= $product['product_id'] ?>" class="btn btn--primary">Xem</a>
                                        </li>
                                        <li>
                                            <a href="edit-product&id=<?= $product['product_id'] ?>" class="btn btn--success">Sửa</a>
                                        </li>
                                        <li>
                                            <form action="" method="post" class="delete-one">
                                                <input type="hidden" name="delete_one" value="<?= $product['product_id'] ?>">
                                                <button type="submit" href="#" class="btn btn--danger select" onClick="javascript:return confirm('Bạn có muốn xóa sản phẩm này?')">Xóa</a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <div class="row flex mx-auto">
                <div class="col table-tools__container">
                    <div class="flex btn-tools">
                    <button class="btn btn--primary select_all" name="select_all" value="true">Chọn tất cả</button>
                    <button class="btn btn--outline deselect_all" name="select_all" value="false">Bỏ chọn tất cả</button>
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
</div>