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
    $result = pdo_execute($sql, 'asd123', 'a1222', 'asasas', 'a@gmail.com', '013832832', 'asasasasasaass' );
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
<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="./public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="./public/css/util.css" />
    <link rel="stylesheet" type="text/css" href="./public/css/theme.css" />
    <link rel="stylesheet" type="text/css" href="./public/css/header.css" />

    <link rel="stylesheet" type="text/css" href="./public/css/footer.css" />
    <script src="https://kit.fontawesome.com/33c0badbf8.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script src="./public/js/header.js"></script>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>"
  </head>
  <body>
    
  <li class="justify-content-between bg-dark">
          <a href="/" class="btn btn-dark btn-block p-2">
            <i class="fas fa-arrow-left"></i>
            <span>Tiếp tục mua hàng</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="col-md-8 order-md-1">
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
    </div>
  </div>
</div>
  </body>
  </html>