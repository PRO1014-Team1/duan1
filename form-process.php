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
}
?>