<?php
if (isset($_POST['submit'])) {

  // Thông tin 
  $result = false;

  $feedback = set_feedback([
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'message' => $_POST['message'],
  ]);

  if ($feedback) {
    $sql = "INSERT INTO feedback ( username, firstname, lastname, email, phone, message) VALUES (?,?,?,?,?,?)";
    $result = pdo_execute($sql,...array_values($feedback));
    if ($result) {
      alert('Liên hệ thành công');
    } else {
      alert('Liên hệ thất bại');
    }
  } else {
    alert('Có lỗi xảy ra, vui lòng thử lại');
  }
}
?>
<div id="container" class="my-5">
  <div class="col-md-8 col mx-auto">
    <h4 class="mb-3">Thông tin khách hàng</h4>
    <form class="needs-validation" method="POST">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="firstName">Tên</label>
          <input type="text" class="form-control" id="firstName" name="firstname" placeholder="Nhập tên" value="<?php echo (isset($fnameValue) && !empty($fnameValue)) ? $fnameValue : '' ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label for="lastName">Họ</label>
          <input type="text" class="form-control" id="lastName" name="lastname" placeholder="Nhập họ" value="<?php echo (isset($lnameValue) && !empty($lnameValue)) ? $lnameValue : '' ?>">
        </div>
      </div>
      <div class="mb-3">
        <label for="phone">Số điện thoại</label>
        <input type="phone" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" value="<?php echo (isset($phoneValue) && !empty($phoneValue)) ? $phoneValue : '' ?>">
      </div>
      <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" value="<?php echo (isset($emailValue) && !empty($emailValue)) ? $emailValue : '' ?>">
      </div>
      <!-- note -->
      <div class="mb-3">
        <label for="message">Ghi chú</label>
        <textarea class="form-control" id="message" name="message" rows="3"><?php echo (isset($messageValue) && !empty($massageValue)) ? $messageValue : '' ?></textarea>
      </div>
      <hr class="mb-4">
      <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit" value="submit">Liên hệ</button>
    </form>
    <a href="/" class="link-dark text-dark p-2 d-inline-block m-2">
      <i class="fas fa-arrow-left"></i>
      <span>Tiếp tục mua hàng</span>
    </a>
  </div>
</div>