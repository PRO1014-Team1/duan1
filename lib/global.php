<?php

// validate đăng nhập
function validate_login($username, $password)
{
    $username = input_clean($username);
    $password = input_clean($password);
    $user = pdo_query_once('SELECT * FROM users WHERE username = ?', [$username]);

    if (!$user) {
        return false;
    } else if (password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

// validate đăng ký
function validate_register($data)
{
    $data = input_clean($data);
    $errors = [];

    if (empty($data['name'])) {
        $errors['name'] = 'Họ và tên không được để trống';
    } else if (!preg_match('/^[a-zA-Z ]+$/', $data['name'])) {
        $errors['name'] = 'Họ và tên không hợp lệ';
    }
    if (empty($data['username'])) {
        $errors['username'] = 'Tên đăng nhập không được để trống';
    } else if (pdo_query_once('SELECT * FROM users WHERE username = ?', [$data['username']])) {
        $errors['username'] = 'Tên đăng nhập đã tồn tại';
    } else if (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
        $errors['username'] = 'Tên đăng nhập không hợp lệ';
    }

    if ($data['email']) {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } else if (pdo_query_once('SELECT * FROM users WHERE email = ?', [$data['email']])) {
            $errors['email'] = 'Email đã tồn tại';
        }
    }

    if ($data['birthdate']) {
        // get this today date minus two years
        $maximum = date('Y-m-d', strtotime('-2 years'));

        if (strtotime($data['birthdate']) < strtotime('1900-01-01') || strtotime($data['birthdate']) > strtotime($maximum)) {
            $errors['birthdate'] = 'Ngày sinh không hợp lệ';
        }
    }

    if (empty($data['password'])) {
        $errors['password'] = 'Mật khẩu không được để trống';
    } else if (strlen($data['password']) < 6) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
    } else if ($data['password'] != $data['confirm-password']) {
        $errors['confirm-password'] = 'Mật khẩu không khớp';
    }


    if ($errors) {
        return $errors;
    } else {
        return false;
    }
}

// validate đăng nhập
function validate_profile($data)
{
    $data = input_clean($data);
    $errors = [];

    if (empty($data['name'])) {
        $errors['name'] = 'Họ và tên không được để trống';
    } else if (!preg_match('/^[a-zA-Z ]+$/', $data['name'])) {
        $errors['name'] = 'Họ và tên không hợp lệ';
    }

    if ($data['birthdate']) {
        if (strtotime($data['birthdate']) < strtotime('1900-01-01') || strtotime($data['birthdate']) > strtotime('2020-01-01')) {
            $errors['birthdate'] = 'Ngày sinh không hợp lệ';
        }
    }
    // phone number
    if ($data['phone']) {
        if (!preg_match('/^(\+84|0)\d{9,11}$/', $data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ';
        }
    }
    // email
    if (empty($data['email'])) {
        $errors['email'] = 'Email không được để trống';
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }


    if ($errors) {
        return $errors;
    } else {
        return false;
    }
}

// xóa mọi ký tự không hợp lệ
function input_clean($data)
{
    if (is_array($data)) {
        $data = array_map('input_clean', $data);
    } else {
        $data = trim($data);
        $data = stripslashes($data);
    }

    return $data;
}



// chuyển trang
function redirect($page)
{
    $sec = 1;
    // header("Refresh: $sec; url=index.php?page=$page");
    header("Refresh: $sec; url=$page");
    exit();
}

// báo lỗi
function alert($message)
{
    echo "<script>alert('$message');</script>";
}

// rút gọn số
function number_shorten($number)
{
    if ($number >= 1000000) {
        return round($number / 1000000, 1) . 'm';
    } else if ($number >= 1000) {
        return round($number / 1000, 1) . 'k';
    } else {
        return $number;
    }
}

// format số sang tiền tệ
function asvnd($value)
{
    if ($value < 0) return "-" . asvnd(-$value);
    return  number_format($value) . 'đ';
}

function pagination($pageno, $search = null, $total_items = [], $items_per_page = 12)
{
    // Tìm kiếm tên sản phẩm
    if ($search) {
        $total_items = array_filter($total_items, function ($prod) use ($search) {
            $clean_target = strtolower($prod['name']);
            $clean_search_str = trim(strtolower($search));
            return strpos($clean_target, $clean_search_str) !== false;
        });
    }

    // Phân trang
    // $items_per_page = 12; // số sản phẩm trên một trang
    $item_count = count($total_items); // tổng số sản phẩm
    $offset = ($pageno - 1) * $items_per_page; // vị trí bắt đầu lấy sản phẩm
    $total_pages = ceil($item_count / $items_per_page); // tổng số trang
    $display_items = array_slice($total_items, $offset, $items_per_page); // sản phẩm hiển thị trên một trang
    return [$pageno, $total_pages, $display_items];
}

// Helper functions cho dữ liệu sql. Dữ liệu phải là dạng array 2D

// lọc item
function item_filter($items, $filterBy, $value)
{
    $result = array_filter($items, function ($item) use ($filterBy, $value) {
        return $item[$filterBy] === $value;
    });
    return $result;
}

// sắp xếp item
function item_sort($items, $sortBy, $order = null)
{
    if (!$sortBy) return $items;
    $col = array_column($items, $sortBy);
    array_multisort($col, ($order ? SORT_DESC : SORT_ASC), $items);
    return $items;
}

// cắt số lượng item
function item_truncate($items, $no_items = null)
{
    return array_slice($items, 0, $no_items ?? count($items));
}


// tính giá sản phẩm đã giảm giá
function sale_price($price, $sale)
{
    if ($sale && $sale > 0 && $sale < 1) {
        return $price - ($price * $sale);
    } else {
        return $price;
    }
}

// chỉ trả về giá trị trong khoảng từ min đến max
function clamp($value, $min, $max)
{
    return max($min, min($value, $max));
}

// tạo mã SKU cho sản phẩm


function array_flatten($array)
{
    $flat = [];
    foreach ($array as $key => $val) {
        if (is_array($val)) {
            $flat[] = $key;
            $flat = array_merge($flat, array_flatten($val));
        } else {
            $flat[] = $val;
        }
    }
    return remove_empty($flat);
}

// remove empty array in 2d array
function remove_empty($array)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = remove_empty($value);
        }
        if (empty($array[$key])) {
            unset($array[$key]);
        }
    }
    return $array;
}


function translate_status($index)
{
    $product_status = ['Chờ xử lý', 'Đang xử lý', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy'];

    // if $index can't be converted to int, find the string in array and return the index
    if (ctype_digit($index)) {
        return $product_status[$index];
    } else {
        return array_search($index, $product_status);
    }
}

// chuyển đổi đơn vị kích cỡ file
function file_size_format($size)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}