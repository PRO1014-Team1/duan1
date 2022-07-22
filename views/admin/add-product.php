<?php
require './dao/category.php';

$category = get_all_category();

if (isset($_POST['add-product'])) {
    // if (!$_SESSION['errors'] = validate_product($_POST)) {
    $data = $_POST;
    $data['import_date'] = date('Y-m-d', strtotime($data['import_date']));

    if (isset($_FILES)) {
        if ($_FILES['product-image']['size']) {
            $path = './db/product/';
            require 'upload.php';
            $data['image'] = $path;
        }
        // }

        // update product
        pdo_execute(
            'INSERT INTO `product` (`name`, `price`, `image`, `import_date`, `category_id`, `description`) VALUES (?, ?, ?, ?, ?, ?)',
            [$data['product_name'], $data['price'], $data['image'], $data['import_date'], $data['category_id'], $data['description']]
        );

        redirect('product');
    }
}


?>

<div class="container">
    <form action="" method="POST" class="form-reg mx-auto" enctype="multipart/form-data" s>
        <input type="hidden" name="add-product" value="true">
        <h2 class="form-reg-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Thêm mới" ?></h2>
        <div class="form-section grid row">
            <div class="form-group grid col col-1.5-2">
                <div class="form-control disabled">
                    <label for="product_id">Mã hàng hóa</label>
                    <input type="text" id="product_id" name="product_id" class="form-input <?= isset($_SESSION['errors']['product_id']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['product-id'] ?? "" ?>">
                </div>
                <div class="form-control">
                    <label for="import_date">Ngày nhập </label>
                    <input type="date" id="import_date" name="import_date" class="form-input <?= isset($_SESSION['errors']['import_date']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['import_date'] ?? "" ?>" autofocus>
                </div>
            </div>
            <div class="form-group col">
                <div class="form-control">
                    <label for="product_name">Tên Hàng hóa</label>
                    <input type="text" id="product_name" name="product_name" class="form-input <?= isset($_SESSION['errors']['product_name']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['product_name'] ?? "" ?>" required>
                </div>
            </div>
        </div>
        <div class="form-section grid row">
            <div class="form-group grid col col-2-2">
                <div class="form-control disabled">
                    <label for="view">Số lượt xem</label>
                    <input type="number" id="view" name="view" class="form-input <?= isset($_SESSION['errors']['view']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['view'] ?? "" ?>">
                </div>
                <div class="form-control">
                    <label for="price">Đơn giá</label>
                    <input type="number" id="price" name="price" step="0.01" class="form-input <?= isset($_SESSION['errors']['price']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['price'] ?? "" ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="category_id">Danh Mục</label>
                    <select name="category_id" id="category_id" class="form-input <?= isset($_SESSION['errors']['category_id']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['category_id'] ?? "" ?>" required>
                        <option value=""></option>
                        <?php foreach ($category as $cate) : ?>
                            <option value="<?= $cate['id'] ?>"><?= $cate['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="form-group">
                <div class="form-control">
                    <label for="description">Hình ảnh</label>
                    <input type="file" name="product-image" id="product-image" class="form-input <?= isset($_SESSION['errors']['description']) ? "error" : "" ?>">
                </div>
                <div class="form-control">
                    <label for="description">Mô tả</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-input form-desc <?= isset($_SESSION['errors']['description']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['description'] ?? "" ?>" required></textarea>
                </div>
            </div>
        </div>
        <!-- return to product -->

        <div class="form-control form-submit">
            <button type="submit" class="btn btn--primary-o add-btn">Thêm sản phẩm</button>
        </div>
        <a href="product" class="btn small"> Quay lại</a>

    </form>
</div>