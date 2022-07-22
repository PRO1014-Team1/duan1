<?php
// validate register
if(isset($_POST['register'])) {
    if($_SESSION['errors'] = validate_register($_POST)) {
    }
    else {
        $data = input_clean($_POST);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['birthdate'] = date('Y-m-d', strtotime($data['birthdate']));
        $data['role'] = false;
        $data['identity'] = $_SESSION['identity'];
        $data['avatar'] = '';
        $user = pdo_execute('INSERT INTO users (name, username, email, birthdate, password, role, identity, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', 
        [$data['name'], $data['username'], $data['email'], $data['birthdate'], $data['password'],  $data['role'], $data['identity'], $data['avatar']]);
        
        echo '<script>alert("Đăng ký thành công!");</script>';
        redirect('login');
    }
}


?>

<div class="container">

    <form action="" method="POST" class="form-reg mx-auto">
        <input type="hidden" name="register" value="true">
        <h2 class="form-reg-heading <?= $_SESSION['errors'] ? "error" : "" ?>"><?= $_SESSION['errors'] ? 'Lỗi' : "Đăng ký tài khoản" ?></h2>
        <div class="form-group grid">
            <div class="form-control">
                <label for="name">Họ và Tên</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input <?= isset($_SESSION['errors']['name']) ? "error" : "" ?>" 
                    placeholder="<?= $_SESSION['errors']['name'] ?? "" ?>"
                    required autofocus
                    >
            </div>
            <div class="form-control">
                <label for="username">Tên Đăng Nhập</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-input <?= isset($_SESSION['errors']['username']) ? "error" : "" ?>" 
                    placeholder="<?= $_SESSION['errors']['username'] ?? "" ?>"
                    required
                    >
            </div>
            <!-- email -->
            <div class="form-control">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input <?= isset($_SESSION['errors']['email']) ? "error" : "" ?>" 
                    placeholder="<?= $_SESSION['errors']['email'] ?? "" ?>"
                    required
                    >
            </div>
            <!-- birthdate -->
            <div class="form-control">
                <label for="birthdate">Ngày Sinh <span class="disabled small p-1">(Không bắt buộc)</span> </label>
                <input 
                    type="date" 
                    id="birthdate" 
                    name="birthdate" 
                    class="form-input <?= isset($_SESSION['errors']['birthdate']) ? "error" : "" ?>" 
                    placeholder="<?= $_SESSION['errors']['birthdate'] ?? "" ?>"
                    >
            </div>
            <!-- password -->
            <div class="form-control">
                <label for="password">Mật Khẩu</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input <?= isset($_SESSION['errors']['password']) ? "error" : "" ?>" 
                    placeholder="<?= $_SESSION['errors']['password'] ?? "" ?>"
                    required
                    >
            </div>
            <!-- confirm password -->
            <div class="form-control">
                <label for="confirm-password">Xác Nhận Mật Khẩu</label>
                <input 
                    type="password" 
                    id="confirm-password" 
                    name="confirm-password" 
                    class="form-input <?= isset($_SESSION['errors']['confirm-password']) ? "error" : "" ?>" 
                    placeholder="<?= $_SESSION['errors']['confirm-password'] ?? "" ?>"
                    required
                    >
            </div>
        </div>
        <div class="form-control form-submit">
        <a href="login" class="login-redirect small">Đã có tài khoản?</a>
            <button type="submit" class="btn btn--primary-o register-btn">Đăng Ký</button>
        </div>
    </form>
</div>