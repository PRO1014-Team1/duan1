<?php

if (isset($_POST['edit'])) {
    $data = $_POST;
    $data['import_date'] = date('Y-m-d', strtotime($data['import_date']));

    if (isset($_FILES)) {
        if ($_FILES['product-image']['size']) {
            $path = 'db/product/';
            require 'upload.php';
            $data['image'] = $path;
        }
    }

    pdo_execute(
        'UPDATE `product` SET `name` = ?, `price` = ?,`image` = ?, `import_date` = ?, `category_id` = ?, `description` = ? WHERE `product_id` = ?',
        [$data['product_name'], $data['price'], $data['image'], $data['import_date'], $data['category_id'], $data['description'], $data['product_id']]
    );

    echo '<script>alert("Sửa sản phẩm thành công")</script>';
    redirect('product');
}

?>

<div class="container">
    <form action="" method="POST" class="form-reg mx-auto" enctype="multipart/form-data" s>
        <input type="hidden" name="edit" value="true">
        <h2 class="form-reg-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Sửa" ?></h2>
        <div class="form-section grid row">
            <div class="form-group grid col col-1.5-2">
                <div class="form-control disabled">
                    <label for="product_id">Mã hàng hóa</label>
                    <input type="text" id="product_id" name="product_id" class="form-input <?= isset($_SESSION['errors']['product_id']) ? "error" : "" ?>" value="<?= $edit_product['product_id'] ?>">
                </div>
                <div class="form-control">
                    <label for="import_date">Ngày nhập </label>
                    <input type="date" id="import_date" name="import_date" class="form-input <?= isset($_SESSION['errors']['import_date']) ? "error" : "" ?>" value="<?= $edit_product['import_date'] ?>">
                </div>
            </div>
            <div class="form-group col">
                <div class="form-control">
                    <label for="product_name">Tên Hàng hóa</label>
                    <input type="text" id="product_name" name="product_name" class="form-input <?= isset($_SESSION['errors']['product_name']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['product_name'] ?? "" ?>" value='<?= $edit_product['name'] ?>' required>
                </div>
            </div>
        </div>
        <div class="form-section grid row">
            <div class="form-group grid col col-2-2">
                <div class="form-control disabled">
                    <label for="view">Số lượt xem</label>
                    <input type="number" id="view" name="view" class="form-input <?= isset($_SESSION['errors']['view']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['view'] ?? "" ?>" value=<?= $edit_product['view'] ?> required>
                </div>
                <div class="form-control">
                    <label for="price">Đơn giá</label>
                    <input type="number" step="0.01" id="price" name="price" class="form-input <?= isset($_SESSION['errors']['price']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['price'] ?? "" ?>" value=<?= $edit_product['price'] ?> required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="category_id">Danh Mục</label>
                    <select name="category_id" id="category_id" class="form-input <?= isset($_SESSION['errors']['category_id']) ? "error" : "" ?>" required>
                        <?php foreach ($category as $cate) : ?>
                            <option value="<?= $cate['id'] ?>" <?= $edit_product['category_id'] == $cate['id'] ? "selected" : "" ?>><?= $cate['name'] ?></option>
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
                    <textarea name="description" id="description" cols="30" rows="10" class="form-input form-desc <?= isset($_SESSION['errors']['description']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['description'] ?? "" ?>"></textarea>
                </div>
            </div>
        </div>
        <!-- return to product -->
        <button type="submit" class="btn btn--primary-o edit-btn">Sửa sản phẩm</button>
        <a href="product" class="btn small"><i class="fas fa-chevron-left"></i> Quay lại</a>

    </form>
</div>