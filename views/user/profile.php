<?php

$user = get_user(get_username());
$genders = ['Nam', 'Nữ', 'Khác'];

if (isset($_POST['update'])) {
    if (!$_SESSION['errors'] = validate_profile($_POST)) {
        $data = input_clean($_POST);
        $data['birthdate'] = date('Y-m-d', strtotime($data['birthdate']));
        if (isset($_FILES)) {
            if ($_FILES['avatar']['size']) {
                $path = './db/user/';
                require 'upload.php';
                $_SESSION['avatar'] = $path;
            }
        } else {
            $_SESSION['avatar'] = $user['avatar'];
        }
        pdo_execute(
            'UPDATE `users` SET `name` = ?, `email` = ?, `birthdate` = ?, `avatar` = ?, `gender` = ? WHERE `username` = ?',
            [$data['name'],  $data['email'], $data['birthdate'],  $_SESSION['avatar'], $data['gender'], $user['username']]
        );
    }
    echo "<script> alert('Cập nhật thành cống!') <script>";
    redirect('profile');
}


?>

<div class="container">
    <form action="" method="POST" class="form-update mx-auto" enctype="multipart/form-data">
        <input type="hidden" name="update" value="true">
        <h2 class="form-update-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Cập nhật tài khoản" ?></h2>
        <div class="profile-avatar">
            <img src="<?= $user['avatar'] ?>" alt="">
        </div>
        <div class="divider"></div>
        <div class="form-group grid">
            <div class="form-control">
                <label for="name">Họ và Tên</label>
                <input type="text" id="name" name="name" class="form-input <?= isset($_SESSION['errors']['name']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['name'] ?? "" ?>" required value="<?= $user['name'] ?>">
            </div>
            <div class="form-control disabled">
                <label for="username">Tên Đăng Nhập</label>
                <input type="text" id="username" name="username" class="form-input" placeholder="<?= $_SESSION['errors']['username'] ?? "" ?>" disabled value="<?= $user['username'] ?>">
            </div>
            <!-- email -->
            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input <?= isset($_SESSION['errors']['email']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['email'] ?? "" ?>" value="<?= $user['email'] ?>" required>
            </div>
            <!-- birthdate -->
            <div class="form-control">
                <label for="birthdate">Ngày Sinh</label>
                <input type="date" id="birthdate" name="birthdate" class="form-input <?= isset($_SESSION['errors']['birthdate']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['birthdate'] ?? "" ?>" value="<?= $user['birthdate'] ?>">
            </div>
            <!-- gender -->
            <div class="form-control">
                <label for="gender">Giới Tính</label>
                <select name="gender" id="gender" class="form-input">
                    <option value="" class="disabled"></option>
                    <?php foreach ($genders as $gender) : ?>
                        <option value=<?= $gender ?> <?= $gender == $user['gender'] ? 'selected' : '' ?>> <?= $gender ?> </option>
                    <?php endforeach ?>
                </select>
            </div>
            <!-- phone -->
            <div class="form-control">
                <label for="phone">SĐT</label>
                <input type="tel" id="phone" name="phone" class="form-input <?= isset($_SESSION['errors']['phone']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['phone'] ?? "" ?>" value="<?= $user['phone_number'] ?>" pattern="(\+84|0)\d{9,11}">
            </div>
            <!-- avatar -->
            <div class="form-control">
                <label for="avatar">Ảnh Đại Diện</label>
                <input type="file" id="avatar" name="avatar" class="form-input <?= isset($_SESSION['errors']['avatar']) ? "error" : "" ?>" placeholder="<?= $_SESSION['errors']['avatar'] ?? "" ?>" value="<?= $user['avatar'] ?>">
            </div>
        </div>
        <div class="form-control form-submit flex">
            <a href="password-change" class="change-password small">Đổi mật khẩu</a>
            <button type="submit" class="btn btn--primary border update-btn">Cập Nhật</button>
            <a href="home" class="btn btn--primary-o block redirect-btn">Huỷ Bỏ</a>
        </div>
    </form>
</div>