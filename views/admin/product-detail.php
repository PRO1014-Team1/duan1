<?php

[$pageno, $total_pages, $display_items] = pagination($_POST['pageno'] ?? 1, $_POST['search'] ?? "", get_product());
$selected = $_POST['selected'] ?? null;

if ($delete_one = $_POST['delete_one'] ?? false) {
    delete_product($delete_one);
}
if ($delete_selected = $_POST['delete_selected'] ?? false) {
    delete_product($selected);
}

if ($_POST['edit'] ?? false) {
    redirect('edit-product?id=' . $_POST['edit']);
}

if ($_POST['edit-submit'] ?? false) {
    $data = $_POST;
    if ($_POST['type_id'] > 334) {
        if ($_FILES['download']['name'] !== '') {
            $_POST["product_name"] = $product['name'];
            $path = 'db/book/';
            require 'lib/upload.php';
            $data['file_size'] = $_FILES['download']['size'] ?? 0;
            $data['download'] = $path;
        }
    }
    $sql = "UPDATE type_detail SET `quantity` = ?, `price` = ?, `download` = ?, `file_size` = ?, `dimensions` = ?, `pages` = ?, `sale` = ?, `status` = ? WHERE `type_id` = ? AND `product_id` = ?";
    $result = pdo_execute(
        $sql,
        $data['quantity'],
        $data['price'],
        $data['download'],
        $data['file_size'] ?? $_FILES['download']['size'],
        $data['dimensions'],
        $data['pages'],
        $data['sale'],
        $data['status'],
        $data['type_id'],
        $data['product_id']
    );
    if ($result) {
        alert('Cập nhật thành công');
        redirect('product-detail?id=' . $data['product_id']);
    }
}

$edit_id = $_POST['edit-type'] ?? null;

?>

<div class="container">
    <div class="title-block">
        <h1 class="title">Danh Sách Biến Thể</h1>
        <a href="product" class="btn btn--primary">Trờ về</a>
    </div>
    <table class="table table-striped mx-auto">
        <thead>
            <tr>
                <th>Tên loại</th>
                <th>Đơn giá</th>
                <th>Giảm giá </th>
                <th>Kích cỡ file</th>
                <th>Kích cỡ sách</th>
                <th>Số lượng</th>
                <th>Số trang</th>
                <th>File</th>
                <th>Trạng thái</th>
                <th></th>
                <th></th>
            </tr>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $type) : ?>
                <?php if (!$edit_id || $edit_id !== $type['type_id']) :  ?>
                    <form action="" method="post">
                        <tr class="type-display">
                            <td><?= get_type_name($type['type_id']) ?></td>
                            <td><?= $type['price'] ?></td>
                            <td><?= $type['sale'] ?></td>
                            <td><?= $type['file_size'] ?></td>
                            <td><?= $type['dimensions'] ?></td>
                            <td><?= $type['quantity'] ?></td>
                            <td><?= $type['pages'] ?></td>
                            <td><?= $type['download'] ?></td>
                            <td><?= $type['status'] ?></td>
                            <td><button type="submit" name="edit-type" value="<?= $type['type_id'] ?>" class="btn edit-type btn--primary-o">Sửa</button></td>
                            <td><button type="submit" name="action" value="delete" class="btn btn--danger">Xóa</button></td>
                        </tr>
                    </form>
                <?php else : ?>
                    <form method="POST" enctype="multipart/form-data">
                        <tr class="type-edit">
                            <td>
                                <p><?= get_type_name($type['type_id']) ?></p>
                            </td>
                            <td>
                                <input type="text" name="price" value="<?= $type['price'] ?>">
                            </td>
                            <td>
                                <input type="text" name="sale" value="<?= $type['sale'] ?>">
                            </td>
                            <td>
                                <input type="text" name="file_size" value="<?= $type['file_size'] ?>">
                            </td>
                            <td>
                                <input type="text" name="dimensions" value="<?= $type['dimensions'] ?>">
                            </td>
                            <td>
                                <input type="text" name="quantity" value="<?= $type['quantity'] ?>">
                            </td>
                            <td>
                                <input type="text" name="pages" value="<?= $type['pages'] ?>">
                            </td>
                            <td>
                                <input type="file" name="download">
                            </td>
                            <td>
                                <input type="text" name="status" value="<?= $type['status'] ?>">
                            </td>
                            <td>
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <input type="hidden" name="type_id" value="<?= $type['type_id'] ?>">
                            </td>
                            <td>
                                <button type="submit" name="edit-submit" value="true" class="edit-type btn btn--primary">Sửa</button>
                            </td>
                        </tr>
                    </form>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <div class="row mx-auto">
        </div>
    </table>
</div>