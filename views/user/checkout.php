<?php
if (isset($_POST['submit'])) {

  // Thông tin đặt hàng order_info
  $result = false;
  $order_info = set_order_info([
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'address' => $_POST['address'],
    'note' => $_POST['note'],
  ]);

  if ($order_info) {
    $sql = "INSERT INTO order_info (order_id, username, first_name, last_name, email, phone, address, note, created_date, updated_date, total_price, order_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

    $result = pdo_execute($sql, ...array_values($order_info));
    if ($result) {
      alert('Đặt hàng thành công');
    } else {
      alert('Đặt hàng thất bại');
    }
  } else {
    alert('Có lỗi xảy ra, vui lòng thử lại');
  }

  // Thông tin từng sản phẩm trong order_detail
  if ($result) {
    $cart = $_SESSION['cart'];
    $total = 0;
    $overall_status = [];
    foreach ($cart as $item) {
      $product = get_product($item['id']);
      $type = get_type_data($product['product_id'])[0];
      $type_id = $item['type_id'] ?? null;
      $price = discount($type['price'], $type['sale']); // đã bao gồm phần giảm giá
      $subtotal = $price * $item['quantity'];
      $total += $subtotal;
      $product_status = $type['status'];
      array_push($overall_status, $product_status);

      // kiểm tra số lượng sản phẩm có đủ hay không
      if ($type['quantity'] < $item['quantity']) {
        $product_status = 'out_of_stock';
      }

      $order_detail = [
        'order_id' => $order_info['order_id'],
        'product_id' => $item['id'],
        'type_id' => $type_id,
        'quantity' => $item['quantity'],
        'price' =>  $price,
        'status' => $product_status,
        'total' =>  $subtotal
      ];

      $sql = "INSERT INTO order_detail (order_id, product_id, type_id, quantity, price, status, total) VALUES (?,?,?,?,?,?,?)";
      $result = pdo_execute($sql, ...array_values($order_detail));
    }

    //update total_price và order_status trong order_info
    if ($result) {
      if (in_array('out_of_stock', $overall_status)) {
        $order_info['order_status'] = 'unavailable'; // 1 trong số sản phẩm không còn hàng
      } else if (in_array('pending', $overall_status)) {
        $order_info['order_status'] = 'pending'; // 1 trong số sản phẩm đang chờ xử lý
      }

      $sql = "UPDATE order_info SET total_price = ?, order_status = ? WHERE order_id = ?";
      $result = pdo_execute($sql, $total, $order_info['order_status'], $order_info['order_id']);
      unset($_SESSION['cart']);
      redirect("/");
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
        $display_total = 0;
        foreach ($_SESSION['cart'] as $item) {
          $product = get_product($item['id']);
          $type = get_type_data($product['product_id'])[0];
          $display_total += discount($type['price'] * $item['quantity'], $type['sale']);
        ?>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h6 class="my-0"><?php echo $product['name'] ?></h6>
              <small class="text-muted">Số lượng: <?php echo $item['quantity'] ?> Giá: <?= asvnd(discount($type['price'], $type['sale'])) ?></small>
              <small class="text-muted">Giảm: <?= ($type['sale']) * 100 ?>%</small>

            </div>
            <span class="text-muted"><?= asvnd(discount($type['price'], $type['sale'])) ?></span>
          </li>
        <?php
        }
        ?>

        <li class="list-group-item d-flex justify-content-between">
          <span>Tổng (VNĐ)</span>
          <strong><?= asvnd($display_total) ?></strong>
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
      if (count($_SESSION['errors']) > 0) {
        foreach ($_SESSION['errors'] as $error) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        unset($_SESSION['errors']);
      }
      ?>
      <form class="needs-validation" method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">Tên</label>
            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Nhập tên" value="<?php echo (isset($fnameValue) && !empty($fnameValue)) ? $fnameValue : '' ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Họ</label>
            <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Nhập họ" value="<?php echo (isset($lnameValue) && !empty($lnameValue)) ? $lnameValue : '' ?>">
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

        <!-- note -->
        <div class="mb-3">
          <label for="note">Ghi chú</label>
          <textarea class="form-control" id="note" name="note" rows="3"><?php echo (isset($noteValue) && !empty($noteValue)) ? $noteValue : '' ?></textarea>
        </div>
        <hr class="mb-4">
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