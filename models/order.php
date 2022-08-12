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
    $code = 'ORD' . date('YmdHis') . rand(10, 99);
    return $code;
}

function get_user_order($user_id = null, $order_id = null)
{

    $sql = "SELECT * FROM order_info";
    if ($user_id && $order_id) {
        $sql .= " WHERE `username` = ? AND `order_id` = ?";
        $result = pdo_query($sql, [$user_id, $order_id]);
    } else if ($user_id) {
        $sql .= " WHERE `username` = ?";
        $result = pdo_query($sql, [$user_id]);
    } else if ($order_id) {
        $sql .= " WHERE `order_id` = ?";
        $result = pdo_query($sql, [$order_id]);
    } else {
        $result = pdo_query($sql);
    }
    return $result;
}

function get_order_detail($order_id = null, $target = "*")
{
    $sql = "SELECT $target FROM order_detail";
    if ($order_id) {
        $sql .= " WHERE order_id = ?";
    }
    $result = pdo_query($sql, [$order_id]);
    return $result;
}


// get all order with specified date range
function get_order_by_date($start = false, $end = false)
{
    if (!$end) {
        $end = date('Y-m-t');
    }
    // if start_date = null return all
    if (!$start) {
        return get_user_order();
    } else {
        $sql = "SELECT * FROM order_info WHERE created_date BETWEEN ? AND ?";
        $result = pdo_query($sql, [$start, $end]);
    }
    return $result;
}

function get_order_detail_by_date($start = false, $end = false)
{
    if (!$end) {
        $end = date('Y-m-t');
    }
    // if start_date = null return all
    if (!$start) {
        $sql = "SELECT  order_detail.*, SUM(`order_detail`.total) AS `income` FROM order_detail INNER JOIN order_info ON `order_info`.order_id = `order_detail`.order_id GROUP BY `order_detail`.order_id";
    } else {
        $sql = "SELECT order_detail.*,SUM(`order_detail`.total) AS `income` FROM order_detail INNER JOIN order_info ON `order_info`.order_id = `order_detail`.order_id WHERE `order_info`.created_date BETWEEN ? AND ? GROUP BY `order_info`.order_id";
    }
    $result = pdo_query($sql, [$start, $end]);
    return $result;
}



function get_order_range($order_by = 'week')
{
    $prev_order = null;
    $cur_order = null;
    switch ($order_by) {
        case 'week':
            $prev_order = get_order_by_date(date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime('-1 day')));
            $cur_order = get_order_by_date(date('Y-m-d', strtotime('-1 day')), date('Y-m-d'));
            break;
        case 'month':
            $cur_order = get_order_by_date(date('Y-m-01'));
            $prev_order = get_order_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
            break;
        case 'year':
            $cur_order = get_order_by_date(date('Y-01-01'), date('Y-12-31'));
            $prev_order = get_order_by_date(date('Y-01-01', strtotime('-1 year')), date('Y-12-31', strtotime('-1 year')));
            break;
        case 'all':
            $cur_order = get_order_by_date();
            $prev_order = get_order_by_date();
            break;
        default:
            $cur_order = get_order_by_date(date('Y-m-01'), date('Y-m-t'));
            $prev_order = get_order_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
            break;
    }
    return [$prev_order, $cur_order];
}

function get_order_detail_range($order_by = 'week')
{
    $prev_order = null;
    $cur_order = null;
    switch ($order_by) {
        case 'week':
            $prev_order = get_order_detail_by_date(date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime('-1 day')));
            $cur_order = get_order_detail_by_date(date('Y-m-d', strtotime('-1 day')), date('Y-m-d'));
            break;
        case 'month':
            $cur_order = get_order_detail_by_date(date('Y-m-01'));
            $prev_order = get_order_detail_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
            break;
        case 'year':
            $cur_order = get_order_detail_by_date(date('Y-01-01'), date('Y-12-31'));
            $prev_order = get_order_detail_by_date(date('Y-01-01', strtotime('-1 year')), date('Y-12-31', strtotime('-1 year')));
            break;
        case 'all':
            $cur_order = get_order_detail_by_date();
            $prev_order = get_order_detail_by_date();
            break;
        default:
            $cur_order = get_order_detail_by_date(date('Y-m-01'), date('Y-m-t'));
            $prev_order = get_order_detail_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
            break;
    }
    return [$prev_order, $cur_order];
}

function get_product_from_order($order_id = null)
{
    $sql = "SELECT `product_id` FROM order_detail";
    if ($order_id) {
        $sql .= " WHERE order_id = ?";
    }
    $result = pdo_query($sql, [$order_id]);
    return $result;
}

function order_update($order_id, $data)
{
    $sql = "UPDATE order_info SET ";
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i > 0) {
            $sql .= ",";
        }
        $sql .= "$key = ?";
        $i++;
    }
    $sql .= " WHERE order_id = ?";
    $result = pdo_execute($sql, ...array_merge(array_values($data), [$order_id]));
    return $result;
}
