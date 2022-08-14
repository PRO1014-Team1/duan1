<?php

function status_convert($index)
{
    $product_status = ['out_of_stock', 'in_stock', 'hide'];
    return $product_status[$index];
}

if (isset($_POST['edit'])) {
    $data = $_POST;
    $data['import_date'] = date('Y-m-d', strtotime($data['import_date']));

    if ($_FILES['product-image']['name'] !== '') {
        if ($_FILES['product-image']['size']) {
            $path = 'db/product/';
            require 'lib/upload.php';
            $data['image'] = $path;
        }
    } else {
        $data['image'] = $edit_product['image'];
    }
    $result = pdo_execute(
        'UPDATE `product` SET `name` = ?, `image` = ?, `import_date` = ?, `category_id` = ?, `description` = ? WHERE `product_id` = ?',
        $data['product_name'],
        $data['image'],
        $data['import_date'],
        $data['category_id'],
        $data['description'],
        $data['product_id']
    );

    if ($result) {
        echo '<script>alert("Sửa sản phẩm thành công")</script>';
        redirect('product');
    }
}

if (isset($_POST['add-variant'])) {
    $data = $_POST;
    $_POST['product_name'] =  $edit_product['name'];
    $data['product_id'] = $edit_id;

    if ($_FILES['type_download']) {
        $path = 'db/book/';
        require 'lib/upload.php';
        $data['type_download'] = $path;
        $data['file_size'] = $_FILES['type_download']['size'];
    } else {
        $data['type_download'] = $edit_product['type_download'];
        $data['file_size'] = 0;
    }

    $result = pdo_execute(
        'INSERT INTO `type_detail` (`product_id`, `type_id`, `download`, `price`, `quantity`, `sale`, `dimensions`, `pages`, `status` ,`file_size`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        $data['product_id'],
        $data['type_id'],
        $data['type_download'],
        $data['type_price'],
        $data['quantity'],
        $data['type_sale'],
        $data['type_dimensions'],
        $data['pages'],
        status_convert($data['status']),
        $data['file_size']
    );
    if ($result) {
        alert("Thêm sản phẩm thành công");
        redirect('edit-product?id=' . $data['product_id']);
    }
}
reset($edit_product);

?>
<div class="container">
    <form action="" method="POST" class="form-reg mx-auto" enctype="multipart/form-data">
        <h2 class="form-reg-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Thông tin chi tiết" ?></h2>
        <div class="form-control"><img src="<?= $edit_product['image'] ?>" alt="" class="mx-auto" width="100"></div>
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
                    <!-- category -->
                    <label for="category_id">Danh Mục</label>
                    <select name="category_id" id="category_id" class="form-input">
                        <?php foreach ($category as $cat) : ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $edit_product['category_id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if (isset($type['type_id'])) : ?>
                    <div class="form-control">
                        <label for="price">Biến thể</label>
                        <?php foreach (get_type_data($edit_product['product_id']) as $type) : ?>
                            <select name="type_id" id="type_id" class="form-input <?= isset($_SESSION['errors']['type_id']) ? "error" : "" ?>" required>
                                <option value="<?= $type['type_id'] ?>"><?= $type['name'] ?></option>
                            </select>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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
                    <textarea name="description" id="description" cols="30" rows="10" class="form-input form-desc"><?= $edit_product['description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="form-group">
                <div class="form-control">
                    <button type="submit" name="edit" class="btn btn--primary-o edit-btn">Sửa sản phẩm</button>
                    <a href="product" class="btn small"><i class="fas fa-chevron-left"></i> Quay lại</a>
                </div>
            </div>
        </div>
    </form>
    <hr class="divider">
    <form class="form-reg variant-form" method="POST" enctype="multipart/form-data">
        <!-- add variant -->
        <?php
        $product_type_data = get_type_data($edit_product['product_id']);
        $type_names = get_type_name();
        ?>
        <h2 class="form-reg-heading"><?= $_SESSION['errors'] ? 'Lỗi' : "Thêm biến thể" ?></h2>
        <div class="form-section grid row">
            <div class="form-group col">
                <div class="form-control">
                    <label for="price">Biến thể</label>
                    <select name="type_id" id="type_id" class="form-input <?= isset($_SESSION['errors']['type_id']) ? "error" : "" ?>" required>
                        <?php foreach ($type_names as $type) : ?>
                            <?php foreach ($product_type_data as $product_type) {
                                if ($type['type_id'] === $product_type['type_id']) {
                                    continue 2;
                                }
                            }
                            ?>
                            <option value="<?= $type['type_id'] ?>"><?= $type['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group grid col col-2-2">
                <div class="form-control">
                    <!-- no of pages -->
                    <label for="pages">Số trang</label>
                    <input type="number" id="pages" name="pages" min=0 class="form-input <?= isset($_SESSION['errors']['pages']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['pages'] ?? "" ?>">
                </div>
                <div class="form-control">
                    <!-- no of pages -->
                    <label for="quantity">Số lượng</label>
                    <input type="number" id="quantity" name="quantity" min=0 class="form-input <?= isset($_SESSION['errors']['quantity']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['quantity'] ?? "" ?>">
                </div>
            </div>
        </div>
        <div class="form-section grid row">
            <div class="form-group col">
                <div class="form-control">
                    <label for="type_price">Giá</label>
                    <input type="number" id="type_price" name="type_price" class="form-input <?= isset($_SESSION['errors']['type_price']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['type_price'] ?? "" ?>" min=0>
                </div>
            </div>
            <div class="form-group grid col col-2-2">
                <div class="form-control">
                    <label for="type_sale">Giảm Giá</label>
                    <input type="number" id="type_sale" name="type_sale" class="form-input <?= isset($_SESSION['errors']['type_sale']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['type_sale'] ?? "" ?>" min=0 max=100 step=1>
                </div>
                <div class="form-control">
                    <label for="type_dimensions">Kích thước</label>
                    <input type="text" id="type_dimensions" name="type_dimensions" class="form-input <?= isset($_SESSION['errors']['type_dimensions']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['type_dimensions'] ?? "" ?>">
                </div>
            </div>
        </div>
        <div class="form-section grid row">
            <div class="form-group col">
                <div class="form-control">
                    <label for="type_download">File</label>
                    <input type="file" name="type_download" id="type_download" class="form-input">
                </div>
            </div>
            <div class="form-group col">
                <div class="form-control">
                    <label for="status">Trạng thái</label>
                    <select name="status" id="status" class="form-input <?= isset($_SESSION['errors']['status']) ? "error" : "" ?>" required>
                        <option value="1">Còn hàng</option>
                        <option value="0">Hết hàng</option>
                        <option value="2">Ẩn</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-section">
            <div class="form-group">
                <div class="form-control">
                    <button type="submit" name="add-variant" class="btn btn--primary-o edit-btn">Thêm biến thể</button>
                </div>
            </div>
        </div>
    </form>
</div>