<?php

function set_order_info($user_info)
{
    $errors = validate_user_info($user_info);
    $order_info = [
        'order_id' => generate_order_id(),
        'username' => get_username(),
        'first_name' => $user_info['first_name'],
        'last_name' => $user_info['last_name'],
        'address' => $user_info['address'],
        'phone' => $user_info['phone'],
        'email' => $user_info['email'],
        'note' => $user_info['note'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'total_price' => 0,
    ];

    if (empty($errors)) {
        $order_info['order_status'] = 'pending';
        return $order_info;
    } else {
        $_SESSION['errors'] = $errors;
        return false;
    }
}

function validate_user_info($user_info)
{
    $errors = [];

    // Kiểm tra ô trống
    if (empty($user_info['first_name']) || $user_info['first_name'] == '') {
        $errors['first_name'] = 'Vui lòng nhập tên';
    }
    if (empty($user_info['last_name'])) {
        $errors['last_name'] = 'Vui lòng nhập tên đệm';
    }
    if (empty($user_info['email'])) {
        $errors['email'] = 'Vui lòng nhập email';
    }
    if (empty($user_info['phone'])) {
        $errors['phone'] = 'Vui lòng nhập số điện thoại';
    }
    if (empty($user_info['address'])) {
        $errors['address'] = 'Vui lòng nhập địa chỉ';
    }

    if (!empty($errors)) {
        return $errors;
    }
    // return false if there are special character or number in the name 
    if (!preg_match('/^[^\d\W]+$/u', $user_info['first_name'])) {
        $errors['first_name'] = 'Tên không hợp lệ';
    }
    // check last name using regex
    if (!preg_match('/^[^\d\W]+$/u', $user_info['last_name'])) {
        $errors['last_name'] = 'Tên đệm không hợp lệ';
    }
    //email
    if (!filter_var($user_info['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }
    //phone
    if (!filter_var($user_info['phone'], FILTER_SANITIZE_NUMBER_INT)) {
        $errors['phone'] = 'Số điện thoại không hợp lệ';
    }

    return $errors;
}

//Tạo mã order
function generate_order_id()
{
    $code = 'ORD' . date('YmdHis');
    return $code;
}

function get_user_order($user_id = null)
{

    $sql = "SELECT * FROM order_info";
    if ($user_id) {
        $sql .= " WHERE `username` = ?";
    }
    $result = pdo_query($sql, [$user_id]);
    return $result;
}

function get_order_detail($order_id = null)
{
    $sql = "SELECT * FROM order_detail";
    if ($order_id) {
        $sql .= " WHERE order_id = ?";
    }
    $result = pdo_query($sql, [$order_id]);
    return $result;
}


// get all order with specified date range
function get_order_by_date($start_date = false, $end_date = false)
{
    if (!$end_date) {
        $end_date = date('Y-m-t');
    }
    // if start_date = null return all
    if (!$start_date) {
        $sql = "SELECT * FROM order_info";
        $result = pdo_query($sql);
    } else {
        $sql = "SELECT * FROM order_info WHERE created_date BETWEEN ? AND ?";
        $result = pdo_query($sql, [$start_date, $end_date]);
    }

    return $result;
}
