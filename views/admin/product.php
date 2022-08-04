<?php

[$pageno, $total_pages, $display_items] = pagination($_POST['pageno'] ?? 1, $_POST['search'] ?? "", get_product());
$selected = $_POST['selected'] ?? null;

if ($delete_one = $_POST['delete_one'] ?? false) {
    
    delete_product($delete_one);
}
if ($delete_selected = $_POST['delete_selected'] ?? false) {
    delete_product($selected);
}

if($_POST['edit']){
    redirect('edit-product?id='.$_POST['edit']);
}


?>

<div class="container">
    <!-- product table -->
    <form action="" method="post" class="ta-center table-form">
        <table class="table table-striped mx-auto">
            <thead>
                <tr>
                    <th>Mã hàng</th>
                    <th></th>
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
                    <?php
                    $type = get_type_data($product['product_id']);
                    ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50" class="product-img"></td>
                        <td><?= $product['name'] ?></td>
                        <td>
                            <?php foreach ($type as $type_data) : ?>
                                <p class="column-price"><?= get_type_name($type_data['type_id']) ?>:
                                    <span><?= asvnd($type_data['price']) ?></span>
                                </p>
                            <?php endforeach; ?>
                        </td>
                        <td><?= get_category($product['category_id'])[0]['name'] ?></td>
                        <td class="ta-center"><?= $product['view'] ?></td>
                        <td class="ta-center"><?= count(get_comment($product['product_id'])) ?></td>
                        <td><?= $product['import_date'] ?></td>
                        <!-- add checkbox -->
                        <td class="extras">
                            <input type="checkbox" name="selected[]" class="selected" value="<?= $product['product_id'] ?>">
                        </td>
                        <td class="ta-center extras">
                            <div class="wrapper">
                                <button data-collapse-toggle="mobile-menu" type="button" class="table__options_btn btn btn--primary-a" aria-controls="mobile-menu" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="table__options_dropdown fadeIn ts-2 hidden">
                                    <ul class="flex">
                                        <li>
                                            <button type="submit" name="detail" value="<?= $product['product_id'] ?>" class="btn btn--primary">Xem</button>
                                        </li>
                                        <li>
                                            <button type="submit" name="edit" value="<?= $product['product_id'] ?>" class="btn btn--primary">Sửa</button>
                                        </li>
                                        <li>
                                            <button type="submit" name="delete_one" value="<?= $product['product_id'] ?>" class="btn btn--danger select" onClick="javascript:return confirm('Bạn có muốn xóa sản phẩm này?')">Xóa</button>
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
                    <div class="flex btn-tools">
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
</div>