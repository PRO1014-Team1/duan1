<?php

if (isset($_POST['edit'])) {
    // if (!$_SESSION['errors'] = validate_category($_POST)) {
    $data = input_clean($_POST);
    pdo_execute('INSERT INTO `category` (`name`) VALUES (?)', [$data['name']]);
    echo '<script>alert("Sửa thành công")</script>';
    redirect('category');
    // }
}

?>

<div class="container">
    <form action="" method="POST" class="form-reg mx-auto" enctype="multipart/form-data" s>
        <input type="hidden" name="edit" value="true">
        <h2 class="form-reg-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Thêm loại hàng" ?></h2>
        <div class="form-section grid row">
            <div class="form-control disabled">
                <label for="category_id">Mã loại</label>
                <input type="text" id="category_id" name="category_id" class="form-input <?= isset($_SESSION['errors']['id']) ? "error" : "" ?>">
            </div>
            <div class="form-control">
                <label for="name">Tên loại</label>
                <input type="text" id="name" name="name" class="form-input <?= isset($_SESSION['errors']['name']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['name'] ?? "" ?>">
            </div>
            <button type="submit" class="btn btn--primary-o add-btn">Thêm loại hàng</button>
            <a href="product" class="btn small"><i class="fas fa-chevron-left"></i> Quay lại</a>
        </div>
</div>
<!-- return to product -->


</form>
</div>