<?php


if (isset($_POST['edit'])) {
    $data = input_clean($_POST);

    pdo_execute('UPDATE `category` SET `name` = ? WHERE `id` = ?', [$data['name'], $edit_id]);

    echo '<script>alert("Sửa thành công")</script>';
    redirect('category');
}

?>

<div class="container">
    <form action="" method="POST" class="form-reg mx-auto" enctype="multipart/form-data" s>
        <input type="hidden" name="edit" value="true">
        <h2 class="form-reg-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Sửa" ?></h2>
        <div class="form-section grid row">
            <div class="form-control disabled">
                <label for="category_id">Mã loại</label>
                <input type="text" id="category_id" name="category_id" class="form-input" value="<?= $edit_category['id'] ?>">
            </div>
            <div class="form-control">
                <label for="name">Tên loại</label>
                <input type="text" id="name" name="name" class="form-input <?= isset($_SESSION['errors']['name']) ? "error" : "" ?>" value="<?= $edit_category['name'] ?>">
            </div>
            <button type="submit" class="btn btn--primary-o edit-btn">Sửa loại hàng</button>
            <a href="product" class="btn small"><i class="fas fa-chevron-left"></i> Quay lại</a>
        </div>
</div>
<!-- return to product -->


</form>
</div>