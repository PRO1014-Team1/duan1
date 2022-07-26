<?php
if (isset($_POST['submit'])) {
  if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['address']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['address'])) {
    $firstName = $_POST['first_name'];

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
      $errorMsg[] = 'Vui lòng nhập Email';
    } else {
      //validate_input is a custom function
      //you can find it in helpers.php file
      $userName = validate_input($_SESSION["username"]);
      $firstName  = validate_input($_POST['first_name']);
      $lastName   = validate_input($_POST['last_name']);
      $phone   = validate_input($_POST['phone']);
      $email      = validate_input($_POST['email']);
      $address    = validate_input($_POST['address']);

      $sql = 'insert into orders (username,first_name, last_name,phone, email, address, order_status,created_at, updated_at) values (?,?,?,?,?,?,?,?,?)';
      $params = [
        $userName,
        $firstName,
        $lastName,
        $phone,
        $email,
        $address,
        'confirmed',
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
      ];
      pdo_execute($sql, $params);
      if (true) {
        if (isset($_SESSION['cart']) || !empty($_SESSION['cart'])) {
          $sqlDetails = 'insert into order_details (order_id, product_id, product_name, product_price, quantity, total_price) values(:order_id,:product_id,:product_name,:product_price,:quantity,:total_price)';
          $getOrderID = pdo_query_once("SELECT id FROM `orders` WHERE `username` = ?", $_SESSION['username']);
          $totalPrice = 0;
          foreach ($_SESSION['cart'] as $item) {
            $totalPrice += $item['total_price'];

            $paramOrderDetails = [
              $getOrderID,
              $item['product_id'],
              $item['product_name'],
              $item['product_price'],
              $item['quantity'],
              $item['total_price']
            ];
            pdo_execute($sqlDetails, $paramOrderDetails);
          }



          $prepareUpdate = [
            'total' => $totalPrice,
            'id' => $getOrderID
          ];



          // unset($_SESSION['cart']);
          // $_SESSION['confirm_order'] = true;
          // header('location:thank-you.php');
          exit();
        }
      } else {
      }
    }
  }
}

?>

<div class="container-fluid pt-5 mb-5">
  <div class="row m-3">
    <div class="col-md-4 order-md-2">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Giỏ hàng của bạn</span>
        <span class="badge badge-dark badge-pill"><?php echo $cartItemCount; ?></span>
      </h4>
      <ul class="list-group list-group-flush mb-3">
        <?php
        foreach ($_SESSION['cart'] as $item) {
          $product = get_product($item['id'])[0];
          $type = get_type_data($product['product_id'])[0];
          $total += $type['price'] * $item['quantity'];
        ?>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h6 class="my-0"><?php echo $product['name'] ?></h6>
              <small class="text-muted">Số lượng: <?php echo $item['quantity'] ?> Giá: <?= asvnd($type['price']) ?></small>
            </div>
            <span class="text-muted"><?= asvnd($type['price'] * $item['quantity']) ?></span>
          </li>
        <?php
        }
        ?>

        <li class="list-group-item d-flex justify-content-between">
          <span>Tổng (VNĐ)</span>
          <strong><?= asvnd($total) ?></strong>
        </li>
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
      <?php
      if (isset($errorMsg) && count($errorMsg) > 0) {
        foreach ($errorMsg as $error) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
      }
      ?>
      <form class="needs-validation" method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">Họ</label>
            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Nhập họ" value="<?php echo (isset($fnameValue) && !empty($fnameValue)) ? $fnameValue : '' ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Tên</label>
            <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Nhập tên" value="<?php echo (isset($lnameValue) && !empty($lnameValue)) ? $lnameValue : '' ?>">
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

        <div class="mb-3">
          <label for="address">Địa chỉ</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ" value="<?php echo (isset($addressValue) && !empty($addressValue)) ? $addressValue : '' ?>">
        </div>



        <h4 class="mb-3">Thanh toán</h4>

        <div class="d-block my-3">
          <div class="custom-control custom-radio input-dark">
            <input id="cashOnDelivery" name="cashOnDelivery" type="radio" class="custom-control-input input-dark" checked="">
            <label class="custom-control-label" for="cashOnDelivery">Thanh toán khi nhận hàng</label>
          </div>
        </div>

        <hr class="mb-4">
        <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit" value="submit">ĐẶT HÀNG</button>
      </form>
    </div>
  </div>
</div>