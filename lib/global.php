<?php

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
